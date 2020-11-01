<?php

namespace App\View;

	class HtmlView
	{
		protected $context = NULL;
		
		public function __construct($context) 
		{
			$this->context = $context;
		}
	
		protected function startPage()
		{
			print('<!DOCTYPE html>');
			print('<html>');
		}
	
		protected function endPage()
		{
			print('</html>');
		}
		
		protected function showHtmlHead(string $title)
		{
			print('<head>');
			print('	<title>' . $title . '</title>');
			print('	<meta charset="UTF8"/>');
			print('	<link rel="stylesheet" type="text/css" href="app\view\css\style.css"/>');
			print('	<link rel="stylesheet" type="text/css" href="app\view\css\form.css"/>');
			print('</head>');
		}
		
		protected function showHeader()
		{
			print('<header id="header">');
			print('	<nav id="homeNav">');
			print('		<ul>');
			print('			<li><a class="activeLink1" href="index.php">Home</a></li>');
			print('			<li><a class="activeLink1" href="index.php">Impressum</a></li>');
			print('			<li><a class="activeLink1" href="index.php">Kontakt</a></li>');
			print('		</ul>');
			print('	</nav>');
			print('	<nav id="accountNav">');
			print('		<ul>');
			print('			<li><a class="activeLink1" href="index.php?view=promoterView">Veranstalterbereich</a></li>');
			print('		</ul>');
			print('	</nav>');
			print('</header>');
		}
		
		protected function showFooter()
		{
			print('<footer>');
			print('	<nav id="footNav">');
			print('		<ul>');
			print('			<li>');
			print('				<a class="activeLink1" href="#header">Zum Seitenanfang</a>');
			print('			</li>');
			print('		</ul>');
			print('	</nav>');
			print('	<div>');
			print('		<legend id="footLegend">Letzte Aktualisierung: ' . $this->context->lastupdate . '</legend>');
			print('	</div>');
			print('</footer>');
		}

		protected function showImage($id, int $width, int $height)
		{
			if($id == null)
				echo '<img src="app/view/img/placeholder.jpg" width="' . $width . '" height="' . $height . '"/>';
			else
				echo '<img src="index.php?view=imageView&imageId=', $id, '" width="' . $width . '" height="' . $height . '"/>';
		}

	}

	class FormView extends HtmlView
	{
		protected $messages = [];
		protected $REQUIRED = "<abbr class = 'required' title='erforderlich' >*</abbr>";
		
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