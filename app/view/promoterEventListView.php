<?php

	namespace App\View;
	use App\Model;
	
	class PromoterEventListView extends ListView
	{
		private $promoter;
		
		public function __construct($context, $list) 
		{
			parent::__construct($context, 'Motorsport (Veranstalter-Termine bearbeiten)', $list);
			$this->promoter = $context->user->promoter;
		}

		public function showMainNavContent() 
		{
			print('<li><a class="activeLink2" href="index.php?action=ShowPromoterView">Meine Grunddaten</a></li>');
			print('<li><div class="navTitle">Meine Veranstaltungen</div></li>');
			print('<li><a class="activeLink2" href="index.php?view=driverEditList">Meine Fahrerliste</a></li>');
		}
		
		protected function showMainSectionContent()
		{
			print('<form id="veranstalter" action="index.php" enctype="multipart/form-data" method="post">');
			print('<table class="editTable">');
			print('<th></th><th>Bezeichnung</th><th>Datum, Zeit</th><th>Ort</th><th>Kategorie</th><th>Bearbeiten</th>');
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
				echo '</td><td>';
				echo '<button class="cellButton" type="submit" name="action" value="EditEvent@', $event->id, '">Ändern</button><br>';
				echo '<button class="cellButton" type="submit" name="action" value="DeleteEvent@', $event->id,'">Löschen</button>';
				echo '</td></tr>';
			}
			print('</table>');
			print('<section class="subTableButton">');
			print('<button type="submit" name="action" value="InsertEvent">Hinzufügen</button>');
			print('</section><section><p/></section></form>');
		}
	}
?>