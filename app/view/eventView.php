<?php
namespace App\View;
use App\Model;

class EventView extends FormView
{
	private \App\Model\Event $event;
	
	public function __construct($context, $event, $messages) 
	{
		parent::__construct($context, 'Motorsport (Termin bearbeiten)', $messages);
		$this->event = $event;
	}

	public function showMainNavContent() 
	{
		print('<li><div class="navTitle">Neue Veranstaltung erfassen</div></li>');
	}
	
	protected function showMainSectionContent()
	{
		include 'inc\eventViewContent.php';
	}
}
?>