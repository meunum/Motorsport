<?php
namespace App\View;
use App\Model;

class DriverView extends FormView
{
	private \App\Model\Driver $driver;
	
	public function __construct($context, $driver, $messages) 
	{
		parent::__construct($context, 'Motorsport (Fahrer bearbeiten)', $messages);
		$this->driver = $driver;
	}

	public function showMainNavContent() 
	{
		print('<li><div class="navTitle">Fahrer erfassen</div></li>');
	}
	
	protected function showMainSectionContent()
	{
		include 'inc\driverViewContent.php';
	}
}
?>