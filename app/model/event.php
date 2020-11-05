<?php
namespace App\Model;

	class Event extends Entity
	{
		public int $id = 0;
		public int $veranstalter = 0;
		public $zeitpunkt = '';
		public string $bezeichnung = '';
		public string $ort = '';
		public string $kategorie = '';
		public int $bildId = 0;
		
		public function __construct($eventData) 
		{
			if(isset($eventData['id']))
				$this->id = $eventData['id'];
			if(isset($eventData['veranstalter']))
				$this->veranstalter = $eventData['veranstalter'];
			if(isset($eventData['zeitpunkt']))
				$this->zeitpunkt = $eventData['zeitpunkt'];
			if(isset($eventData['bezeichnung']))
				$this->bezeichnung = $eventData['bezeichnung'];
			if(isset($eventData['ort']))
				$this->ort = $eventData['ort'];
			if(isset($eventData['kategorie']))
				$this->kategorie = $eventData['kategorie'];
			if(isset($eventData['bild']))
				$this->bildId = $eventData['bild'];
		}
	}

	class EventList extends EntityList
	{

		public static function createListByPromoterId(int $promoterId) 
		{
			$list = [];
			$stmt = self::$db->query(
				"SELECT v.* FROM veranstaltung v WHERE veranstalter = $promoterId");
			$all = $stmt->fetchAll();
			foreach($all as $event)
			{
				$list[] = new Event($event);
			}
			
			return $list;
			
		}
			
		public function eventsComingByPromoterId(int $promoterId, int $limit = 0)
		{
			$SQL = "SELECT id,zeitpunkt,bezeichnung,ort FROM veranstaltung WHERE veranstalter=$promoterId and zeitpunkt>=CURRENT_DATE() " .
				"ORDER BY zeitpunkt";
			if ($limit > 0)
				$SQL = $SQL . " limit $limit";
			$events = self::$db->query($SQL);
			
			return $events;
			
		}
		
		public function save(Event $event)
		{
				self::$db->beginTransaction();

				$event->bildId = self::saveImage($event->bildId);

				if($event->id == 0)
				{
					$event->veranstalter = self::$context->user->promoter->id;
					$statement = self::$db->prepare(
						'INSERT INTO veranstaltung (bezeichnung, zeitpunkt, ort, kategorie, veranstalter, bild) VALUES(?, ?, ?, ?, ?, ?)');
					$statement->execute(array(
						$event->bezeichnung, 
						$event->zeitpunkt, 
						$event->ort, 
						$event->kategorie, 
						$event->veranstalter, 
						$event->bildId));
					$event->id = self::$db->lastInsertId();
				}
				else
				{
					$statement = self::$db->prepare(
						'UPDATE veranstaltung SET bezeichnung=?, zeitpunkt=?, ort=?, kategorie=?, bild=? WHERE id=?');
					$statement->execute(array(
						$event->bezeichnung, 
						$event->zeitpunkt, 
						$event->ort, 
						$event->kategorie, 
						$event->bildId,
						$event->id));
				}
				

				self::$db->commit();
			
		}
	}
?>