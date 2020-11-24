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
	}
	
	class DriverList extends EntityList
	{

		public static function createList() 
		{
			$list = [];
			$stmt = self::$db->query("SELECT * FROM fahrer");
			$allDriver = $stmt->fetchAll();
			foreach($allDriver as $driverData)
			{
				$list[] = new Driver($driverData);
			}
			return $list;
		}

		public static function get($id) 
		{
			$stmt = self::$db->query("SELECT * FROM fahrer WHERE id=" . $id);
			if($stmt)
				return new driver($stmt->fetch());
		}
		
		public static function save(driver $driver)
		{
			self::$context->logger->LogDebug("\n-------------------------------------------------------\n");
			self::$context->logger->LogDebug("DriverList->save()\n");
			try
			{
				$db = self::$db;
				$db->beginTransaction();
				$driver->bildId = self::saveImage($driver->bildId);
				if($driver->id == 0)
				{
					$statement = $db->prepare('INSERT INTO fahrer (name, vorname, anmerkung, grafik_fk) VALUES(?,?,?,?)');
					$statement->execute(array(
						$driver->name, $driver->vorname, $driver->anmerkung, $driver->bildId));
					$driver->id = self::$db->lastInsertId();
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
				self::$db->rollBack();
				throw($e);
			}
		}
		
		public static function delete(driver $driver)
		{
			self::$context->logger->LogDebug("\n-------------------------------------------------------\n");
			self::$context->logger->LogDebug("DriverList->delete()\n");
			$db = self::$db;
			$statement = $db->prepare('DELETE FROM fahrer WHERE id=?');
			$statement->execute(array($driver->id));
		}
		
		public static function validate(Driver $driver)
		{
			self::$context->logger->LogDebug("\n-------------------------------------------------------\n");
			self::$context->logger->LogDebug("DriverList->validate()\n");

			$messages = [];
			if ($driver->name == '')
				$messages[] = 'Der Name darf nicht leer sein.';
			if ($driver->vorname == '')
				$messages[] = 'Der Vorname darf nicht leer sein.';

			self::$context->logger->LogDebug("messages: " . print_r($messages, true) . "\n");
			
			return $messages;
			
		}
	}
?>