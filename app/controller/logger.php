<?php		
namespace App\Controller;

class Logger
{
	private int $loglevel = -1;
	
	public function __construct(string $loglevel) 
	{
		switch($loglevel)
		{
			case 'error': 
				$this->loglevel = 0;
				break;
			case 'info': 
				$this->loglevel = 1;
				break;
			case 'debug': 
				$this->loglevel = 2;
				break;
		}
		$this->LogText("\n=======================================================\n");
		$this->LogText(date("Y-m-d h:n:s") . ", " . "Loglevel: " . $loglevel . "\n");
	}
	
	public function LogInfo($text)
	{
		if($this->loglevel >= 1)
			$this->LogText($text);
	}

	public function LogDebug($text)
	{
		if($this->loglevel >= 2)
		{
			$this->LogText($text);
		}
	}
	
	public function LogError($e)
	{                     
		if($this->loglevel >= 0)
		{
			$this->LogText("\n!-!-!-!-!-!-!-!-!-!-!-!- ERROR !-!-!-!-!-!-!-!-!-!-!-!-\n");
			$this->LogText($e->getMessage() . "\n");
			$this->LogText($e->getTraceAsString() . "\n");
		}
	}
	
	public function LogText($text)
	{
		$logFile = "log/application.log_" . date("Y-m-d") . ".txt";
		file_put_contents($logFile, $text, FILE_APPEND);
	}
}
?>