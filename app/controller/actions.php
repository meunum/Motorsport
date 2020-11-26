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
		$context->logger->LogDebug("\n-------------------------------------------------------\n");
		$context->logger->LogDebug($this->className() . "->__construct(" . print_r($parameter, true) . ")\n");
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
		$this->context->logger->LogDebug("\n-------------------------------------------------------\n");
		$this->context->logger->LogDebug($this->className() . "->execute()\n");
	}
}

class ShowImageAction extends Action
{
	private $image;
	private $imageId;
	private $type;
	
	public function __construct($context, $parameter) 
	{
		parent::__construct($context, $parameter);
		
		$this->imageId = $parameter['id'];
		
		$context->logger->LogDebug("imageId: " . $this->imageId);
	}

	public function createViewOnSuccess()
	{
		return new \App\View\ImageView($this->context, $this->image, $this->type);
	}
	
	public function execute()
	{
		parent::execute();
		if($this->imageId != 0)
		{
			$mysqli = new \mysqli($this->context->dbhost, $this->context->dbuser, $this->context->dbpass, $this->context->dbname);
			$sql = "SELECT daten, typ FROM grafik WHERE id=" . $this->imageId;
			$this->context->logger->LogDebug("sql: " . $sql);
			$Q = $mysqli->query($sql);
			$Q = $Q->fetch_array();
			$this->image = $Q['daten'];
			$this->type = $Q['typ'];
			$mysqli->close();
			$this->success = true;
		}
		$this->executed = true;
	}
	
}
?>