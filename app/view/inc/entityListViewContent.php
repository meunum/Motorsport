<?php
        print('<form id="' . $this->entityClass . 'ListForm" action="index.php" enctype="multipart/form-data" method="post">');
		if($this->context->user->loggedIn)
		{
			print('<script>');include('listViewScript.js');print('</script>');
			print('<input type="hidden" id="actionInput" name="action" value="" />');
			print('<input type="hidden" id="idInput" name="id" value="" />');
		}

		print('<table>');
        print('<th><i class="fas fa-camera"/>');
        $qualifiedEntityClass = 'App\\Model\\' . $this->entityClass;
        $captions = $qualifiedEntityClass::GetListCaptions();
        foreach($captions as $columnTitle)
        {
            print('<th>' . $columnTitle . '</th>');
        }

		if($this->context->user->loggedIn)
		{
			print('<th/>');// eine weitere Spalte für die Edit-Buttons
		}
		foreach($this->contentList as $entity) 
		{
			echo '<tr><td>';
			$this->showCellImage($entity->bildId);
            echo '</td>';
            $props = $entity->GetListProps();
            foreach ($props as $property) 
            {
                echo '<td>', htmlspecialchars($property), '</td>';    
            }
			if($this->context->user->loggedIn)
			{
                echo '<td class="td-buttons">',
                    '<button class="iconButton editIcon" type="submit"', 
                        'onclick="editEntity(', $entity->id, ', \'', $this->entityClass, '\')" >',
                        '<i class="far fa-edit"></i>',
                    '</button>',
                    '<button class="iconButton deleteIcon" type="submit" ',
                        'onclick="confirmDeleteEntity(',
                            $entity->id, ', ',
                            '\'', $entity->className(), '\', ',
                            '\'', $entity->Bezeichnung(), '\', ',
                            '\'', $entity->GetTitle(4), '\')" >',
                        '<i class="far fa-trash-alt"></i>',
                    '</button>',
                '</td>';
            }
			echo '</tr>';
		}
		print('</table>');

		if($this->context->user->loggedIn)
		{
			// Button zum Hinzufügen unterhalb der Tabelle
			print('<section class="subTableButton">');
			print('<button class="iconButton insertIcon" type="submit" name="action" value="Insert' . $this->entityClass . '">');
			print(' <i class="far fa-plus-square"></i></button>');
			print('</section>');
		}
		print('<section><p/></section></form>');
?>