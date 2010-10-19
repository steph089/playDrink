<?php
//require_once 'db_turn.php';

class Turn
{
	private $_id;
	private $_player_id;
	private $_dealer_id;
	private $_gets;

	private $_first_guess_num;
	private $_first_guess_result;
	private $_second_guess_num;

	private $_drinker_id;
	private $_drinks;
	private $_card;

	private $_db;

	//**************** CONSTRUCT *********************************

	public function __construct()
	{

		$this->_db = new db_turn();

		$argv = func_get_args();
		switch(func_num_args())
		{
			case 4:
				$this->_start_new_turn($argv[0], $argv[1], $argv[2], $argv[3]);
			break;
			case 1:
				$this->_load_turn($argv[0]);
			break;
		}
	}

	private function _start_new_turn($game_id, $player_id, $dealer_id, $gets)
	{
		$this->_gets = $gets;
		$this->_game_id = $game_id;
		$this->_player_id = $player_id;
		$this->_dealer_id = $dealer_id;

		$this->_first_guess_num		= NULL;
		$this->_first_guess_result 	= NULL;
		$this->_second_guess_num	= NULL;
		$this->_drinker_id			= NULL;
		$this->_drinks				= NULL;
		$this->_card				= NULL;


		$this->_id = $this->_db->insert_turn($game_id, $player_id, $dealer_id, $gets);
	}

	private function _load_turn($turn_id)
	{
		
	}

	//*********** DESTRUCTORS *********************************

	public function __destruct()
	{
		$this->_db->save_turn($this);
	}

	//************** ACCESSORS *********************************

	public function get_id()
	{
		return $this->_id;
	}

	public function get_first_guess_num()
	{
		return $this->_first_guess_num;
	}

	public function get_first_guess_result()
	{
		return $this->_first_guess_result;
	}

	public function get_second_guess_num()
	{
		return $this->_second_guess_num;
	}

	public function get_drinker_id()
	{
		return $this->_drinker_id;
	}

	public function get_drinks()
	{
		return $this->_drinks;
	}

	public function get_card()
	{
		return $this->_card;
	}
	//**************** MUTATORS *********************************

	public function set_first_guess_num($guess_num)
	{
		$this->_first_guess_num = $guess_num;
	}

	public function set_second_guess_num($guess_num)
	{
		$this->_second_guess_num = $guess_num;
	}
}
?>