<?php

	namespace App\View;
	include 'mainView.php';
	
		class ListView extends MainView
		{
			
			public function __construct($context) 
			{
				parent::__construct($context);
			}
			
			public function showBody()
			{
				echo "ListView::showBody";
			}
			
		}
?>