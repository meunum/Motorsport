<?php
  namespace App\Controller;
  
  class AppContext
  {
		public string $domain;
		public string $dbhost;
		public string $dbname;
		public string $dbuser;
		public string $dbpass;
		public string $indexdir;
		public string $lastupdate;
		public $user;
		public $database;
		public $logger;
		public $loglevel;
		
		public function __construct(string $indexdir) 
		{
			include $indexdir . '/app/appSettings.php';
			$this->indexdir = $indexdir;
			$this->domain = $appSettings['DOMAIN'];
			$this->dbhost = $appSettings['DBHOST'];
			$this->dbname = $appSettings['DBNAME'];
			$this->dbuser = $appSettings['DBUSER'];
			$this->dbpass = $appSettings['DBPASS'];
			$this->loglevel = $appSettings['LOGLEVEL'];
			$this->lastupdate = $appSettings['LASTUPDATE'];
		}

  }
?>