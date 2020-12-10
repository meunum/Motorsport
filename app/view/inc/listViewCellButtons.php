<?php
echo '</td><td class="td-buttons">';
echo '<button class="iconButton editIcon" type="submit" onclick="editEntity(', $entity->id, ', \'Event\')" >';
echo '<i class="far fa-edit"></i></button>';
echo '<button class="iconButton deleteIcon" type="submit" onclick="confirmDeleteEntity(';
    echo $entity->id, ', ';
    echo '\'', $entity->Classname(), '\', ';
    echo '\'', $entity->Bezeichnung(), '\', ';
    echo '\'', $entity->Title4(), '\')" >';
echo '<i class="far fa-trash-alt"></i></button>';
?>