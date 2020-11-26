<?php
namespace App\View;
use App\Controller;
use App\Model;
	
class ListView extends HtmlView
{
    protected $contentList;
    
    public function __construct($context, $title, $list) 
    {
        parent::__construct($context, $title);
        $this->contentList = $list;
    }

    protected function showMainNavContent() 
    {
        $this->showMainNavItem('PromoterList', 'Veranstalter');
        $this->showMainNavItem('EventList', 'Veranstaltungen');
        $this->showMainNavItem('DriverList', 'Fahrer');
    }

    protected function showMainNavItem($viewName, $title)
    {
        if($this->className() == $viewName . "View")
            print('<li><div class="navTitle">' . $title . '</div></li>');
        else
            print('<li><a class="mainNavLink" href="index.php?action=' . $viewName . '">'. $title . '</a></li>');
    }

    protected function showCellImage(int $id)
    {
        $this->showImage($id, 150, 80);
    }
}

?>