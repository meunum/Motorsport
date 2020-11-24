<?php
namespace App\View;
use App\Model;

class DriverView extends EntityView
{
	private \App\Model\Driver $driver;
	
	public function __construct($context, $driver, $messages) 
	{
		parent::__construct($context, $driver, 'Motorsport (Fahrer bearbeiten)', $messages);
		$this->driver = $driver;
	}

	public function showMainNavContent() 
	{
		print('<li><div class="navTitle">Fahrer bearbeiten</div></li>');
	}
	
	protected function showMainSectionContent()
	{
		parent::showMainSectionContent();
		include 'inc/driverViewContent.php';
	}
}
?>