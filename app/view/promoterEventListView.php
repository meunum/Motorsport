<?php

	namespace App\View;
	use App\Model;
	require_once 'views.php';
	
	class PromoterEventListView extends ListView
	{
		
		public function __construct($context, $list) 
		{
			
			parent::__construct($context, 'Motorsport (Veranstalter-Termine bearbeiten)', $list);
		}

		public function showMainNavContent() 
		{
			print('<li><a class="activeLink2" href="index.php?action=ShowPromoterView">Meine Grunddaten</a></li>');
			print('<li><div class="navTitle">Meine Veranstaltungen</div></li>');
			print('<li><a class="activeLink2" href="index.php?view=driverEditListView">Meine Fahrerliste</a></li>');
		}
		
		protected function showMainSectionContent()
		{
			print('<form id="veranstalter" enctype="multipart/form-data" method="post">');
			print('<table class="editEvents">');
			print('<th></th><th>Bezeichnung</th><th>Datum, Zeit</th><th>Ort</th><th>Kategorie</th><th>Bearbeiten</th>');
			foreach($this->contentList as $event) 
			{
				echo '<tr><td>';
				if($event['bild']==NULL)
					echo '<img src="res/keinbild.jpg" width="160" height="90"/>';
				else
					echo '<img src="php/bild.php?id=', $event['bild'], '" width="160" height="90"/>';
				echo '</td><td>';
				echo htmlspecialchars($event['bezeichnung']);
				echo '</td><td>';
				echo htmlspecialchars($event['zeitpunkt']);
				echo '</td><td>';
				echo htmlspecialchars($event['ort']);
				echo '</td><td>';
				echo htmlspecialchars($event['kategorie']);
				echo '</td><td>';
				echo '<button class="cellButton" type="submit" name="editButton" value="', $event['id'], '">Ändern</button><br>';
				echo '<button class="cellButton" type="submit" name="deleteButton" value="', $event['id'],'">Löschen</button>';
				echo '</td></tr>';
			}
			print('</table>');
			print('<section class="subTableButton">');
			print('<button type="submit" name="insertButton" value="-1">Hinzufügen</button>');
			print('</section>');
			print('<section><p/></section>');
			print('</form>');
		}
	}
?>