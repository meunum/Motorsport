<?php

	namespace App\View;
	use App\Model;
	
	class EventListView extends ListView
	{
		private $promoter;
		
		public function __construct($context, $list) 
		{
			parent::__construct($context, 'Motorsport (Veranstalter-Termine bearbeiten)', $list);
			$this->promoter = $context->user->promoter;
		}

		public function showMainNavContent() 
		{
			print('<li><a class="activeLink2" href="index.php?action=PromoterList">Veranstalter</a></li>');
			print('<li><div class="navTitle">Veranstaltungen</div></li>');
			print('<li><a class="activeLink2" href="index.php?view=driverlist">Fahrer</a></li>');
		}
		
		protected function showMainSectionContent()
		{
			print('<script>');
			print('function editEvent(eventId) {');
			print('	 var action = document.getElementById("action");');
			print('	 action.setAttribute("value", "EditEvent");');
			print('	 var id = document.getElementById("id");');
			print('	 id.setAttribute("value", eventId);');
			print('}');
			print('function confirmDeleteEvent(eventId, eventName) {');
			print('	 var action = document.getElementById("action");');
			print('	 var id = document.getElementById("id");');
			print('  if (confirm("Möchtest Du die Veranstaltung \"" + eventName + "\" löschen?")) {');
			print('	 	action.setAttribute("value", "DeleteEvent");');
			print('	 	id.setAttribute("value", eventId);');
			print('  } else {');
			print('		action.setAttribute("value", "EventList");');
			print('	 	id.setAttribute("value", "");');
			print('  }');
			print('}');
			print('</script>');
			print('<form id="veranstaltungenForm" action="index.php" enctype="multipart/form-data" method="post">');
			print('<input type="hidden" id="action" name="action" value="" /><input type="hidden" id="id" name="id" value="" />');
			print('<table class="editTable">');
			print('<th></th><th>Bezeichnung</th><th>Datum, Zeit</th><th>Ort</th><th>Kategorie</th>');
			if($this->context->user->loggedIn)
			{
				print('<th/>');
			}
			foreach($this->contentList as $event) 
			{
				echo '<tr><td>';
				if($event->bildId==0)
					echo '<img src="app/view/img/placeholder.jpg" width="160" height="90"/>';
				else
					$this->showImage($event->bildId, 160, 90);
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
					echo '<button class="iconButton editIcon" type="submit" onclick="editEvent(', $event->id, ')" ><i class="far fa-edit"></i></button>';
					echo '<button class="iconButton deleteIcon" type="submit" onclick="confirmDeleteEvent(', $event->id, ',\'', $event->bezeichnung, '\')" ><i class="far fa-trash-alt"></i></button>';
				}
				echo '</td></tr>';
			}
			print('</table>');
			if($this->context->user->loggedIn)
			{
				print('<section class="subTableButton">');
				print('<button class="iconButton insertIcon" type="submit" name="action" value="InsertEvent"><i class="far fa-plus-square"></i></button>');
				print('</section>');
			}
			print('<section><p/></section></form>');
		}
	}
?>