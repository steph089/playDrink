<?php

class Card {
	private $_rank;
	private $_suit;

	public function __construct($init_string) {
		if(strlen($init_string) <= 3) {
			$pre_rank = substr($init_string,0,-1);
			switch($pre_rank) {
				case 1:
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:
				case 10:
				case 11:
				case 12:
				case 13:
					$this->_rank = $pre_rank;
					break;
				case 'A':
				case 'a':
					$this->_rank = '1';
					break;
				case 'J':
				case 'j':
					$this->_rank = '11';
					break;
				case 'Q':
				case 'q':
					$this->_rank = '12';
					break;
				case 'K':
				case 'k':
					$this->_rank = '13';
					break;
				default:
					throw new Exception("Card Rank Invalid.");
					break;
			}

			$pre_suit = substr($init_string,-1);
			switch($pre_suit) {
				case 'h':
				case 'H':
					$this->_suit = 'Heart';
					break;
				case 'd':
				case 'D':
					$this->_suit = 'Diamond';
					break;
				case 's':
				case 'S':
					$this->_suit = 'Spade';
					break;
				case 'c':
				case 'D':
					$this->_suit = 'Club';
					break;
				default:
					throw new Exception("Card Suit Invalid.");
			}
		}
	}

	private function pluralize_suit() {
		return $this->_suit . 's';
	}

	private function pluralize_rank() {
		$plural = $this->get_rank_name();
		if($this->_rank == 6)
			$plural .= 'e';
		return $plural . 's';
	}

	public function get_full_name() {
		return $this->get_rank_name() . ' of ' . $this->pluralize_suit();
	}

	public function get_rank_name() {
		switch($this->_rank) {
			case 1:
				return "Ace";
				break;
			case 2:
				return "Deuce";
				break;
			case 3:
				return "Three";
				break;
			case 4:
				return "Four";
				break;
			case 5:
				return "Five";
				break;
			case 6:
				return "Six";
				break;
			case 7:
				return "Seven";
				break;
			case 8:
				return "Eight";
				break;
			case 9:
				return "Nine";
				break;
			case 10:
				return "Ten";
				break;
			case 11:
				return "Jack";
				break;
			case 12:
				return "Queen";
				break;
			case 13:
				return "King";
				break;
		}
	}

	public function get_rank_int()
	{
		return $this->_rank;
	}

	public function get_card_string()
	{
		return "$this";
	}

	public function __toString() {
		return $this->_rank . strtolower(substr($this->_suit,0,1));
	}
}

?>