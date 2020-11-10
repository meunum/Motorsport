<?php
	namespace App\View;
	use App\Model;
	require_once 'views.php';
	
	class SignUpView extends FormView
	{
		private \App\Model\Promoter $promoter;
		
		public function __construct($context, \App\Model\Promoter $promoter, $messages) 
		{
			parent::__construct($context, 'Motorsport (Konto erstellen)', $messages);
			$this->promoter = $promoter;
		}
		
		protected function showMainSectionContent()
		{
			parent::showMainSectionContent();
			print('<form id="veranstalter" action="index.php" enctype="multipart/form-data" method="post">');
			print('<legend class="dialogHint">Pflichtfelder sind gekennzeichnet mit: ' . $this->REQUIRED . '</legend>');
			print('<section class="groupBox">');
			print('<legend>Daten zur Anmeldung</legend>');
			print('<ul><li>');
			print('<label for="email"><span>E-Mail: ' . $this->REQUIRED . '</label>');
			print('<input class="edit" type="email" name="email" id="email" value="' . htmlspecialchars($_POST['email']??'') . '" required/>');
			print('</li><li>');
			print('<label for="passwort"><span>Passwort: </span>' . $this->REQUIRED . '</label>');
			print('<input class="edit" type="password" name="passwort" id="passwort" minlength="8" required/>');
			print('</li><li>');
			print('<label for="passwort2"><span>Passwort wiederholen: </span>' . $this->REQUIRED . '</label>');
			print('<input class="edit" type="password" name="passwort2" id="passwort2" minlength="8" required/>');
			print('</li></ul>');
			print('</section>');
			print('<section class="groupBox">');
			print('<legend>Daten des Veranstalters</legend>');
			print('<ul><li>');
			print('<label for="name"><span>Name: ' . $this->REQUIRED . '</label>');
			print('<input class="edit" type="text" name="name" id="name" value="' . htmlspecialchars($this->promoter->name??'') . '" required/>');
			print('</li><li>');
			print('<label for="kategorie"><span>Kategorie: </span></label>');
			print('<input class="edit" type="text" name="kategorie" id="kategorie" value="' . htmlspecialchars($this->promoter->kategorie??'') . '" />');
			print('</li><li>');
			print('<label for="region"><span>Region: </span></label>');
			print('<input class="edit" type="text" name="region" id="region" value="' . htmlspecialchars($this->promoter->region??'') . '"/>');
			print('</li><li>');
			print('<label for="beschreibung"><span>Beschreibung: </span></label>');
			print('<input class="edit" type="text" name="beschreibung" id="beschreibung" value="' . htmlspecialchars($this->promoter->beschreibung??'') . '" />');
			print('</li><li>');
			print('<label for="bild"><span>Bild: </span></label>');
			print('<input class="edit" type="file" name="bild" id="bild" />');
			print('</li><li>');
			print('<input class="edit" type="hidden" name="id" id="id" value="' . htmlspecialchars($this->promoter->id) . '" />');
			print('</li></ul>');
			print('</section>');
			print('<section id="submitSection">');
			print('<ul><li>');
			print('<label for="submitButton" id="buttonLabel">.</label>');
			print('<button class="submit" name="action" id="submitButton" value="Signup">Konto erstellen</button>');
			print('</li></ul>');
			print('</section></form>');
		}
	}

	class SignUpSuccessView extends HtmlView
	{
		
		public function __construct($context, $messages) 
		{
			parent::__construct($context, 'Motorsport (Konto erstellt)', $messages);
		}
		
		protected function showMainSectionContent()
		{
			print('<form id="signUpSuccess" action="index.php" enctype="multipart/form-data" method="post">');
			print('<div class="zentralerInfotext">');
			print('<p>Vielen Dank für Deine Registrierung auf ' . $this->context->domain . '.</p>');
			print('<p>Es wurde eine Nachricht an Deine Emailadresse geschickt. Um die Registrierung abzuschließen, klicke bitte auf den dort enthaltenen Link.</p>');
			print('<p>Danach kannst Du Dich mit Deinen Benutzerdaten auf ' . $this->context->domain . ' im Veranstalterbereich anmelden.</p>');
			print('</div></form>');
		}
	}
?>