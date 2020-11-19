<?php
namespace App\Controller;

	class AppObject
	{
	
		protected function className()
		{
			$arr = explode('\\', get_class($this));
			return $arr[count($arr) - 1];
		}
		
	}
?>