<?php
if(isset($_POST['submitButton'])) {
//	echo "<div><pre>"; print_r ($_POST); echo "/<pre></div>";

	
  $messages = [];

	function registerCallback ($selector, $token) 
	{
		$empfaenger = $_POST["email"];
		$betreff = "Konto auf meunum.de aktivieren";
		$nachricht = "Hallo, " . "\r\n" .
			"\r\n" .
			"Du hast Dich erfolgreich auf meunum.de registriert. Bitte aktiviere Dein Konto durch Klick auf folgenden Link:" . "\r\n" .
			"http://meunum.de/registrierungabschliessen.php?selector=" . \urlencode($selector) . "&token=" . \urlencode($token) . "\r\n" .
			"Danach kannst Du Dich mit Deinen Benutzerdaten im Veranstalterbereich anmelden." . "\r\n" .
			"\r\n" .
			"Viel Spaß auf meunum.de";
		$header = "From: webmaster@meunum.de" . "\r\n" .
			"Reply-To: webmaster@meunum.de" . "\r\n" .
			"X-Mailer: PHP/" . phpversion();
		
		$success = mail($empfaenger, $betreff, $nachricht, $header);
		
		if (!$success)
		{
			$messages[] = "Fehler beim Mailversand";
		}
	}
	$registerCallbackVar = 'registerCallback';

  // Eingaben überprüfen:
  if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $messages[] = 'Die E-Mail-Adresse ist nicht gültig.';
  }
  if(($_POST['passwort']??'') != ($_POST['passwort2']??'')) {
    $messages[] = 'Die eingegebenen Passwörter sind nicht gleich.';
  }
  // ggf. noch mehr Tests auf schlechte Passwörter durchführen
  if(!empty($_POST['email']) && $_POST['email']==$_POST['passwort']) {
    $messages[] = 'Das Passwort darf nicht gleich der E-Mail-Adresse sein.';
  }
  if(!empty($_POST['benutzername']) && $_POST['benutzername']==$_POST['passwort']) {
    $messages[] = 'Das Passwort darf nicht gleich dem Anmeldenamen sein.';
  }
  if(mb_strlen($_POST['passwort']) < 8) {
    $messages[] = 'Das eingegebene Passwort ist zu kurz.';
  }

  if(empty($messages)) 
  {
	require_once __DIR__ . '/../vendor/autoload.php';
	require_once 'globals.php';
	$db = new \PDO('mysql:dbname='.$DBNAME.';host='.$DBHOST.';charset=utf8mb4', $DBUSER, $DBPASS);
	$auth = new \Delight\Auth\Auth($db);

	try 
	{
		$db->beginTransaction();
		$UserId = $auth->register($_POST['email'], $_POST['passwort'], '', $registerCallbackVar);

		$Name = $_POST['name'];
		$Kategorie = $_POST['kategorie'];
		$Region = $_POST['region'];
		$Beschreibung = $_POST['beschreibung'];
		$BildId = NULL;
		
		if(!empty($_FILES['bild']['name']))
		{
			$Path = $_FILES['bild']['tmp_name'];
			$Size = $_FILES['bild']['size'];
			$File = fread(fopen($Path, "r"), $Size);
			$Bild = addslashes($File);
			$db->exec("INSERT INTO grafik (daten) VALUES ('$Bild')");
			$BildId = $db->lastInsertId();
		}

		$statement = $db->prepare('INSERT INTO veranstalter (users_fk, name, kategorie, region, beschreibung, bild) VALUES(?, ?, ?, ?, ?, ?)');
		$statement->execute(array($UserId, $Name, $Kategorie, $Region, $Beschreibung, $BildId));

		$db->commit();
	}
	catch (\Delight\Auth\InvalidEmailException $e) {
		$messages[] = 'Ungültige Email-Adresse';
		$db->rollBack();
	}
	catch (\Delight\Auth\InvalidPasswordException $e) {
		$messages[] = 'Ungültiges Passwort';
		$db->rollBack();
	}
	catch (\Delight\Auth\UserAlreadyExistsException $e) {
		$messages[] = 'Der Benutzer existiert bereits';
		$db->rollBack();
	}
	catch (\Delight\Auth\TooManyRequestsException $e) {
		$messages[] = 'Zu viele Versuche';
		$db->rollBack();
	}
	catch(Error $e)
	{
		echo '<div class="error">Fehler beim Speichern:<br>';
		print_r($e->errorInfo());
		echo '</div>';
		$db->rollBack();
	}
  }
}
?>
