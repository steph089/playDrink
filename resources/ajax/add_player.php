<?php

function __autoload($class_name) {
	require_once "../classes/$class_name.php";
}

if(isset($_POST['name']) && isset($_POST['game_id']))
{
	$game = new Game($_POST['game_id']);
	$new_player = $game->add_player($_POST['name']);	
	$json_array = array('li'=>$game->get_player_li($new_player));
	$json_array['status'] = 'added a new player named ' . $new_player->get_name();

	echo json_encode($json_array);
}
else
{
	echo "Val Error";
}

?>