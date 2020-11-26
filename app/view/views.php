<?php
namespace App\View;
use App\Controller;
use App\Model;
	
	class ImageView
	{
		protected $context = NULL;
		private $image;
		private $type;
		
		public function __construct($context, $image, $type) 
		{
			$this->context = $context;
			$this->image = $image;
			$this->type = $type;
			if($this->type == "")
			  $this->type = "image/jpg";
		}
		
		public function show()
		{
			header("Content-type: " . $this->type);
			echo $this->image;
		}
	}

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