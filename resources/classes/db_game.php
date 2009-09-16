<?php

class db_game extends db
{
	const _TABLE = 'games';
	const _ID_FIELD = 'game_id';

	public function new_game($deck)
	{
		$values = array('deck'=>$deck);
		return parent::insert(self::_TABLE, $values);
	}


	public function get_deck_array($game_id)
	{
		$init_string = parent::select_value(self::_TABLE, 'deck', self::_ID_FIELD, $game_id);
		$deck_array =  explode(',', $init_string);
		return $deck_array;
	}

	public function get_next_card($game_id)
	{
		return parent::select_value(self::_TABLE, 'next_card', self::_ID_FIELD, $game_id);
	}

	public function set_next_card($game)
	{
		parent::update_value(self::_TABLE, 'next_card', $game->get_next_card(), self::_ID_FIELD, $game->get_game_id());
	}

	public function save_game_vars($game)
	{
		parent::update_value(self::_TABLE, 'gets', $game->get_gets(), self::_ID_FIELD, $game->get_game_id());
		parent::update_value(self::_TABLE, 'guess_num', $game->get_guess_num(), self::_ID_FIELD, $game->get_game_id());
		if($game->get_dealer_id())
		{
			parent::update_value(self::_TABLE, 'dealer_id', $game->get_dealer_id(), self::_ID_FIELD, $game->get_game_id());
		}
		if($game->get_player_id())
		{
			parent::update_value(self::_TABLE, 'player_id', $game->get_player_id(), self::_ID_FIELD, $game->get_game_id());
		}
	}

	public function get_game_vars($game)
	{
		return parent::select_row(self::_TABLE, self::_ID_FIELD, $game->get_game_id());
	}
}
?>