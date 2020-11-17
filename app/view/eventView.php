<?php
namespace App\View;
use App\Model;

class EventView extends FormView
{
	private \App\Model\Event $event;
	
	public function __construct($context, $event, $messages) 
	{
		parent::__construct($context, 'Motorsport (Veranstaltung bearbeiten)', $messages);
		$this->event = $event;
	}

	public function showMainNavContent() 
	{
		if($this->event->id == 0)
			print('<li><div class="navTitle">Neue Veranstaltung erfassen</div></li>');
		else
			print('<li><div class="navTitle">Veranstaltung ändern</div></li>');
		print('<li><a class="activeLink2" href="index.php?action=ShowEventDriverListView">Teilnehmer</a></li>');
	}
	
	protected function showMainSectionContent()
	{
		parent::showMainSectionContent();
		include 'inc/eventViewContent.php';
	}
}
?>