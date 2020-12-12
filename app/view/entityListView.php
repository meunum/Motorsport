<?php
namespace App\View;
use App\Model;

class EntityListView extends ListView
{
    private $promoter;
    private $entityClass;
	
	public function __construct($context, $list, $caption, $entityClass) 
	{
		parent::__construct($context, $caption, $list);
        $this->promoter = $context->user->promoter;
        $this->entityClass = $entityClass;
	}
	
	protected function showMainSectionContent()
	{
		parent::showMainSectionContent();
		include('inc/entityListViewContent.php');
	}
}?>