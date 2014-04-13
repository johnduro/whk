<?php

try
{
	$bdd = new PDO('mysql:host=localhost;port=8080;dbname=42_rush1', 'root', '123456');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
}

$reponse = $bdd->query('SELECT * FROM t_chat ORDER BY id DESC LIMIT 10');

while ($donnees = $reponse->fetch())
{
	$color = ($donnees['id'] % 2 == 0 ? 'red' : 'green');
	echo '<p style="color: '.$color.'">
		<strong>' . htmlspecialchars($donnees['login']) . '</strong>
		('.htmlspecialchars($donnees['date']).') : 
		' . htmlspecialchars($donnees['text']) . '</p>';
}

$reponse->closeCursor();
$bdd = NULL;

?>
