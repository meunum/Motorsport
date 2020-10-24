<?php
$GLOBALS = [];
if($_SERVER['SERVER_NAME'] == 'localhost')
{
	$GLOBALS['DOMAIN']='localhost/motorsport';
	$GLOBALS['DBHOST']='localhost';
	$GLOBALS['DBNAME']='motorsport';
	$GLOBALS['DBUSER']='root';
	$GLOBALS['DBPASS']='';
}
else
{
	$GLOBALS['DOMAIN']='meunum.de';
	$GLOBALS['DBHOST']='10.35.46.173:3306';
	$GLOBALS['DBNAME']='k143704_mtrsprt';
	$GLOBALS['DBUSER']='k143704_root';
	$GLOBALS['DBPASS']='&22uuS4p';
}
?>