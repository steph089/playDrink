<?php
require_once 'db_game.php';

class Game
{
	private $_game_id;
	private $_deck;

	public function __construct() {
		$argv = func_get_args();
		switch(func_num_args())
		{
			default:
			case 0:
				$this->_startNewGame();
			break;
			case 1:
				$this->_loadGame($argv[0]);
			break;
		}
	}

	private function _startNewGame() {
		$this->_deck = new Deck;
		$db = new db_game;
		$this->_game_id = $db->newGame((string)$this->_deck);
		echo $this->_game_id;
	}

	private function _loadGame($game_id)
	{
		echo "needs work";
	}
}
?>