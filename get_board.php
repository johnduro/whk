<?php

require_once("Pawn.class.php");
require_once("Ship.class.php");
require_once("Player.class.php");
require_once("Weapon.class.php");

function get_board($player1, $player2, $asteroid)
{
	$board = array_fill(0, 100, array_fill(0, 150, -1));
	foreach ($player1->getShips() as $pl)
	{
		$i = 0;
		$j = 1;
		$tab = $pl->getPos();
		$dim = $pl->getDim();
		$board[$tab[1]][$tab[0]] = $pl->getId();
		while ($i < $dim[1])
		{
			while ($j < $dim[0])
			{
				$board[$tab[1] + $i][$tab[0] + $j] = 1;
				$j++;
			}
			$j = 0;
			$i++;
		}
	}
	foreach ($player2->getShips() as $pl)
	{
		$i = 0;
		$j = 1;
		$tab = $pl->getPos();
		$dim = $pl->getDim();
		$board[$tab[1]][$tab[0]] = $pl->getId();
		while ($i < $dim[1])
		{
			while ($j < $dim[0])
			{
				$board[$tab[1] + $i][$tab[0] + $j] = 2;
				$j++;
			}
			$j = 0;
			$i++;
		}
	}
	foreach ($asteroid as $ast)
	{
		$i = 0;
		$j = 1;
		$tab = $ast->getPos();
		$dim = $ast->getDim();
		$board[$tab[1]][$tab[0]] = $ast->getId();
		while ($i < $dim[1])
		{
			while ($j < $dim[0])
			{
				$board[$tab[1] + $i][$tab[0] + $j] = 3;
				$j++;
			}
			$j = 0;
			$i++;
		}
	}
	return $board;
}

?>
