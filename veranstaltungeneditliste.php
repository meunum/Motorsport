<html>
	<head>
		<title>Motorsport (Meine Veranstaltungen)</title>
		<meta charset="UTF8"/>
		<link rel="stylesheet" type="text/css" href="css\style.css"/>
		<link rel="stylesheet" type="text/css" href="css\form.css"/>
<?php
		require 'php/getUserData.php';
		if(isset($_POST['editButton']))
		{
			// Der User hat auf Ändern geklickt und wird zum Ändern einer Veranstaltung weitergeleitet
			echo '<meta http-equiv="Refresh" content="0; url=veranstaltung.php?id=', $_POST['editButton'], '" />';
		}
		else if(isset($_POST['deleteButton']))
		{
			// Der User hat auf Löschen geklickt
		}
		else if(isset($_POST['insertButton']))
		{
			// Der User hat auf Hinzufügen geklickt und wird zum Erfassen einer Veranstaltung weitergeleitet
			echo '<meta http-equiv="Refresh" content="0; url=veranstaltung.php?id=" />';
		}
		else if (!$loggedIn) 
		{
			// Der User ist noch nicht oder nicht mehr angemeldet, er wird zur Anmeldeseite weitergeleitet.
			echo '<meta http-equiv="Refresh" content="0; url=anmelden.php" />';
		}
?>
	</head>
	<body>
<?php 	
		require("php/header.php"); 
?>
		<main>
			<section class="formHead">
				<?php require("php/userSection.php"); ?> 
				<nav class="formNav">
					<ul>
						<li><a class="activeLink2" href="veranstalter.php">Meine Grunddaten</a></li>
						<li><div class="navTitle">Meine Veranstaltungen</div></li>
						<li><a class="activeLink2" href="fahrereditliste.php">Meine Fahrerliste</a></li>
					</ul>
				</nav>
			</section>
			<form id="veranstalter" enctype="multipart/form-data" method="post">
				<table class="editEvents">
					<th></th><th>Bezeichnung</th><th>Datum, Zeit</th><th>Ort</th><th>Kategorie</th><th>Bearbeiten</th>
<?php
					require_once 'php/globals.php';
					$mysqli = new mysqli($DBHOST, $DBUSER, $DBPASS, $DBNAME);
					$veranstaltungen = $mysqli->query("SELECT * FROM veranstaltung WHERE veranstalter=$BenutzerId");
					foreach($veranstaltungen as $zeile) 
					{
						echo '<tr><td>';
							if($zeile['bild']==NULL)
								echo '<img src="res/keinbild.jpg" width="160" height="90"/>';
							else
								echo '<img src="php/bild.php?id=', $zeile['bild'], '" width="160" height="90"/>';
						echo '</td><td>';
							echo htmlspecialchars($zeile['bezeichnung']);
						echo '</td><td>';
							echo htmlspecialchars($zeile['zeitpunkt']);
						echo '</td><td>';
							echo htmlspecialchars($zeile['ort']);
						echo '</td><td>';
							echo htmlspecialchars($zeile['kategorie']);
						echo '</td><td>';
							echo '<button class="cellButton" type="submit" name="editButton" value="', $zeile['id'], '">Ändern</button><br>';
							echo '<button class="cellButton" type="submit" name="deleteButton" value="', $zeile['id'],'">Löschen</button>';
						echo '</td></tr>';
					}
?>
				</table>
				<section class="subTableButton">
					<button type="submit" name="insertButton" value="-1">Hinzufügen</button>
				</section>
				<section><p/></section>
			</form>
		</main>
<?php require("php/footer.php"); ?>
	</body>
</html>