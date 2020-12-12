<?php
namespace App\Model;

	class Driver extends Entity
	{
		public string $name = '';
		public string $vorname = '';
		public string $anmerkung = '';

		public function __construct($driverData) 
		{
			parent::__construct($driverData);
			if(isset($driverData['name']))
				$this->name = $driverData['name'];
			if(isset($driverData['vorname']))
				$this->vorname = $driverData['vorname'];
			if(isset($driverData['anmerkung']))
				$this->anmerkung = $driverData['anmerkung'];
		}

		public function GetProps()
		{
			EventList::GetContext()->logger->LogDebug("\n-------------------------------------------------------\n");
			EventList::GetContext()->logger->LogDebug("Driver->GetProps()\n");
			$props = [
				'Name' => [$this->name, 1],
				'Vorname' => [$this->vorname, 1],
				'Anmerkung' => [$this->anmerkung, 0]];
			EventList::GetContext()->logger->LogDebug(print_r($props, true));

			return $props;

		}

		public function GetListProps()
		{
			DriverList::GetContext()->logger->LogDebug("\n-------------------------------------------------------\n");
			DriverList::GetContext()->logger->LogDebug("Driver->GetListProps()\n");
			$props = [
				'Name',
				'Vorname',
				'Anmerkung'];
			EventList::GetContext()->logger->LogDebug(print_r($props, true));

			return $props;
			
		}

		public static function GetListCaptions()
		{
			DriverList::GetContext()->logger->LogDebug("\n-------------------------------------------------------\n");
			DriverList::GetContext()->logger->LogDebug("Driver->GetListCaptions()\n");
			$props = [];
			$props[] = 'Name';
			$props[] = 'Vorname';
			$props[] = 'Anmerkung';
			DriverList::GetContext()->logger->LogDebug(print_r($props, true));

			return $props;

		}

		public function Bezeichnung()
		{
			return $this->vorname . ' ' . $this->name;
		}

		public function GetTitle(int $x)
		{
			$titles = [];
			$titles[] = 'der Fahrer';
			$titles[] = 'des Fahrers';
			$titles[] = 'dem Fahrer';
			$titles[] = 'den Fahrer';

			return $titles[$x - 1];

		}
	}
	
	class DriverList extends EntityList
	{

		public static function createList() 
		{
			$list = [];
			$stmt = DriverList::$db->query("SELECT * FROM fahrer");
			$allDriver = $stmt->fetchAll();
			foreach($allDriver as $driverData)
			{
				$list[] = new Driver($driverData);
			}
			return $list;
		}

		public static function get($id) 
		{
			$stmt = DriverList::$db->query("SELECT * FROM fahrer WHERE id=" . $id);
			if($stmt)
				return new driver($stmt->fetch());
		}
		
		public static function save(driver $driver)
		{
			DriverList::GetContext()->logger->LogDebug("\n-------------------------------------------------------\n");
			DriverList::GetContext()->logger->LogDebug("DriverList->save()\n");
			try
			{
				$db = DriverList::$db;
				$db->beginTransaction();
				$driver->bildId = DriverList::saveImage($driver->bildId);
				if($driver->id == 0)
				{
					$statement = $db->prepare('INSERT INTO fahrer (name, vorname, anmerkung, grafik_fk) VALUES(?,?,?,?)');
					$statement->execute(array(
						$driver->name, $driver->vorname, $driver->anmerkung, $driver->bildId));
					$driver->id = DriverList::$db->lastInsertId();
				}
				else
				{
					$statement = $db->prepare('UPDATE fahrer SET name=?, vorname=?, anmerkung=?, grafik_fk=? WHERE id=?');
					$statement->execute(array(
						$driver->name, $driver->vorname, $driver->anmerkung, $driver->bildId, $driver->id));
				}
				$db->commit();
			}
			catch(PDOException $e)
			{
				DriverList::$db->rollBack();
				throw($e);
			}
		}
		
		public static function delete(driver $driver)
		{
			DriverList::GetContext()->logger->LogDebug("\n-------------------------------------------------------\n");
			DriverList::GetContext()->logger->LogDebug("DriverList->delete()\n");
			$db = DriverList::$db;
			$statement = $db->prepare('DELETE FROM fahrer WHERE id=?');
			$statement->execute(array($driver->id));
		}
		
		public static function validate(Driver $driver)
		{
			DriverList::GetContext()->logger->LogDebug("\n-------------------------------------------------------\n");
			DriverList::GetContext()->logger->LogDebug("DriverList->validate()\n");

			$messages = [];
			if ($driver->name == '')
				$messages[] = 'Der Name darf nicht leer sein.';
			if ($driver->vorname == '')
				$messages[] = 'Der Vorname darf nicht leer sein.';

			DriverList::GetContext()->logger->LogDebug("messages: " . print_r($messages, true) . "\n");
			
			return $messages;
			
		}
	}
?>