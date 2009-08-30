<?php
require_once 'db_game.php';

class Game
{
	private $_game_id;
	public $deck;
	private $_next_card; //index integer of next (current) card in deck order
	
	private $_num_players;
	public $players;

	
// ******************* CONSTRUCT ***************************************
	public function __construct() 
	{
		$argv = func_get_args();
		switch(func_num_args())
		{
			default:
			case 0:
				$this->_start_new_game();
			break;
			case 1:
				$this->_load_game($argv[0]);
			break;
		}
	}

	private function _start_new_game() {
		$this->_next_card = 0;
		$this->deck = new Deck;
		$db = new db_game;
		$this->_game_id = $db->new_game((string)$this->deck);
		return $this->_game_id;
	}

	private function _load_game($game_id)
	{
		$this->_game_id = $game_id;
		
		//load deck
		$db = new db_game();
		$card_array = $db->get_deck_array($game_id);
		$this->deck = new Deck($card_array);

		$this->_next_card = $db->get_next_card($game_id);
		
		//load players
		
		
	}
	
// ******************* ACCESS ******************************************
	public function get_game_id() 
	{
		return $this->_game_id;
	}
	
	public function get_next_card() 
	{
		return $this->_next_card;
	}
	
	public function get_table_cards() 
	{
		return $this->deck->sub_deck(0,$this->_next_card-1);
	}
	
	public function get_table_cards_string() 
	{
		$sub_deck = $this->get_table_cards();
		return implode(',', $sub_deck);
	}
	
//************************** OPS **************************************
	public function end_turn() {
		$this->_next_card++;
		
		$db = new db_game();
		$db->set_value('next_card',$this->_next_card, $this->_game_id);
	}
}
?>