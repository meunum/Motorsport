<?php
namespace App\Controller;
use App\Model;
use App\View;

class PromoterSubmitAction extends SubmitAction
{

	protected \App\Model\Promoter $promoter;
	
	public function createView()
	{
		return new \App\View\promoterView($this->context, $this->promoter, $this->messages);
	}
	
	public function execute()
	{
		$this->executed = true;
		$this->promoter = new \App\Model\Promoter($_POST);
		$this->savePromoter();
	}
	
	public function savePromoter()
	{
		try
		{
			$this->messages = \App\Model\PromoterList::validate($this->promoter);
			if(empty($this->messages))
			{
				\App\Model\PromoterList::save($this->promoter);
				$this->context->user->promoter = $this->promoter;
				$this->success = True;
			}
		}
		catch(Exception $e)
		{
			$this->messages[] = 'Fehler beim Speichern';
			$this->messages[] = $e->getMessage();
		}
			
		return $this->success;
			
	}
}