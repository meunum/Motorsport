<?php
namespace App\Controller;
require_once 'action.php';

class AccountActivateAction extends Action
{
	
	public function execute()
	{
		require_once $this->context->indexdir . '/vendor/autoload.php';

		$auth = new \Delight\Auth\Auth($this->context->database);

		$messages = [];
		try {
			$auth->confirmEmail($_GET['selector'], $_GET['token']);
		}
		catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
			$messages[] = 'Aktivierungsinformationen sind ungültig';
		}
		catch (\Delight\Auth\TokenExpiredException $e) {
			$messages[] = 'Aktivierungsinformationen sind nicht mehr gültig';
		}
		catch (\Delight\Auth\UserAlreadyExistsException $e) {
			$messages[] = 'Emailadresse existiert bereits';
		}
		catch (\Delight\Auth\TooManyRequestsException $e) {
			$messages[] = 'Zu viele Versuche';
		}
		
		return $messages;
		
	}
}