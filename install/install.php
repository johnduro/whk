<html>
	<head>
		<title>Install</title>
	</head>
<body>

<?php
if(!isset($_POST['hote'], $_POST['port'], $_POST['login'], $_POST['mdp'], $_POST['base']))
{
	echo '
		<h1>Informations sur la base de donnees MySQL :</h1>
		<form action="index.php" method="post">
		<p>
		<label for="hote">Hote :</label>
		<input type="text" name="hote" maxlength="40" /><br />

		<label for="hote">Port :</label>
		<input type="text" name="port" maxlength="40" /><br />

		<label for="login">Utilisateur :</label>
		<input type="text" name="login" maxlength="40" /><br />

		<label for="mdp">Mot de passe :</label>
		<input type="password" name="mdp" maxlength="40" /><br />

		<label for="base">Nom de la base :</label>
		<input type="text" name="base" maxlength="40" /><br /><br />

		<label for="submit">&nbsp;</label>
		<input type="submit" name="submit" value="Envoyer" />
		</p>
		</form>';
}
else
{
	$fichier = 'sql.confs.php';
	if(file_exists($fichier) AND filesize($fichier ) > 0) {
		exit('Fichier de configuration deja existant. Installation interrompue.');
	}

	$hote = trim($_POST['hote']);
	$port = trim($_POST['port']);
	$login = trim($_POST['login']);
	$mdp = trim($_POST['mdp']);
	$base = trim($_POST['base']);

	if(!($l = mysql_connect($hote.':'.$port, $login, $mdp))) {
		exit('Mauvais paramètres de connexion.');
	}
	mysql_query("CREATE DATABASE ".$base, $l);

	if(!mysql_select_db($base)) {
		exit('Mauvais nom de base.');
	}

	$texte = '<?php
$sql_host   = "'. $hote .'";
$sql_port   = "'. $port .'";
$sql_user  = "'. $login .'";
$sql_pass   = "'. $mdp .'";
$sql_db   = "'. $base .'";

?>';

if(!$ouvrir = fopen($fichier, 'w')) {
exit('Impossible d\'ouvrir le fichier : <strong>'. $fichier .'</strong>.');
}

if(fwrite($ouvrir, $texte) == FALSE) {
exit('Impossible d\'ecrire dans le fichier : <strong>'. $fichier .'</strong>.');
}

echo 'Fichier de configuration : OK';
fclose($ouvrir);

$requetes = '';

$sql = file('install/base.sql');
foreach($sql as $lecture) {
	if(substr(trim($lecture), 0, 2) != '--') {
	$requetes .= $lecture;
	}
}

$reqs = split(';', $requetes);
foreach($reqs as $req){
	if(!mysql_query($req) AND trim($req) != '') {
		exit('ERREUR : '. $req);
	}
}
echo 'Installation : OK';
echo '<br /><span class="note">Note : si le site est en ligne, veuillez supprimer le repertoire <strong>/install</strong> du depot.</span>';
// header("Location: index.php");

}
?>
</p>
</body>
</html>
