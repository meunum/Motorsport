<?php
namespace App\Controller;
use App\View;

class PromoterSubmitAction extends Action
{

	public function createView()
	{
		return new \App\View\promoterView($this->context, $this->messages);
	}
	
	public function execute()
	{
		require_once $this->context->indexdir . '/app/model/promoter.php';
		try
		{
			$BildId = $this->context->user->promoter->bildId;
			$BenutzerId = $this->context->user->promoter->id;
			$db = $this->context->database;
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
			$statement = $db->prepare('UPDATE veranstalter SET name=?, kategorie=?, region=?, beschreibung=?, bild=? WHERE id=?');
			$statement->execute(array($_POST['name'], $_POST['kategorie'], $_POST['region'], $_POST['beschreibung'], $BildId, $BenutzerId));
			$db->commit();
			$this->context->user->promoter = \App\Model\Promoterlist::get($BenutzerId);
			$this->success = True;
		}
		catch(PDOException $e)
		{
			$this->messages[] = 'Datenbankfehler';
		}
			
		return $this->success;
			
	}
}