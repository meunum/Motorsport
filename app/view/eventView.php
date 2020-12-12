<?php
namespace App\View;
use App\Model;

class EventView extends EntityView
{
	private \App\Model\Event $event;
	
	public function __construct($context, $event, $messages) 
	{
		parent::__construct($context, $event, $messages);
		$this->event = $event;
	}

	public function showMainNavContent() 
	{
		if($this->event->id == 0)
			print('<li><div class="navTitle">Neue Veranstaltung erfassen</div></li>');
		else
			print('<li><div class="navTitle">Veranstaltung ändern</div></li>');
		print('<li><a class="mainNavLink" href="index.php?action=ShowEventDriverListView">Teilnehmer</a></li>');
	}
}
?>