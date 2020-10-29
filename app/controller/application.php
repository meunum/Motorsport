<?php
	namespace App\Controller;
	use App\Model;
	use App\View;
	require_once dirname($_SERVER['SCRIPT_FILENAME']) . '/vendor/autoload.php';
	require_once dirname($_SERVER['SCRIPT_FILENAME']) . '/app/model/promoter.php';
	
		class Application
		{

			public \PDO $database;
			public AppContext $context;
			
			public function __construct() 
			{
				$INDEXDIR = dirname($_SERVER['SCRIPT_FILENAME'], 1);
				require_once 'context.php';
				require_once 'user.php';
				
				$this->context = new AppContext($INDEXDIR);
				$this->database = new \PDO(
					'mysql:dbname=' . 
						$this->context->dbname . ';host=' . 
						$this->context->dbhost . ';charset=utf8mb4', 
					$this->context->dbuser, 
					$this->context->dbpass);
				$this->context->database = $this->database;
				$this->context->user = new User($this->context);
				\App\Model\PromoterList::SetContext($this->context);
			}
			
			public function run()
			{
				$view = $this->createView();
				$view->show();
			}
			
			private function createView()
			{
				require_once $this->context->indexdir . '/app/view/notfoundView.php';
				require_once $this->context->indexdir . '/app/view/promoterListView.php';
				require_once $this->context->indexdir . '/app/view/imageView.php';
				require_once $this->context->indexdir . '/app/model/promoter.php';
				require_once $this->context->indexdir . '/app/view/loginView.php';
				require_once $this->context->indexdir . '/app/view/signupView.php';
				require_once $this->context->indexdir . '/app/controller/signupAction.php';
				require_once $this->context->indexdir . '/app/view/signupSuccessView.php';

				if(isset($_GET['view']))
				{
					if($_GET['view'] == 'imageView' & isset($_GET['imageId']))
					{
						$view = new \App\View\ImageView($this->context, $_GET['imageId']);
					}
					else if($_GET['view'] == 'currentUserView')
					{
						if($this->context->user->loggedIn)
						{
							
						}
						else
						{
							$view = new \App\View\LogInView($this->context);
						}
					}
					else
						$view = new \App\View\NotFoundView();
				}
				else if(isset($_POST['view']))
				{
					if($_POST['view'] == 'signupView')
					{
						$view = new \App\View\SignUpView($this->context, []);
					}
				}
				else if(isset($_GET['action']))
				{
					if($_GET['action'] == 'accountActivate' & isset($_GET['selector']) & isset($_GET['token']))
					{
						//$action = new AccountActivateAction($this->context);
					}
				}
				else if(isset($_POST['action']))
				{
					if($_POST['action'] == 'login')
					{
						
					}
					else if($_POST['action'] == 'signup')
					{
						$action = new \App\Controller\SignUpAction($this->context);
						$messages = $action->execute();
						if(!empty($messages)) 
						{
							$view = new \App\View\SignUpView($this->context, $messages);
						}
						else
						{
							$view = new \App\View\SignUpSuccessView($this->context);
						}
						
					}
					else if($_POST['action'] == 'submit...')
					{
						
					}
				}
				else
				{
					$view = new \App\View\PromoterListView(
						$this->context, 
						\App\Model\PromoterList::createList());
				}
				
				return $view;
				
			}
		}

?>