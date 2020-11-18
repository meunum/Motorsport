<?php
namespace App\Model;

class User
{
	public $id = NULL;
	public $email = NULL;
	public $loggedIn = False;
	public $justLoggedOut = False;
	public $promoter = NULL;
	
	public function __construct($id, $email, $loggedIn) 
	{
		$this->id = $id;
		$this->email = $email;
		$this->loggedIn = $loggedIn;
	}
}
?>