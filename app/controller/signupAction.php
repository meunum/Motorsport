<?php
namespace App\Controller;
require_once 'action.php';

class SignUpAction extends Action
{
	
	public function execute()
	{
		$messages = [];

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
			require_once $this->context->indexdir . '/vendor/autoload.php';

			try 
			{
				$this->context->database->beginTransaction();
				$auth = new \Delight\Auth\Auth($this->context->database);
				$my_context = $this->context;
				$UserId = $auth->register(
					$_POST['email'], 
					$_POST['passwort'], 
					'', 
					function($selector, $token) use ($my_context) 
					{
						$empfaenger = $_POST["email"];
						$betreff = "Konto auf " . $my_context->domain . " aktivieren";
						$url = 'http://' . $my_context->domain . '/index.php?action=accountActivate&selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
						$nachricht = "Hallo, " . "\r\n" .
							"\r\n" .
							"Du hast Dich erfolgreich auf Motorsport.de registriert. Bitte aktiviere Dein Konto durch Klick auf folgenden Link:" . "\r\n" .
							$url . "\r\n" .
							"Danach kannst Du Dich mit Deinen Benutzerdaten im Veranstalterbereich anmelden." . "\r\n" .
							"\r\n" .
							"Viel Spaß auf " . $my_context->domain;
						$header = "From: webmaster@". $my_context->domain . "\r\n" .
							"Reply-To: webmaster@" . $my_context->domain . "\r\n" .
							"X-Mailer: PHP/" . phpversion();
						
						if($_SERVER['SERVER_NAME'] == "localhost")
						{
							echo '<a href="' . $url . '">$url</a>';
						}
						else
						{
							mail($empfaenger, $betreff, $nachricht, $header);
							mail('meunum.4.tomsel@neverbox.com', 'Registrierung erfolgt', $empfaenger . ' wurde registriert.', $header);
						}
					}
				);

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
					$this->context->database->exec("INSERT INTO grafik (daten) VALUES ('$Bild')");
					$BildId = $this->context->database->lastInsertId();
				}

				$statement = $this->context->database->prepare('INSERT INTO veranstalter (users_fk, name, kategorie, region, beschreibung, bild) VALUES(?, ?, ?, ?, ?, ?)');
				$statement->execute(array($UserId, $Name, $Kategorie, $Region, $Beschreibung, $BildId));

				$this->context->database->commit();
			}
			catch (\Delight\Auth\InvalidEmailException $e) {
				$messages[] = 'Ungültige Email-Adresse';
				$this->context->database->rollBack();
			}
			catch (\Delight\Auth\InvalidPasswordException $e) {
				$messages[] = 'Ungültiges Passwort';
				$this->context->database->rollBack();
			}
			catch (\Delight\Auth\UserAlreadyExistsException $e) {
				$messages[] = 'Der Benutzer existiert bereits';
				$this->context->database->rollBack();
			}
			catch (\Delight\Auth\TooManyRequestsException $e) {
				$messages[] = 'Zu viele Versuche';
				$this->context->database->rollBack();
			}
			catch (PDOException $e) {
				$messages[] = 'Datenbankfehler';
			}
		}
		
		return $messages;
		
	}
}