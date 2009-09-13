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

}
?>