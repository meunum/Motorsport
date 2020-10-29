<?php
$appSettings = [];
if($_SERVER['SERVER_NAME'] == 'localhost')
{
	$appSettings['DOMAIN']='localhost/motorsport_';
	$appSettings['DBHOST']='localhost';
	$appSettings['DBNAME']='motorsport';
	$appSettings['DBUSER']='root';
	$appSettings['DBPASS']='';
}
else
{
	$appSettings['DOMAIN']='meunum.de';
	$appSettings['DBHOST']='10.35.46.173:3306';
	$appSettings['DBNAME']='k143704_mtrsprt';
	$appSettings['DBUSER']='k143704_root';
	$appSettings['DBPASS']='&22uuS4p';
}
$appSettings['LASTUPDATE']='27.10.2020 20:45';
?>