<?php
namespace App\Model;

	class Promoter extends Entity
	{
		public int $id = 0;
		public string $email = '';
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
		
		public function __construct($promoterData) 
		{
			parent::__construct($promoterData);
			if(isset($promoterData['name']))
				$this->name = $promoterData['name'];
			if(isset($promoterData['kategorie']))
				$this->kategorie = $promoterData['kategorie'];
			if(isset($promoterData['region']))
				$this->region = $promoterData['region'];
			if(isset($promoterData['beschreibung']))
				$this->beschreibung = $promoterData['beschreibung'];
			if(isset($promoterData['users_fk']))
				$this->userId = $promoterData['users_fk'];
			if(isset($promoterData['userId']))
				$this->userId = $promoterData['userId'];
			$this->email = EventList::GetContext()->user->email;
		}

		public function GetProps()
		{
			EventList::GetContext()->logger->LogDebug("\n-------------------------------------------------------\n");
			EventList::GetContext()->logger->LogDebug("Event->GetProps()\n");
			$props = [
				'Email' => [$this->email, 2],
				'Name' => [$this->name, 1],
				'Kategorie' => [$this->kategorie, 0],
				'Region' => [$this->region, 0],
				'Beschreibung' => [$this->beschreibung, 0]];
			EventList::GetContext()->logger->LogDebug(print_r($props, true));

			return $props;

		}

		public function GetTitle(int $x)
		{
			$titles = [
				'Veranstalter',
				'der Veranstalter',
				'des Veranstalters',
				'dem Veranstalter',
				'den Veranstalter'];

			return $titles[$x];

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
			foreach($allPromoter as $promoterData)
			{
				$list[] = new Promoter($promoterData);
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