<?php
$appSettings = [];
if($_SERVER['SERVER_NAME'] == 'localhost')
{
	$appSettings['DOMAIN']='localhost/motorsport';
	$appSettings['DBHOST']='localhost';
	$appSettings['DBNAME']='motorsport';
	$appSettings['DBUSER']='root';
	$appSettings['DBPASS']='';
	$appSettings['LOGLEVEL']='debug';
}
else
{
	$appSettings['DOMAIN']='meunum.de';
	$appSettings['DBHOST']='10.35.46.173:3306';
	$appSettings['DBNAME']='k143704_mtrsprt';
	$appSettings['DBUSER']='k143704_root';
	$appSettings['DBPASS']='&22uuS4p';
	$appSettings['LOGLEVEL']='info';
}
$appSettings['LASTUPDATE']='19.11.2020 20:10';
?>