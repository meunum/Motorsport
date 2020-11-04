<?php
namespace App\Model;
	
	class EntityList
	{
		protected static $context;
		protected static $db;
		
		public static function SetContext($acontext)
		{
			self::$context = $acontext;
			self::$db = $acontext->database;
		}
		
		public static function GetContext()
		{
			return self::$context;
		}

		public static function createList() 
		{
		}
	}
?>