<?php
namespace App\View;
use App\Model;

class EventListView extends ListView
{
	private $promoter;
	
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
		parent::__construct($context, $caption, $list);
		$this->promoter = $context->user->promoter;
	}
	
	protected function showMainSectionContent()
	{
		if($this->context->user->loggedIn)
		{
			print('<script>');

			print('function editEvent(eventId) {');
			print('  var actionInput = document.getElementById("actionInput");');
			print('  actionInput.setAttribute("value", "EditEvent");');
			print('  var idInput = document.getElementById("idInput");');
			print('  idInput.setAttribute("value", eventId);');
			print('}');

			print('function confirmDeleteEvent(eventId, eventName) {');
			print('  var actionInput = document.getElementById("actionInput");');
			print('  var idInput = document.getElementById("idInput");');
			print('  if (confirm("Möchtest Du die Veranstaltung \"" + eventName + "\" löschen?")) {');
			print('    actionInput.setAttribute("value", "DeleteEvent");');
			print('    idInput.setAttribute("value", eventId);');
			print('  } else {');
			print('    actionInput.setAttribute("value", "EventList");');
			print('    idInput.setAttribute("value", "");');
			print('  }');
			print('}');

			print('</script>');
		}
		print('<form id="veranstaltungenForm" action="index.php" enctype="multipart/form-data" method="post">');
		print('<input type="hidden" id="actionInput" name="action" value="" />');
		print('<input type="hidden" id="idInput" name="id" value="" />');

		print('<table>');
		print('<th><i class="fas fa-camera"/></th><th>Bezeichnung</th><th>Datum, Zeit</th><th>Ort</th><th>Kategorie</th>');
		if($this->context->user->loggedIn)
		{
			print('<th/>');
		}
		foreach($this->contentList as $event) 
		{
			echo '<tr><td>';
			$this->showCellImage($event->bildId);
			echo '</td><td>';
			echo htmlspecialchars($event->bezeichnung);
			echo '</td><td>';
			echo htmlspecialchars($event->zeitpunkt);
			echo '</td><td>';
			echo htmlspecialchars($event->ort);
			echo '</td><td>';
			echo htmlspecialchars($event->kategorie);
			if($this->context->user->loggedIn)
			{
				echo '</td><td class="td-buttons">';
				echo '<button class="iconButton editIcon" type="submit" onclick="editEvent(', $event->id, ')" >';
				echo  '<i class="far fa-edit"></i></button>';
				echo '<button class="iconButton deleteIcon" type="submit"';
				echo ' onclick="confirmDeleteEvent(', $event->id, ',\'', $event->bezeichnung, '\')" >';
				echo  '<i class="far fa-trash-alt"></i></button>';
			}
			echo '</td></tr>';
		}
		print('</table>');

		if($this->context->user->loggedIn)
		{
			print('<section class="subTableButton">');
			print('<button class="iconButton insertIcon" type="submit" name="action" value="InsertEvent">');
			print(' <i class="far fa-plus-square"></i></button>');
			print('</section>');
		}
		print('<section><p/></section></form>');
	}
}?>