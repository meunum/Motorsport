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
			print('<li><a class="homeNavLink" href="index.php">Home</a></li>');
			print('<li><a class="homeNavLink" href="index.php">Impressum</a></li>');
			print('<li><a class="homeNavLink" href="index.php">Kontakt</a></li>');
			print('</ul>');
			print('</nav>');
			print('<nav id="userNav">');
			print('<ul>');
			if($this->context->user->loggedIn)
			{
				print('<li><a class="userNavLink" href="index.php?action=Logout&sender=' . $this->className() . '">' . $this->context->user->promoter->name . ' Abmelden</a></li>');
			}
			print('<li><a class="userNavLink" href="index.php?action=ShowPromoterView"><span class="icon"><i class="far fa-user"></i></span>');
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

		protected function showMainNavContent() 
		{
		}
		
		protected function showFooter()
		{
			print('<footer>');
			print('	<nav id="footNav">');
			print('		<ul>');
			print('			<li>');
			print('				<a class="homeNavLink" href="#header">Zum Seitenanfang</a>');
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
				$width = $height * (275 / 183);
				echo '<img src="app/view/img/placeholder.png" width="' . $width . '" height="' . $height . '"/>';
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
?>