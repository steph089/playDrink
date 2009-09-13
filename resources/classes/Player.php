<?php
require_once 'db_player.php';

class Player
{
	private $_name;
	private $_player_id;
	private $_modifer;

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
		$this->_modifier = '';
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
		$this->_modifier = $player_array['modifier'];
	}

// ******************** OVERLOAD ***************************************

	public function __toString()
	{
		return $this->_name;
	}

// ******************* MANIP ********************************************

	public function make_dealer($game_id)
	{
		$this->_modifier = 'd';
		$db = new db_player();		
		$db->add_modifier($this, $game_id);
	}
	
	public function make_cur_player($game_id)
	{
		$this->_modifier = 'p';
		$db = new db_player();		
		$db->add_modifier($this, $game_id);
	}

// ****************** ACCESS ********************************************

	public function name()
	{
		return $this->_name;
	}
	
	public function id()
	{
		return $this->_player_id;
	}
	
	public function modifier()
	{
		return $this->_modifier;
	}

	public function get_li()
	{
		$li = "<li class='player";
		switch($this->_modifier)
		{
			case 'd':
				$li .= " dealer";
				break;
			case 'p':
				$li .= " cur_player";
				break;
		}
		$li .= "' player_id='" . $this->_player_id . "'>" . $this->_name . "</li>";
		return $li;
	}
}
?>