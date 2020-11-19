<?php
namespace App\Controller;

class Action extends AppObject
{
	protected $context;
	protected $parameter;
	public bool $success = false;
	public bool $executed = false;
	public $messages = [];
	
	public function __construct($context, $parameter) 
	{
		$this->context = $context;
		$this->parameter = $parameter;
	}

	public function createView()
	{
		if(!$this->executed)
			$this->execute();
		
		if($this->success)
			return $this->createViewOnSuccess();
		else
			return $this->createViewOnFail();
	}

	protected function createViewOnSuccess()
	{
	}

	protected function createViewOnFail()
	{
	}
	
	public function execute()
	{
	}
}

class ShowImageAction extends action
{
	private $image;

	public function createViewOnSuccess()
	{
		return new \App\View\ImageView($this->context, $this->image);
	}
	
	public function execute()
	{
		$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
		$this->context->logger->LogDebug("ShowImageAction->execute()\n");
		if($this->parameter[1] > 0)
		{
			$mysqli = new \mysqli($this->context->dbhost, $this->context->dbuser, $this->context->dbpass, $this->context->dbname);
			$sql = "SELECT * FROM grafik WHERE id=" . $this->parameter[1];
			$this->context->logger->LogDebug("sql: " . $sql);
			$Q = $mysqli->query($sql);
			$Q = $Q->fetch_array();
			$this->image = $Q['daten'];
			$mysqli->close();
			$this->success = true;
		}
		$this->executed = true;
	}
	
}
?>