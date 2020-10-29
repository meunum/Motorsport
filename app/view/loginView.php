<?php
	namespace App\View;
	use App\Model;
	require_once 'htmlView.php';
	
	class LogInView extends htmlView
	{
		
		private function showMainContent()
		{
			print('<main>');
			print('<form id="veranstalter" action="index.php" enctype="multipart/form-data" method="post">');
			print('<section class="dialogSection">');
			printf('<legend>Bitte melde Dich mit Deinen Zugansdaten auf %s an.</legend>', $this->context->domain);
			print('<ul><li>');
			print('<label for="email"><span>E-Mail: </span></label>');
			printf('<input class="edit" type="email" name="email" id="email" value="%s" />', $this->context->user->email);
			print('</li><li>');
			print('<label for="passwort">Passwort</label>');
			print('<input class="edit" id="passwort" name="passwort" type="password" minlength="8" >');
			print('</li><li>');
			print('<label for="submitButton" id="buttonLabel">.</label>');
			print('<button class="button" name="action" id="submitButton" value="login">Anmelden</button>');
			print('</li></ul>');
			print('</section>');
			print('<section class="dialogSection">');
			printf('<legend>Falls Du noch kein Benutzerkonto auf %s hast, dann klicke auf Registrieren, um ein Konto anzulegen.</legend>', $this->context->domain);
			print('<ul><li>');
			print('<label for="signupButton" id="buttonLabel">.</label>');
			print('<button class="button" name="view" id="signupButton" value="signupView">Registrieren</button>');
			print('</li></ul>');
			print('</section></form></main>');
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
			$this->showHtmlHead('Motorsport (anmelden)');
			$this->showBody();
			$this->endPage();
		}
	}
?>