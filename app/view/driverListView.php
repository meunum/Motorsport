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

	public function showMainNavContent() 
	{
		print('<li><a class="activeLink2" href="index.php?action=PromoterList">Veranstalter</a></li>');
		print('<li><a class="activeLink2" href="index.php?action=EventList">Veranstaltungen</a></li>');
		print('<li><div class="navTitle">Fahrer</div></li>');
	}
	
	protected function showMainSectionContent()
	{
		if($this->context->user->loggedIn)
		{
			print('<script>');

			print('function editDriver(DriverId) {');
			print('  var action = document.getElementById("action");');
			print('  action.setAttribute("value", "EditDriver");');
			print('  var id = document.getElementById("id");');
			print('  id.setAttribute("value", DriverId);');
			print('}');

			print('function confirmDeleteDriver(DriverId, DriverName) {');
			print('  var action = document.getElementById("action");');
			print('  var id = document.getElementById("id");');
			print('  if (confirm("Möchtest Du den Fahrer \"" + DriverName + "\" löschen?")) {');
			print('    action.setAttribute("value", "DeleteDriver");');
			print('    id.setAttribute("value", DriverId);');
			print('  } else {');
			print('    action.setAttribute("value", "DriverList");');
			print('    id.setAttribute("value", "");');
			print('  }');
			print('}');

			print('</script>');
		}
		print('<form id="driverForm" action="index.php" enctype="multipart/form-data" method="post">');
		print('<input type="hidden" id="action" name="action" value="" /><input type="hidden" id="id" name="id" value="" />');

		print('<table>');
		print('<th><i class="fas fa-camera"/></th><th>Vorname</th><th>Name</th><th>Anmerkung</th>');
		if($this->context->user->loggedIn)
		{
			print('<th/>');
		}
		foreach($this->contentList as $driver) 
		{
			echo '<tr><td>';
			$this->showImage($driver->bildId, 160, 90);
			echo '</td><td>';
			echo htmlspecialchars($driver->vorname);
			echo '</td><td>';
			echo htmlspecialchars($driver->name);
			echo '</td><td>';
			echo htmlspecialchars($driver->anmerkung);
			if($this->context->user->loggedIn)
			{
				echo '</td><td class="td-buttons">';
				echo '<button class="iconButton editIcon" type="submit" onclick="editDriver(', $driver->id, ')" ><i class="far fa-edit"></i></button>';
				echo '<button class="iconButton deleteIcon" type="submit" onclick="confirmDeleteDriver(', $driver->id, ',\'';
					echo $driver->vorname . ' ' . $driver->name, '\')" ><i class="far fa-trash-alt"></i></button>';
			}
			echo '</td></tr>';
		}
		print('</table>');

		if($this->context->user->loggedIn)
		{
			print('<section class="subTableButton">');
			print('<button class="iconButton insertIcon" type="submit" name="action" value="InsertDriver"><i class="far fa-plus-square"></i></button>');
			print('</section>');
		}
		print('<section><p/></section></form>');
	}
}?>