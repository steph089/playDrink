<?php

class Deck
{
	const numOfCards = 13;
	//can't have const array
	private $suits = array('h','d','s','c');

	private $_cards = array();

	public function __construct() {
		$argv = func_get_args();
		switch(func_num_args())
		{
			default:
			case 0:
				$this->__constructNewDeck();
			break;
			case 1:
				$this->__loadDeck($argv[0]);
			break;
		}
	}

	private function __constructNewDeck() {
		for($i=1;$i<=self::numOfCards;$i++)
		{
			for($ii=0;$ii<count($this->suits);$ii++)
			{
				array_push($this->_cards, new Card($i . $this->suits[$ii]));
			}
		}
		$this->shuffle();
	}

	private function __loadDeck($game_id) {
		$db = new db_game();
		$cardArray = $db->getDeckArray($game_id);
		foreach($cardArray as $cardString) {
			array_push($this->_cards, new Card($cardString));
		}
	}

	public function __toString()
	{
		return implode(',',$this->_cards);
	}

	public function listCards()
	{
		$nameArray = array();
		foreach($this->_cards as $card)
			array_push($nameArray, $card->getFullName());
		return implode('<BR>',$nameArray);
	}

	public function shuffle()
	{
		shuffle($this->_cards);
	}
}
?>