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
			parent::__construct($eventData);
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
		}

		public function GetProps()
		{
			EventList::GetContext()->logger->LogDebug("\n-------------------------------------------------------\n");
			EventList::GetContext()->logger->LogDebug("Event->GetProps()\n");
			$props = [
				'Bezeichnung' => [$this->bezeichnung, 1],
				'Datum, Zeit' => [$this->zeitpunkt, 1],
				'Ort' => [$this->ort, 1],
				'Kategorie' => [$this->kategorie, 0]];
			EventList::GetContext()->logger->LogDebug(print_r($props, true));

			return $props;

		}

		public function GetListProps()
		{
			EventList::GetContext()->logger->LogDebug("\n-------------------------------------------------------\n");
			EventList::GetContext()->logger->LogDebug("Event->GetListProps()\n");
			$props = [
				'Bezeichnung' => $this->bezeichnung,
				'Datum, Zeit' => $this->zeitpunkt,
				'Ort' => $this->ort,
				'Kategorie' => $this->kategorie];
			EventList::GetContext()->logger->LogDebug(print_r($props, true));

			return $props;

		}

		public static function GetListCaptions()
		{
			EventList::GetContext()->logger->LogDebug("\n-------------------------------------------------------\n");
			EventList::GetContext()->logger->LogDebug("Event->GetListCaptions()\n");
			$props = [
				'Bezeichnung',
				'Datum, Zeit',
				'Ort',
				'Kategorie'];
			EventList::GetContext()->logger->LogDebug(print_r($props, true));

			return $props;

		}

		public function Bezeichnung()
		{
			return $this->bezeichnung;
		}

		public function GetTitle(int $x)
		{
			$titles = [];
			$titles[] = 'die Veranstaltung';
			$titles[] = 'der Veranstaltung';
			$titles[] = 'der Veranstaltung';
			$titles[] = 'die Veranstaltung';

			return $titles[$x - 1];

		}
	}

	class EventList extends EntityList
	{

		public static function createList() 
		{
			return self::__createList("SELECT v.* FROM veranstaltung v");
		}

		public static function createListByPromoterId(int $promoterId) 
		{
			return self::__createList("SELECT v.* FROM veranstaltung v WHERE veranstalter = $promoterId");
		}

		private static function __createList(string $sql) 
		{
			$list = [];
			$stmt = self::$db->query($sql);
			$all = $stmt->fetchAll();
			foreach($all as $event)
			{
				$list[] = new Event($event);
			}
			
			return $list;
			
		}
			
		public static function eventsComingByPromoterId(int $promoterId, int $limit = 0)
		{
			$SQL = "SELECT id,zeitpunkt,bezeichnung,ort FROM veranstaltung WHERE veranstalter=$promoterId and zeitpunkt>=CURRENT_DATE() " .
				"ORDER BY zeitpunkt";
			if ($limit > 0)
				$SQL = $SQL . " limit $limit";
			$events = self::$db->query($SQL);
			
			return $events;
			
		}
		
		public static function get(int $id)
		{
			$stmt = self::$db->query("SELECT * FROM veranstaltung WHERE id=" . $id);
			if($stmt)
				return new Event($stmt->fetch());
		}
		
		public static function save(Event $event)
		{
			try
			{
				self::$db->beginTransaction();
				$event->bildId = self::saveImage($event->bildId);
				if($event->id == 0)
				{
					$event->veranstalter = self::EventList::GetContext()->user->promoter->id;
					$statement = self::$db->prepare(
						'INSERT INTO veranstaltung (bezeichnung, zeitpunkt, ort, kategorie, veranstalter, grafik_fk) VALUES(?, ?, ?, ?, ?, ?)');
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
						'UPDATE veranstaltung SET bezeichnung=?, zeitpunkt=?, ort=?, kategorie=?, grafik_fk=? WHERE id=?');
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
			catch(PDOException $e)
			{
				self::$db->rollBack();
				throw($e);
			}
		}
		
		public static function delete(Event $event)
		{
			try
			{
				if($event->id != 0)
				{
					self::$db->beginTransaction();
					
					if($event->bildId != 0)
					{
						$statement = self::$db->prepare('DELETE FROM grafik WHERE id=?');
						$statement->execute(array($event->bildId));
					}
					$statement = self::$db->prepare('DELETE FROM veranstaltung WHERE id=?');
					$statement->execute(array($event->id));
					
					self::$db->commit();
				}
			}
			catch(PDOException $e)
			{
				self::$db->rollBack();
				throw($e);
			}
		}
		
		public static function validate(Event $event)
		{
			$messages = [];
			if($event->bezeichnung == '')
				$messages[] = 'Die Bezeichnung darf nicht leer sein.';
			if($event->zeitpunkt == '')
				$messages[] = 'Der Zeitpunkt darf nicht leer sein.';
			if($event->ort == '')
				$messages[] = 'Der Ort darf nicht leer sein.';
			
			return $messages;
			
		}
	}
?>