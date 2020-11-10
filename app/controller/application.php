<?php
	namespace App\Controller;
	use \Exception as Exception;
	use App\Model;
	use App\View;
	require_once dirname($_SERVER['SCRIPT_FILENAME']) . '/vendor/autoload.php';
	
	class Application
	{
		private $debug = true;

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
			require_once $INDEXDIR . '/app/view/promoterEventListView.php';
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
			$this->LogDebug("\n=======================================================\n");
			$this->LogDebug("createView\n");
			$this->LogDebug("GET: " . print_r($_GET, true));
			$this->LogDebug("POST: " . print_r($_POST, true));
			if(isset($_GET['view']))
				$view = $this->CreateViewByName($_GET['view']);
			else if(isset($_POST['view']))
				$view = $this->CreateViewByName($_POST['view']);
			else if(isset($_GET['action']))
				$view = $this->CreateViewByAction($_GET['action']);
			else if(isset($_POST['action']))
				$view = $this->CreateViewByAction($_POST['action']);
			else
				$view = $this->CreateViewByAction('ShowPromoterList');
			
			return $view;
			
		}

		private function CreateViewByName(string $viewName)
		{
			$this->LogDebug("-------------------------------------------------------\n");
			$this->LogDebug("CreateViewByName\n");
			$viewClass = '\\App\\View\\' . $viewName . 'View';
			try
			{
				$this->LogDebug("viewName: " . $viewName . "\n");
				$this->LogDebug("viewClass: " . $viewClass . "\n");
			
				return new $viewClass($this->context, []);
			
			}
			catch(\Throwable $e)
			{
				$this->LogError($e);
			}
		}
		
		private function CreateViewByAction(string $actionName)
		{
			$this->LogDebug("-------------------------------------------------------\n");
			$this->LogDebug("CreateViewByAtion\n");
			$actionParams = explode('@', $actionName);
			$actionClass = '\\App\\Controller\\' . $actionParams[0] . 'Action';
			try
			{
				$this->LogDebug("actionName: " . $actionName . "\n");
				$this->LogDebug("actionClass: " . $actionClass . "\n");
				$this->LogDebug("actionParams: " . print_r($actionParams, true));
				$action = new $actionClass($this->context, $actionParams);
				
				$action->execute();
				$view = $action->createView();
		
				return $view;
			
			}
			catch(\Throwable $e)
			{
				$this->LogError($e);
			}
		}
		
		private function LogDebug($text)
		{
			if($this->debug)
			{
				$this->LogText($text);
			}
		}
		
		private function LogError($e)
		{                     
			$this->LogText("\n!-!-!-!-!-!-!-!-!-!-!-!- ERROR !-!-!-!-!-!-!-!-!-!-!-!-\n");
			$this->LogText($e->getMessage() . "\n");
			$this->LogText($e->getTraceAsString() . "\n");
		}
		
		private function LogText($text)
		{
			$logFile = "application.log.txt";
			file_put_contents($logFile, $text, FILE_APPEND);
		}
	}
?>