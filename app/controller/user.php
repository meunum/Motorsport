<?php
namespace App\Controller;
use App\Model;

class User
{
	public $id = NULL;
	public $email = NULL;
	public $loggedIn = False;
	public $promoter = NULL;
	
	public function __construct($context) 
	{
		require_once $context->indexdir . '/app/model/promoter.php';
		$auth = new \Delight\Auth\Auth($context->database);
		if ($auth->isLoggedIn()) 
		{
			$this->loggedIn = True;
			$this->id = $auth->getUserId();
			$this->email = $auth->getEmail();
			$this->promoter = \App\Model\PromoterList::get($this->id);
		}
	}
}
?>