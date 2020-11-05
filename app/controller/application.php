<?php
	namespace App\Controller;
	use App\Model;
	use App\View;
	require_once dirname($_SERVER['SCRIPT_FILENAME']) . '/vendor/autoload.php';
	
		class Application
		{
			
			public function __construct() 
			{
				$INDEXDIR = dirname($_SERVER['SCRIPT_FILENAME'], 1);
				require_once $INDEXDIR . '/app/controller/context.php';
				require_once $INDEXDIR . '/app/controller/actions.php';
				require_once $INDEXDIR . '/app/controller/promoterActions.php';
				require_once $INDEXDIR . '/app/controller/eventActions.php';
				require_once $INDEXDIR . '/app/controller/signupAction.php';
				require_once $INDEXDIR . '/app/controller/accountActivateAction.php';
				require_once $INDEXDIR . '/app/controller/signupAction.php';
				require_once $INDEXDIR . '/app/controller/loginActions.php';
				require_once $INDEXDIR . '/app/controller/promoterSubmitAction.php';
				require_once $INDEXDIR . '/app/model/entity.php';
				require_once $INDEXDIR . '/app/model/user.php';
				require_once $INDEXDIR . '/app/model/promoter.php';
				require_once $INDEXDIR . '/app/model/event.php';
				require_once $INDEXDIR . '/app/view/views.php';
				require_once $INDEXDIR . '/app/view/loginView.php';
				require_once $INDEXDIR . '/app/view/signupViews.php';
				require_once $INDEXDIR . '/app/view/accountActivateViews.php';
				require_once $INDEXDIR . '/app/view/promoterListView.php';
				require_once $INDEXDIR . '/app/view/promoterView.php';
				require_once $INDEXDIR . '/app/view/PromoterEventListView.php';
				require_once $INDEXDIR . '/app/view/eventView.php';
				
				$this->context = new AppContext($INDEXDIR);
				$this->context->database = new \PDO(
					'mysql:' . 
						'dbname=' . $this->context->dbname . 
						';host=' . $this->context->dbhost . 
						';charset=utf8mb4', 
					$this->context->dbuser, 
					$this->context->dbpass);
				\App\Model\EntityList::SetContext($this->context);
				$this->context->user = new \App\Model\User();
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
			}
			
			private function createView()
			{
				if(isset($_GET['view']))
					$view = $this->CreateViewByName($_GET['view'], []);
				else if(isset($_POST['view']))
					$view = $this->CreateViewByName($_POST['view'], []);
				else if(isset($_GET['action']))
					$view = $this->CreateViewByAction($_GET['action'], []);
				else if(isset($_POST['action']))
					$view = $this->CreateViewByAction($_POST['action'], []);
				else
					$view = $this->CreateViewByAction('ShowPromoterList', []);
				
				return $view;
				
			}

			private function CreateViewByName(string $viewName, bool $internal=False)
			{
				$viewClass = '\\App\\View\\' . $viewName . 'View';
				$view = new $viewClass($this->context, []);
				
				if (isset($view))
					return $view;
				
			}
			
			private function CreateViewByAction(string $actionName)
			{
				$actionParams = explode('@', $actionName);
				$actionClass = '\\App\\Controller\\' . $actionParams[0] . 'Action';
				$action = new $actionClass($this->context, $actionParams);
				
				if(isset($action))
				{
					$action->execute();
					$view = $action->createView();
			
					if (isset($view))
						return $view;
				
				}
			}
		}
?>