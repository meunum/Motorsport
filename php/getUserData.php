<?php
	require_once __DIR__ . '/../vendor/autoload.php';
	require_once 'globals.php';
	$BenutzerDaten = NULL;
	$BenutzerEmail = null;
	$BenutzerId = NULL;
	$loggedIn = False;
	$pdo = new \PDO('mysql:dbname='.$DBNAME.';host='.$DBHOST.';charset=utf8mb4', $DBUSER, $DBPASS);
	$auth = new \Delight\Auth\Auth($pdo);
	if ($auth->isLoggedIn()) 
	{
		$loggedIn = True;
		$BenutzerId = $auth->getUserId();
		$BenutzerEmail = $auth->getEmail();
		$stmt = $pdo->query("SELECT * FROM veranstalter where users_fk=$BenutzerId LIMIT 1");
		if($stmt)
		{
			$BenutzerDaten = $stmt->fetch();
		}
	}
?>