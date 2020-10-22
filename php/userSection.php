				<nav class="userNav">
					<ul>
<?php 
						require_once 'php/getUserData.php';
						if($loggedIn)
							echo '<li><a class="activeLink2" href="php/logout.php">Abmelden</a></li>';
						else
							echo '<li></li>';
?>
					</ul>
				</nav>
<?php 
				if($loggedIn)
					echo '<legend class="userLegend">Du bist angemeldet als ' . htmlspecialchars($BenutzerDaten['name']??'') . '</legend>';
				else
					echo '<legend class="userLegend"></legend>';
?>
