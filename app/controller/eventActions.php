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
		$this->executed = true;
		$this->success = $this->context->user->loggedIn;
	}
}

class EditEventAction extends Action
{
	private int $eventId = 0;
	private \App\Model\Event $event;
	
	public function __construct($context, $parameter) 
	{
		parent::__construct($context, $parameter);
		$context->logger->LogDebug("\n-------------------------------------------------------\n");
		$context->logger->LogDebug("EditEventAction->__construct(" . print_r($parameter, true) . ")\n");
		
		$this->eventId = $parameter[1];
		
		$context->logger->LogDebug("eventId: " . $this->eventId);
	}

	protected function createViewOnSuccess()
	{
		return new \App\View\EventView($this->context, $this->event, []);
	}

	protected function createViewOnFail()
	{
	}
	
	public function execute()
	{
		$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
		$this->context->logger->LogDebug("EditEventAction->execute()\n");
		$this->event = \App\Model\EventList::get($this->eventId);
		$this->context->logger->LogDebug("event: " . print_r($this->event, true) . ")\n");
		
		$this->executed = true;
		$this->success = isset($this->event);

		$this->context->logger->LogDebug("success: " . $this->success . "\n");
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
		$followAction = new ShowPromoterEventListAction($this->context);
		return $followAction->createView();
	}

	protected function createViewOnFail()
	{
		return new \App\View\EventView($this->context, $this->event, $this->messages);
	}
	
	public function execute()
	{
		$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
		$this->context->logger->LogDebug("EventSubmitAction->execute()\n");

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
?>