<?php

class db {
	const enviro = 'prod';

	private $_con;
	private $_query;

	public function __construct() {
		switch(self::enviro) {
			case 'dev':
				$username="root";
				$password="mysqlpassword";
				$database="playdrink";
				$host='localhost';
				break;
			case 'prod':
			default:
				$username="presenc2_playdri";
				$password="secure";
				$database="presenc2_playdrink";
				break;
		}
		$this->_con = mysql_connect($host,$username,$password) or die("Unable to connect to Database");
		@mysql_select_db($database) or die("Unable to select Database");
	}

	public function __destruct() {

	}

// ************** PROTECTED *************************************

	protected function run() {
		$query = $this->_query;
		$result =  mysql_query($query) or die("<BR>Query: <br>$query<br> has Failed..." . mysql_error());
		return $result;
	}

	protected function inserted_id() {
		$this->_query = "SELECT LAST_INSERT_ID()";
		$result = $this->run();
		$row = mysql_fetch_array($result)or die("Data Retrival Failed");
		return $row[0];
	}

	protected function insert($table, $values)
	{
		if(count($values) > 0) 
		{
			$field_list = '';
			$value_list = '';
			foreach($values as $key => $value) {
				$field_list .= "" . $key . ", ";
				$value_list .= "'" . mysql_real_escape_string($value) . "', ";
			}
			$field_list = trim($field_list, ", ");
			$value_list = trim($value_list, ", ");

			$this->_query = "INSERT INTO $table ($field_list) VALUES ($value_list)";
			$results = $this->run();

			return $this->inserted_id();
		}
		else
		{
			return false;
		}
	}

	protected function select_value($table, $field, $id_field, $id) {
		$this->_query = "SELECT $field FROM $table WHERE $id_field = '$id'";
		$result = $this->run();
		$row = mysql_fetch_array($result)or die("Data Retrival Failed");
		return $row[0];
	}

	protected function select_row($table, $id_field, $id) {
		$this->_query = "SELECT * FROM $table WHERE $id_field = '$id'";
		$result = $this->run();
		$row = mysql_fetch_array($result, MYSQL_ASSOC)or die("Data Retrival Failed");
		return $row;
	}

	protected function update_value($table, $field, $value, $id_field, $id)
	{
		$this->_query = "UPDATE $table SET $field  = '$value' WHERE $id_field = '$id'";
		$this->run();
	}

	protected function select_list($table, $field, $id_field, $id, $extraCond)
	{
		$this->_query = "SELECT $field FROM $table WHERE $id_field = '$id' $extraCond";
		$results = $this->run();
		if(mysql_num_rows($results) == 0)
		{
			return array();
		}
		else
		{
			$return_array = array();
			while($row = mysql_fetch_array($results))
			{
				array_push($return_array, $row[0]);
			}
			return $return_array;
		}
	}
}
?>