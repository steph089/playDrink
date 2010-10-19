<?php

function __autoload($class_name) {
	require_once "../classes/$class_name.php";
}

if(isset($_POST['game_id']) && isset($_POST['new_order']))
{
	$player_order = explode(',',$_POST['new_order']);
	$game = new Game($_POST['game_id']);
	$game->players->reorder($player_order);
	
}
else
{
	echo "Passed Val Error";
}

?>