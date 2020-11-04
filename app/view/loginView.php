<?php
	namespace App\View;
	use App\Model;
	require_once 'views.php';
	
	class LogInView extends FormView
	{
		
		public function __construct($context, $messages) 
		{
			parent::__construct($context, 'Motorsport (anmelden)', $messages);
		}
		
		protected function showMainSectionContent()
		{
			print('<form id="veranstalter" action="index.php" enctype="multipart/form-data" method="post">');
			print('<section class="dialogSection">');
			printf('<legend>Bitte melde Dich mit Deinen Zugangsdaten auf %s an.</legend>', $this->context->domain);
			print('<ul><li>');
			print('<label for="email"><span>E-Mail: </span></label>');
			printf('<input class="edit" type="email" name="email" id="email" value="%s" />', $this->context->user->email);
			print('</li><li>');
			print('<label for="passwort">Passwort</label>');
			print('<input class="edit" id="passwort" name="passwort" type="password" minlength="8" >');
			print('</li><li>');
			print('<label for="submitButton" id="buttonLabel">.</label>');
			print('<button class="button" name="action" id="submitButton" value="Login">Anmelden</button>');
			print('</li></ul>');
			print('</section>');
			print('<section class="dialogSection">');
			printf('<legend>Falls Du noch kein Benutzerkonto auf %s hast, dann klicke auf Registrieren, um ein Konto anzulegen.</legend>', $this->context->domain);
			print('<ul><li>');
			print('<label for="signupButton" id="buttonLabel">.</label>');
			print('<button class="button" name="view" id="signupButton" value="Signup">Registrieren</button>');
			print('</li></ul>');
			print('</section></form>');
		}
	}
?>