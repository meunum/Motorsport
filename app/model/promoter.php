<?php
	namespace App\Model;
	
		class Promoter
		{
			public $id = NULL;
			public $name = '';
			public $kategorie = '';
			public $region = '';
			public $beschreibung = '';
			public $bildId = NULL;
			
			public function __construct($pdaten) 
			{
				$this->id = $pdaten['id'];
				$this->name = $pdaten['name'];
				$this->kategorie = $pdaten['kategorie'];
				$this->region = $pdaten['region'];
				$this->bildId = $pdaten['bild'];
			}
		}
		
		class PromoterList
		{
			private static $context;
			
			public static function SetContext($context)
			{
				self::$context = $context;
			}

			public static function createList() 
			{
				$list = [];
				$stmt = self::$context->database->query(
					"SELECT v.id, v.name, v.kategorie, v.region, v.bild FROM veranstalter v INNER JOIN users u ON v.users_fk = u.id WHERE u.verified = 1");
				$allPromoter = $stmt->fetchAll();
				foreach($allPromoter as $pdaten)
				{
					$list[] = new Promoter($pdaten);
				}
				return $list;
			}

			public static function get($id) 
			{
				$stmt = self::$context->database->query("SELECT * FROM veranstalter where id=" . $id);
				return new Promoter($stmt->fetch());
			}
		}
	
