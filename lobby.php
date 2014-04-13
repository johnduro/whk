<?php
session_start();
if (isset($_POST['player']))
	$_SESSION['player'] = $_POST['player'];
$player = $_SESSION['player'];
	try
	{
		$bdd = new PDO('mysql:host=localhost;port=8080;dbname=game', 'root', '123456789');
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
$req = $bdd->prepare('SELECT id, player, player_1_login, player_2_login, player_3_login, player_4_login FROM party WHERE running=0 AND player < 4');
$req->execute();
$bol = 1;
$bol2 = 1;
while ($test = $req->fetch())
{
	$bol2 = 0;
	$id = $test['id'];
	$nb_player = $test['player'];
	if ($player === $test['player_1_login'] || $player === $test['player_2_login'] || $player === $test['player_3_login'] || $player === $test['player_4_login'])
	{
		$bol = 0 ;
		$id = $test['id'];
		$_SESSION['id_party'] = $id;
		$nb_player = $test['player'];
		break ;
	}
	$req->closeCursor();
}
if ($bol2 === 1 && !isset($_SESSION['id_party']))
{
	$req = $bdd->prepare('INSERT INTO party (`running`, `turn`, `player`) VALUES (0, 0, 0)');
	$req->execute();
	//   $req->closeCursor();
//	$req = 'SELECT id FROM party WHERE running=0 AND player < 4';
	$req = $bdd->prepare('SELECT id, player, player_1_login, player_2_login, player_3_login, player_4_login FROM party WHERE running=0 AND player < 4');
	$req->execute();
//    $req->closeCursor(); //nononononoonononono

	$bol = 1;
	while ($test = $req->fetch())
//    foreach ($bdd->query($req) as $test)
        $id = $test['id'];
	$nb_player = 0;

}
if ($bol === 1 && !isset($_SESSION['id_party']))
{
	$nb_player++;
	$_SESSION['player_id'] = $nb_player;
	$_SESSION['id_party'] = $id;
	$str = "player_".$nb_player."_login";
	$req = $bdd->prepare("UPDATE `party` SET `player`=".$nb_player." , `".$str."`='".$player."' where  id=".$id);
	$req->execute();
	$req->closeCursor();
}
else if (isset($_SESSION['id_party']))
{
	$req = 'SELECT player FROM party WHERE id='.$_SESSION['id_party'];
    $bol = 1;
    foreach ($bdd->query($req) as $test)
        $nb_player = $test['player'];
}
	$bdd = NULL;
?>
<html>
	<head>
	</head>
	<body>
		Hello <?php echo $player;?></br>
<?php
		if ($nb_player == 1)
		{
			echo "Sorry $player you have to wait for another player";
				header("Refresh: 5; url=lobby.php");
		}
		else if ($nb_player > 1 && $nb_player <= 4)
		{
			echo "<form method='post' action='init_session.php' ><input type='submit' name='submit' value='PLAY !' id='button'></form>";
		}
		else
		{
			echo "Sorry, too many players on our very popular game, come back later !";
			header("Refresh: 5; url=index.php");
		}
?>
	</body>
</html>