<?php

class db_game extends db
{
	const _TABLE = 'games';
	const _ID_FIELD = 'game_id';

	public function new_game($deck)
	{
		$fields = array('deck');
		$values = array($deck);
		return parent::insert(self::_TABLE, $fields, $values);
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
}
?>