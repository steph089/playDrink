<?php

class db_game extends db
{
	const table = 'games';
	const id = 'game_id';

	public function newGame($deck) {
		$fields = array('deck');
		$values = array($deck);
		return parent::insert(self::table, $fields, $values);
	}

	/*
	public function getDeckArray($game_id) {
		$initString = $db->selectValue('game', 'deck', 'game_id', $game_id);
		return explode($initString,',');
	}
	*/


}
?>