<?php

namespace App\View;
use App\Model;

class EventView extends FormView
{
	private $event;
	
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
	//	print_r($this->context);
		print('<form id="veranstaltung" action="index.php" enctype="multipart/form-data" method="post">');
		print('<legend class="dialogHint">Pflichtfelder sind gekennzeichnet mit: ' . $this->REQUIRED . '</legend>');
		print('<section class="groupBox">');
		print('<ul><li>');
		print('<label for="bezeichnung"><span>Bezeichnung: </span>' . $this->REQUIRED . '</label>');
		print('<input class="edit" type="text" name="bezeichnung" id="bezeichnung" value="' . htmlspecialchars($this->event->bezeichnung) . '" required />');
		print('</li><li>');
		print('<label for="zeitpunkt"><span>Zeitpunkt: </span>' . $this->REQUIRED . '</label>');
		print('<input class="edit" type="text" name="zeitpunkt" id="zeitpunkt" value="' . htmlspecialchars($this->event->zeitpunkt) . '" required />');
		print('</li><li>');
		print('<label for="ort"><span>Ort: </span>' . $this->REQUIRED . '</label>');
		print('<input class="edit" type="text" name="ort" id="ort" value="' . htmlspecialchars($this->event->ort) . '" required />');
		print('</li><li>');
		print('<label for="kategorie"><span>Kategorie: </span></label>');
		print('<input class="edit" type="text" name="kategorie" id="kategorie" value="' . htmlspecialchars($this->event->kategorie) . '" />');
		print('</li><li>');
		print('<label for="bild"><span>Bild hochladen: </span></label>');
		print('<input class="edit" type="file" name="bild" id="bild" />');
		print('</li><li>');
		print('<label for="bild"><span>Bild aktuell: </span></label>');
		$this->showImage($this->event->bildId, 160, 90);
		print('</li><li>');
		print('<input class="edit" type="text" name="eventId" id="eventId" value="' . $this->event->id . '" />');
		print('</li></ul></section>');
		print('<section id="buttonSection">');
		print('<ul><li>');
		print('<label for="submitButton" id="buttonLabel">.</label>');
		print('<button id="submitButton" name="action" value="EventSubmit">Speichern</button>');
		print('</li></ul></section></form>');
	}
}