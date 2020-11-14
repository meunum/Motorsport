<?php
namespace App\Controller;
use App\Model;
use App\View;

class PromoterSubmitAction extends Action
{

	protected \App\Model\Promoter $promoter;
	
	public function __construct($context, $parameter) 
	{
		parent::__construct($context, $parameter);
		$context->logger->LogDebug("\n-------------------------------------------------------\n");
		$context->logger->LogDebug("PromoterSubmitAction->__construct()\n");
	}
	
	public function createView()
	{
		return new \App\View\promoterView($this->context, $this->promoter, $this->messages);
	}
	
	public function execute()
	{
		$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
		$this->context->logger->LogDebug("PromoterSubmitAction->execute()\n");
		$this->executed = true;
		$this->promoter = new \App\Model\Promoter($_POST);
		$this->savePromoter();
	}
	
	public function savePromoter()
	{
		$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
		$this->context->logger->LogDebug("PromoterSubmitAction->savePromoter()\n");
		$this->context->logger->LogDebug("promoter: " . print_r($this->promoter, true));

		$this->messages = \App\Model\PromoterList::validate($this->promoter);
		if(empty($this->messages))
		{
			\App\Model\PromoterList::save($this->promoter);
			$this->context->user->promoter = $this->promoter;
			$this->success = True;
		}
			
		return $this->success;
			
	}
}