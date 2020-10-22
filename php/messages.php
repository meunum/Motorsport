<?php
	if(!empty($messages)) 
	{
		// Fehlermeldungen ausgeben:
		echo '<div class="error">Bitte korrigiere folgende Eingaben:<ul>';
		foreach($messages as $message) {
		  echo '<li>'.htmlspecialchars($message).'</li>';
		}
		echo '</ul></div>';
	}
?>