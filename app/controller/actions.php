<?php
namespace App\Controller;

class Action
{
	protected $context;
	public bool $success = false;
	public bool $executed = false;
	public $messages = [];
	
	public function __construct($context) 
	{
		$this->context = $context;
	}

	public function createView()
	{
	}
	
	public function execute()
	{
	}
}

class ShowImageAction extends action
{
	private int $imageId = 0;
	private $image;
	
	public function __construct($context) 
	{
		$this->context = $context;
		if (isset($_GET['imageId']))
			$this->imageId = $_GET['imageId'];
	}

	public function createView()
	{
		if($this->success)
			return new \App\View\ImageView($this->context, $this->image);
	}
	
	public function execute()
	{
		if($this->imageId > 0)
		{
			$mysqli = new \mysqli($this->context->dbhost, $this->context->dbuser, $this->context->dbpass, $this->context->dbname);
			$Q = $mysqli->query("SELECT * FROM grafik WHERE id=" . $this->imageId);
			$Q = $Q->fetch_array();
			$this->image = $Q['daten'];
			$mysqli->close();
			$this->success = true;
		}
		$this->executed = true;
	}
	
}
?>