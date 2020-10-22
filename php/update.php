<?php
			require_once 'globals.php';
			$db = new \PDO('mysql:dbname='.$DBNAME.';host='.$DBHOST.';charset=utf8mb4', $DBUSER, $DBPASS);
			$auth = new \Delight\Auth\Auth($db);
			try
			{
				require 'getUserData.php';
				//print_r($BenutzerDaten);
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
			catch(Error $e)
			{
				echo '<div class="error">Fehler beim Speichern:<br>';
				print_r($e->errorInfo());
				echo '</div>';
				$db->rollBack();
			}
?>