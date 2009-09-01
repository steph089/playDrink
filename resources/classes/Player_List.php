<?php
require_once 'db_player_list.php';

class Player_List
{
	private $_players;
	
	public function __construct($game_id)
	{
		$this->_players = array();
		$db = new db_player_list();
		$player_array = $db->get_players($game_id);
		
		for($i=0; $i < count($player_array); $i++)
		{
			array_push($this->_players, new Player($player_array[$i]));
		}
	}

// *************** ACCESS ********************************************
	
	public function num_players() {
		return count($this->_players);
	}
	
// **************** DISPLAY ******************************************
	
	public function get_player_list_elements()
	{
		$output = '';
		for($i=0; $i<count($this->_players); $i++)
		{
			$output .= "<li class='player'>" . $this->_players[$i]->name() . "</li>";
		}
		return $output;
	}
}
?>