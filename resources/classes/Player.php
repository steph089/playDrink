<?php
require_once 'db_player.php';

class Player
{
	private $_name;
	private $_player_id;
	private $_order_int;

// ******************* CONSTRUCT ***************************************
	public function __construct()
	{
		$argv = func_get_args();
		switch(func_num_args())
		{
			case 3:
				$this->_add_new_player($argv[0], $argv[1], $argv[2]);
			break;
			case 1:
				$this->_load_player($argv[0]);
			break;
		}
	}

	private function _add_new_player($game_id, $name, $order_int)
	{		
		$this->_name = $name;		
		$db = new db_player();
		$this->_player_id = $db->insert_player($game_id, $name, $order_int);		
	}

	private function _load_player($player_id)
	{
		$this->_player_id = $player_id;

		//load player data
		$db = new db_player();
		$player_array = $db->load_player($player_id);

		$this->_name = $player_array['name'];		
		$this->_order_int = $player_array['order_int'];		
	}

// ******************** OVERLOAD ***************************************

	public function __toString()
	{
		return $this->_name;
	}

// ******************* MANIP ********************************************
	

// ****************** ACCESS ********************************************

	public function get_name()
	{
		return $this->_name;
	}
	
	public function get_id()
	{
		return $this->_player_id;
	}	

	public function get_order_int()
	{
		return $this->_order_int;
	}	

	public function get_li($mod)
	{
		$li = "<li class='player' player_id='" . $this->_player_id . "'>" . $this->_name . "</li>";
		return $li;
	}
}
?>