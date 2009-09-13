<?php

function __autoload($class_name) {
	require_once "../classes/$class_name.php";
}

if(isset($_POST['name']) && isset($_POST['game_id']))
{
	$game = new Game($_POST['game_id']);
	$game->players->add_player($game->get_game_id(),$_POST['name']);
	$index = $game->players->num_players()-1;
	$json_array = array('li'=>$game->players->get_li($index));
	//$json_array = array('li'=>$game->players->get_player_list_elements());

	echo json_encode($json_array);
}
else
{
	echo "Val Error";
}

?>