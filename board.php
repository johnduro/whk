<?php

require_once("Pawn.class.php");
require_once("Ship.class.php");
require_once("Player.class.php");
require_once("Weapon.class.php");
require_once("get_board.php");
require_once('Serial.trait.php');

function	making($move, $bol, $player)
{
	if (!$bol)
	{
		if ($move == 1)
			$player = unserialize($_SESSION['player_1']);
		else
			$player = unserialize($_SESSION['player_2']);
		return ($player);
	}
	else
	{
		if ($move == 1)
			$_SESSION['player_1'] = $player->getSerial();
		else
			$_SESSION['player_2'] = $player->getSerial();
	}
}

function	make_select($move)
{
	$player = making($move, 0, NULL);
	$ships = $player->getShips();
	$print_ship = array();
	foreach ($ships as $ship)
		$print_ship[] = $ship->getName();
	$_SESSION['print_ship'] = $print_ship;
	making($move, 1, $player);
}

function	make_order($move, $array)
{
	$player = making($move, 0, NULL);
	$ships = $player->getShips();
	foreach ($ships as $i => $ship)
	{
		if ($ship->getName() === $array['ship_to_play'])
		{
			$_SESSION['ship_power'] = $ship->getPower();
			$_SESSION['ship_to_play'] = $array['ship_to_play'];
			$_SESSION['index_ship'] = $i;
			$_SESSION['ship_orientation'] = $ship->getOrientation();
			break ;
		}
	}
	making($move, 1, $player);
}

function	make_mvt($move, $array)
{
	$player = making($move, 0, NULL);
	$ships = $player->getShips();
	$ship = $ships[$_SESSION['index_ship']];
	if (isset($array['bonus_speed']))
		$ship->setBonus_speed($array['bonus_speed']);
	$_SESSION['ship_speed'] = $ship->getSpeed();
	if (isset($array['bonus_shield']))
		$ship->setShield($array['bonus_shield']);
	if (isset($array['bonus_weapon']))
		$ship->setBonus_Weapon($array['bonus_weapon']);
	$_SESSION['ship_mvt'] = $ship->getSpeed();
	making($move, 1, $player);
}

function	check_collision($grid, $x, $y, $dim)
{
	$i = 0;
	$j = 0;
	while ($i < $dim[1])
	{
		while ($j < $dim[0])
		{
			if ($grid[$i + $y][$j + $x] !== -1)
				return 1;
			$j++;
		}
		$j = 0;
		$i++;
	}
	return -1;
}

function	make_move($move, $array)
{
	$player = making($move, 0, NULL);
	$ships = $player->getShips();
	$ship = $ships[$_SESSION['index_ship']];
	$grid = $_SESSION['board'];
	$ship->setOrientation($array['ship_orientation']);
	$pos = $ship->getPos();
	$dim = $ship->getDim();
	if ($array['ship_orientation'] === "down")
	{
		$y = $pos[1] + intval($array['deplacement']);
		if ($y < 100 && check_collision($grid, $pos[0], $y, $dim) === -1)
			$ship->setPos(array($pos[0], $y));
		else if (intval($array['deplacement']) <= $dim[1] && $grid[$y + $dim[1]][$pos[0]] !== -1)
			$ship->setPos(array($pos[0], $y));
		else
			$ship->setHealth(-1000);
	}
	if ($array['ship_orientation'] === "up")
	{
		$y = $pos[1] - intval($array['deplacement']);
		if ($y >= 0 && check_collision($grid, $pos[0], $y, $dim) === -1)
			$ship->setPos(array($pos[0], $y));
		else if (intval($array['deplacement']) <= $dim[1] && $grid[$y][$pos[0]] !== -1)
			$ship->setPos(array($pos[0], $y));
		else
			$ship->setHealth(-1000);
	}
	if ($array['ship_orientation'] === "right")
	{
		$y = $pos[0] + intval($array['deplacement']);
		if ($y < 150 && check_collision($grid, $y, $pos[1], $dim) === -1)
			$ship->setPos(array($y, $pos[1]));
		else if (intval($array['deplacement']) <= $dim[1] && $grid[$pos[1]][$y + $dim[0]] !== -1)
			$ship->setPos(array($pos[0], $y));
		else
			$ship->setHealth(-1000);
	}
	if ($array['ship_orientation'] === "left")
	{
		$y = $pos[0] - intval($array['deplacement']);
		if ($y >=0 && check_collision($grid, $y, $pos[1], $dim) === -1 || intval($array['deplacement']) <= $dim[0])
			$ship->setPos(array($y, $pos[1]));
		else if (intval($array['deplacement']) <= $dim[1] && $grid[$pos[1]][$y] !== -1)
			$ship->setPos(array($pos[0], $y));
		else
			$ship->setHealth(-1000);
	}
	making($move, 1, $player);
	$_SESSION['board'] = get_board(unserialize($_SESSION['player_1']), unserialize($_SESSION['player_2']), unserialize($_SESSION['asteroid']));
}

?>
