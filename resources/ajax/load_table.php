<?php

function __autoload($class_name) {
	require_once "../classes/$class_name.php";
}


if(isset($_POST['game_id'])) {
	
	$game = new Game($_POST['game_id']);
	echo $game->get_table_cards_string();	
}
else echo "No Game ID";
?>