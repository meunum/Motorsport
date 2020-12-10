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
			include('inc/listViewScript.js');
			print('</script>');
		}
		print('<form id="veranstaltungenForm" action="index.php" enctype="multipart/form-data" method="post">');
		print('<input type="hidden" id="actionInput" name="action" value="" />');
		print('<input type="hidden" id="idInput" name="id" value="" />');

		print('<table>');
		print('<th><i class="fas fa-camera"/></th><th>Bezeichnung</th><th>Datum, Zeit</th><th>Ort</th><th>Kategorie</th>');
		if($this->context->user->loggedIn)
		{
			print('<th/>');// eine weitere Spalte für die Edit-Buttons
		}
		foreach($this->contentList as $entity) 
		{
			echo '<tr><td>';
			$this->showCellImage($entity->bildId);
			echo '</td><td>';
			echo htmlspecialchars($entity->bezeichnung);
			echo '</td><td>';
			echo htmlspecialchars($entity->zeitpunkt);
			echo '</td><td>';
			echo htmlspecialchars($entity->ort);
			echo '</td><td>';
			echo htmlspecialchars($entity->kategorie);
			if($this->context->user->loggedIn)
			{
				include('inc/listViewCellButtons.php');
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