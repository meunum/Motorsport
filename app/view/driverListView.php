<?php
namespace App\View;
use App\Model;

class DriverListView extends ListView
{
	
	public function __construct($context, $list) 
	{
		if($context->user->loggedIn)
		{
			$caption = 'Motorsport (Fahrer bearbeiten)';
		}
		else
		{
			$caption = 'Motorsport (Fahrer)';
		}
		parent::__construct($context, $caption, $list);
	}
	
	protected function showMainSectionContent()
	{
		if($this->context->user->loggedIn)
		{
			print('<script>');
			include('inc/listViewScript.js');
			print('</script>');
		}
		print('<form idInput="driverForm" action="index.php" enctype="multipart/form-data" method="post">');
		print('<input type="hidden" id="actionInput" name="action" value="" />');
		print('<input type="hidden" id="idInput" name="id" value="" />');

		print('<table>');
		print('<th><i class="fas fa-camera"/></th><th>Vorname</th><th>Name</th><th>Anmerkung</th>');
		if($this->context->user->loggedIn)
		{
			print('<th/>');// eine weitere Spalte für die Edit-Buttons
		}
		foreach($this->contentList as $entity) 
		{
			echo '<tr><td>';
			$this->showCellImage($entity->bildId);
			echo '</td><td>';
			echo htmlspecialchars($entity->vorname);
			echo '</td><td>';
			echo htmlspecialchars($entity->name);
			echo '</td><td>';
			echo htmlspecialchars($entity->anmerkung);
			if($this->context->user->loggedIn)
			{
				include('inc/listViewCellButtons.php');
			}
			echo '</td></tr>';
		}
		print('</table>');

		if($this->context->user->loggedIn)
		{
			// Button zum Hinzufügen eines Fahrers
			print('<section class="subTableButton">');
			print('<button class="iconButton insertIcon" type="submit" name="action" value="InsertDriver">');
			print(' <i class="far fa-plus-square"></i></button>');
			print('</section>');
		}
		print('<section><p/></section></form>');
	}
}?>