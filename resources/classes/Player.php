<?php
require_once 'db_player.php';

class Player
{
	private $_name;
	private $_player_id;	

// ******************* CONSTRUCT ***************************************
	public function __construct()
	{
		$argv = func_get_args();
		switch(func_num_args())
		{
			case 2:
				$this->_add_new_player($argv[0], $argv[1]);
			break;
			case 1:
				$this->_load_player($argv[0]);
			break;
		}
	}

	private function _add_new_player($game_id, $name)
	{
		$db = new db_player();
		$this->_player_id = $db->insert_player($game_id, $name);
		$this->_name = $name;		
	}

	private function _load_player($player_id)
	{
		$this->_player_id = $player_id;

		//load player data
		$db = new db_player();
		$player_array = $db->load_player($player_id);

		$this->_name = $player_array['name'];
	}

// ******************** OVERLOAD ***************************************

	public function __toString()
	{
		return $this->_name;
	}

// ****************** ACCESS ********************************************

	public function name()
	{
		return $this->_name;
	}
	
	public function get_li()
	{
		return "<li class='player'>" . $this->_name . "</li>";
	}
}
?>