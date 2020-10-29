<?php
namespace App\Controller;

class Action
{
	protected $context;
	
	public function __construct($context) 
	{
		$this->context = $context;
	}
	
}