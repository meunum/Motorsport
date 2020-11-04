<?php
namespace App\Controller;
use App\View;
use App\Model;

class LogInAction extends Action
{

	public function createView()
	{
		if($this->success) 
		{
			return new \App\View\promoterView($this->context, []);
		}
		else
		{
			return new \App\View\loginView($this->context, $this->messages);
		}
	}
	
	public function execute()
	{
		$this->messages = [];
		if(empty($_POST['email'])) {
			$this->messages[] = 'Die Email-Adresse darf nicht leer sein.';
		}
		if(empty($_POST['passwort'])) {
			$this->messages[] = 'Das Passwort darf nicht leer sein.';
		}

		if(empty($this->messages)) 
		{
			try 
			{
				$auth = new \Delight\Auth\Auth($this->context->database);
				$auth->login($_POST['email'], $_POST['passwort']);
				$this->context->user->loggedIn = True;
				$this->context->user->id = $auth->getUserId();
				$this->context->user->email = $_POST['email'];
				$this->context->user->promoter = \App\Model\Promoterlist::getByUserId($this->context->user->id);
				$this->success = true;
			}
			catch (\Delight\Auth\InvalidEmailException $e) {
				$this->messages[] = 'Die Email-Adresse ist keinem Benutzerkonto zugeordnet, oder das Passwort ist falsch.';
				$this->messages[] = 'Klicke auf "Registrieren", wenn Du ein neues Konto anlegen möchtest.';
			}
			catch (\Delight\Auth\InvalidPasswordException $e) {
				$this->messages[] = 'Die Email-Adresse ist keinem Benutzerkonto zugeordnet, oder das Passwort ist falsch.';
				$this->messages[] = 'Klicke auf "Registrieren", wenn Du ein neues Konto anlegen möchtest.';
			}
			catch (\Delight\Auth\EmailNotVerifiedException $e) {
				$this->messages[] = 'Email nicht verifiziert';
			}
			catch (\Delight\Auth\TooManyRequestsException $e) {
				$this->messages[] = 'Zu viele Versuche';
			}
			catch (PDOException $e) {
				$this->messages[] = 'Datenbankfehler';
			}
		}

		return $this->success;
		
	}
}

class LogOutAction extends Action
{

	public function createView()
	{
		return new \App\View\loginView($this->context, $this->messages);
	}
	
	public function execute()
	{
		$this->messages = [];
		$this->success = !$this->context->user->loggedIn;
		$this->context->user->justLoggedOut = False;
		if ($this->context->user->loggedIn)
		{
			$auth = new \Delight\Auth\Auth($this->context->database);
			try {
				$auth->logOut();
				$this->context->user->loggedIn = False;
				$this->context->user->justLoggedOut = True;
				$this->context->user->promoter = null;
				$this->success = true;
			}
			catch (\Delight\Auth\NotLoggedInException $e) {
				$this->messages[] = 'Nicht angemeldet';
			}
		}
		
		return $this->success;
		
	}
}
?>
