<?php
namespace App\Controller;
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
	protected $event;
	
	public function __construct($context) 
	{
		$this->context = $context;
	}

	protected function createViewOnSuccess()
	{
		$followAction = new \App\Controller\ShowPromoterEventListAction($this->context);
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
		$this->checkInput();
		if(empty($this->messages)) 
		{
			try 
			{
				\App\Model\EventList::save($this->event);
				$this->success = true;
			}
			catch (PDOException $e) {
				$this->messages[] = 'Fehler beim Speichern';
			}
		}
		
		return $this->success;
		
	}
		
	private function checkInput()
	{
		$this->messages = [];

/*		if(!empty($_POST['']) && $_POST['']==$_POST['']) {
			$this->messages[] = '';
		}*/
	}
}
?>