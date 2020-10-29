<?php
	namespace App\View;
	require_once 'htmlView.php';
	
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