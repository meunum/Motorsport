<html>
	<head>
		<title>Motorsport (Meine Daten)</title>
		<meta charset="UTF8"/>
		<link rel="stylesheet" type="text/css" href="css\style.css"/>
		<link rel="stylesheet" type="text/css" href="css\form.css"/>
<?php
		require_once __DIR__ . '/vendor/autoload.php';
		if(isset($_POST['submitButton']))
		{
			// Der User hat auf 'Speichern' geklickt, Veranstalterdaten werden aktualisiert.
			require 'php/update.php';
		}
		if(isset($_POST['logoutButton']))
		{
			// Der User hat auf Abmelden geklickt, logout wird ausgeführt.
			require 'php/logout.php';
		}
		require 'php/getUserData.php';
		if (!$loggedIn) 
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
						<li><div class="navTitle">Meine Grunddaten</div></li>
						<li><a class="activeLink2" href="veranstaltungeneditliste.php">Meine Veranstaltungen</a></li>
						<li><a class="activeLink2" href="fahrereditliste.php">Meine Fahrerliste</a></li>
					</ul>
				</nav>
			</section>
			<form id="veranstalter" enctype="multipart/form-data" method="post">
<?php	 		const REQUIRED = "<abbr class = 'required' title='erforderlich' >*</abbr>";?>
				<legend class="dialogHint">Pflichtfelder sind gekennzeichnet mit: <?php echo REQUIRED; ?></legend>
				<section class="groupBox">
					<ul>
						<li>
							<label for="email"><span>E-Mail: </span></label>
							<input class="edit" type="text" name="email" id="email" disabled value="<?=htmlspecialchars($BenutzerEmail??'')?>"/>
						</li>
						<li>
							<label for="name"><span>Name: </span><?php echo REQUIRED; ?></label>
							<input class="edit" type="text" name="name" id="name" value="<?=htmlspecialchars($BenutzerDaten['name']??'')?>" required/>
						</li>
						<li>
							<label for="kategorie"><span>Kategorie: </span></label>
							<input class="edit" type="text" name="kategorie" id="kategorie" value="<?=htmlspecialchars($BenutzerDaten['kategorie']??'')?>" />
						</li>
						<li>
							<label for="region"><span>Region: </span></label>
							<input class="edit" type="text" name="region" id="region" value="<?=htmlspecialchars($BenutzerDaten['region']??'')?>"/>
						</li>
						<li>
							<label for="beschreibung"><span>Beschreibung: </span></label>
							<input class="edit" type="text" name="beschreibung" id="beschreibung" value="<?=htmlspecialchars($BenutzerDaten['beschreibung']??'')?>" />
						</li>
						<li>
							<label for="bild"><span>Bild hochladen: </span></label>
							<input class="edit" type="file" name="bild" id="bild" />
						</li>
						<li>
							<label for="bild"><span>Bild aktuell: </span></label>
							<?php echo '<img src="php/bild.php?id=', $BenutzerDaten['bild'], '" width="160" height="90"/>'; ?>
						</li>
					</ul>
				</section>
				<section id="buttonSection">
					<ul>
						<li>
							<label for="submitButton" id="buttonLabel">.</label>
							<button name="submitButton" id="submitButton" value="submit">Speichern</button>
							<button name="logoutButton" id="logoutButton" value="logout">Abmelden</button>
						</li>
					</ul>
				</section>
			</form>
		</main>
<?php require("php/footer.php"); ?>
	</body>
</html>
