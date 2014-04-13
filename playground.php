<?php
    var_dump($_POST);
    require_once("play.php");
    turn();
    require_once("functionjs.php");

    function    take_pos()
    {
        if ($_SESSION['move'] == 1)
            $player = unserialize($_SESSION['player_1']);
        else
            $player = unserialize($_SESSION['player_2']);
        $pos = $player->ships[$_SESSION['index_ship']]->getPos();
        $dim = $player->ships[$_SESSION['index_ship']]->getDim();
        $pos[0] += $dim[0] - 2;
        $pos[1] -= round(($dim[1]) / 2, 0, PHP_ROUND_HALF_DOWN);
        return ($pos);
    }

?>
<html>
<head>
	<link href="style.css" rel="stylesheet">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<body>
   <!-- <embed src="music.mp3" autostart="true" loop="true" hidden="true"></embed>-->
    <div id="content">
        <div id="board">
            <?php
                $i = 0;
                $j = 0;
                $grid = $_SESSION['board'];
                if (isset($_POST['fire']))
                    $pos = take_pos();
                else
                    $pos = array(-1 , -1);
                while($i < 100)
                {
                    $j = 0;
                    while ($j < 150)
                    {
                        if ($grid[$i][$j] === 11)
                        echo "<div id='carre'> <img id='bat_p1_middle' title='Star of the Galaxy' src='img/w/1.png'> </div>";
                        else if ($grid[$i][$j] === 13)
                        echo "<div id='carre'> <img id='bat_p1' title='Ultramarines' src='img/w/2.png'> </div>";
                        else if ($grid[$i][$j] === 14)
                        echo "<div id='carre'> <img id='bat_p1' title='Dreadclaw' src='img/w/3.png'>  </div>";
                        else if ($grid[$i][$j] === 10)
                        echo "<div id='carre'> <img id='bat_p1_big' title='Wrath of the Empire' src='img/w/11.png'>  </div>";
                        else if ($grid[$i][$j] === 15)
                        echo "<div id='carre'> <img id='bat_p1' title='Storm Bird' src='img/w/5.png'> </div>";
                        else if ($grid[$i][$j] === 16)
                        echo "<div id='carre'> <img id='bat_p1' title='Vengeful Spirit' src='img/w/3.png'> </div>";
                        else if ($grid[$i][$j] === 12)
                        echo "<div id='carre'> <img id='bat_p1_middle' title='Blood Angels' src='img/w/4.png'> </div>";
                        else if ($grid[$i][$j] === 18)
                        echo "<div id='carre'> <img id='bat_p2_middle' title='Rabbi Jacob' style='-webkit-transform:rotate(180deg)' src='img/w/1.png'> </div>";
                        else if ($grid[$i][$j] === 20)
                        echo "<div id='carre'> <img id='bat_p2' title='Shabbat Shalom' style='-webkit-transform:rotate(180deg)' src='img/w/2.png'> </div>";
                        else if ($grid[$i][$j] === 21)
                        echo "<div id='carre'> <img id='bat_p2' title='Jew Counter-Attacks' style='-webkit-transform:rotate(180deg)' src='img/w/3.png'> </div>";
                        else if ($grid[$i][$j] === 17)
                        echo "<div id='carre'> <img id='bat_p2_big' title='Drone Tsahal' style='-webkit-transform:rotate(180deg)' src='img/w/11.png'> </div>";
                        else if ($grid[$i][$j] === 22)
                        echo "<div id='carre'> <img id='bat_p2' title='David's Death Star' style='-webkit-transform:rotate(180deg)' src='img/w/5.png'> </div>";
                        else if ($grid[$i][$j] === 23)
                        echo "<div id='carre'> <img id='bat_p2' title='Casher Enterprise' style='-webkit-transform:rotate(180deg)' src='img/w/3.png'> </div>";
                        else if ($grid[$i][$j] === 19)
                        echo "<div id='carre'> <img id='bat_p2_middle' title='Israel Battleship' style='-webkit-transform:rotate(180deg)' src='img/w/4.png'> </div>";
                        else if ($grid[$i][$j] === 24)
                        echo "<div id='carre'> <img id='obstacle_big' title='Asteroid' src='img/w/asteroid-1.gif'> </div>";
                        else if ($grid[$i][$j] === 25)
                        echo "<div id='carre'> <img id='obstacle' title='Asteroid' src='img/w/asteroid-2.gif'> </div>";
                        else if ($grid[$i][$j] === 26)
                        echo "<div id='carre'> <img id='obstacle' title='Asteroid' src='img/w/asteroid-3.gif'> </div>";
                        else if ($grid[$i][$j] === 27)
                        echo "<div id='carre'> <img id='obstacle' title='Asteroid' src='img/w/asteroid-4.gif'> </div>";
                        else if ($grid[$i][$j] === 28)
                        echo "<div id='carre'> <img id='obstacle' title='Asteroid' src='img/w/asteroid-4.gif'> </div>";
                        else if ($grid[$i][$j] === 29)
                        echo "<div id='carre'> <img id='obstacle_big' title='Asteroid' src='img/w/asteroidAn.gif'> </div>";
                        else if ($i == $pos[1] && $j == $pos[0])
                            echo "<img id='laser' src='img/w/laser_green.png'>";
                        else
                        echo "<div id='carre'></div>";
                        $j++;
                    }
                    echo "<br>";
                    $i++;
                }
            ?>
        </div>
        <div id="panel">
            <div id="panel_content">
                <span id="title">
                    <?php if ($_SESSION['move']) echo $_SESSION['player2_name']; else echo $_SESSION['player1_name']; echo "'s turn !" ?>
                </span>
                <?php
                   if ($_SESSION['select'] == 1)
                    {
                        echo '<div id="panel_form">';
                        end_turn();
                        echo "<form action='playground.php' method='POST' name='form'>";
                        foreach ($_SESSION['print_ship'] as $value)
                        {
                            echo ("<div id='ship_name'>");
                            echo ("<input type='radio' required name='ship_to_play' value='".$value."'>".$value);
                            echo ("</div>");
                        }
                        echo "</div>";
                        echo '<input type="submit" value="next" class="button"> </form>';
                    }
                   else if ($_SESSION['order'] == 1)
                    {
                       end_turn(); ?>
                       <div id="panel_form">
                       <form action='playground.php' method='POST' name="form">
                            <input type="text" id="PP" disabled value= <?php if (isset ($_SESSION['ship_power'])) echo $_SESSION['ship_power']; ?> >
                            <input type="button" name="bouton" value="-" onclick="desincremente(1);">
                            <input type="text" name="bonus_speed" id="incrementation1" value="0">
                            <input type="button" name="bouton" value="+" onclick="incremente(1);">
                            Speed <br>
                            <input type="button" name="bouton" value="-" onclick="desincremente(2);">
                            <input type="text" name="bonus_shield" id="incrementation2" value="0">
                            <input type="button" name="bouton" value="+" onclick="incremente(2);">
                            Shield <br>
                            <input type="button" name="bouton" value="-" onclick="desincremente(3);">
                            <input type="text" name="bonus_weapon" id="incrementation3" value="0">
                            <input type="button" name="bouton" value="+" onclick="incremente(3);">
                            Weapon <br>
                        </div>
                            <input type="submit" value="next" class="button">
                        </form>
                    <?php
                    }
                    else if ($_SESSION['mvt'] == 1)
                    {
                        end_turn(); ?>
                        <div id="panel_form">
                        <form action='playground.php' method='POST' name="form">
                            <input type="radio" name="ship_orientation" value="up">Up<br>
                            <input type="radio" name="ship_orientation" value="down">Down<br>
                            <input type="radio" name="ship_orientation" value="right">Right<br>
                            <input type="radio" name="ship_orientation" value="left">Left<br>
                            <input type="button" name="bouton" value="-" onclick="desincremente(1);">
                            <input type="text" name="deplacement" id="incrementation1" value="0">
                            <input type="button" name="bouton" value="+" onclick="incremente(1);">
                        </div>
                            <input type="submit" value="next" class="button">
                        </form>
                    <?php
                    }
                    else
                    {
                        echo '<div id="panel_form">';
<<<<<<< HEAD
                            echo "Unleash Your RAGE !!!";
                        echo "</div>";
                        echo '<input type="submit" value="fire" class="button">';
=======
                        echo "Unleash Your RAGE !!!";
                        echo "</div>";
                        echo ' <form action="playground.php" method="POST" name="form">';
                        echo '<input type="text" name="fire" hidden>';
                        echo '<input type="submit" value="fire" class="button">';
                        echo '</form>';
                        echo 'icsandlas;ndasdbaf';

>>>>>>> 6ea9df2f1aa02e6d65cb125226c3a8084c631109
                        end_turn();
                        end_turn();
                    }
                ?>
            </div>
            <div id="chat">
    			<script type="text/javascript">
    			   function SendForm()
    			   {
    				   var jqxhr = $.ajax({
    					   type: "POST",
    						   url: "chat-set.php",
    						   data: {login: $("#chat_login").val(), text: $("#chat_text").val()}
    				   });
    				   $("#chat_text").val("");
    			   }
    			   var autoLoad = setInterval(
    				   function ()
    				   {
    					   $('#chat_content').load('chat-get.php');
    				   }, 100);
                </script>
                <div id="chat_content"><?php include('chat-get.php'); ?></div>
                <form id="chat_post" method="post" onsubmit="SendForm(); return false;">
    				<input type="hidden" id="chat_login" name="login" value= <?php echo $_SESSION['player1_name']; ?> >
    				<label for="message">Message</label> :
                    <input type="text" id="chat_text" name="text" maxlength="255" >
    				<input type="submit" id="submit" name="submit" value="Send" />
				</form>
            </div>
        </div>
    </div>
</body>
</html>
