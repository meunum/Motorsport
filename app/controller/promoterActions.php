<?php
namespace App\Controller;
use App\Model;

class ShowPromoterListAction extends Action
{
	private $list;
	
	public function createView()
	{
		if(!$this->executed)
			$this->execute();
		if($this->success)
			return new \App\View\PromoterListView($this->context, $this->list);
		
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

	public function createView()
	{
		if(!$this->executed)
			$this->execute();
		if($this->success)
			return new \App\View\PromoterView($this->context, []);
		else
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
	
	public function createView()
	{
		if(!$this->executed)
			$this->execute();
		if($this->success)
			return new \App\View\PromoterEventListView($this->context, $this->list);
	}
	
	public function execute()
	{
		$this->list = $this->context->user->promoter->events();
		$this->success = isset($this->list);
		$this->executed = true;
		return $this->success;
	}
	
}
?>