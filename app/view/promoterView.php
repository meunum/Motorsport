<?php
	namespace App\View;
	use App\Model;
	require_once 'views.php';
	
	class PromoterView extends FormView
	{
		
		public function __construct($context, $messages) 
		{
			parent::__construct($context, 'Motorsport (Veranstalterdaten)', $messages);
		}

		public function showMainNavContent() 
		{
			print('<li><div class="navTitle">Meine Grunddaten</div></li>');
			print('<li><a class="activeLink2" href="index.php?action=ChangePassword">Passwort ändern</a></li>');
		}
		
		protected function showMainSectionContent()
		{
			include 'inc/promoterViewContent.php';
		}
	}
?>