<?php
namespace App\Controller;
use App\Model;
use App\View;

class InsertEventAction extends Action
{
	
	public function __construct($context) 
	{
		$this->context = $context;
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

class EventSubmitAction extends SubmitAction
{
	protected \App\Model\Event $event;
	
	public function __construct($context) 
	{
		$this->context = $context;
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
		$this->executed = true;
		$this->event = new \App\Model\Event($_POST);
		$this->saveEvent();
	}
	
	private function saveEvent()
	{
		try 
		{
			$this->messages = \App\Model\EventList::validate($this->event);
			if(empty($this->messages)) 
			{
				\App\Model\EventList::save($this->event);
				$this->success = true;
			}
		}
		catch (Exception $e) {
			$this->messages[] = 'Fehler beim Speichern';
			$this->messages[] = $e->getMessage();
		}
		
		return $this->success;
		
	}
}
?>