<?php
namespace App\View;
use App\Controller;
use App\Model;

	class EntityView extends FormView
	{
		protected \App\Model\Entity $entity;
		
		public function __construct($context, $entity, $messages) 
		{
			$title = 'Motorsport (' . $entity->GetTitle(0);
			if($entity->id > 0)
			{
				$title = $title . ' ändern)';
			}
			else
			{
				$title = $title . ' erfassen)';
			}
			parent::__construct($context, $title, $messages);
			$this->entity = $entity;
		}
	
		protected function showMainSectionContent()
		{
			parent::showMainSectionContent();
			include('inc/entityViewContent.php');
		}
	}
?>