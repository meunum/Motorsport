<?php
namespace App\Model;
use App\Controller;

	class Entity extends \App\Controller\AppObject
	{
		public int $id = 0;
		public int $bildId = 0;

		public function __construct($data) 
		{
			if(isset($data['id']))
				$this->id = $data['id'];
			if(isset($data['grafik_fk']))
				$this->bildId = $data['grafik_fk'];
			if(isset($data['bildId']))
				$this->bildId = $data['bildId'];
			if(isset($data['bildTyp']))
				$this->bildTyp = $data['bildTyp'];
		}

		public function GetProps()
		{
			$props = [];

			return $props;

		}

		public static function GetCaptions()
		{
			$props = [];

			return $props;

		}

		public function GetListProps()
		{
			$props = [];

			return $props;

		}

		public static function GetListCaptions()
		{
			$props = [];

			return $props;

		}

		public function Bezeichnung()
		{
			return 'Entität XY';
		}

		public function GetTitle(int $x)
		{
			$titles = [
				'Entität',		// ohne Artikel
				'die Entität',	// Nominativ
				'der Entität',	// Genitiv
				'der Entität',	// Dativ
				'die Entität'];	// Akkusativ

			return $titles[$x];

		}
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
				$Type =  $_FILES['bild']['type'];
				$Path = $_FILES['bild']['tmp_name'];
				$Size = $_FILES['bild']['size'];
				$Image = fread(fopen($Path, "r"), $Size);
				$Image = addslashes($Image);
				$size = getImageSize($Path);
				$Width = $size[0];
				$Height = $size[1];
				if($imageId == 0)
				{
					self::$db->exec("INSERT INTO grafik (daten, typ, hoehe, breite) VALUES ('$Image', '$Type', $Height, $Width)");
					$imageId = self::$db->lastInsertId();
				}
				else
				{
					self::$db->exec("UPDATE grafik SET daten = '$Image', typ = '$Type', hoehe = $Height, breite = $Width WHERE id=$imageId");
				}
			}
			
			return $imageId;
			
		}
	}
?>