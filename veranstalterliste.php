<!DOCTYPE html>
<html>
	<head>
		<title>Motorsport</title>
		<meta charset="UTF8"/>
		<link rel="stylesheet" type="text/css" href="css\style.css"/>
		<link rel="stylesheet" type="text/css" href="css\form.css"/>
	</head>
	<body>
<?php
		require 'php/getUserData.php';
		require("php/header.php"); 
?>
			<main>
			<section class="formHead">
				<?php require("php/userSection.php"); ?> 
				<nav class="formNav">
					<ul>
						<li><div class="navTitle">Veranstalter</div></li>
						<li><a class="activeLink2" href="veranstaltungenliste.php">Veranstaltungen</a></li>
						<li><a class="activeLink2" href="fahrerliste.php">Fahrer</a></li>
					</ul>
				</nav>
			</section>
			<p>
			<table>
				<th></th><th>Veranstalter</th><th>Bevorstehende Termine</th>
<?php
				require_once 'php/globals.php';
				$mysqli = new mysqli($DBHOST, $DBUSER, $DBPASS, $DBNAME);
				if (mysqli_connect_errno()) {
					echo "Connect failed: %s\n", mysqli_connect_error();
					exit();
				}
				if (!$mysqli->set_charset("utf8")) {
					echo "Error loading character set utf8: %s\n", $mysqli->error;
				}
				$veranstalter = $mysqli->query("SELECT id, name, kategorie, region, bild FROM veranstalter");
				foreach($veranstalter as $zeile) 
				{
					$VeranstId = $zeile['id'];
					$BildId = $zeile['bild'];
					echo '<tr><td>';
						if($BildId==NULL)
							echo '<img src="res/keinbild.jpg" width="160" height="90"/>';
						else
							echo '<img src="php/bild.php?id=', $BildId, '" width="160" height="90"/>';
					echo '</td><td>';
						echo '<div>', htmlspecialchars($zeile['name']), '</div><br>';
						echo '<div> Kategorie: ', htmlspecialchars($zeile['kategorie']), '</div>';
						echo '<div> Region: ', htmlspecialchars($zeile['region']), '</div>';
					echo '</td><td>';
						$SQL = "SELECT zeitpunkt,bezeichnung,ort FROM veranstaltung WHERE veranstalter=$VeranstId and zeitpunkt>=CURRENT_DATE() ORDER BY zeitpunkt LIMIT 3";
						$termine = $mysqli->query($SQL);
						foreach($termine as $termin)
						{
							echo '<div>';
							echo '<span>', htmlspecialchars($termin['bezeichnung']), ', </span>';
 							echo '<span>am ', htmlspecialchars($termin['zeitpunkt']), ', </span>';
							echo '<span>Ort: ', htmlspecialchars($termin['ort']), '</span>';
							echo '</div>';
						}
					echo '</td></tr>';
				}
?>
			</table>
		</main>
		<?php require("php/footer.php"); ?>
	</body>
</html>