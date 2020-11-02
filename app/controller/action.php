<?php
namespace App\Controller;

class Action
{
	protected $context;
	public bool $success = false;
	public $messages = [];
	
	public function __construct($context) 
	{
		$this->context = $context;
	}
	
}