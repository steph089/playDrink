<?php

function __autoload($class_name) {
	require_once "../classes/$class_name.php";
}

if(isset($_POST['game_id']) && isset($_POST['guess']))
{
	$game = new Game($_POST['game_id']);
	echo $game->guess($_POST['guess']);
}
else
{
	echo "game id not set";
}
?>