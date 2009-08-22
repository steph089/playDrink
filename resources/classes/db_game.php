<?php

class db_game extends db
{
	const _TABLE = 'games';
	const _ID_FIELD = 'game_id';
	
	private function get_value($field, $game_id) {
		return $this->select_value(self::_TABLE, $field, self::_ID_FIELD, $game_id);
	}

	public function new_game($deck) {
		$fields = array('deck');
		$values = array($deck);
		return parent::insert(self::table, $fields, $values);
	}


	public function get_deck_array($game_id) {
		$init_string = $this->get_value('deck', $game_id);
		$deck_array =  explode(',', $init_string);
		return $deck_array;
	}
	
	public function get_next_card($game_id) {
		return $this->get_value('next_card',$game_id);
	}


}
?>