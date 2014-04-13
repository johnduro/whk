<?php

date_default_timezone_set('Europe/Paris');

try
{
	$bdd = new PDO('mysql:host=localhost;port=8080;dbname=42_rush1', 'root', '123456');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}

if (isset($_POST['login'], $_POST['text']))
{
	$req = $bdd->prepare('INSERT INTO t_chat (login, text, date) VALUES(?, ?, ?)');
	$req->bindParam(1, $_POST['login']);
	$req->bindParam(2, $_POST['text']);
	$req->bindParam(3, date("Y-m-d H:i:s"));
	$req->execute();
}

$req->closeCursor();
$bdd = NULL;
?>
