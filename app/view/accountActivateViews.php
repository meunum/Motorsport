<?php
	namespace App\View;
	use App\Model;
	require_once 'views.php';
	
	class AccountActivateSuccessView extends formView
	{
		
		public function __construct($context, $messages) 
		{
			parent::__construct($context, 'Motorsport (Konto aktivieren)', $messages);
		}
		
		protected function showMainSectionContent()
		{
			print('<form id="accountActivate" action="index.php" enctype="multipart/form-data" method="post">');
			print('<section class="groupBox">');
			print('<div class="zentralerInfotext">');
			print('<p>Dein Konto auf ' . $this->context->domain . ' wurde erfolgreich aktiviert.</p>');
			print('<p>Du kannst Dich nun mit Deinen Benutzerdaten im Veranstalterbereich anmelden.</p>');
			print('</div>');
			print('<ul><li>');
			print('<label for="submitButton" id="buttonLabel">.</label>');
			print('<button class="button" name="view" id="submitButton" value="Login">Anmelden...</button>');
			print('</li></ul></section></form>');
		}
	}
	
	class AccountActivateErrorView extends FormView
	{
		
		public function __construct($context, $messages) 
		{
			parent::__construct($context, 'Motorsport (Konto aktivieren)', $messages);
		}

		protected function showMainSectionContent()
		{
			print('<div class="zentralerInfotext">');
			print('<p>Dein Konto konnte nicht aktiviert werden!</p>');
			print('</div>');
		}
	}
?>