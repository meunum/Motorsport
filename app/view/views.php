<?php

namespace App\View;

	class HtmlView
	{
		protected $context = NULL;
		protected string $title = '';
		
		public function __construct($context, $title) 
		{
			$this->context = $context;
			$this->title = $title;
		}
	
		public function className()
		{
			$arr = explode('\\', get_class($this));
			return $arr[count($arr) - 1];
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
			print('	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">');
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
			print('			<li><a class="activeLink1" href="index.php?action=ShowPromoterView">Veranstalterbereich</a></li>');
			print('		</ul>');
			print('	</nav>');
			print('</header>');
		}
		
		private function showBody()
		{
			print('<body>');
			$this->showHeader();
			print('<main>');
			$this->showMainHead();
			$this->showMainSectionContent();
			print('</main>');
			$this->showFooter();
			print('</body>');
		}
		
		protected function showMainHead()
		{
			print('<section class="mainHead">');
			print('<nav class="userNav">');
			print('<ul>');
			if($this->context->user->loggedIn)
				print('<li><a class="activeLink2" href="index.php?action=Logout@' . $this->className() . '">Abmelden</a></li>');
			else
				print('<li></li>');
			print('</ul>');
			print('</nav>');
			if($this->context->user->loggedIn)
				print('<legend class="userLegend">Du bist angemeldet als ' . htmlspecialchars($this->context->user->promoter->name??'') . '</legend>');
			else
				if($this->context->user->justLoggedOut)
					print('<legend class="userLegend">Du bist nicht mehr angemeldet</legend>');
				else
					print('<legend class="userLegend"></legend>');
			print('<nav class="mainNav">');
			print('<ul>');
			$this->showMainNavContent();
			print('</ul>');
			print('</nav>');
			print('</section>');
			
		}
		
		protected function showMainSectionContent()
		{
		}

		public function showMainNavContent() 
		{
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

		protected function showImage(int $id, int $width, int $height)
		{
			if($id == 0)
				echo '<img src="app/view/img/placeholder.jpg" width="' . $width . '" height="' . $height . '"/>';
			else
				echo '<img src="index.php?action=ShowImage@', $id, '" width="' . $width . '" height="' . $height . '"/>';
		}
		
		public function show()
		{
			$this->startPage();
			$this->showHtmlHead($this->title);
			$this->showBody();
			$this->endPage();
		}

	}

	class FormView extends HtmlView
	{
		protected $messages = [];
		protected $REQUIRED = "<abbr class = 'required' title='erforderlich' >*</abbr>";
		
		public function __construct($context, $title, $messages) 
		{
			parent::__construct($context, $title);
			$this->messages = $messages;
		}
		
		protected function showMainSectionContent()
		{
			$this->showMessages();
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

	class ListView extends HtmlView
	{
		protected $contentList;
		
		public function __construct($context, $title, $list) 
		{
			parent::__construct($context, $title);
			$this->contentList = $list;
		}
	}
	
	class ImageView
	{
		protected $context = NULL;
		private $image;
		
		public function __construct($context, $image) 
		{
			$this->context = $context;
			$this->image = $image;
		}
		
		public function show()
		{
			header("Content-type: image/jpg");
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