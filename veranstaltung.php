 <html>
	<head>
		<title>Motorsport (Meine Veranstaltungen)</title>
		<meta charset="UTF8"/>
		<link rel="stylesheet" type="text/css" href="css\style.css"/>
		<link rel="stylesheet" type="text/css" href="css\form.css"/>
	</head>
	<body>
<?php 	require("php/header.php"); ?>
		<main>
			<section class="formHead">
				<?php require("php/userSection.php"); ?> 
				<nav class="formNav">
					<ul>
						<li><a class="activeLink2" href="veranstalter.php">Meine Grunddaten</h2></li>
						<li><a class="activeLink2" href="veranstaltungeneditliste.php">Meine Veranstaltungen</a></li>
						<li><a class="activeLink2" href="fahrereditliste.php">Meine Fahrerliste</a></li>
					</ul>
				</nav>
			</section>
			<form id="veranstalter" enctype="multipart/form-data" method="post">
<?php
				const REQUIRED = "<abbr class = 'required' title='erforderlich' >*</abbr>";
?>
				<div class="dialogTitle">Veranstaltung bearbeiten</div>
				<legend>Pflichtfelder sind gekennzeichnet mit: <?php echo REQUIRED; ?></legend>
				<section class="groupBox">
					<ul>
						<li>
							<label for="bezeichnung"><span>Bezeichnung: </span><?php echo REQUIRED; ?></label>
							<input class="edit" type="text" name="Bezeichnung" id="bezeichnung" value="<?=htmlspecialchars($FormDaten['bezeichnung']??'')?>" required/>
						</li>
						<li>
							<label for="zeitpunkt"><span>Datum, Zeit: </span><?php echo REQUIRED; ?></label>
							<input class="edit" type="text" name="zeitpunkt" id="zeitpunkt" value="<?=htmlspecialchars($FormDaten['zeitpunkt']??'')?>" required/>
						</li>
						<li>
							<label for="region"><span>Ort: </span><?php echo REQUIRED; ?></label>
							<input class="edit" type="text" name="region" id="region" value="<?=htmlspecialchars($FormDaten['region']??'')?>" required/>
						</li>
						<li>
							<label for="kategorie"><span>Kategorie: </span></label>
							<input class="edit" type="text" name="kategorie" id="kategorie" value="<?=htmlspecialchars($FormDaten['kategorie']??'')?>" />
						</li>
						<li>
							<label for="bild"><span>Bild hochladen: </span></label>
							<input class="edit" type="file" name="bild" id="bild" />
						</li>
						<li>
							<label for="bild"><span>Bild aktuell: </span></label>
							<?php echo '<img src="php/bild.php?id=', $FormDaten['bild'], '" width="160" height="90"/>'; ?>
						</li>
					</ul>
				</section>
				<section id="buttonSection">
					<ul>
						<li>
							<label for="submitButton" id="buttonLabel">.</label>
							<button name="submitButton" id="submitButton" value="submit">Speichern</button>
						</li>
					</ul>
				</section>
			</form>
		</main>
<?php require("php/footer.php"); ?>
	</body>
</html>