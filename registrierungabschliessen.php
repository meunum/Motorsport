<html>
<?php
	require_once __DIR__ . '/vendor/autoload.php';
	require_once 'php/globals.php';
	$db = new \PDO('mysql:dbname='.$DBNAME.';host='.$DBHOST.';charset=utf8mb4', $DBUSER, $DBPASS);
	$auth = new \Delight\Auth\Auth($db);

	try {
		$auth->confirmEmail($_GET['selector'], $_GET['token']);
	}
	catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
		die('Invalid token');
	}
	catch (\Delight\Auth\TokenExpiredException $e) {
		die('Token expired');
	}
	catch (\Delight\Auth\UserAlreadyExistsException $e) {
		die('Email address already exists');
	}
	catch (\Delight\Auth\TooManyRequestsException $e) {
		die('Too many requests');
	}
?>
		<title>Motorsport (Konto aktivieren)</title>
		<meta charset="UTF8"/>
		<link rel="stylesheet" type="text/css" href="css\style.css"/>
		<link rel="stylesheet" type="text/css" href="css\form.css"/>
	</head>
	<body>
<?php 
		require("php/header.php"); 
?>
		<main>
			<div class="zentralerInfotext">
				<p>Dein Konto wurde erfolgreich aktiviert. Hier geht's zur <a href="anmelden.php">Anmeldung.</a></p>
			</div>
		</main>
<?php	
		require("php/footer.php"); 
?>
	</body>
</html>