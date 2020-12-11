<?php
namespace App\View;
use App\Model;

class DriverListView extends EntityListView
{
	
	public function __construct($context, $list) 
	{
		if($context->user->loggedIn)
		{
			$caption = 'Motorsport (Fahrer bearbeiten)';
		}
		else
		{
			$caption = 'Motorsport (Fahrer)';
		}
		parent::__construct($context, $list, $caption, 'Driver');
	}
}?>