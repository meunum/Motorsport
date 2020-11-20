<?php
namespace App\Controller;
use App\Model;
use App\View;

class InsertDriverAction extends Action
{
	
	public function __construct($context, $parameter) 
	{
		parent::__construct($context, $parameter);
	}

	protected function createViewOnSuccess()
	{
		return new \App\View\DriverView($this->context, new \App\Model\Driver([]), []);
	}

	protected function createViewOnFail()
	{
		return new \App\View\LoginView($this->context);
	}
	
	public function execute()
	{
		$this->executed = true;
		$this->success = true;
	}
}

class DriverAction extends Action
{
	protected int $DriverId = 0;
	protected \App\Model\Driver $Driver;
	
	public function __construct($context, $parameter) 
	{
		parent::__construct($context, $parameter);
		$context->logger->LogDebug("\n-------------------------------------------------------\n");
		$context->logger->LogDebug($this->className() . "->__construct(" . print_r($parameter, true) . ")\n");
		
		$this->DriverId = $_POST['id'];
		
		$context->logger->LogDebug("DriverId: " . $this->DriverId);
	}
	
	public function execute()
	{
		$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
		$this->context->logger->LogDebug($this->className() . "->execute()\n");
		$this->Driver = \App\Model\DriverList::get($this->DriverId);
		$this->context->logger->LogDebug("Driver: " . print_r($this->Driver, true) . ")\n");
		
		$this->executed = true;
		$this->success = isset($this->Driver);

		$this->context->logger->LogDebug("success: " . $this->success . "\n");
	}
}

class EditDriverAction extends DriverAction
{

	protected function createViewOnSuccess()
	{
		return new \App\View\DriverView($this->context, $this->Driver, []);
	}
}

class DeleteDriverAction extends DriverAction
{
	private $list;

	public function createView()
	{
		return new \App\View\DriverListView($this->context, $this->list, []);
	}
	
	public function execute()
	{
		parent::execute();
		\App\Model\DriverList::delete($this->Driver);
		$this->list = \App\Model\DriverList.createList();
	}
}

class DriverSubmitAction extends Action
{
	protected \App\Model\Driver $Driver;
	
	public function __construct($context, $parameter) 
	{
		parent::__construct($context, $parameter);
		$context->logger->LogDebug("\n-------------------------------------------------------\n");
		$context->logger->LogDebug("DriverSubmitAction->__construct()\n");
	}

	protected function createViewOnSuccess()
	{
		$followAction = new DriverListAction($this->context, $this->parameter);
		return $followAction->createView();
	}

	protected function createViewOnFail()
	{
		return new \App\View\DriverView($this->context, $this->Driver, $this->messages);
	}
	
	public function execute()
	{
		$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
		$this->context->logger->LogDebug("DriverSubmitAction->execute()\n");

		$this->executed = true;
		$this->Driver = new \App\Model\Driver($_POST);

		$this->context->logger->LogDebug("Driver: " . print_r($this->Driver, true) . ")\n");

		$this->success = $this->saveDriver();
	}
	
	private function saveDriver()
	{
		$this->messages = \App\Model\DriverList::validate($this->Driver);
		if(empty($this->messages)) 
		{
			\App\Model\DriverList::save($this->Driver);
			return true;
		}
		
		return false;
		
	}
}

class DriverListAction extends Action
{
	protected $list = [];
	
	public function __construct($context, $parameter) 
	{
		parent::__construct($context, $parameter);
		$context->logger->LogDebug("\n-------------------------------------------------------\n");
		$context->logger->LogDebug("EditDriverAction->__construct(" . print_r($parameter, true) . ")\n");
	}

	protected function createViewOnSuccess()
	{
		return new \App\View\DriverListView($this->context, $this->list, []);
	}

	protected function createViewOnFail()
	{
	}
	
	public function execute()
	{
		$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
		$this->context->logger->LogDebug("DriverListAction->execute()\n");
		
		$this->list = \App\Model\DriverList::createList();
		$this->executed = true;
		$this->success = true;

		$this->context->logger->LogDebug("success: " . $this->success . "\n");
	}
}
?>