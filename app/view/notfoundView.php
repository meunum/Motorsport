<?php

	namespace App\View;
	
		class NotFoundView
		{
			public function __construct() 
			{
			}
			
			public function show()
			{
				header("HTTP/1.0 404 Not Found");
				die();
			}
		}
?>