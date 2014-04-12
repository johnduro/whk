<?php

//session_start();
require_once("Pawn.class.php");
require_once("Ship.class.php");
require_once("Player.class.php");
require_once("Weapon.class.php");
require_once("get_board.php");
require_once("board.php");
require_once("play.php");
require_once('Serial.trait.php');

function	down_fire($pos, $range, $tab, $p1, $p2, $pa, $bol, $move)
{
	$i = $pos[1] + 1;
	while ($tab[$i][$pos[0]] == $move)
		$i++;
	while ($bol < $range && $i < 100 && $tab[$i][$pos[1]] == -1)
	{
		$i++;
		$bol++;
	}
	if ($bol < $range && $i < 100)
	{
		if (($tab[$i][$pos[0]] == 2 || ($tab[$i][$pos[0]] >= 17 && $tab[$i][$pos[0]] <= 23)) && $move == 1)
		{
			$p2->ships[$_SESSION['index_ship']]->setHealth(-3);
			$_SESSION['player_2'] = $p2->getSerial();
		}
		else if (($tab[$i][$pos[0]] == 1 || ($tab[$i][$pos[0]] >=10 && $tab[$i][$pos[0]] <= 16)) && $move != 1)
		{
			$p1->ships[$_SESSION['index_ship']]->setHealth(-3);
			$_SESSION['player_1'] = $p1->getSerial();
		}
		else if ($tab[$i][$pos[0]] == 3 || ($tab[$i][$pos[0]] >= 24 && $tab[$i][$pos[0]] <= 29))
		{
			$pa->setHealth(-3);
			$_SESSION['asteroid'] = serialize($pa);
		}
	}
}

function	up_fire($pos, $range, $tab, $p1, $p2, $pa, $bol, $move)
{
	$i = $pos[1] - 1;
	while ($tab[$i][$pos[0]] == $move)
		$i++;
	while ($bol < $range && $i >= 0 && $tab[$i][$pos[0]] == -1)
	{
		$i--;
		$bol++;
	}
	if ($bol < $range && $i >= 0)
	{
		if (($tab[$i][$pos[0]] == 2 || ($tab[$i][$pos[0]] >= 17 && $tab[$i][$pos[0]] <= 23)) && $move == 1)
		{
			$p2->ships[$_SESSION['index_ship']]->setHealth(-3);
			$_SESSION['player_2'] = $p2->getSerial();
		}
		else if (($tab[$i][$pos[0]] == 1 || ($tab[$i][$pos[0]] >=10 && $tab[$i][$pos[0]] <= 16)) && $move != 1)
		{
			$p1->ships[$_SESSION['index_ship']]->setHealth(-3);
			$_SESSION['player_1'] = $p1->getSerial();
		}
		else if ($tab[$i][$pos[0]] == 3 || ($tab[$i][$pos[0]] >= 24 && $tab[$i][$pos[0]] <= 29))
		{
			$pa->setHealth(-3);
			$_SESSION['asteroid'] = serialize($pa);
		}
	}
}

function	right_fire($pos, $range, $tab, $p1, $p2, $pa, $bol, $move)
{
	$i = $pos[0] + 2;
	while ($tab[$pos[1]][$i] == $move)
		$i++;
	while ($bol < $range && $i < 150 && $tab[$pos[1]][$i] == -1)
	{
		$i++;
		$bol++;
	}
	if ($bol < $range && $i < 150)
	{
		if (($tab[$pos[1]][$i] == 2 || ($tab[$pos[1]][$i] >= 17 && $tab[$pos[1]][$i] <= 23)) && $move == 1)
		{
			$p2->ships[$_SESSION['index_ship']]->setHealth(-3);
			$_SESSION['player_2'] = $p2->getSerial();
		}
		else if (($tab[$pos[1]][$i] == 1 || ($tab[$pos[1]][$i] >=10 && $tab[$pos[1]][$i] <= 16)) && $move != 1)
		{
			$p1->ships[$_SESSION['index_ship']]->setHealth(-3);
			$_SESSION['player_1'] = $p1->getSerial();
		}
		else if ($tab[$pos[1]][$i] == 3 || ($tab[$pos[1]][$i] >= 24 && $tab[$pos[1]][$i] <= 29))
		{
			$pa->setHealth(-3);
			$_SESSION['asteroid'] = serialize($pa);
		}
	}
}

function	left_fire($pos, $range, $tab, $p1, $p2, $pa, $bol, $move)
{
	$i = $pos[0] - 1;
	while ($tab[$pos[1]][$i] == $move)
		$i--;
	while ($bol < $range && $i >= 0 && $tab[$pos[1]][$i] == -1)
	{
		$i--;
		$bol++;
	}
	if ($bol < $range && $i >= 0)
	{
		if (($tab[$pos[1]][$i] == 2 || ($tab[$pos[1]][$i] >= 17 && $tab[$pos[1]][$i] <= 23)) && $move == 1)
		{
			$p2->ships[$_SESSION['index_ship']]->setHealth(-3);
			$_SESSION['player_2'] = $p2->getSerial();
		}
		else if (($tab[$pos[1]][$i] == 1 || ($tab[$pos[1]][$i] >=10 && $tab[$pos[1]][$i] <= 16)) && $move != 1)
		{
			$p1->ships[$_SESSION['index_ship']]->setHealth(-3);
			$_SESSION['player_1'] = $p1->getSerial();
		}
		else if ($tab[$pos[1]][$i] == 3 || ($tab[$pos[1]][$i] >= 24 && $tab[$pos[1]][$i] <= 29))
		{
			$pa->setHealth(-3);
			$_SESSION['asteroid'] = serialize($pa);
		}
	}
}

function	make_fire($move)
{
	$p1 = unserialize($_SESSION['player_1']);
	$p2 = unserialize($_SESSION['player_2']);
	$pa = unserialize($_SESSION['asteroid']);
	$tab = get_board($p1, $p2, $pa);
	$range = 35;
	$bol = 1;

	if ($move == 1)
	{
		$pos = $p1->ships[$_SESSION['index_ship']]->getPos();
		$or = $p1->ships[$_SESSION['index_ship']]->getOrientation();
	}
	else
	{
		$pos = $p2->ships[$_SESSION['index_ship']]->getPos();
		$or = $p2->ships[$_SESSION['index_ship']]->getOrientation();
	}

	if ($or == "right")
		right_fire($pos, $range, $tab, $p1, $p2, $pa, $bol, $move);
	else if ($or == "left")
		left_fire($pos, $range, $tab, $p1, $p2, $pa, $bol, $move);
	else if ($or == "up")
		up_fire($pos, $range, $tab, $p1, $p2, $pa, $bol, $move);
	else
		down_fire($pos, $range, $tab, $p1, $p2, $pa, $bol, $move);
}

?>
