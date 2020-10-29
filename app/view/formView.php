<?php

	namespace App\View;
	
		class FormView extends HtmlView
		{
			protected $messages = [];
			
			public function __construct($context, $messages) 
			{
				parent::__construct($context);
				$this->messages = $messages;
			}
			
			protected function showMessages()
			{
				if(!empty($this->messages)) 
				{
					echo '<div class="error">Bei der Verarbeitung Deiner Eingaben sind Fehler aufgetreten:<ul>';
					foreach($this->messages as $message) {
					  echo '<li>'.htmlspecialchars($message).'</li>';
					}
					echo '</ul></div>';
				}
			}
		}
?>