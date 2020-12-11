<?php
namespace App\View;
use App\Model;

class EventListView extends EntityListView
{
	
	public function __construct($context, $list) 
	{
		if($context->user->loggedIn)
		{
			$caption = 'Motorsport (Termine bearbeiten)';
		}
		else
		{
			$caption = 'Motorsport (Veranstaltungen)';
		}
		parent::__construct($context, $list, $caption, 'Event');
	}
}?>