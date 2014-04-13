<?php

require_once('sql.confs.php');

try
{
	$bdd = new PDO('mysql:host='.$sql_host.';port='.$sql_port.';dbname='.$sql_db, $sql_user, $sql_pass);
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}

?>
