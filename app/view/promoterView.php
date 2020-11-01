<?php
	namespace App\View;
	use App\Model;
	require_once 'views.php';
	
	class PromoterView extends FormView
	{
		
		private function showMainContent()
		{
			print('<main>');
			print('<section class="mainHead">');
			print('<nav class="mainNav">');
			print('<ul>');
			print('<li><div class="navTitle">Meine Grunddaten</div></li>');
			print('<li><a class="activeLink2" href="index.php?view=eventEditListView">Meine Veranstaltungen</a></li>');
			print('<li><a class="activeLink2" href="index.php?view=driverEditListView">Meine Fahrerliste</a></li>');
			print('</ul></nav></section>');
			print('<form id="veranstalter" action="index.php" enctype="multipart/form-data" method="post">');
			print('<legend class="dialogHint">Pflichtfelder sind gekennzeichnet mit: ' . $this->REQUIRED . '</legend>');
			print('<section class="groupBox">');
			print('<ul><li>');
			print('<label for="email"><span>E-Mail: </span></label>');
			print('<input class="edit" type="text" name="email" id="email" disabled value="' . htmlspecialchars($this->context->user->email) . '"/>');
			print('</li><li>');
			print('<label for="name"><span>Name: </span>' . $this->REQUIRED . '</label>');
			print('<input class="edit" type="text" name="name" id="name" value="' . htmlspecialchars($this->context->user->promoter->name) . '" required/>');
			print('</li><li>');
			print('<label for="kategorie"><span>Kategorie: </span></label>');
			print('<input class="edit" type="text" name="kategorie" id="kategorie" value="' . htmlspecialchars($this->context->user->promoter->kategorie) . '" />');
			print('</li><li>');
			print('<label for="region"><span>Region: </span></label>');
			print('<input class="edit" type="text" name="region" id="region" value="' . htmlspecialchars($this->context->user->promoter->region) . '"/>');
			print('</li><li>');
			print('<label for="beschreibung"><span>Beschreibung: </span></label>');
			print('<input class="edit" type="text" name="beschreibung" id="beschreibung" value="' . htmlspecialchars($this->context->user->promoter->beschreibung) . '" />');
			print('</li><li>');
			print('<label for="bild"><span>Bild hochladen: </span></label>');
			print('<input class="edit" type="file" name="bild" id="bild" />');
			print('</li><li>');
			print('<label for="bild"><span>Bild aktuell: </span></label>');
			$this->showImage($this->context->user->promoter->bildId, 160, 90);
			print('</li></ul>');
			print('</section>');
			print('<section id="buttonSection">');
			print('<ul><li>');
			print('<label for="submitButton" id="buttonLabel">.</label>');
			print('<button name="action" id="submitButton" value="promoterView.submit">Speichern</button>');
			print('<button name="action" id="logoutButton" value="logout">Abmelden</button>');
			print('</li></ul></section></form></main>');
		}
		
		private function showBody()
		{
			print('<body>');
			$this->showHeader();
			$this->showMainContent();
			$this->showFooter();
			print('</body>');
		}
		
		public function show()
		{
			$this->startPage();
			$this->showHtmlHead('Motorsport (Veranstalterdaten)');
			$this->showMessages();
			$this->showBody();
			$this->endPage();
		}
	}
?>