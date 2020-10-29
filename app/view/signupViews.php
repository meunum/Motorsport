<?php
	namespace App\View;
	use App\Model;
	require_once 'views.php';
	
	class SignUpView extends FormView
	{
		
		private function showMainContent()
		{
			$REQUIRED = "<abbr class = 'required' title='erforderlich' >*</abbr>";
			print('<main>');
			print('<form id="veranstalter" action="index.php" enctype="multipart/form-data" method="post">');
			print('<legend class="dialogHint">Pflichtfelder sind gekennzeichnet mit: ' . $REQUIRED . '</legend>');
			print('<section class="groupBox">');
			print('<legend>Daten zur Anmeldung</legend>');
			print('<ul><li>');
			print('<label for="email"><span>E-Mail: ' . $REQUIRED . '</label>');
			print('<input class="edit" type="email" name="email" id="email" value="' . htmlspecialchars($_POST['email']??'') . '" required/>');
			print('</li><li>');
			print('<label for="passwort"><span>Passwort: </span>' . $REQUIRED . '</label>');
			print('<input class="edit" type="password" name="passwort" id="passwort" minlength="8" required/>');
			print('</li><li>');
			print('<label for="passwort2"><span>Passwort wiederholen: </span>' . $REQUIRED . '</label>');
			print('<input class="edit" type="password" name="passwort2" id="passwort2" minlength="8" required/>');
			print('</li></ul>');
			print('</section>');
			print('<section class="groupBox">');
			print('<legend>Daten des Veranstalters</legend>');
			print('<ul><li>');
			print('<label for="name"><span>Name: ' . $REQUIRED . '</label>');
			print('<input class="edit" type="text" name="name" id="name" value="' . htmlspecialchars($_POST['name']??'') . '" required/>');
			print('</li><li>');
			print('<label for="kategorie"><span>Kategorie: </span></label>');
			print('<input class="edit" type="text" name="kategorie" id="kategorie" value="' . htmlspecialchars($_POST['kategorie']??'') . '" />');
			print('</li><li>');
			print('<label for="region"><span>Region: </span></label>');
			print('<input class="edit" type="text" name="region" id="region" value="' . htmlspecialchars($_POST['region']??'') . '"/>');
			print('</li><li>');
			print('<label for="beschreibung"><span>Beschreibung: </span></label>');
			print('<input class="edit" type="text" name="beschreibung" id="beschreibung" value="' . htmlspecialchars($_POST['beschreibung']??'') . '" />');
			print('</li><li>');
			print('<label for="bild"><span>Bild: </span></label>');
			print('<input class="edit" type="file" name="bild" id="bild" />');
			print('</li></ul>');
			print('</section>');
			print('<section id="submitSection">');
			print('<ul><li>');
			print('<label for="submitButton" id="buttonLabel">.</label>');
			print('<button class="button" name="action" id="submitButton" value="signup">Konto erstellen</button>');
			print('</li></ul>');
			print('</section></form></main>');
		}
		
		private function showBody()
		{
			print('<body>');
			$this->showHeader();
			$this->showMessages();
			$this->showMainContent();
			$this->showFooter();
			print('</body>');
		}
		
		public function show()
		{
			$this->startPage();
			$this->showHtmlHead('Motorsport (anmelden)');
			$this->showBody();
			$this->endPage();
		}
	}

	class SignUpSuccessView extends HtmlView
	{
		
		private function showMainContent()
		{
			print('<main>');
			print('<div class="zentralerInfotext">');
			print('<p>Vielen Dank für Deine Registrierung auf dieser Seite.</p>');
			print('<p>Es wurde eine Nachricht an Deine Emailadresse geschickt. Um die Registrierung abzuschließen, klicke bitte auf den dort enthaltenen Link. Danach kannst Du Dich mit Deinen Benutzerdaten im Veranstalterbereich anmelden.</p>');
			print('</div>');
			print('</main>');
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
			$this->showHtmlHead('Motorsport (Konto erstellt)');
			$this->showBody();
			$this->endPage();
		}
	}
?>