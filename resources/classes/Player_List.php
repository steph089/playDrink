<?php
require_once 'db_player_list.php';

class Player_List
{
	private $_players;

	public function __construct($game_id)
	{
		$db = new db_player_list();
		$player_array = $db->get_players($game_id);
		self::build_player_array($player_array);
	}

	private function build_player_array($player_array)
	{
		$this->_players = array();
		for($i=0; $i < count($player_array); $i++)
		{
			array_push($this->_players, new Player($player_array[$i]));
		}
	}

// **************** MANIP ********************************************
	public function add_player($game_id, $name)
	{
		$this->_players[] = new Player($game_id, $name, $this->num_players());
		switch($this->num_players())
		{
			case 1:
				$this->_players[$this->num_players()-1]->make_dealer($game_id);
				break;
			case 2:
				$this->_players[$this->num_players()-1]->make_cur_player($game_id);
				break;
		}
	}

	public function reorder($new_order)
	{
		if(count($new_order) == $this->num_players())
		{
			self::build_player_array($new_order);
			$db = new db_player_list();
			$db->save_order($this);
		}
		else
		{
			return "New Player Order Length does not match Current PLayer Order Length";
		}
	}

// *************** ACCESS ********************************************

	public function num_players()
	{
		return count($this->_players);
	}

	public function get_id($index)
	{
		return $this->_players[$index]->id();
	}

// **************** DISPLAY ******************************************

	public function get_player_list_elements()
	{
		$output = '';
		for($i=0; $i<$this->num_players(); $i++)
		{
			$output .= $this->_players[$i]->get_li();
		}
		return $output;
	}

	public function get_li($index)
	{
		if($index <= $this->num_players()-1)
		{
			return $this->_players[$index]->get_li();
		}
		else
		{
			return "Get Player List Item Index Error";
		}
	}

}
?>