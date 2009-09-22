<?php
require_once 'db_game.php';

class Game
{
	private $_game_id;
	private $_next_card; //index integer of next (current) card in deck order
	private $_gets;
	private $_guess_num;
	private $_player;
	private $_dealer;
	const _PERFECT_GUESS_DRINKS = 10;

	public $deck;

// ******************* CONSTRUCT / DESTRUCT ***************************************

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
		$this->_next_card 	= 0;
		$this->_gets 		= 0;
		$this->_guess_num 	= 1;

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

		//load game vars
		$game_vars = $db->get_game_vars($this);
		$this->_gets = $game_vars['gets'];
		$this->_guess_num = $game_vars['guess_num'];
		$this->_next_card = $game_vars['next_card'];

		//load player/dealer
		if($game_vars['player_id'] != '')
			$this->_player = new Player($game_vars['player_id']);
		if($game_vars['dealer_id'] != '')
			$this->_dealer = new Player($game_vars['dealer_id']);
	}

	public function __destruct()
	{
		$db = new db_game();
		$db->save_game_vars($this);
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

	public function get_gets()
	{
		return $this->_gets;
	}

	public function get_guess_num()
	{
		return $this->_guess_num;
	}

	public function get_num_players()
	{
		$players = new Player_List($this->_game_id);
		return $players->get_num_players();
	}

	public function get_player_list()
	{
		$players = new Player_List($this->_game_id);

		$list = '';
		for($i=0; $i<$players->get_num_players(); $i++)
		{
			$list .= $this->get_player_li($players->get_player($i));
		}
		return $list;
	}

	public function get_player_li($player)
	{
		$li = "<li class='player";
		$id = $player->get_id();
		if($id == $this->_dealer->get_id())
		{
			$li .= " dealer";
		}
		elseif ($id == $this->_player->get_id())
		{
			$li .= " cur_player";
		}
		$li .= "' player_id='" . $id . "'>" . $player->get_name() . "</li>";
		return $li;
	}

	public function get_dealer_id()
	{
		if(isset($this->_dealer))
		{
			return $this->_dealer->get_id();
		}
		else
		{
			return false;
		}
	}

	public function get_player_id()
	{
		if(isset($this->_player))
		{
			return $this->_player->get_id();
		}
		else
		{
			return false;
		}
	}

	public function get_player_order_int()
	{
		if(isset($this->_player))
		{
			return $this->_player->get_order_int();
		}
		else
		{
			return false;
		}
	}

//************************** OPS **************************************
// ************************ PRIVATE ***********************************

	private function increment_guess_num()
	{
		$this->_guess_num++;
	}

	private function reset_guess_num()
	{
		$this->_guess_num = 1;
	}

	private function increment_gets()
	{
		$this->_gets++;
	}

	private function reset_gets()
	{
		$this->_gets = 0;
	}

	private function increment_player()
	{
		$db = new db_player_list();
		$next_players_id = $db->get_next_players_id($this);

		if(! $next_players_id)
		{
			$next_players_id = $db->get_first_not_dealer_players_id($this);
		}

		return new Player($next_players_id);
	}



// ************************* PUBLIC *************************************

	public function guess($guess)
	{
		$next_card_int = $this->deck->get_card($this->_next_card, 'rank_int');

		$json_array = array(
			'status'		=> 'failed geuss parse. fuck.',
			'end_turn'		=> false
		);


		if($guess == $next_card_int) //perfect guess
		{
			$json_array['status'] = "yes! dealer drinks " . self::_PERFECT_GUESS_DRINKS / $this->_guess_num . "!";
			$this->reset_guess_num();
			$this->reset_gets();
			$json_array['end_turn'] = true;
		}
		else
		{
			if($this->_guess_num == 1)
			{
				$json_array['status'] =  $guess > $next_card_int ? "lower" : "higher";
				$this->increment_guess_num();
			}
			else
			{
				$json_array['status'] = "no, it was the " . $this->deck->get_card($this->_next_card, 'full_name') . ". drink " . abs($guess - $next_card_int);
				$this->reset_guess_num();
				$this->increment_gets();
				$json_array['end_turn'] = true;
			}
		}

		if($json_array['end_turn'])
		{
			$json_array['card_string'] = $this->deck->get_card($this->_next_card);
			$this->_next_card++;

			$db = new db_game();
			$db->set_next_card($this);

			if($this->_gets == 3)
			{
				$this->reset_gets();
				$json_array['new_player_id'] = $this->_dealer->get_id();
				$this->_player = $this->_dealer;
				$this->_dealer = $this->increment_player();
				$json_array['new_dealer_id'] = $this->_dealer->get_id();
			}
			else
			{
				$this->_player = $this->increment_player();
				$json_array['new_player_id'] = $this->_player->get_id();
			}
		}

		$json_array['guess'] = $this->_guess_num;
		$json_array['gets'] = $this->_gets;

		return json_encode($json_array);
	}

	public function add_player($name)
	{
		$db = new db_player_list();
		if($this->get_num_players() > 0)
		{
			$order_int = $db->get_next_order_int($this);
		}
		else
		{
			$order_int = 0;
		}

		$new_player = new Player($this->_game_id, $name, $order_int);

		if(! isset($this->_dealer))
		{
			$this->_dealer = $new_player;
		}
		elseif(! isset($this->_player))
		{
			$this->_player = $new_player;
		}

		return $new_player;
	}


}

?>