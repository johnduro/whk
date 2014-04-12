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

function	kill_ship()
{
	$p1 = unserialize($_SESSION['player_1']);
	foreach ($p1->ships as $i => $tab)
	{
		if ($tab->getHealth() <= 0)
		{
			$p1->ships[$i]->__destruct();
			unset($p1->ships[$i]);
			$p1->ships = array_filter($p1->ships);
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
}

function	turn()
{
	if (!$_SESSION['move'])
	{
		if ($_SESSION['select'])
		{
			make_select(1);
		}
		else if ($_SESSION['order'])
		{
			make_order(1, $_POST);
		}
		else if ($_SESSION['mvt'])
		{
			make_mvt(1, $_POST);
		}
		else if ($_SESSION['make_move'])
		{
			make_move(1, $_POST);
		}
		else
		{
			make_fire(1);
		}
	}
	else
	{
		if ($_SESSION['select'])
		{
			make_select(2);
		}
		else if ($_SESSION['order'])
		{
			make_order(2, $_POST);
		}
		else if ($_SESSION['mvt'])
		{
			make_mvt(2, $_POST);
		}
		else if ($_SESSION['make_move'])
		{
			make_move(2, $_POST);
		}
		else
		{
			make_fire(2);
		}
	}
	kill_ship();
}

?>
