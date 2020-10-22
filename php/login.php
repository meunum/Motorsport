<?php
	require 'php/logout.php';
	$messages = [];
	if(isset($_POST['submitButton'])) 
	{
		if(empty($_POST['email'])) {
			$messages[] = 'Die Email-Adresse darf nicht leer sein.';
		}
		if(empty($_POST['passwort'])) {
			$messages[] = 'Das Passwort darf nicht leer sein.';
		}

		if(empty($messages)) 
		{
			require_once __DIR__ . '/../vendor/autoload.php';
			require_once 'globals.php';
			$pdo = new \PDO('mysql:dbname='.$DBNAME.';host='.$DBHOST.';charset=utf8mb4', $DBUSER, $DBPASS);
			$auth = new \Delight\Auth\Auth($pdo);
			try 
			{
				$auth->login($_POST['email'], $_POST['passwort']);
				echo '<div class="success">Anmeldung erfolgreich.</div>';
				$loggedIn = True;
				$stmt = $pdo->query("SELECT * FROM veranstalter where users_fk=$BenutzerId LIMIT 1");
				if($stmt)
				{
					$BenutzerDaten = $stmt->fetch();
				}
			}
			catch (\Delight\Auth\InvalidEmailException $e) {
				$messages[] = 'Die Email-Adresse ist keinem Benutzerkonto zugeordnet, oder das Passwort ist falsch. Klicke auf "Registrieren", um ein neues Konto zu erstellen.';
			}
			catch (\Delight\Auth\InvalidPasswordException $e) {
				$messages[] = 'Die Email-Adresse ist keinem Benutzerkonto zugeordnet, oder das Passwort ist falsch. Klicke auf "Registrieren", um ein neues Konto zu erstellen.';
			}
			catch (\Delight\Auth\EmailNotVerifiedException $e) {
				$messages[] = 'Email not verified';
			}
			catch (\Delight\Auth\TooManyRequestsException $e) {
				$messages[] = 'Zu viele Versuche';
			}
		}
	}
?>
