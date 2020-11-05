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
			
			public function events()
			{
				return EventList::createListByPromoterId($this->id);
			}
			
			public function eventsComing(int $limit = 0)
			{
				return EventList::eventsComingByPromoterId($this->id, $limit);
			}
			
			public function __construct($pdaten) 
			{
				$this->id = 0;
				$this->name = '';
				$this->region = '';
				$this->beschreibung = '';
				$this->kategorie = '';
				$this->bild = 0;
				
				if(isset($pdaten['id']))
					$this->id = $pdaten['id'];
				if(isset($pdaten['name']))
					$this->name = $pdaten['name'];
				if(isset($pdaten['kategorie']))
					$this->kategorie = $pdaten['kategorie'];
				if(isset($pdaten['region']))
					$this->region = $pdaten['region'];
				if(isset($pdaten['beschreibung']))
					$this->beschreibung = $pdaten['beschreibung'];
				if(isset($pdaten['bild']))
					if($pdaten['bild'] != null)
						$this->bildId = $pdaten['bild'];
			}
		}
		
		class PromoterList extends EntityList
		{

			public static function createList() 
			{
				$list = [];
				$stmt = self::$db->query(
					"SELECT v.* FROM veranstalter v INNER JOIN users u ON v.users_fk = u.id WHERE u.verified = 1");
				$allPromoter = $stmt->fetchAll();
				foreach($allPromoter as $pdaten)
				{
					$list[] = new Promoter($pdaten);
				}
				return $list;
			}

			public static function getByUserId($userId) 
			{
				$stmt = self::$db->query("SELECT * FROM veranstalter where users_fk=" . $userId);
				if($stmt)
					return new Promoter($stmt->fetch());
			}

			public static function get($id) 
			{
				$stmt = self::$db->query("SELECT * FROM veranstalter where id=" . $id);
				if($stmt)
					return new Promoter($stmt->fetch());
			}
		}
	
