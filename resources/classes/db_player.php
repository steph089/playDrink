<?php

class db_player extends db
{
	const _TABLE = 'players';
	const _ID_FIELD = 'id';

	public function load_player($player_id)
	{
		return parent::select_row(self::_TABLE, self::_ID_FIELD, $player_id);
	}

	public function insert_player($game_id, $name, $order_int)
	{
		$values = array('name'=>$name, 'game_id'=>$game_id, 'order_int'=>$order_int);
		return parent::insert(self::_TABLE, $values);
	}

	public function add_modifier($player, $game_id, $only_one=true)
	{
		// remove others
		if($only_one)
		{
			$extra_cond = "game_id = '$game_id'";
			parent::update_value(self::_TABLE, 'modifier', "NULL", 'modifier', $player->modifier(), $extra_cond);
		}

		parent::update_value(self::_TABLE, 'modifier', $player->modifier(), self::_ID_FIELD, $player->id());
	}

}
?>