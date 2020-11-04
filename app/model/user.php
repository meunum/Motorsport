<?php
namespace App\Model;

class User
{
	public $id = NULL;
	public $email = NULL;
	public $loggedIn = False;
	public $justLoggedOut = False;
	public $promoter = NULL;
	
	public function __construct() 
	{
		$context = \App\Model\PromoterList::GetContext();
		$auth = new \Delight\Auth\Auth($context->database);
		if ($auth->isLoggedIn()) 
		{
			$this->loggedIn = True;
			$this->id = $auth->getUserId();
			$this->email = $auth->getEmail();
			$this->promoter = \App\Model\PromoterList::getByUserId($this->id);
		}
	}
}
?>