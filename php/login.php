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
			try 
			{
				$pdo = new \PDO('mysql:dbname='.$GLOBALS['DBNAME'].';host='.$GLOBALS['DBHOST'].';charset=utf8mb4', $GLOBALS['DBUSER'], $GLOBALS['DBPASS']);
				$auth = new \Delight\Auth\Auth($pdo);
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
				$messages[] = 'Email nicht verifiziert';
			}
			catch (\Delight\Auth\TooManyRequestsException $e) {
				$messages[] = 'Zu viele Versuche';
			}
			catch (PDOException $e) {
				$messages[] = 'Datenbankfehler';
			}
		}
	}
?>
