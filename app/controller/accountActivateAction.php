<?php
namespace App\Controller;
use App\View;

class AccountActivateAction extends Action
{

	public function createView()
	{
		if(!$this->success) 
		{
			return new \App\View\accountActivateErrorView($this->context, $this->messages);
		}
		else
		{
			return new \App\View\accountActivateSuccessView($this->context, []);
		}
	}
	
	public function execute()
	{
		parent::execute();
		$auth = new \Delight\Auth\Auth($this->context->database);

		$this->messages = [];
		try {
			$auth->confirmEmail($_GET['selector'], $_GET['token']);
			$this->success = true;
		}
		catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
			$this->messages[] = 'Aktivierungsinformationen sind ungültig';
		}
		catch (\Delight\Auth\TokenExpiredException $e) {
			$this->messages[] = 'Aktivierungsinformationen sind nicht mehr gültig';
		}
		catch (\Delight\Auth\UserAlreadyExistsException $e) {
			$this->messages[] = 'Emailadresse existiert bereits';
		}
		catch (\Delight\Auth\TooManyRequestsException $e) {
			$this->messages[] = 'Zu viele Versuche';
		}
		
		return $this->success;
		
	}
}