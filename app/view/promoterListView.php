<?php

	namespace App\View;
	use App\Model;
	require_once 'views.php';
	
	class PromoterListView extends htmlView
	{
		private $promoterList;
		
		public function __construct($context, $promoterList) 
		{
			parent::__construct($context);
			$this->promoterList = $promoterList;
		}
		
		private function showBody()
		{
			print('<body>');
			$this->showHeader();
			$this->showMainContent();
			$this->showFooter();
			print('</body>');
		}
		
		private function showMainContent()
		{
			print('<main>');
			print('<section class="mainHead">');
			print('<nav class="userNav">');
			print('<ul>');
			if($this->context->user->loggedIn)
				print('<li><a class="activeLink2" href="index.php?action=logout">Abmelden</a></li>');
			else
				print('<li></li>');
			print('</ul>');
			print('</nav>');
			if($this->context->user->loggedIn)
				print('<legend class="userLegend">Du bist angemeldet als ' . htmlspecialchars($this->context->user->promoter->name??'') . '</legend>');
			else
				if($this->context->user->justLoggedOut)
					print('<legend class="userLegend">Du bist nicht mehr angemeldet</legend>');
				else
					print('<legend class="userLegend"></legend>');
			print('<nav class="mainNav">');
			print('<ul>');
			print('<li><div class="navTitle">Veranstalter</div></li>');
			print('<li><a class="activeLink2" href="index.php?view=eventlistview">Veranstaltungen</a></li>');
			print('<li><a class="activeLink2" href="index.php?view=driverlistview">Fahrer</a></li>');
			print('</ul>');
			print('</nav>');
			print('</section>');
			print('<p>');
			print('<table>');
			print('<th></th><th>Veranstalter</th><th>Bevorstehende Termine</th>');
			foreach($this->promoterList as $promoter) 
			{
				print('<tr><td>');
					if($promoter->bildId==NULL)
						print('<img src="app/view/img/placeholder.jpg" width="160" height="90"/>');
					else
						$this->showImage($promoter->bildId, 160, 90);
				print('</td><td>');
					echo '<div>', htmlspecialchars($promoter->name), '</div><br>';
					echo '<div> Kategorie: ', htmlspecialchars($promoter->kategorie), '</div>';
					echo '<div> Region: ', htmlspecialchars($promoter->region), '</div>';
				print('</td><td>');
					$SQL = "SELECT zeitpunkt,bezeichnung,ort FROM veranstaltung WHERE veranstalter=$promoter->id and zeitpunkt>=CURRENT_DATE() ORDER BY zeitpunkt LIMIT 3";
					$termine = $this->context->database->query($SQL);
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
			print('</table></main>');
		}
		
		public function show()
		{
			$this->startPage();
			$this->showHtmlHead('Motorsport');
			$this->showBody();
			$this->endPage();
		}
	}
?>