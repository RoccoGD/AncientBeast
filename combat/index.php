<?php
/* Ancient Beast - Free Open Source Online PvP TBS: card game meets chess, with creatures.
 * Copyright (C) 2007-2012  Valentin Anastase (a.k.a. Dread Knight)
 *
 * This file is part of Ancient Beast.
 *
 * Ancient Beast is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Ancient Beast is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * http://www.AncientBeast.com
 * https://github.com/FreezingMoon/AncientBeast
 * DreadKnight@FreezingMoon.org
 */

// Utility
if(!file_exists(dirname(__FILE__) . "/../config.php"))
	die("Warning: config.php not found, please edit config.php.in to point to a database and save it as config.php<br>Disclaimer: Since this project is web based, you can use the code and assets along with database.sql to host Ancient Beast yourself for testing and development purposes only! Also, your version should not be indexable by search engines because that can cause harm to the project!");
require_once("../config.php"); //only needed for multiplayer
?>
<html>
	<head>
		<meta charset='utf-8'>

		<title>Ancient Beast 0.2</title>
		
		<link rel="stylesheet" type="text/css" href="./css/dot-luv/jquery-ui-1.9.2.custom.min.css">
		<link rel="stylesheet" type="text/css" href="./css/style.css">
		<link rel="stylesheet" type="text/css" href="./css/grid.css">


		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="./js/phaser.min.js"></script>
		<script type="text/javascript" src="./js/jquery-ui-1.9.2.custom.min.js"></script>
		<script type="text/javascript" src="./js/jquery.transit.min.js"></script>
		<script type="text/javascript" src="./js/jquery.kinetic.js"></script>
		<script type="text/javascript" src="./js/jquery.mousewheel.js"></script>

		<script type="text/javascript" src="../media/js/audioplayer.js"></script>

		<script type="text/javascript">
			var $j = jQuery.noConflict();
		</script>
		
