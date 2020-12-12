<?php
namespace App\View;
use App\Controller;
use App\Model;

	class EntityView extends FormView
	{
		protected \App\Model\Entity $entity;
		
		public function __construct($context, $entity, $title, $messages) 
		{
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