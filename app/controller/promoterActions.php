<?php
namespace App\Controller;
use App\Model;

class ShowPromoterListAction extends Action
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
		$this->list = \App\Model\PromoterList::createList();
		$this->success = isset($this->list);
		$this->executed = true;
		return $this->success;
	}
	
}

class ShowPromoterViewAction extends Action
{

	public function createViewOnSuccess()
	{
		return new \App\View\PromoterView($this->context, []);
	}

	public function createViewOnFail()
	{
		$_POST = [];
		return new \App\View\LoginView($this->context, []);
	}
	
	public function execute()
	{
		$this->success = $this->context->user->loggedIn;
		$this->executed = true;

		return $this->success;

	}
	
}

class ShowPromoterEventListAction extends Action
{
	private $list;
	
	public function createViewOnSuccess()
	{
		return new \App\View\PromoterEventListView($this->context, $this->list);
	}

	public function createViewOnFail()
	{
		return new \App\View\LoginView($this->context, []);
	}
	
	public function execute()
	{
		if($this->context->user->loggedIn)
		{
			$this->list = $this->context->user->promoter->events();
			$this->success = true;
		}
		$this->executed = true;

		return $this->success;

	}
	
}
?>