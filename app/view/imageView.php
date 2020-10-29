<?php

	namespace App\View;
	
		class ImageView
		{
			protected $context = NULL;
			private int $imageId = 0;
			
			public function __construct($context, $imageId) 
			{
				$this->context = $context;
				$this->imageId = $imageId;
			}
			
			public function show()
			{
				$mysqli = new \mysqli($this->context->dbhost, $this->context->dbuser, $this->context->dbpass, $this->context->dbname);
				$Q = $mysqli->query("SELECT * FROM grafik WHERE id=" . $this->imageId);
				$Q = $Q->fetch_array();
				$Bild = $Q['daten'];
				$mysqli->close();

				header("Content-type: image/jpg");
				echo $Bild;
			}
		}
?>