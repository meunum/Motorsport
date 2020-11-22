<?php

	namespace App\View;
	use App\Model;
	require_once 'views.php';
	
	class PromoterListView extends ListView
	{
		
		public function __construct($context, $list) 
		{
			parent::__construct($context, 'Motorsport', $list);
		}
		
		protected function showMainSectionContent()
		{
			print('<p>');
			print('<table>');
			print('<th><i class="fas fa-camera"/></th><th>Veranstalter</th><th>Bevorstehende Termine</th>');
			foreach($this->contentList as $promoter) 
			{
				print('<tr><td>');
					$this->showImage($promoter->bildId, 160, 90);
				print('</td><td>');
					echo '<div>', htmlspecialchars($promoter->name), '</div><br>';
					echo '<div> Kategorie: ', htmlspecialchars($promoter->kategorie), '</div>';
					echo '<div> Region: ', htmlspecialchars($promoter->region), '</div>';
				print('</td><td>');
					$termine = $promoter->eventsComing(3);
					foreach($termine as $termin)
					{
						print('<div>');
						echo '<span>', htmlspecialchars($termin['bezeichnung']), ', </span>';
						echo '<span>am ', htmlspecialchars($termin['zeitpunkt']), ', </span>';
						echo '<span>Ort: ', htmlspecialchars($termin['ort']), '</span>';
						echo '</div>';
					}
				print('</td></tr>');
			}
			print('</table>');
		}

		public function showMainNavContent() 
		{
			print('<li><div class="navTitle">Veranstalter</div></li>');
			print('<li><a class="activeLink2" href="index.php?action=EventList">Veranstaltungen</a></li>');
			print('<li><a class="activeLink2" href="index.php?action=Driverlist">Fahrer</a></li>');
		}
	}
?>