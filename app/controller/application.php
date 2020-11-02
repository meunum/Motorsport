<?php
	namespace App\Controller;
	use App\Model;
	use App\View;
	require_once dirname($_SERVER['SCRIPT_FILENAME']) . '/vendor/autoload.php';
	
		class Application
		{
			
			public function __construct() 
			{
				require_once 'context.php';
				require_once 'user.php';
				$INDEXDIR = dirname($_SERVER['SCRIPT_FILENAME'], 1);
				require_once $INDEXDIR . '/app/model/promoter.php';
				require_once $INDEXDIR . '/app/view/promoterListView.php';
				require_once $INDEXDIR . '/app/view/loginView.php';
				require_once $INDEXDIR . '/app/view/signupViews.php';
				require_once $INDEXDIR . '/app/view/accountActivateViews.php';
				require_once $INDEXDIR . '/app/view/promoterView.php';
				require_once $INDEXDIR . '/app/controller/signupAction.php';
				require_once $INDEXDIR . '/app/controller/accountActivateAction.php';
				require_once $INDEXDIR . '/app/controller/signupAction.php';
				require_once $INDEXDIR . '/app/controller/loginActions.php';
				require_once $INDEXDIR . '/app/controller/promoterSubmitAction.php';
				
				$this->context = new AppContext($INDEXDIR);
				$this->context->database = new \PDO(
					'mysql:' . 
						'dbname=' . $this->context->dbname . 
						';host=' . $this->context->dbhost . 
						';charset=utf8mb4', 
					$this->context->dbuser, 
					$this->context->dbpass);
				\App\Model\PromoterList::SetContext($this->context);
				$this->context->user = new User($this->context);
			}
			
			public function run()
			{
				$view = $this->createView();
				if(isset($view))
				{
					$view->show();
				}
				else
				{
					print('$_GET: '); print_r($_GET);
					print('$_POST: '); print_r($_POST);
				}
				$this->afterRender();
			}
			
			private function createView()
			{
				if(isset($_GET['view']))
				{
					$view = $this->CreateViewByName($_GET['view'], []);
				}
				else if(isset($_POST['view']))
				{
					$view = $this->CreateViewByName($_POST['view'], []);
				}
				else if(isset($_GET['action']))
				{
					$view = $this->CreateViewByAction($_GET['action'], []);
				}
				else if(isset($_POST['action']))
				{
					$view = $this->CreateViewByAction($_POST['action'], []);
				}
				else
				{
					$view = $this->CreateMainView();
				}
				
				if(isset($view))
					return $view;
				
			}

			private function CreateViewByName(string $viewName, $messages, bool $internal=False)
			{
				if($viewName == 'imageView' & isset($_GET['imageId']))
				{
					$view = new \App\View\ImageView($this->context, $_GET['imageId']);
				}
				else if($viewName == 'promoterView')
				{
					if($this->context->user->loggedIn)
					{
						$view = new \App\View\PromoterView($this->context, $messages);
					}
					else
					{
						$view = new \App\View\LogInView($this->context, $messages);
					}
				}
				else if($viewName == 'signupView')
				{
					$view = new \App\View\SignUpView($this->context, $messages);
				}
				else if($viewName == 'loginView')
				{
					$view = new \App\View\LoginView($this->context, $messages);
				}
				else if($viewName == 'mainView')
				{
					$view = $this->CreateMainView();
				}
//				else
	//				$view = new \App\View\NotFoundView();
				
				return $view;
				
			}
			
			private function CreateViewByAction(string $actionName)
			{
				if($actionName == 'signup')
				{
					$action = new \App\Controller\SignUpAction($this->context);
				}
				else if($actionName == 'accountActivate')
				{
					$action = new \App\Controller\AccountActivateAction($this->context);
				}
				else if($actionName == 'login')
				{
					$action = new \App\Controller\LogInAction($this->context);
				}
				else if($actionName == 'logout')
				{
					$action = new \App\Controller\LogOutAction($this->context);
				}
				else if($actionName == 'promoterView.submit')
				{
					$action = new \App\Controller\PromoterSubmitAction($this->context);
				}
				if(isset($action))
				{
					$action->execute();
					$view = $action->createView();
				}
			
				return $view;
				
			}
			
			private function CreateMainView()
			{
				$view = new \App\View\PromoterListView(
					$this->context, 
					\App\Model\PromoterList::createList());
					
				return $view;
			}
			
			private function afterRender()
			{
				$this->context->user->justLoggedOut = False;
			}
		}
?>