<?php
namespace App\Model;

	class Promoter
	{
		public int $id = 0;
		public string $name = '';
		public string $kategorie = '';
		public string $region = '';
		public string $beschreibung = '';
		public int $bildId = 0;
		public int $userId = 0;
		
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
			if(isset($pdaten['grafik_fk']))
				if($pdaten['grafik_fk'] != null)
					$this->bildId = $pdaten['grafik_fk'];
			if(isset($pdaten['users_fk']))
				$this->userId = $pdaten['users_fk'];
			if(isset($pdaten['userId']))
				$this->userId = $pdaten['userId'];
			if(isset($pdaten['bildId']))
				if($pdaten['bildId'] != null)
					$this->bildId = $pdaten['bildId'];
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
			$stmt = self::$db->query("SELECT * FROM veranstalter WHERE users_fk=" . $userId);
			if($stmt)
				return new Promoter($stmt->fetch());
		}

		public static function get($id) 
		{
			$stmt = self::$db->query("SELECT * FROM veranstalter WHERE id=" . $id);
			if($stmt)
				return new Promoter($stmt->fetch());
		}
		
		public static function save(Promoter $promoter)
		{
			self::$context->logger->LogDebug("\n-------------------------------------------------------\n");
			self::$context->logger->LogDebug("PromoterList->save()\n");
			self::$context->logger->LogDebug("promoter: " . print_r($promoter, true));
			try
			{
				$db = self::$db;
				$db->beginTransaction();
				$promoter->bildId = self::saveImage($promoter->bildId);
				if($promoter->id == 0)
				{
					$statement = $db->prepare('INSERT INTO veranstalter (name, kategorie, region, beschreibung, grafik_fk, users_fk) VALUES(?,?,?,?,?,?)');
					$statement->execute(array(
						$promoter->name, $promoter->kategorie, $promoter->region, $promoter->beschreibung, $promoter->bildId, $promoter->userId));
					$promoter->id = self::$db->lastInsertId();
				}
				else
				{
					$statement = $db->prepare('UPDATE veranstalter SET name=?, kategorie=?, region=?, beschreibung=?, grafik_fk=?, users_fk=? WHERE id=?');
					$statement->execute(array(
						$promoter->name, $promoter->kategorie, $promoter->region, $promoter->beschreibung, $promoter->bildId, $promoter->userId, $promoter->id));
				}
				$db->commit();
			}
			catch(PDOException $e)
			{
				self::$db->rollBack();
				throw($e);
			}
		}
		
		public static function validate(Promoter $promoter)
		{
			$messages = [];
			if ($promoter->name == '')
				$messages[] = 'Der Name darf nicht leer sein.';
			
			return $messages;
			
		}
	}
?>