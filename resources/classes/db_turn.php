<?php

class db_turn extends db
{
	const _TABLE = 'turns';
	const _ID_FIELD = 'id';

	public function insert_turn($game_id, $player_id, $dealer_id, $gets)
	{
		$values = array();
		$values['game_id'] = $game_id;
		$values['player_id'] = $player_id;
		$values['dealer_id'] = $dealer_id;
		$values['gets'] = $gets;
		return parent::insert(self::_TABLE, $values);
	}

	public function save_turn($turn)
	{
		$table =		self::_TABLE;
		$field_vals =	array();

		if($turn->get_first_guess_num() != NULL)
			$field_vals['first_guess_num'] = $turn->get_first_guess_num();

		if($turn->get_first_guess_result() != NULL)
			$field_vals['first_guess_result'] =	$turn->get_first_guess_result();

		if($turn->get_second_guess_num() != NULL)
			$field_vals['second_guess_num'] = $turn->get_second_guess_num();

		if($turn->get_drinker_id() != NULL)
			$field_vals['drinker_id'] =	$turn->get_drinker_id();

		if($turn->get_drinks() != NULL)
			$field_vals['drinks'] = $turn->get_drinks();

		if($turn->get_card() != NULL)
			$field_vals['card'] = $turn->get_card();

		$id_field = self::_ID_FIELD;
		$id = $turn->get_id();

		parent::update_multi_values($table, $field_vals, $id_field, $id);
	}

}
?>