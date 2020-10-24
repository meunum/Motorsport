<html>
	<head>
		<title>Motorsport (Anmelden)</title>
		<meta charset="UTF8"/>
		<link rel="stylesheet" type="text/css" href="css\style.css"/>
		<link rel="stylesheet" type="text/css" href="css\form.css"/>
<?php
		if(isset($_POST['signupButton']))
		{
			// Der User hat auf 'Registrieren' geklickt, er wird auf das Registrierungsformular weitergeleitet.
			echo '<meta http-equiv="Refresh" content="0; url=registrieren.php" />';
			$messages = NULL;
		}
		else
		{
			// Der User hat auf 'Anmelden' geklickt, die Eingaben werden geprüft und das Login ausgeführt.
			require("php/login.php");
		}
		if(!empty($messages)) 
		{
			// Das Login war nicht erfolgreich, der Grund steht in den Messages und wird weiter unten angezeigt.
			// Keine Weiterleitung, wir bleiben im Loginformular.
		}
		else
		{
			if($loggedIn)
			{
				// Der User ist angemeldet und wird auf das Benutzerformular weitergeleitet.
				echo '<meta http-equiv="Refresh" content="0; url=veranstalter.php" />';
			}
			else
			{
				// Der User ist noch nicht eingeloggt.
			}
		}
?>
	</head>
	<body>
		<main>
<?php		
			require("php/header.php");
			require("php/messages.php"); 
?>
			<form method="post">
				<section class="dialogSection">
					<legend>
						Bitte melde Dich mit Deinen Zugansdaten auf <?php echo $GLOBALS['DOMAIN']?> an.
					</legend>
					<ul>
						<li>
							<label for="email"><span>E-Mail: </span></label>
							<input class="edit" type="email" name="email" id="email" value="<?=htmlspecialchars($_POST['email']??'')?>" />
						</li>
						<li>
							<label for="passwort">Passwort</label>
							<input class="edit" id="passwort" name="passwort" type="password" minlength="8" >
						</li>
						<li>
							<label for="submitButton" id="buttonLabel">.</label>
							<button class="button" name="submitButton" id="submitButton" value="1">Anmelden</button>
						</li>
					</ul>
				</section>
				<section class="dialogSection">
					<legend>
						Falls Du noch kein Benutzerkonto auf <?php echo $GLOBALS['DOMAIN']?> hast, dann klicke auf Registrieren, um ein Konto anzulegen.
					</legend>
					<ul>
						<li>
							<label for="signupButton" id="buttonLabel">.</label>
							<button class="button" name="signupButton" id="signupButton" value="1">Registrieren</button>
						</li>
					</ul>
				</section>
			</form>
		</main>
<?php require("php/footer.php"); ?>
	</body>
</html>