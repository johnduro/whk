<?php

//session_start();

require_once("board.php");
require_once("fire.php");

function end_turn()
{
//	if (!$_SESSION['move'])
//	{
		if ($_SESSION['select'])
		{
			$_SESSION['select'] = 0;
			$_SESSION['order'] = 1;
		}
		else if ($_SESSION['order'])
		{
			$_SESSION['order'] = 0;
			$_SESSION['mvt'] = 1;
		}
		else if ($_SESSION['mvt'])
		{
			$_SESSION['mvt'] = 0;
			$_SESSION['make_move'] = 1;
		}
		else if ($_SESSION['make_move'])
		{
			$_SESSION['make_move'] = 0;
			$_SESSION['fire'] = 1;
		}
		else
		{
			$_SESSION['fire'] = 0;
			$_SESSION['select'] = 1;
			try
			{
				$bdd = new PDO('mysql:host=localhost;port=8080;dbname=game', 'root', '123456789');
			}
			catch(Exception $e)
			{
				die('Erreur : '.$e->getMessage());
			}

			$req = $bdd->prepare("UPDATE `party` SET turn = (turn % player) + 1  where id=".$_SESSION['id_party']);
			$req->execute();
			$req->closeCursor();
//			$_SESSION['move'] = 1;
		}
/*	}
	else
	{
		if ($_SESSION['select'])
		{
			$_SESSION['select'] = 0;
			$_SESSION['order'] = 1;
		}
		else if ($_SESSION['order'])
		{
			$_SESSION['order'] = 0;
			$_SESSION['mvt'] = 1;
		}
		else if ($_SESSION['mvt'])
		{
			$_SESSION['mvt'] = 0;
			$_SESSION['make_move'] = 1;
		}
		else if ($_SESSION['make_move'])
		{
			$_SESSION['make_move'] = 0;
			$_SESSION['fire'] = 1;
		}
		else
		{
			$_SESSION['fire'] = 0;
			$_SESSION['select'] = 1;
			$_SESSION['move'] = 0;
		}
		}*/
}

function	kill_ship($move)
{


    try
    {
        $bdd = new PDO('mysql:host=localhost;port=8080;dbname=game', 'root', '123456789');
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }


	$bol = 0;
//	$p1 = unserialize($_SESSION['player_1']);
//	$player = unserialize($_SESSION['player_obj']);
	$player = $_SESSION['hit_obj'];
	foreach ($player->ships as $i => $tab)
	{
		if ($tab->getHealth() <= 0)
		{
			$p1->ships[$i]->__destruct();
			unset($p1->ships[$i]);
			$p1->ships = array_filter($p1->ships);
			if ($move == 1)
				$bol = 1;
		}
	}
/*	$_SESSION['player_1'] = $p1->getSerial();
	$p2 = unserialize($_SESSION['player_2']);
	foreach ($p2->ships as $i => $tab)
	{
		if ($tab->getHealth() <= 0)
		{
			$p2->ships[$i]->__destruct();
			unset($p2->ships[$i]);
			$p2->ships = array_filter($p2->ships);
			if ($move == 2)
				$bol = 1;
		}
	}
	$_SESSION['player_2'] = $p2->getSerial();
	$rocher = unserialize($_SESSION['asteroid']);
	foreach ($rocher as $i => $tab)
	{
		if ($tab->getHealth() <= 0)
		{
			$rocher[$i]->__destruct();
			unset($rocher[$i]);
			$rocher = array_filter($rocher);
		}
		}*/
	$_SESSION['asteroid'] = serialize($rocher);
//	$_SESSION['board'] = get_board($p1, $p2, $rocher);

	$str = "`player_".$_SESSION['player_id_hit']."_obj='".$player->getSerial()."'";
	$req = $bdd->prepare("UPDATE `party` SET $str WHERE `id`=1");
	$req->execute();
	$req->closeCursor();
	return ($bol);
}

function	turn()
{
//	if (!$_SESSION['move'])
//	{
	if ($_SESSION['select'])
	{
		try
		{
			$bdd = new PDO('mysql:host=localhost;port=8080;dbname=game', 'root', 'password');
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}
		$req = 'SELECT player_1_obj, player_2_obj, player_3_obj, player_4_obj, asteroid FROM party WHERE `id`= 1';
		$pl = array();
		foreach ($bdd->query($req) as $test)
		{
			if ($test['player_1_obj'] !== "" && $_SESSION['player_id'] === 1)
				$_SESSION['player_obj'] = unserialize($test['player_1_obj']);
			if ($test['player_2_obj'] !== "" && $_SESSION['player_id'] === 2)
				$_SESSION['player_obj'] = unserialize($test['player_2_obj']);
			if ($test['player_3_obj'] !== "" && $_SESSION['player_id'] === 3)
				$_SESSION['player_obj'] = unserialize($test['player_3_obj']);
			if ($test['player_4_obj'] !== "" && $_SESSION['player_id'] === 4)
				$_SESSION['player_obj'] = unserialize($test['player_4_obj']);
			if ($test['asteroid'] !== "")
				$_SESSION['asteroid'] = unserialise($test['asteroid']);
		}
		make_select();
	}
	else if ($_SESSION['order'])
	{
//			$move = 1;
		make_order($_POST);
	}
	else if ($_SESSION['mvt'])
	{
//			$move = 1;
		make_mvt($_POST);
	}
	else if ($_SESSION['make_move'])
	{
//			$move = 1;
		make_move($_POST);
	}
	else
	{
//			$move = 1;
		make_fire();
	}
//	}
/*	else
	{
	if ($_SESSION['select'])
	{
	$move = 2;
	make_select(2);
	}
	else if ($_SESSION['order'])
	{
	$move = 2;
	make_order(2, $_POST);
	}
	else if ($_SESSION['mvt'])
	{
	$move = 2;
	make_mvt(2, $_POST);
	}
	else if ($_SESSION['make_move'])
	{
	$move = 2;
	make_move(2, $_POST);
	}
	else
	{
	$move = 2;
	make_fire(2);
	}
	}*/
	if (kill_ship($move)) //a checker7
	{
		$_SESSION['select'] = 1;
		$_SESSION['order'] = 0;
		$_SESSION['mvt'] = 0;
		$_SESSION['make_move'] = 0;
		$_SESSION['fire'] = 0;

		try
		{
			$bdd = new PDO('mysql:host=localhost;port=8080;dbname=game', 'root', '123456789');
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}

		$req = $bdd->prepare("UPDATE `party` SET turn = (turn % player) + 1  where id=".$_SESSION['id_party']);
		$req->execute();
		$req->closeCursor();
/*		if ($move == 1)
		$_SESSION['move'] = 2;
		else
		$_SESSION['move'] = 1;*/
	}
}

?>
