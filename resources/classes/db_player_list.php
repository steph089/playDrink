<?php

class db_player_list extends db
{
	const _TABLE = 'players';
	const _ID_FIELD = 'game_id';

	public function get_players($game_id)
	{
		$field = 'id';
		$extraCond = ' ORDER BY order_int';
		return parent::select_list(self::_TABLE, $field, self::_ID_FIELD, $game_id, $extraCond);
	}

	public function save_order($players)
	{
		for($i=0; $i<$players->num_players(); $i++)
		{
			parent::update_value(self::_TABLE, 'order_int', $i, 'id', $players->get_id($i));
		}
	}
}
?>