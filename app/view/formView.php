<?php
namespace App\View;
use App\Controller;
use App\Model;

class FormView extends HtmlView
{
    protected $messages = [];
    protected $REQUIRED = "<abbr class = 'required' title='erforderlich' >*</abbr>";
    
    public function __construct($context, $title, $messages) 
    {
        parent::__construct($context, $title);
        $this->messages = $messages;
    }
    
    protected function showMainSectionContent()
    {
        $this->showMessages();
    }
    
    protected function showMessages()
    {
        if(!empty($this->messages)) 
        {
            echo '<div class="error">Bei der Verarbeitung Deiner Eingaben sind Fehler aufgetreten:<ul>';
            foreach($this->messages as $message) {
              echo '<li>'.htmlspecialchars($message).'</li>';
            }
            echo '</ul></div>';
        }
    }
}

?>