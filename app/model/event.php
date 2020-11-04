<?php
namespace App\Model;

	class Event
	{
		public int $id;
		public int $veranstalter;
		public $zeitpunkt;
		public string $bezeichnung;
		public string $ort;
		public string $kategorie;
		public int $bildId;
		
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
			if(isset($eventData['bildId']))
				$this->bildId = $eventData['bildId'];
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
		
	}
?>