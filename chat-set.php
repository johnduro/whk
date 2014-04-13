<?php

date_default_timezone_set('Europe/Paris');

require_once('sql.php');

if (isset($_POST['login'], $_POST['text']))
{
	$req = $bdd->prepare('INSERT INTO t_chat (login, text, date) VALUES(?, ?, ?)');
	$req->bindParam(1, $_POST['login']);
	$req->bindParam(2, $_POST['text']);
	$req->bindParam(3, date("Y-m-d H:i:s"));
	$req->execute();
}

$req->closeCursor();

?>
