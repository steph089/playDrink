<?php

class db_player extends db
{
	const _TABLE = 'players';
	const _ID_FIELD = 'id';

	public function load_player($player_id)
	{
		return parent::select_row(self::_TABLE, self::_ID_FIELD, $player_id);
	}

	public function save_player($player)
	{
		$field_vals = array();
		$field_vals['drinks'] = $player->get_drinks();
		$field_vals['turns'] = $player->get_turns();
		$field_vals['correct_guesses'] = $player->get_correct_guesses();
		$field_vals['correct_guesses_2'] = $player->get_correct_guesses_2();

		parent::update_multi_values(self::_TABLE, $field_vals, self::_ID_FIELD, $player->get_id());
	}

	public function insert_player($game_id, $name, $order_int)
	{
		$values = array('name'=>$name, 'game_id'=>$game_id, 'order_int'=>$order_int);
		return parent::insert(self::_TABLE, $values);
	}
}
?>