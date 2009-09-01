<?php

class db_player_list extends db
{
	const _TABLE = 'players';
	const _ID_FIELD = 'game_id';

	public function get_players($game_id)
	{
		$field = 'id';
		return parent::select_list(self::_TABLE, $field, self::_ID_FIELD, $game_id);
	}

}
?>