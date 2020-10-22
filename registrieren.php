<html>
	<head>
		<title>Motorsport (Konto erstellen)</title>
		<meta charset="UTF8"/>
		<link rel="stylesheet" type="text/css" href="css\style.css"/>
		<link rel="stylesheet" type="text/css" href="css\form.css"/>
<?php
		if(isset($_POST['submitButton'])) 
		{
			// Der User hat auf "Registrieren" geklickt, Registrierung wird ausgeführt.
			require("php/signup.php");
			if (empty($messages))
			{
				// Registrieren war erfolgreich, Weiterleitung
				echo '<meta http-equiv="Refresh" content="0; url=registrierungsmitteilung.php" />';
			}
			else
			{
				// Registrierung nicht erfolgreich, Fehlermeldungen werden weiter unten ausgegeben.
			}
		}
?>
	</head>
	<body>
<?php 
		const REQUIRED = "<abbr class = 'required' title='erforderlich' >*</abbr>";
		require("php/header.php"); 
		require("php/messages.php"); 
?>
		<main>
			<form id="veranstalter" enctype="multipart/form-data" method="post">
				<legend class="dialogHint">Pflichtfelder sind gekennzeichnet mit: <?php echo REQUIRED; ?></legend>
				<section class="groupBox">
					<legend>Daten zur Anmeldung</legend>
					<ul>
						<li>
							<label for="email"><span>E-Mail: </span><?php echo REQUIRED; ?></label>
							<input class="edit" type="email" name="email" id="email" value="<?=htmlspecialchars($_POST['email']??'')?>" required/>
						</li>
						<li>
							<label for="passwort"><span>Passwort: </span><?php echo REQUIRED; ?></label>
							<input class="edit" type="password" name="passwort" id="passwort" minlength="8" required/>
						</li>
						<li>
							<label for="passwort2"><span>Passwort wiederholen: </span><?php echo REQUIRED; ?></label>
							<input class="edit" type="password" name="passwort2" id="passwort2" minlength="8" required/>
						</li>
					</ul>
				</section>
				<section class="groupBox">
					<legend>Daten des Veranstalters</legend>
					<ul>
						<li>
							<label for="name"><span>Name: </span><?php echo REQUIRED; ?></label>
							<input class="edit" type="text" name="name" id="name" value="<?=htmlspecialchars($_POST['name']??'')?>" required/>
						</li>
						<li>
							<label for="kategorie"><span>Kategorie: </span></label>
							<input class="edit" type="text" name="kategorie" id="kategorie" value="<?=htmlspecialchars($_POST['kategorie']??'')?>" />
						</li>
						<li>
							<label for="region"><span>Region: </span></label>
							<input class="edit" type="text" name="region" id="region" value="<?=htmlspecialchars($_POST['region']??'')?>"/>
						</li>
						<li>
							<label for="beschreibung"><span>Beschreibung: </span></label>
							<input class="edit" type="text" name="beschreibung" id="beschreibung" value="<?=htmlspecialchars($_POST['beschreibung']??'')?>" />
						</li>
						<li>
							<label for="bild"><span>Bild: </span></label>
							<input class="edit" type="file" name="bild" id="bild" />
						</li>
					</ul>
				</section>
				<section id="submitSection">
					<ul>
						<li>
							<label for="submitButton" id="buttonLabel">.</label>
							<button class="button" name="submitButton" id="submitButton" value="1">Konto erstellen</button>
						</li>
					</ul>
				</section>
			</form>
		</main>
<?php require("php/footer.php"); ?>
	</body>
</html>