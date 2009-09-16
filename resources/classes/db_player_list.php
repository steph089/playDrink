<?php

class db_player_list extends db
{
	const _TABLE = 'players';
	const _ID_FIELD = 'game_id';

	public function get_players($game_id)
	{
		$field = 'id';
		$extra_cond = '1 ORDER BY order_int';
		return parent::select_list(self::_TABLE, $field, self::_ID_FIELD, $game_id, $extra_cond);
	}

	public function save_order($players)
	{
		for($i=0; $i<$players->num_players(); $i++)
		{
			parent::update_value(self::_TABLE, 'order_int', $i, 'id', $players->get_id($i));
		}
	}

	public function get_next_order_int($game)
	{
		return parent::select_value(self::_TABLE, 'order_int', self::_ID_FIELD, $game->get_game_id(), "1 ORDER BY order_int DESC LIMIT 0,1") + 1;
	}

	public function get_next_players_id($game)
	{
		$extra_cond = "order_int > '" . $game->get_player_order_int() . "' AND id <> '" . $game->get_dealer_id() . "' LIMIT 0,1";
		return parent::select_value(self::_TABLE, 'id', self::_ID_FIELD, $game->get_game_id(), $extra_cond);
	}

	public function get_first_not_dealer_players_id($game)
	{
		$extra_cond = "id <> '" . $game->get_dealer_id() . "' ORDER BY order_int LIMIT 0,1";
		return parent::select_value(self::_TABLE, 'id', self::_ID_FIELD, $game->get_game_id(), $extra_cond);
	}
}
?>