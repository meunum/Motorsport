<?php
	if(!empty($messages)) 
	{
		// Fehlermeldungen ausgeben:
		echo '<div class="error">Bei der Verarbeitung Deiner Eingaben sind Fehler aufgetreten:<ul>';
		foreach($messages as $message) {
		  echo '<li>'.htmlspecialchars($message).'</li>';
		}
		echo '</ul></div>';
	}
?>