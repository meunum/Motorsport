<?php
namespace App\Model;

	class Driver
	{
		public int $id = 0;
		public string $name = '';
		public int $bildId = 0;

		public function __construct($driverData) 
		{
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
			//print('$driver: '); print_r($driver);
			try
			{
				$db = self::$db;
				$db->beginTransaction();
				$driver->bildId = self::saveImage($driver->bildId);
				if($driver->id == 0)
				{
					$statement = $db->prepare('INSERT INTO fahrer (name, grafik_fk) VALUES(?,?)');
					$statement->execute(array(
						$driver->name, $driver->bildId));
					$driver->id = self::$db->lastInsertId();
				}
				else
				{
					$statement = $db->prepare('UPDATE fahrer SET name=?, grafik_fk=? WHERE id=?');
					$statement->execute(array(
						$driver->name, $driver->bildId, $driver->id));
				}
				$db->commit();
			}
			catch(PDOException $e)
			{
				self::$db->rollBack();
				throw($e);
			}
		}
		
		public static function validate(Driver $driver)
		{
			$messages = [];
			if ($driver->name == '')
				$messages[] = 'Der Name darf nicht leer sein.';
			
			return $messages;
			
		}
	}
?>