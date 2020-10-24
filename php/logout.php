<html>
	<head>
		<title>Motorsport</title>
		<meta charset="UTF8"/>
<?php
		require_once __DIR__ . '/../vendor/autoload.php';
		require_once 'globals.php';
		require 'getUserData.php';
		if ($loggedIn)
		{
			$messages = [];

			$db = new \Delight\Db\PdoDsn(
				'mysql:dbname=' . $GLOBALS['DBNAME'] . ';host=' . $GLOBALS['DBHOST'] . ';charset=utf8mb4', $GLOBALS['DBUSER'], $GLOBALS['DBPASS']);
			$auth = new \Delight\Auth\Auth($db);
			try {
				$auth->logOut();
				$loggedIn = False;
				// Der User ist nicht mehr angemeldet, er wird zur Anmeldeseite weitergeleitet.
				echo '<meta http-equiv="Refresh" content="0; url=..\anmelden.php" />';
			}
			catch (\Delight\Auth\NotLoggedInException $e) {
				$messages[] = 'Nicht angemeldet';
			}
		}
		echo "</head><body>";
		if(!empty($messages)) 
		{
			// Fehlermeldungen ausgeben:
			echo '<div class="error">Fehler bei Abmeldung:<ul>';
			foreach($messages as $message) 
			{
				echo '<li>'.htmlspecialchars($message).'</li>';
			}
			echo '</ul></div>';
			die();
		}
?>
	</body>
</html>