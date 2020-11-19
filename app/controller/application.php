<?php
/* <script src="https://kit.fontawesome.com/b20425f347.js" crossorigin="anonymous"></script>*/
	namespace App\Controller;
	use \Exception as Exception;
	use App\Model;
	use App\View;
	require_once dirname($_SERVER['SCRIPT_FILENAME']) . '/vendor/autoload.php';
	
	class Application
	{

		public function __construct() 
		{

			$INDEXDIR = dirname($_SERVER['SCRIPT_FILENAME'], 1);
			require_once $INDEXDIR . '/app/controller/object.php';
			require_once $INDEXDIR . '/app/controller/context.php';
			require_once $INDEXDIR . '/app/controller/logger.php';
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
			require_once $INDEXDIR . '/app/view/eventView.php';
			require_once $INDEXDIR . '/app/view/eventListView.php';

			$this->context = new AppContext($INDEXDIR);
			$this->context->logger = new Logger($this->context->loglevel);
			$this->context->logger->LogDebug("Application->__construct()\n");

			$this->context->database = new \PDO(
				'mysql:' . 
					'dbname=' . $this->context->dbname . 
					';host=' . $this->context->dbhost . 
					';charset=utf8mb4', 
				$this->context->dbuser, 
				$this->context->dbpass);
				
			$auth = new \Delight\Auth\Auth($this->context->database);
			\App\Model\EntityList::SetContext($this->context);
			if ($auth->isLoggedIn()) 
			{
				$this->context->user = new \App\Model\User($auth->getUserId(), $auth->getEmail(), true);
				$this->context->user->promoter = \App\Model\PromoterList::getByUserId($this->context->user->id);
			}
			else
			{
				$this->context->user = new \App\Model\User("", "", false);
			}

			$this->context->logger->LogDebug("\n" . "context: " . print_r(\App\Model\EntityList::GetContext(), true) . "\n");
		}
		
		public function run()
		{
			$this->context->logger->LogInfo("\n-------------------------------------------------------\n");
			$this->context->logger->LogInfo("Application->run()\n");
			$this->context->logger->LogInfo("GET: " . print_r($_GET, true));
			$this->context->logger->LogInfo("POST: " . print_r($_POST, true));
			$this->context->logger->LogInfo("FILES: " . print_r($_FILES, true));
			try
			{
				$view = $this->createView();
				$view->show();
			}
			catch(\Throwable $e)
			{
				$this->context->logger->LogError($e);
				header($_SERVER["SERVER_PROTOCOL"]." 501 Not Implemented", true, 404);
			}
		}
		
		private function createView()
		{
			$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
			$this->context->logger->LogDebug("Application->createView()\n");
			if(isset($_GET['view']))
				$view = $this->CreateViewByName($_GET['view']);
			else if(isset($_POST['view']))
				$view = $this->CreateViewByName($_POST['view']);
			else if(isset($_GET['action']))
				$view = $this->CreateViewByAction($_GET['action']);
			else if(isset($_POST['action']))
				$view = $this->CreateViewByAction($_POST['action']);
			else
				$view = $this->CreateViewByAction('PromoterList');
			
			return $view;
			
		}

		private function CreateViewByName(string $viewName)
		{
			$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
			$this->context->logger->LogDebug("Application->CreateViewByName(". $viewName . ")\n");
			$viewClass = '\\App\\View\\' . $viewName . 'View';
			$this->context->logger->LogDebug("viewClass: " . $viewClass . "\n");
		
			return new $viewClass($this->context, []);
		
		}
		
		private function CreateViewByAction(string $actionName)
		{
			$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
			$this->context->logger->LogDebug("Application->CreateViewByAtion(" . $actionName . ")\n");
			$actionParams = explode('@', $actionName);
			$actionClass = '\\App\\Controller\\' . $actionParams[0] . 'Action';
			$this->context->logger->LogDebug("actionClass: " . $actionClass . "\n");
			$this->context->logger->LogDebug("actionParams: " . print_r($actionParams, true));
			$action = new $actionClass($this->context, $actionParams);
			
			$action->execute();
			$view = $action->createView();
	
			return $view;
		
		}
	}
?>