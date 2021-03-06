<?php
namespace App\Controller;
use App\Model;

class PromoterListAction extends Action
{
	private $list;
	
	public function createViewOnSuccess()
	{
		return new \App\View\PromoterListView($this->context, $this->list);
	}
	
	public function createViewOnFail()
	{
		return new \App\View\PromoterListView($this->context, []);
	}
	
	public function execute()
	{
		parent::execute();
		$this->list = \App\Model\PromoterList::createList();
		$this->success = isset($this->list);
		$this->executed = true;
		return $this->success;
	}
	
}

class LoggedInPromoterActions extends Action
{

	public function createViewOnFail()
	{
		if (!$this->context->user->loggedIn)
		{
			$_POST = [];
			return new \App\View\LoginView($this->context, []);
		}
		else
			return null;
	}
	
	protected function executeIfLoggenIn()
	{
		
	}
	
	public function execute()
	{
		parent::execute();
		$this->executed = true;
		if($this->context->user->loggedIn)
			$this->success = $this->executeIfLoggenIn();
		
		return $this->success;

	}
}

class ShowPromoterViewAction extends LoggedInPromoterActions
{

	public function createViewOnSuccess()
	{
		return new \App\View\PromoterView($this->context, []);
	}
	
	public function executeIfLoggenIn()
	{
		$this->success = true;
		
		return $this->success;

	}
}

?>