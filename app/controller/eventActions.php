<?php
namespace App\Controller;
use App\View;

class InsertEventAction extends Action
{
	
	public function __construct($context) 
	{
		$this->context = $context;
	}

	protected function createViewOnSuccess()
	{
	}

	protected function createViewOnFail()
	{
		return new \App\View\LoginView($this->context);
	}
	
	public function execute()
	{
		$this->executed = true;
		$this->success = $this->context->user->loggedIn;
	}
}
?>