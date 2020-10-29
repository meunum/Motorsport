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
				print('			<li><a class="activeLink1" href="index.php?view=currentUserView">Veranstalterbereich</a></li>');
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

			protected function showImage(int $id, int $width, int $height)
			{
				echo '<img src="index.php?view=imageView&imageId=', $id, '" width="' . $width . '" height="' . $height . '"/>';
			}
			
			public function show()
			{
			}
		}
?>