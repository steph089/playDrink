<?php
require_once 'db_player.php';

class Player
{
	private $_name;
	private $_player_id;

// ******************* CONSTRUCT ***************************************
	public function __construct($player_id)
	{
		$this->_player_id = $player_id;

		//load player data
		$db = new db_player();
		$player_array = $db->load_player($player_id);

		$this->_name = $player_array['name'];
	}

// ****************** ACCESS ********************************************

	public function name()
	{
		return $this->_name;
	}
}
?>