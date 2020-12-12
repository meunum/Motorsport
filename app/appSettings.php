<?php
//echo "<pre>";print_r($_SERVER);echo "</pre>";
if(isset($_SERVER['VSCODE_CWD']) | isset($_SERVER['WINDIR']))
{
	$appSettings['DOMAIN']='localhost/motorsport';
	$appSettings['DBHOST']='localhost';
	$appSettings['DBNAME']='motorsport';
	$appSettings['DBUSER']='root';
	$appSettings['DBPASS']='';
	$appSettings['LOGLEVEL']='debug';
}
else if($_SERVER['SERVER_NAME'] == 'meunum.de')
{
	$appSettings['DOMAIN']='meunum.de';
	$appSettings['DBHOST']='10.35.46.173:3306';
	$appSettings['DBNAME']='k143704_mtrsprt';
	$appSettings['DBUSER']='k143704_root';
	$appSettings['DBPASS']='&22uuS4p';
	$appSettings['LOGLEVEL']='info';
}
$appSettings['LASTUPDATE']='12.12.2020 19:30';
?>