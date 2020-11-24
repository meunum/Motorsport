<?php

namespace App\View;
use App\Controller;
use App\Model;

	class HtmlView extends \App\Controller\AppObject
	{
		protected $context = NULL;
		protected string $title = '';
		
		public function __construct($context, $title) 
		{
			$this->context = $context;
			$this->title = $title;
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
			print('	<script src="https://kit.fontawesome.com/b20425f347.js" crossorigin="anonymous"></script>');
			print('</head>');
		}
		
		protected function showHeader()
		{
			print('<header id="header">');
			print('<nav id="homeNav">');
			print('<ul>');
			print('<li><a class="activeLink1" href="index.php">Home</a></li>');
			print('<li><a class="activeLink1" href="index.php">Impressum</a></li>');
			print('<li><a class="activeLink1" href="index.php">Kontakt</a></li>');
			print('</ul>');
			print('</nav>');
			print('<nav id="accountNav">');
			print('<ul>');
			if($this->context->user->loggedIn)
			{
				print('<li><a class="activeLink1" href="index.php?action=Logout&sender=' . $this->className() . '">' . $this->context->user->promoter->name . ' Abmelden</a></li>');
			}
			print('<li><a class="activeLink1" href="index.php?action=ShowPromoterView"><span class="icon"><i class="far fa-user"></i></span>');
			if($this->context->user->loggedIn)
			{
				print('Konto');
			}
			else
			{
				print('Anmelden');
			}
			print('</a></li></ul>');
			print('</nav>');
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
			$this->showHeadNavContent();
			print('</ul>');
			print('</nav>');
			print('<nav class="mainNav">');
			print('<ul>');
			$this->showMainNavContent();
			print('</ul>');
			print('</nav>');
			print('</section>');
			
		}
		
		protected function showHeadNavContent()
		{
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
			{
				$width = $height * (209 / 222);
				echo '<img src="app/view/img/placeholder.jpg" width="100" height="90"/>';
			}
			else
			{
				$stmt = $this->context->database->query("SELECT hoehe, breite FROM grafik WHERE hoehe<>0 AND breite<>0 AND id=" . $id);
				if($stmt)
				{
					$data = $stmt->fetch();
					if($data)
					{
						$width = $height * ($data['breite'] / $data['hoehe']);
					}
				}
				echo '<img src="index.php?action=ShowImage&id=', $id, '" width="' . $width . '" height="' . $height . '"/>';
			}
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

	class EntityView extends FormView
	{
		protected \App\Model\Entity $entity;
		
		public function __construct($context, $entity, $title, $messages) 
		{
			parent::__construct($context, $title, $messages);
			$this->entity = $entity;
		}
		
		protected function ShowImageFragment()
		{
			print('<li>');
			print('	<label for="bild"><span>Bild hochladen: </span></label>');
			print('	<input class="edit" type="file" name="bild" id="bild" />');
			print('</li>');
			print('<li>');
			print('	<label for="bild"><span>Bild aktuell: </span></label>');
			$this->showImage($this->entity->bildId, 320, 180);
			print('</li>');
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