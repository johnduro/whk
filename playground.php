<?php
    session_start();
    ob_start();
    include('connection.php');
    $req = 'SELECT turn FROM party WHERE `id`='.$_SESSION['id_party'];
    foreach ($bdd->query($req) as $test)
        $turn = $test['turn'];
    require_once("play.php");
    if (intval($turn) === intval($_SESSION['player_id']))
        turn();
    require_once("functionjs.php");

    function    first($player, $ship)
    {
        $pos = $player->ships[$ship]->getPos();
        $dim = $player->ships[$ship]->getDim();
        $or = $player->ships[$ship]->getOrientation();
        if ($or == "0deg")
        {
            $pos[0] += $dim[0] - 2;
            $pos[1] -= round($dim[1] / 2, 0, PHP_ROUND_HALF_DOWN);
            if ($dim[1] == 3)
             $pos[3] = 1;
            else if ($dim[1] == 4)
                $pos[3] = 2;
            else
                $pos[3] = 3;
        }
        else if ($or == "180deg")
        {
            $pos[0] -= $dim[0] + 2;
            $pos[1] += round($dim[1] / 2, 0, PHP_ROUND_HALF_UP);
            if ($dim[1] == 3)
             $pos[3] = 1;
            else if ($dim[1] == 4)
                $pos[3] = 2;
            else
                $pos[3] = 3;
        }
        else if ($or == "-90deg")
        {
            $pos[0] += round($dim[0] / 2, 0, PHP_ROUND_HALF_DOWN);
            $pos[1] -= $dim[1] + 2;
            if ($dim[1] == 3)
             $pos[3] = 1;
            else if ($dim[1] == 4)
                $pos[3] = 2;
            else
                $pos[3] = 3;
        }
        else
        {
            $pos[0] -= round($dim[0] / 2);
            $pos[1] += $dim[1] - 2;
            if ($dim[1] == 3)
             $pos[3] = 1;
            else if ($dim[1] == 4)
                $pos[3] = 2;
            else
                $pos[3] = 3;
        }
        return ($pos);
    }

    function    second($player, $ship)
    {
        $pos = $player->ships[$ship]->getPos();
        $dim = $player->ships[$ship]->getDim();
        $or = $player->ships[$ship]->getOrientation();
        if ($or == "0deg")
        {
            $pos[0] += 1;
            $pos[1] += round(($dim[1]) / 2, 0, PHP_ROUND_HALF_DOWN);
            if ($dim[1] == 3)
             $pos[3] = 1;
            else if ($dim[1] == 4)
                $pos[3] = 2;
            else
                $pos[3] = 3;
        }
        else if ($or == "180deg")
        {
            $pos[0] -= 33;
            $pos[1] -= round(($dim[1]) / 2, 0, PHP_ROUND_HALF_DOWN);
            if ($dim[1] == 3)
             $pos[3] = 1;
            else if ($dim[1] == 4)
                $pos[3] = 2;
            else
                $pos[3] = 3;
        }
        else if ($or == "-90deg")
        {
            $pos[0] -= round($dim[0] / 2, 0, PHP_ROUND_HALF_DOWN);
            $pos[1] -= 33;
            if ($dim[1] == 3)
             $pos[3] = 1;
            else if ($dim[1] == 4)
                $pos[3] = 2;
            else
                $pos[3] = 3;
        }
        else
        {
            $pos[0] += round($dim[0] / 2, 0, PHP_ROUND_HALF_DOWN);
            $pos[1] += 1;
            if ($dim[1] == 3)
             $pos[3] = 1;
            else if ($dim[1] == 4)
                $pos[3] = 2;
            else
                $pos[3] = 3;
        }
        return ($pos);
    }

    function    take_pos()
    {
        include('connection.php');

        $req = "SELECT player_".$turn."_obj, current_ship FROM party WHERE `id`=".$_SESSION['id_party']."";
        $pl = array();
        foreach ($bdd->query($req) as $test)
        {
            if ($test['player_'.$turn.'_obj'] !== "")
                $ser_pl = unserialize($test['player_'.$turn.'_obj']);
            if ($test['current_ship'] !== "")
                $ship = $test['current_ship'];
        }
        if (intval($turn) == 1 || intval($turn) == 3)
            return (first($player, $ship));
        else
            return (second($player, $ship));
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
                $grid = get_board();
                if (isset($_POST['fire']))
                    $pos = take_pos();
                else
                    $pos = array(-1 , -1);
                while($i < 100)
                {
                    $j = 0;
                    while ($j < 150)
                    {
                        if (isset($grid[$i][$j][1]))
                            $rot = $grid[$i][$j][1];
                        else
                            $rot = "0deg";
                        if ($grid[$i][$j][0] === 11)
                        echo "<div id='carre'> <img id='bat_p1_middle' title='Star of the Galaxy' style='-webkit-transform:rotate(".$rot.")' src='img/w/1.png'> </div>";
                        else if ($grid[$i][$j][0] === 13)
                        echo "<div id='carre'> <img id='bat_p1' title='Ultramarines' style='-webkit-transform:rotate(".$rot.")' src='img/w/2.png'> </div>";
                        else if ($grid[$i][$j][0] === 14)
                        echo "<div id='carre'> <img id='bat_p1' title='Dreadclaw' style='-webkit-transform:rotate(".$rot.")' src='img/w/3.png'> </div>";
                        else if ($grid[$i][$j][0] === 10)
                        echo "<div id='carre'> <img id='bat_p1_big' title='Wrath of the Empire' style='-webkit-transform:rotate(".$rot.")' src='img/w/11.png'> </div>";
                        else if ($grid[$i][$j][0] === 15)
                        echo "<div id='carre'> <img id='bat_p1' title='Storm Bird' style='-webkit-transform:rotate(".$rot.")' src='img/w/5.png'> </div>";
                        else if ($grid[$i][$j][0] === 16)
                        echo "<div id='carre'> <img id='bat_p1' title='Vengeful Spirit' style='-webkit-transform:rotate(".$rot.")' src='img/w/3.png'> </div>";
                        else if ($grid[$i][$j][0] === 12)
                        echo "<div id='carre'> <img id='bat_p1_middle' title='Blood Angels' style='-webkit-transform:rotate(".$rot.")' src='img/w/4.png'> </div>";
                        else if ($grid[$i][$j][0] === 18)
                        echo "<div id='carre'> <img id='bat_p2_middle' title='Rabbi Jacob' style='-webkit-transform:rotate(".$rot.")' src='img/w/1.png'> </div>";
                        else if ($grid[$i][$j][0] === 20)
                        echo "<div id='carre'> <img id='bat_p2' title='Shabbat Shalom' style='-webkit-transform:rotate(".$rot.")' src='img/w/2.png'> </div>";
                        else if ($grid[$i][$j][0] === 21)
                        echo "<div id='carre'> <img id='bat_p2' title='Jew Counter-Attacks' style='-webkit-transform:rotate(".$rot.")' src='img/w/3.png'> </div>";
                        else if ($grid[$i][$j][0] === 17)
                        echo "<div id='carre'> <img id='bat_p2_big' title='Drone Tsahal' style='-webkit-transform:rotate(".$rot.")' src='img/w/11.png'> </div>";
                        else if ($grid[$i][$j][0] === 22)
                        echo "<div id='carre'> <img id='bat_p2' title='David's Death Star' style='-webkit-transform:rotate(".$rot.")' src='img/w/5.png'> </div>";
                        else if ($grid[$i][$j][0] === 23)
                        echo "<div id='carre'> <img id='bat_p2' title='Casher Enterprise' style='-webkit-transform:rotate(".$rot.")' src='img/w/3.png'> </div>";
                        else if ($grid[$i][$j][0] === 19)
                        echo "<div id='carre'> <img id='bat_p2_middle' title='Israel Battleship' style='-webkit-transform:rotate(".$rot.")' src='img/w/4.png'> </div>";
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
                        {
                            if ($pos[3] == 1)
                            {
                                echo $i."ici c'est i en pos[3]";
                                echo $j."ici c'est j en pos[3]";
                                  if ($grid[$i][$j] >= (10 * 10) && $grid[$i][$j] <= (16 * 10))
                                    echo "<img id='laser1' src='img/w/laser_red.png'>";
                                 else if ($grid[$i][$j] >= (17 * 10) && $grid[$i][$j] <= (10 * 23 ))
                                     echo "<img id='laser1' src='img/w/laser_green.png'>";
                            }
                            else if ($pos[3] == 2)
                            {
                                  echo $i."ici c'est i en pos[3]2";
                                echo $j."ici c'est j en pos[3]2";
                                if ($grid[$i][$j] >= (10 * 10) && $grid[$i][$j] <= (16 * 10))
                                    echo "<img id='laser2' src='img/w/laser_red.png'>";
                                else if ($grid[$i][$j] >= (17 * 10) && $grid[$i][$j] <= (23 * 10))
                                   echo "<img id='laser2' src='img/w/laser_green.png'>";
                            }
                            else
                            {
                                  echo $i."ici c'est i en pos[3]3";
                                echo $j."ici c'est j en pos[3]3";
                                if ($grid[$i][$j - 1] >= (10 * 10) && $grid[$i][$j - 1] <= (16 * 10))
                                    echo "<img id='laser3' src='img/w/laser_red.png'>";
                                else if ($grid[$i][$j - 1] >= (17 * 10) && $grid[$i][$j - 1] <= (23 * 10))
                                     echo "<img id='laser3' src='img/w/laser_green.png'>";
                            }
                        }
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
                    <?php if (intval($turn) === intval($_SESSION['player_id'])) echo "It's your turn".$_SESSION['player']; else echo "Wait for other players !" ?>
                </span>
                <?php
                    if (intval($_SESSION['player_id']) !== intval($turn))
                    {
                        echo $_SESSION['player_id']." et ".$turn;
                        echo "Waiting for others players !";
                        header("Refresh: 15; url=playground.php");
                    }
                    else if ($_SESSION['select'] == 1)
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
                       end_turn();ob_end_flush();?>
                       <div id="panel_form">
                       <input type="text" id="PP" disabled value= <?php if (isset ($_SESSION['ship_power'])) echo $_SESSION['ship_power']; ?> >
                       <form action='playground.php' method='POST' name="form">
                            <br>
                            <input type="button" name="bouton" value="-" onclick="desincremente(1);">
                            <input type="text" name="bonus_speed" onFocus="javascript: this.blur()" id="incrementation1" value="0">
                            <input type="button" name="bouton" value="+" onclick="incremente(1);">
                            Speed <br>
                            <input type="button" name="bouton" value="-" onclick="desincremente(2);">
                            <input type="text" name="bonus_shield" onFocus="javascript: this.blur()" id="incrementation2" value="0">
                            <input type="button" name="bouton" value="+" onclick="incremente(2);">
                            Shield <br>
                            <input type="button" name="bouton" value="-" onclick="desincremente(3);">
                            <input type="text" name="bonus_weapon" onFocus="javascript: this.blur()" id="incrementation3" value="0">
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
                            <input type="radio" name="ship_orientation" value="left" style="margin-left: calc(50% - 30px);">Left<br>
                            <input type="radio" name="ship_orientation" value="right" style="margin-left: calc(50% - 30px);">Right<br>
                            <input type="button" name="bouton" value="-" onFocus="javascript: this.blur()" onclick="desincremente(1);" style="margin-left: calc(50% - 30px);">
                            <input type="text" name="deplacement" onFocus="javascript: this.blur()" id="incrementation1" value="0">
                            <input type="button" name="bouton" value="+" onclick="incremente(1);">
                        </div>
                            <input type="submit" value="next" class="button">
                        </form>
                    <?php
                    }
                    else
                    {
                        echo '<div id="panel_form">';
                        echo "Unleash Your RAGE !!!";
                        echo "</div>";
                        echo ' <form action="playground.php" method="POST" name="form">';
                        echo '<input type="text" name="fire" hidden>';
                        echo '<input type="submit" value="fire" class="button">';
                        echo '</form>';
                        echo 'icsandlas;ndasdbaf';

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
                    <input type="hidden" id="chat_login" name="login" value= <?php echo $_SESSION['player']; ?> >
                    <label for="message">Message</label> :
                    <input type="text" id="chat_text" name="text" maxlength="255" >
                    <input type="submit" id="submit" name="submit" value="Send" />
                </form>
            </div>
        </div>
    </div>
</body>
</html>
