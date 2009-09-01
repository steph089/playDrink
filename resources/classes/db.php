<?php

class db {
	const enviro = 'dev';

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
				$username="";
				$password="";
				$database="";
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

	protected function insert($table, $fields, $values)
	{
		$fields = implode(',',$fields);
		$values = "'" . implode("','",$values) . "'";
		$this->_query = "INSERT INTO $table ($fields) VALUES ($values)";
		$results = $this->run();

		return $this->inserted_id();
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

	protected function select_list($table, $field, $id_field, $id)
	{
		$this->_query = "SELECT $field FROM $table WHERE $id_field = '$id'";
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