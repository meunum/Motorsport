<?php
	namespace App\View;
	use App\Model;
	require_once 'views.php';
	
	class AccountActivateSuccessView extends formView
	{
		private function showMainContent()
		{
			print('<main>');
			print('<section class="groupBox">');
			print('<ul><li>');
			print('<label for="name"><span>Dein Konto wurde erfolgreich aktiviert. Du kannst Dich nun mit Deinen Benutzerdaten anmelden.</label>');
			print('</li></ul></section>');
			print('<section id="submitSection">');
			print('<ul><li>');
			print('<label for="submitButton" id="buttonLabel">.</label>');
			print('<button class="button" name="view" id="submitButton" value="loginView">Anmelden...</button>');
			print('</li></ul></section></form></main>');
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
			$this->showHtmlHead('Motorsport (Konto aktivieren)');
			$this->showBody();
			$this->endPage();
		}
	}
	
	class AccountActivateErrorView extends FormView
	{
		private function showMainContent()
		{
			print('<main>');
			print('<div class="zentralerInfotext">');
			print('<p>Dein Konto konnte nicht aktiviert werden!</p>');
			print('</div>');
			print('</main>');
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
			$this->showHtmlHead('Motorsport (Konto aktivieren)');
			$this->showBody();
			$this->endPage();
		}
	}
?>