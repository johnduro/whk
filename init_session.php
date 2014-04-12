<?php
session_start();


require_once("get_board.php");
require_once("Pawn.class.php");
require_once("Ship.class.php");
require_once("Player.class.php");
require_once("Weapon.class.php");
require_once('Serial.trait.php');

if (!isset($_SESSION['init_game']))
	die ("FATAL ERROR" . PHP_EOL);
else
{
	if ($_SESSION['init_game'] === 1)
	{
		if ($_POST['submit'] === "PLAY !" && $_POST['player1'] !== "" && $_POST['player2'] !== "")
		{
			$army_1 = array();
			$army_2	= array();
			$asteroids = array();

			$army_1[] = new Ship (array ('id' => 10, 'name' => "Wrath of the Empire", 'health' => 20, 'dim' => array(19, 10), 'faction' => "player_1", 'pos' => array(1, 45), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'right'));
			$army_1[] = new Ship (array ('id' => 11, 'name' => "Star of Galaxy", 'health' => 20, 'dim' => array(14, 7), 'faction' => "player_1", 'pos' => array(1, 2), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'right'));
			$army_1[] = new Ship (array ('id' => 12, 'name' => "Blood Angels", 'health' => 20, 'dim' => array(14, 7), 'faction' => "player_1", 'pos' => array(1, 90), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'right'));
			$army_1[] = new Ship (array ('id' => 13, 'name' => "Ultramarines", 'health' => 20, 'dim' => array(10, 5), 'faction' => "player_1", 'pos' => array(1, 17), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'right'));
			$army_1[] = new Ship (array ('id' => 14, 'name' => "Dreadclaw", 'health' => 20, 'dim' => array(10, 5), 'faction' => "player_1", 'pos' => array(1, 28), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'right'));
			$army_1[] = new Ship (array ('id' => 15, 'name' => "Storm Bird", 'health' => 20, 'dim' => array(10, 5), 'faction' => "player_1", 'pos' => array(1, 62), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'right'));
			$army_1[] = new Ship (array ('id' => 16, 'name' => "Vengeful Spirit", 'health' => 20, 'dim' => array(10, 5), 'faction' => "player_1", 'pos' => array(1, 75), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'right'));

			$army_2[] = new Ship (array ('id' => 17, 'name' => "Drone Tsahal", 'health' => 20, 'dim' => array(19, 10), 'faction' => "player_2", 'pos' =>array(139, 45), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'left'));
			$army_2[] = new Ship (array ('id' => 18, 'name' => "Rabbi Jacob", 'health' => 20, 'dim' => array(14, 7), 'faction' => "player_2", 'pos' => array(142, 2), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'left'));
			$army_2[] = new Ship (array ('id' => 19, 'name' => "Israel Battleship", 'health' => 20, 'dim' => array(14, 7), 'faction' => "player_2", 'pos' => array(142, 90), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'left'));
			$army_2[] = new Ship (array ('id' => 20, 'name' => "Shabbat Shalom", 'health' => 20, 'dim' => array(10, 5), 'faction' => "player_2", 'pos' => array(144, 17), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'left'));
			$army_2[] = new Ship (array ('id' => 21, 'name' => "Jew Counter-Attacks", 'health' => 20, 'dim' => array(10, 5), 'faction' => "player_2", 'pos' => array(144, 28), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'left'));
			$army_2[] = new Ship (array ('id' => 22, 'name' => "David's Death Star", 'health' => 20, 'dim' => array(10, 5), 'faction' => "player_2", 'pos' => array(144, 62), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'left'));
			$army_2[] = new Ship (array ('id' => 23, 'name' => "Casher Enterprise", 'health' => 20, 'dim' => array(10, 5), 'faction' => "player_2", 'pos' => array(144, 75), 'speed' => 10, 'max_shield' => 10, 'power' => 15, 'orientation' => 'left'));

			$asteroids[] = new Pawn (array ('id' => 24, 'name' => "Asteroid 1", 'health' => 100, 'dim' => array(10, 10), 'pos' => array(45, 10)));
			$asteroids[] = new Pawn (array ('id' => 25, 'name' => "Asteroid 2", 'health' => 100, 'dim' => array(5, 5), 'pos' => array(100, 20)));
			$asteroids[] = new Pawn (array ('id' => 26, 'name' => "Asteroid 3", 'health' => 100, 'dim' => array(8, 8), 'pos' => array(75, 50)));
			$asteroids[] = new Pawn (array ('id' => 27, 'name' => "Asteroid 4", 'health' => 100, 'dim' => array(10, 10), 'pos' => array(45, 70)));
			$asteroids[] = new Pawn (array ('id' => 28, 'name' => "Asteroid 5", 'health' => 100, 'dim' => array(5, 5), 'pos' => array(40, 50)));
			$asteroids[] = new Pawn (array ('id' => 29, 'name' => "Asteroid 6", 'health' => 100, 'dim' => array(8, 8), 'pos' => array(100, 80)));

			$player =  new Player ($_POST['player1'], $army_1);
			$_SESSION['player_1'] = $player->getSerial();
			$playerx =  new Player ($_POST['player2'], $army_2);
			$_SESSION['player_2'] = $playerx->getSerial();
			$_SESSION['player1_name'] = $_POST['player1'];
			$_SESSION['player2_name'] = $_POST['player2'];
			$_SESSION['asteroid'] = serialize($asteroids);
			$_SESSION['select'] = 1;
			$_SESSION['order'] = 0;
			$_SESSION['mvt'] = 0;
			$_SESSION['fire'] = 0;
			$_SESSION['move'] = 0;
			$_SESSION['col'] = 0;
			$_SESSION['board'] = get_board(unserialize($_SESSION['player_1']), unserialize($_SESSION['player_2']), unserialize($_SESSION['asteroid']));

			header('Location: playground.php');
		}
	}
}

?>