<?php
require_once("../units/functions.php");
require_once('../units/cards.php');
?>

		<script src="//ajax.googleapis.com/ajax/libs/prototype/1.7.1.0/prototype.js"></script>
		<script type="text/javascript" src="./js/hex.js"></script>
		<script type="text/javascript" src="./js/animations.js"></script>
		<script type="text/javascript" src="./js/abilities.js"></script>
		<script type="text/javascript" src="./js/creature.js"></script>
		<script type="text/javascript" src="./js/drops.js"></script>
		<script type="text/javascript" src="./js/pathfinding.js"></script>
		<script type="text/javascript" src="./js/game.js"></script>
		<script type="text/javascript" src="./js/ui.js"></script>
		<script type="text/javascript" src="./js/json2.js"></script>
		<script type="text/javascript" src="./js/script.js"></script>

		<!--google analytics-->	
		<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-2840181-5']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		</script>	
	</head>
	<body oncontextmenu="return false;">
		<div id="matchmaking">
			<div id="loader"><img src="../images/AB.gif">Loading</div>
			<div id="gamesetupcontainer">
				<form id="gamesetup">
					<div class="cont">
						<h2>Players</h2>
						<div id="nbrplayer" class="typeradio">
							<input type="radio" name="nbrplayer" checked="checked" value="2" id="p2"><label for="p2">1vs1</label>
							<input type="radio" name="nbrplayer" value="4" id="p4"><label for="p4">2vs2</label>
						</div>
					</div>
					<div class="cont">
						<h2>Active Units</h2>
						<span id="active_units" class="typeradio">
							<input type="radio" id="activeunitsopt1" name="active_units" value="1"><label for="activeunitsopt1">1</label>
							<input type="radio" id="activeunitsopt2" name="active_units" value="2"><label for="activeunitsopt2">2</label>
							<input type="radio" id="activeunitsopt3" name="active_units" value="3"><label for="activeunitsopt3">3</label>
							<input type="radio" id="activeunitsopt4" name="active_units" value="4" checked="checked"><label for="activeunitsopt4">4</label>
							<input type="radio" id="activeunitsopt5" name="active_units" value="5"><label for="activeunitsopt5">5</label>
							<input type="radio" id="activeunitsopt6" name="active_units" value="6"><label for="activeunitsopt6">6</label>
							<input type="radio" id="activeunitsopt7" name="active_units" value="7"><label for="activeunitsopt7">7</label>
						</span>
					</div>
					<br>
					<div class="cont">
						<h2>Plasma Points</h2>
						<div id="plasma" class="typeradio">
							<input type="radio" id="plasmaopt1" name="plasma" value="5" ><label for="plasmaopt1">5</label>
							<input type="radio" id="plasmaopt2" name="plasma" value="10"><label for="plasmaopt2">10</label>
							<input type="radio" id="plasmaopt3" name="plasma" value="20"><label for="plasmaopt3">20</label>
							<input type="radio" id="plasmaopt4" name="plasma" value="30"><label for="plasmaopt4">30</label>
							<input type="radio" id="plasmaopt5" name="plasma" value="40" checked="checked"><label for="plasmaopt5">40</label>
							<input type="radio" id="plasmaopt6" name="plasma" value="50"><label for="plasmaopt6">50</label>
							<input type="radio" id="plasmaopt7" name="plasma" value="60"><label for="plasmaopt7">60</label>
							<input type="radio" id="plasmaopt8" name="plasma" value="70"><label for="plasmaopt8">70</label>
							<input type="radio" id="plasmaopt9" name="plasma" value="80"><label for="plasmaopt9">80</label>
							<input type="radio" id="plasmaopt10" name="plasma" value="90"><label for="plasmaopt10">90</label></div>
					</div>
					<br>
					<div class="cont">
						<h2>Turn Time</h2>
						<div id="time_turn" class="typeradio">
							<input type="radio" id="timeopt1" name="time_turn" value="20"><label for="timeopt1">20 sec</label>
							<input type="radio" id="timeopt2" name="time_turn" value="40"><label for="timeopt2">40 sec</label>
							<input type="radio" id="timeopt3" name="time_turn" value="60"><label for="timeopt3">60 sec</label>
							<input type="radio" id="timeopt4" name="time_turn" value="80"><label for="timeopt4">80 sec</label>
							<input type="radio" id="timeopt5" name="time_turn" value="99"><label for="timeopt5">99 sec</label>
							<input type="radio" id="timeopt6" name="time_turn" value="-1"  checked="checked"><label for="timeopt6">&#8734;</label>
						</div>
					</div>
					<br>
					<div class="cont">
						<h2>Time Pools</h2>
						<div id="time_pool" class="typeradio">
							<!-- <input type="radio" id="timepoolopt0" name="time_pool" value="1" ><label for="timepoolopt0">1 min</label> -->
							<input type="radio" id="timepoolopt1" name="time_pool" value="5" ><label for="timepoolopt1">5 min</label>
							<input type="radio" id="timepoolopt2" name="time_pool" value="10"><label for="timepoolopt2">10 min</label>
							<input type="radio" id="timepoolopt3" name="time_pool" value="15"><label for="timepoolopt3">15 min</label>
							<input type="radio" id="timepoolopt4" name="time_pool" value="20"><label for="timepoolopt4">20 min</label>
							<input type="radio" id="timepoolopt5" name="time_pool" value="25"><label for="timepoolopt5">25 min</label>
							<input type="radio" id="timepoolopt6" name="time_pool" value="30"><label for="timepoolopt6">30 min</label>
							<input type="radio" id="timepoolopt7" name="time_pool" value="-1" checked="checked"><label for="timepoolopt7">&#8734;</label>

						</div>
					</div>
					<br>
					<div class="cont">
						<h2>Location</h2>
						<span id="location" class="typeradio">
							<input type="radio" id="bgopt1" name="location" checked="checked" value="random"><label for="bgopt1">Random Place</label>
							<input type="radio" id="bgopt2" name="location" value="Dark Forest"><label for="bgopt2">Dark Forest</label>
							<input type="radio" id="bgopt3" name="location" value="Frozen Skull"><label for="bgopt3">Frozen Skull</label>
							<input type="radio" id="bgopt4" name="location" value="Shadow Cave"><label for="bgopt4">Shadow Cave</label>
						</span><br/>
						<!-- <div style="background:url('../locations/Shadow Cave/prev.jpg'); width : 400px; height : 225px; display: inline-block;"></div> -->
					</div>
					<br>
					<div style="font-size: 1.5em !important;">
						<span class="blink" >PRESS </span>
						<input class="ui-state-error" id="startbutton" style="border:rgba(180,0,0,.5) 2px solid;" type="submit" value="START">
						<span class="blink"> BUTTON</span>
					</div>
				</form>
			</div>
		</div>
		<div id="ui" style="display:none;">
			<div id="endscreen" style="display:none;">
				<div id="scoreboard">
					<h1>Match Over</h1>
					<table id="score">
						<tbody>
							<tr class="player_name">
								<td>Players</td>
								<td>Player 1</td>
								<td>Player 2</td>
								<td>Player 3</td>
								<td>Player 4</td>
							</tr>
							<tr class="firstKill">
								<td>First blood</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
							</tr>
							<tr class="kill">
								<td>Kills</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
							</tr>
							<tr class="combo">
								<td>Combos</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
							</tr>
							<tr class="humiliation">
								<td>Humiliation</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
							</tr>
							<tr class="annihilation">
								<td>Annihilation</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
							</tr>
							<tr class="deny">
								<td>Denies</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
							</tr>
							<tr class="timebonus">
								<td>Time Bonus</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
							</tr>
							<tr class="nofleeing">
								<td>No Fleeing</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
							</tr>
							<tr class="creaturebonus">
								<td>Survivor Creatures</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
							</tr>
							<tr class="darkpriestbonus">
								<td>Survivor DarkPriest</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
							</tr>
							<tr class="immortal">
								<td>Immortal</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
							</tr>
							<tr class="total">
								<td>Total</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
								<td>--</td>
							</tr>
						</tbody>
					</table>
					<p></p>
				</div>
			</div>
			<div id="dash" class="selected0">
				<div id="return" class="toggledash button"></div>
				<div id="playertabswrapper">
					<?php for ($i=0; $i < 4; $i++){
						echo '<div class="playertabs p'.$i.'"  player="'.$i.'">
								<div id="playeravatar" class="vignette active p'.$i.'"><div class="frame"></div></div>
								<div class="infos">
									<h3 class="name"></h3>
									<p class="score">0 Score</p>
									<p class="plasma">0 Plasma</p>
									<p class="units">Units</p>
									<p>Time <span class="activePlayer turntime">&#8734;</span> / <span class="timepool">&#8734;</span></p>
								</div>
							</div>';
						}
					php?>
				</div>
				<div id="tabwrapper">
					<div id="cardwrapper">
						<div id="cardwrapper_inner">
							<div id="card"><?php cards("",0,0,true); ?></div>
							<div id="materialize_button" >
								<p></p>
							</div>
						</div>
					</div>
					<div id="creaturegridwrapper"><?php
						require_once('../units/grid.php');
						creatureGrid(false);
					?></div>
				</div>
				<div id="musicplayerwrapper">
					<?php 
						$media = scandir("../media/music");
						natsort($media);
						$i = 0;
						$error = 'Your browser does not support the audio element.';

						echo '<audio id="audio" preload="auto" tabindex="0" controls="" style="width:890px";"><source src="'.$site_root.'media/music/'.$media[0].'">'.$error.'</audio><a style="cursor: pointer;" id="mp_shuffle">Shuffle</a>';
						echo '<ul id="playlist" style="list-style-type: none;padding-left:0px;" >';

						foreach($media as $file) {
							if($file == "." || $file == "..") continue;
							if($i == 0){
							}
							$title = substr($file, 0, -4);
							$file = str_replace(' ', '%20', $file);
							if($title!=""){
								echo '<li class="active"><a href="'.$site_root.'media/music/'.$file.'">' . $title . '</a></li>';
							}
							$i++;
						}
						echo '</ul>';
					?>
					<div id="volume_sliders">
						Effects volume <div id="effects_volume"></div>
					</div>
				</div>
			</div>
			<div id="toppanel">
				<div id="queue">
					<div id="queuewrapper"></div>
				</div>
				<div id="playerbutton" class="toggledash vignette active frame">
					<div class="frame"></div>
					<div id="playerinfos">
					<p class="name"></p>
					<p class="points"><span></span> Points</p>
					<p class="plasma"><span></span> Plasma</p>
					<p class="units"><span></span> Units</p>
					<p ><span class="activePlayer turntime">&#8734;</span> / <span class="timepool">&#8734;</span></p>
				</div>
				</div>

				<div id="rightpanel">
					<div style="position:relative"><div id="audio" class="button"></div><div class="desc"><div class="arrow"></div><div class="shortcut">hotkey A</div><span>Music Player</span><p>Listen to some really fine epic tracks.</p></div></div>
					<div style="position:relative"><div id="skip" class="button"></div><div class="desc"><div class="arrow"></div><div class="shortcut">hotkey S</div><span>Skip Turn</span><p>End the turn of the current creature and proceed with the next in queue.</p></div></div>
					<div style="position:relative"><div id="delay" class="button"></div><div class="desc"><div class="arrow"></div><div class="shortcut">hotkey D</div><span>Delay Creature</span><p>Delayed creatures will act at the end of the round, if alive and still able to.</p></div></div>
					<div style="position:relative"><div id="flee" class="button"></div><div class="desc"><div class="arrow"></div><div class="shortcut">hotkey F</div><span>Flee Match</span><p>Give up but only after first 12 rounds.</p></div></div>
					<div class="progressbar"><div class="bar poolbar"></div><div class="bar timebar"></div></div>
				</div>
				<div id="leftpanel">
					<div id="activebox">
						<div id="abilities">
							<div style="position:relative">
								<div ability="0" class="ability button" style="cursor:default;"></div>
								<div ability="0" class="desc">
									<div class="arrow"></div>
									<div class="abilityinfo_content">
										<div class="shortcut">passive</div>
										<span></span>
										<p></p>
										<div class="cost"></div>
										<div class="damages"></div>
									</div>
								</div>
							</div>
							<div style="position:relative">
								<div ability="1" class="ability button"></div>
								<div ability="1" class="desc">
									<div class="arrow"></div>
									<div class="abilityinfo_content">
										<div class="shortcut">hotkey W</div>
										<span></span>
										<p></p>
										<div class="cost"></div>
										<div class="damages"></div>
									</div>
								</div>
							</div>
							<div style="position:relative">
								<div ability="2" class="ability button"></div>
								<div ability="2" class="desc">
									<div class="arrow"></div>
									<div class="abilityinfo_content">
										<div class="shortcut">hotkey E</div>
										<span></span>
										<p></p>
										<div class="cost"></div>
										<div class="damages"></div>
									</div>	
								</div>
							</div>
							<div style="position:relative">
								<div ability="3" class="ability button"></div>
								<div ability="3" class="desc">
									<div class="arrow"></div>
									<div class="abilityinfo_content">
										<div class="shortcut">hotkey R</div>
										<span></span>
										<p></p>
										<div class="cost"></div>
										<div class="damages"></div>
									</div>	
								</div>
							</div>
							<div class="progressbar"><div class="bar energybar"></div><div class="bar healthbar"></div></div>
						</div>
					</div>
				</div>
			</div>
			<div id="bottompanel">
				<div id="chat">
					<div id="chatbox">
						<div id="chatcontent">
						</div>
					</div>
					<textarea id="chatinput"></textarea>
				</div>
			</div>
		</div>
		<div id="combatwrapper">
		</div>
	</body>
</html>
