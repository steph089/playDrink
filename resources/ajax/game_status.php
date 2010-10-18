<?php

function __autoload($class_name) {
	require_once "../classes/$class_name.php";
}

if(isset($_POST['game_id']))
{
	$game = new Game($_POST['game_id']);
  $json_array = array();

	$json_array['status'] = $game->status();

  echo json_encode($json_array);
}
else
{
	echo "game id not set";
}
?>
