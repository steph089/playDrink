<?php
require_once 'db_game.php';

class Game
{
	private $_game_id;
	public $deck;
	private $_next_card;

	public function __construct() {
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
		$db = new db_game();
		$card_array = $db->get_deck_array($game_id);
		$this->deck = new Deck($card_array);

		$this->_next_card = $db->get_next_card($game_id);

		$this->_game_id = $game_id;
	}

}
?>