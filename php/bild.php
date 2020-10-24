<?php
require_once 'globals.php';
header("Content-type: image/jpg");
$BildId=$_GET['id'];
$mysqli = new mysqli($GLOBALS['DBHOST'], $GLOBALS['DBUSER'], $GLOBALS['DBPASS'], $GLOBALS['DBNAME']);
$Q = $mysqli->query("SELECT * FROM grafik WHERE id=$BildId");
$Q = $Q->fetch_array();
$Bild=$Q['daten'];
$mysqli->close();

echo $Bild;

?>
