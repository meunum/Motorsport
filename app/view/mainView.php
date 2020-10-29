<?php

	namespace App\View;
	include 'htmlView.php';
	
		class MainView extends HtmlView
		{
			public function __construct($context) 
			{
				parent::__construct($context);
			}
			
			public function showBody()
			{
				echo "MainView::showBody";
			}
		}
?>