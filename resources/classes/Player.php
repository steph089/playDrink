<?php
require_once 'db_player.php';

class Player
{
	private $_name;
	private $_player_id;
	private $_order_int;

	private $_drinks;
	private $_turns;
	private $_correct_guesses;
	private $_correct_geusses_2;

// ******************* CONSTRUCT / DESTRUCT *************************
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
		$this->_drinks = $this->_player_id;
		$this->_turns = 0;
		$this->_correct_guesses = 0;
		$this->_correct_guesses_2 = 0;

	}

	private function _load_player($player_id)
	{
		$this->_player_id = $player_id;

		//load player data
		$db = new db_player();
		$player_array = $db->load_player($player_id);

		$this->_name = $player_array['name'];
		$this->_order_int = $player_array['order_int'];

		$this->_drinks = $player_array['drinks'];
		$this->_turns = $player_array['turns'];
		$this->_correct_guesses = $player_array['correct_guesses'];
		$this->_correct_guesses_2 = $player_array['correct_guesses_2'];
	}

	public function __destruct()
	{
		$db = new db_player();
		$db->save_player($this);
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

	public function get_drinks()
	{
		return $this->_drinks;
	}
	
	public function add_drinks($drinks)
	{
		$this->_drinks += $drinks;
	}

	public function get_turns()
	{
		return $this->_turns;
	}
	
	public function inc_turns()
	{
		$this->_turns++;
	}

	public function get_correct_guesses()
	{
		return $this->_correct_guesses;
	}
	
	public function inc_correct_guesses()
	{
		$this->_correct_guesses++;
	}

	public function get_correct_guesses_2()
	{
		return $this->_correct_guesses_2;
	}
	
	public function inc_correct_guesses_2()
	{
		$this->_correct_guesses_2++;
	}

	public function get_guess_percentage()
	{
		if($this->_turns != 0)
		{
			return number_format((($this->_correct_guesses + $this->_correct_guesses_2) / $this->_turns)*100, 0) . "%";
		}
		else
		{
			return "0%";
		}
	}
}
?>