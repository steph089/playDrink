<?php

class db_player extends db
{
	const _TABLE = 'players';
	const _ID_FIELD = 'id';


	public function create_player()
	{

	}


	public function load_player($player_id)
	{
		return parent::select_row(self::_TABLE, self::_ID_FIELD, $player_id);
	}

}
?>