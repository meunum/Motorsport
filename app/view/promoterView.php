<?php
namespace App\View;
use App\Model;

class PromoterView extends EntityView
{
	
	public function __construct($context, $messages) 
	{
		parent::__construct($context, $context->user->promoter, 'Motorsport (Veranstalterdaten)', $messages);
	}
	
	protected function showHeadNavContent()
	{
		print('<li><div class="navTitle">Kontodaten</div></li>');
		print('<li><a class="activeLink2" href="index.php?action=ChangePassword">Passwort ändern</a></li>');
	}

	public function showMainNavContent() 
	{
		print('<li><a class="activeLink2" href="index.php?action=PromoterList">Veranstalter</a></li>');
		print('<li><a class="activeLink2" href="index.php?action=EventList">Veranstaltungen</a></li>');
		print('<li><a class="activeLink2" href="index.php?action=Driverlist">Fahrer</a></li>');
	}
	
	protected function showMainSectionContent()
	{
		include 'inc/promoterViewContent.php';
	}
}
?>