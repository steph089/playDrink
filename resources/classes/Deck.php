<?php

class Deck
{
	const NUM_OF_CARDS = 13;
	//can't have const array
	private $suits = array('h','d','s','c');

	private $_cards = array();

	public function __construct() {
		$argv = func_get_args();
		switch(func_num_args())
		{
			default:
			case 0:
				$this->__construct_new_deck();
			break;
			case 1:
				$this->__load_deck($argv[0]);
			break;
		}
	}

	private function __construct_new_deck() {
		for($i=1;$i<=self::NUM_OF_CARDS;$i++)
		{
			for($ii=0;$ii<count($this->suits);$ii++)
			{
				array_push($this->_cards, new Card($i . $this->suits[$ii]));
			}
		}
		$this->shuffle();
	}

	public function __load_deck($card_array) {
		$this->_cards = array();
		foreach($card_array as $card_string)
		{
			array_push($this->_cards, new Card($card_string));
		}
	}

	public function __toString()
	{
		return implode(',',$this->_cards);
	}

	public function list_cards()
	{
		$name_array = array();
		foreach($this->_cards as $card)
			array_push($name_array, $card->get_full_name());
		return implode('<BR>',$name_array);
	}

	public function shuffle()
	{
		shuffle($this->_cards);
	}
	
	public function sub_deck($start, $end=0) {
		$card_array = array();
		if($start < 0) 
		{
			$start = $this->_cards.length() + $start - 1;
		}
		
		if($end < 1) 
		{
			$end = $this->_cards.length() + $end - 1;
		}
		
		for($i=$start;$i<$end;$i++) 
		{
			array_push($card_array, $this->_cards[$i]);
		}
		return $card_array;
	}
	
	public function get_card($index, $return_func='card_string')
	{
		$return_func = 'get_' . $return_func;
		
		$card = $this->_cards[$index];
		return $card->$return_func();
		
	}
}
?>