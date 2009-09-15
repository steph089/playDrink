<?php

function __autoload($class_name) {
	require_once "../classes/$class_name.php";
}

if(isset($_POST['game_id']) && isset($_POST['guess']))
{
	$game = new Game($_POST['game_id']);
	$next_card = $game->get_next_card();
	$next_card_name = $game->deck->get_card($next_card, 'full_name');
	$next_card_string = $game->deck->get_card($next_card);
	$next_card_int = $game->deck->get_card($next_card, 'rank_int');
	$guess = $_POST['guess'];
	$guess_num = $game->guess_num();
	$json_array = array(
		'status'		=> 'failed geuss parse. fuck.',
		'end_turn'		=> false
	);


	if($guess == $next_card_int) //perfect guess
	{
		$json_array['status'] = "yes! dealer drinks " . 10 / $guess_num . "!";
		$game->reset_guess_num();
		$game->reset_gets();
		$json_array['end_turn'] = true;
	}
	else
	{
		if($guess_num == 1)
		{
			$json_array['status'] =  $guess > $next_card_int ? "lower" : "higher";
			$game->increment_guess_num();
		}
		else
		{
			$json_array['status'] = "no, it was the " . $next_card_name . ". drink " . abs($guess - $next_card_int);
			$game->reset_guess_num();
			$game->increment_gets();
			$json_array['end_turn'] = true;
		}
	}
	
	$game->end_guess();
	
	if($json_array['end_turn'])
	{
		$json_array['card_string'] = $next_card_string;
		$game->end_turn();		
	}
	
	
	
	$json_array['guess'] = $game->guess_num();
	$json_array['gets'] = $game->gets();
	echo json_encode($json_array);
}
else
{
	echo "game id not set";
}
?>