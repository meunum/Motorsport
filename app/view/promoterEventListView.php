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
		}
		
		protected function showMainSectionContent()
		{
			print('<form id="veranstalter" action="index.php" enctype="multipart/form-data" method="post">');
			print('<table class="editTable">');
			print('<th></th><th>Bezeichnung</th><th>Datum, Zeit</th><th>Ort</th><th>Kategorie</th><th/>');
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
				echo '</td><td class="td-buttons">';
				echo '<button class="icoBtn icoEdit" type="submit" name="action" value="EditEvent@', $event->id, '"><i class="fa fa-edit"></i></button>';
				echo '<button class="icoBtn icoDelete" type="submit" name="action" value="DeleteEvent@', $event->id,'"><i class="fa fa-trash"></i></button>';
				echo '</td></tr>';
			}
			print('</table>');
			print('<section class="subTableButton">');
			print('<button class="icoBtn icoAdd" type="submit" name="action" value="InsertEvent"><i class="fa fa-plus"></i></button>');
			print('</section><section><p/></section></form>');
		}
	}
?>