<?php
namespace App\Controller;
use App\Model;
use App\View;

class InsertEventAction extends Action
{
	
	public function __construct($context, $parameter) 
	{
		parent::__construct($context, $parameter);
	}

	protected function createViewOnSuccess()
	{
		return new \App\View\EventView($this->context, new \App\Model\Event([]), []);
	}

	protected function createViewOnFail()
	{
		return new \App\View\LoginView($this->context);
	}
	
	public function execute()
	{
		parent::execute();
		$this->executed = true;
		$this->success = $this->context->user->loggedIn;
	}
}

class EventAction extends Action
{
	protected int $eventId = 0;
	protected \App\Model\Event $event;
	
	public function __construct($context, $parameter) 
	{
		parent::__construct($context, $parameter);
		$context->logger->LogDebug("\n-------------------------------------------------------\n");
		$context->logger->LogDebug($this->className() . "->__construct(" . print_r($parameter, true) . ")\n");
		
		$this->eventId = $parameter['id'];
		
		$context->logger->LogDebug("eventId: " . $this->eventId);
	}
	
	public function execute()
	{
		parent::execute();
		$this->event = \App\Model\EventList::get($this->eventId);
		$this->context->logger->LogDebug("event: " . print_r($this->event, true) . ")\n");
		
		$this->executed = true;
		$this->success = isset($this->event);

		$this->context->logger->LogDebug("success: " . $this->success . "\n");
	}
}

class EditEventAction extends EventAction
{

	protected function createViewOnSuccess()
	{
		return new \App\View\EventView($this->context, $this->event, []);
	}
	
	public function execute()
	{
		parent::execute();
	}
}

class DeleteEventAction extends EventAction
{
	private $list;

	public function createView()
	{
		return new \App\View\EventListView($this->context, $this->list, []);
	}
	
	public function execute()
	{
		parent::execute();
		\App\Model\EventList::delete($this->event);
		$this->list = $this->context->user->promoter->events();
	}
}

class EventSubmitAction extends Action
{
	protected \App\Model\Event $event;
	
	public function __construct($context, $parameter) 
	{
		parent::__construct($context, $parameter);
		$context->logger->LogDebug("\n-------------------------------------------------------\n");
		$context->logger->LogDebug("EventSubmitAction->__construct()\n");
	}

	protected function createViewOnSuccess()
	{
		$followAction = new EventListAction($this->context, $this->parameter);
		return $followAction->createView();
	}

	protected function createViewOnFail()
	{
		return new \App\View\EventView($this->context, $this->event, $this->messages);
	}
	
	public function execute()
	{
		parent::execute();

		$this->executed = true;
		$this->event = new \App\Model\Event($_POST);

		$this->context->logger->LogDebug("event: " . print_r($this->event, true) . ")\n");

		$this->success = $this->saveEvent();
	}
	
	private function saveEvent()
	{
		$this->messages = \App\Model\EventList::validate($this->event);
		if(empty($this->messages)) 
		{
			\App\Model\EventList::save($this->event);
			return true;
		}
		
		return false;
		
	}
}

class EventListAction extends Action
{
	protected $list = [];
	
	public function __construct($context, $parameter) 
	{
		parent::__construct($context, $parameter);
		$context->logger->LogDebug("\n-------------------------------------------------------\n");
		$context->logger->LogDebug("EditEventAction->__construct(" . print_r($parameter, true) . ")\n");
	}

	protected function createViewOnSuccess()
	{
		return new \App\View\EventListView($this->context, $this->list, []);
	}

	protected function createViewOnFail()
	{
	}
	
	public function execute()
	{
		parent::execute();
		
		if($this->context->user->loggedIn)
			$this->list = $this->context->user->promoter->events();
		else
			$this->list = \App\Model\EventList::createList();
		$this->executed = true;
		$this->success = true;

		$this->context->logger->LogDebug("success: " . $this->success . "\n");
	}
}
?>