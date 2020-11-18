<?php
namespace App\Model;

	class Entity
	{
	}
	
	class EntityList
	{
		protected static $context;
		protected static $db;
		
		public static function SetContext($context)
		{
			self::$context = $context;
			self::$db = $context->database;
		}
		
		public static function GetContext()
		{
			return self::$context;
		}

		public static function createList() 
		{
		}

		protected static function saveImage(int $imageId)
		{
			if(!empty($_FILES['bild']['name']))
			{
				$Path = $_FILES['bild']['tmp_name'];
				$Size = $_FILES['bild']['size'];
				$File = fread(fopen($Path, "r"), $Size);
				$Bild = addslashes($File);
				if($imageId == 0)
				{
					self::$db->exec("INSERT INTO grafik (daten) VALUES ('$Bild')");
					$imageId = self::$db->lastInsertId();
				}
				else
				{
					self::$db->exec("UPDATE grafik SET daten = '$Bild' WHERE id=$imageId");
				}
			}
			return $imageId;
			
		}
	}
?>