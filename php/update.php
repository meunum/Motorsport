<?php
			require_once 'globals.php';
			require 'getUserData.php';
			$messages = [];
			try
			{
				$db = new \PDO('mysql:dbname='.$GLOBALS['DBNAME'].';host='.$GLOBALS['DBHOST'].';charset=utf8mb4', $GLOBALS['DBUSER'], $GLOBALS['DBPASS']);
				$BildId = $BenutzerDaten['bild'];
				$db->beginTransaction();
				if(!empty($_FILES['bild']['name']))
				{
					$Path = $_FILES['bild']['tmp_name'];
					$Size = $_FILES['bild']['size'];
					$File = fread(fopen($Path, "r"), $Size);
					$Bild = addslashes($File);
					if(!isset($BenutzerDaten['bild']))
					{
						$db->exec("INSERT INTO grafik (daten) VALUES ('$Bild')");
						$BildId = $db->lastInsertId();
					}
					else
					{
						$db->exec("UPDATE grafik SET daten = '$Bild' WHERE id=$BildId");
					}
				}

				$statement = $db->prepare('UPDATE veranstalter SET name=?, kategorie=?, region=?, beschreibung=?, bild=? WHERE users_fk=?');
				$statement->execute(array($_POST['name'], $_POST['kategorie'], $_POST['region'], $_POST['beschreibung'], $BildId, $BenutzerId));

				$db->commit();
			}
			catch(PDOException $e)
			{
				$messages[] = 'Datenbankfehler';
			}
?>