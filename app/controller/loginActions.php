<?php
namespace App\Controller;
require_once 'action.php';

class LogInAction extends Action
{
	
	public function execute()
	{
		$messages = [];
		if(empty($_POST['email'])) {
			$messages[] = 'Die Email-Adresse darf nicht leer sein.';
		}
		if(empty($_POST['passwort'])) {
			$messages[] = 'Das Passwort darf nicht leer sein.';
		}

		if(empty($messages)) 
		{
			try 
			{
				$auth = new \Delight\Auth\Auth($this->context->database);
				$auth->login($_POST['email'], $_POST['passwort']);
				$this->context->user->loggedIn = True;
			}
			catch (\Delight\Auth\InvalidEmailException $e) {
				$messages[] = 'Die Email-Adresse ist keinem Benutzerkonto zugeordnet, oder das Passwort ist falsch.';
				$messages[] = 'Klicke auf "Registrieren", wenn Du ein neues Konto anlegen möchtest.';
			}
			catch (\Delight\Auth\InvalidPasswordException $e) {
				$messages[] = 'Die Email-Adresse ist keinem Benutzerkonto zugeordnet, oder das Passwort ist falsch.';
				$messages[] = 'Klicke auf "Registrieren", wenn Du ein neues Konto anlegen möchtest.';
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
		
		return $messages;
		
	}
}

class LogOutAction extends Action
{
	
	public function execute()
	{
		if ($this->context->user->loggedIn)
		{
			$messages = [];

			$auth = new \Delight\Auth\Auth($this->context->database);
			try {
				$auth->logOut();
				$this->context->user->loggedIn = False;
			}
			catch (\Delight\Auth\NotLoggedInException $e) {
				$messages[] = 'Nicht angemeldet';
			}
		}
		
		return $messages;
		
	}
}
?>
