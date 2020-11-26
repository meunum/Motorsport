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

			print('function editDriver(DriverId) {');
			print('  var actionInput = document.getElementById("actionInput");');
			print('  actionInput.setAttribute("value", "EditDriver");');
			print('  var idInput = document.getElementById("idInput");');
			print('  idInput.setAttribute("value", DriverId);');
			print('}');

			print('function confirmDeleteDriver(DriverId, DriverName) {');
			print('  var actionInput = document.getElementById("actionInput");');
			print('  var idInput = document.getElementById("idInput");');
			print('  if (confirm("Möchtest Du den Fahrer \"" + DriverName + "\" löschen?")) {');
			print('    actionInput.setAttribute("value", "DeleteDriver");');
			print('    idInput.setAttribute("value", DriverId);');
			print('  } else {');
			print('    actionInput.setAttribute("value", "DriverList");');
			print('    idInput.setAttribute("value", "");');
			print('  }');
			print('}');

			print('</script>');
		}
		print('<form idInput="driverForm" action="index.php" enctype="multipart/form-data" method="post">');
		print('<input type="hidden" id="actionInput" name="action" value="" />');
		print('<input type="hidden" id="idInput" name="id" value="" />');

		print('<table>');
		print('<th><i class="fas fa-camera"/></th><th>Vorname</th><th>Name</th><th>Anmerkung</th>');
		if($this->context->user->loggedIn)
		{
			print('<th/>');
		}
		foreach($this->contentList as $driver) 
		{
			echo '<tr><td>';
			$this->showCellImage($driver->bildId);
			echo '</td><td>';
			echo htmlspecialchars($driver->vorname);
			echo '</td><td>';
			echo htmlspecialchars($driver->name);
			echo '</td><td>';
			echo htmlspecialchars($driver->anmerkung);
			if($this->context->user->loggedIn)
			{
				echo '</td><td class="td-buttons">';
				echo '<button class="iconButton editIcon" type="submit" onclick="editDriver(', $driver->id, ')" >';
				echo '<i class="far fa-edit"></i></button>';
				echo '<button class="iconButton deleteIcon" type="submit"';
				echo ' onclick="confirmDeleteDriver(', $driver->id, ',\'', $driver->vorname, ' ', $driver->name, '\')" >';
				echo '<i class="far fa-trash-alt"></i></button>';
			}
			echo '</td></tr>';
		}
		print('</table>');

		if($this->context->user->loggedIn)
		{
			print('<section class="subTableButton">');
			print('<button class="iconButton insertIcon" type="submit" name="action" value="InsertDriver">');
			print(' <i class="far fa-plus-square"></i></button>');
			print('</section>');
		}
		print('<section><p/></section></form>');
	}
}?>