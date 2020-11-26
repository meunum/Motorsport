<?php
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
			include("includes.php");
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
			if(!empty($_POST))
			{
				$this->context->logger->LogDebug("use _POST");
				$parameter = $_POST;
			}
			else if(!empty($_GET))
			{
				$this->context->logger->LogDebug("use _GET");
				$parameter = $_GET;
			} 
			if(isset($parameter['action']))
				$view = $this->CreateViewByAction($parameter['action'], $parameter);
			else if(isset($parameter['view']))
				$view = $this->CreateViewByName($viewParams['view'], $parameter);
			else
				$view = $this->CreateViewByAction('PromoterList', []);
				
			return $view;
			
		}

		private function CreateViewByName($viewName, $viewParams)
		{
			$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
			$this->context->logger->LogDebug("Application->CreateViewByName(". $viewName . ")\n");
			$viewClass = '\\App\\View\\' . $viewName . 'View';
			$this->context->logger->LogDebug("viewClass: " . $viewClass . "\n");
			$this->context->logger->LogDebug("viewParams: " . print_r($viewParams, true));
		
			return new $viewClass($this->context, []);
		
		}
		
		private function CreateViewByAction($actionName, $actionParams)
		{
			$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
			$this->context->logger->LogDebug("Application->CreateViewByAtion(" . $actionName . ")\n");
			$actionClass = '\\App\\Controller\\' . $actionName . 'Action';
			$this->context->logger->LogDebug("actionClass: " . $actionClass . "\n");
			$this->context->logger->LogDebug("actionParams: " . print_r($actionParams, true));
			$action = new $actionClass($this->context, $actionParams);
			
			$action->execute();
			$view = $action->createView();
	
			return $view;
		
		}
	}
?>