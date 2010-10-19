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
		$table =		self::_TABLE;
		$field_vals =	array(
							"gets" =>		$game->get_gets(),
							"guess_num" =>	$game->get_guess_num(),
							"turn_id" =>	$game->get_turn_id()
						);
		if($game->get_dealer_id())
			$field_vals['dealer_id'] = $game->get_dealer_id();

		if($game->get_player_id())
			$field_vals['player_id'] = $game->get_player_id();

		$id_field = self::_ID_FIELD;
		$id = $game->get_game_id();

		parent::update_multi_values($table, $field_vals, $id_field, $id);
	}

	public function get_game_vars($game)
	{
		return parent::select_row(self::_TABLE, self::_ID_FIELD, $game->get_game_id());
	}
}
?>