<?php

session_start();

require_once("board.php");
require_once("fire.php");

function end_turn()
{
	if (!$_SESSION['move'])
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
			$_SESSION['move'] = 1;
		}
	}
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
	}
}

function	kill_ship($move)
{
	$bol = 0;
	$p1 = unserialize($_SESSION['player_1']);
	foreach ($p1->ships as $i => $tab)
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
	$_SESSION['player_1'] = $p1->getSerial();
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
	}
	$_SESSION['asteroid'] = serialize($rocher);
	$_SESSION['board'] = get_board($p1, $p2, $rocher);
	return ($bol);
}

function	turn()
{
	if (!$_SESSION['move'])
	{
		if ($_SESSION['select'])
		{
			$move = 1;
			make_select(1);
		}
		else if ($_SESSION['order'])
		{
			$move = 1;
			make_order(1, $_POST);
		}
		else if ($_SESSION['mvt'])
		{
			$move = 1;
			make_mvt(1, $_POST);
		}
		else if ($_SESSION['make_move'])
		{
			$move = 1;
			make_move(1, $_POST);
		}
		else
		{
			$move = 1;
			make_fire(1);
		}
	}
	else
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
	}
	if (kill_ship($move))
	{
		$_SESSION['select'] = 1;
		$_SESSION['order'] = 0;
		$_SESSION['mvt'] = 0;
		$_SESSION['make_move'] = 0;
		$_SESSION['fire'] = 0;
		if ($move == 1)
			$_SESSION['move'] = 2;
		else
			$_SESSION['move'] = 1;
	}
}

?>
