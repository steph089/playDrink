<?php

class db {
	const enviro = 'dev';

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
		$con = mysql_connect($host,$username,$password) or die("Unable to connect to Database");
		@mysql_select_db($database) or die("Unable to select Database");
	}

	public function __destruct() {
		mysql_close();
	}

	protected function run_query($query) {
		$result =  mysql_query($query) or die("Query: <br>$query<br> has Failed..." . mysql_error());
		return $result;
	}

	protected function inserted_id() {
		$query = "SELECT LAST_INSERT_ID()";
		$result = $this->run_query($query);
		$row = mysql_fetch_array($result)or die("Data Retrival Failed");
		return $row[0];
	}

	protected function insert($table, $fields, $values)
	{
		$fields = implode(',',$fields);
		$values = "'" . implode("','",$values) . "'";
		$query = "INSERT INTO $table ($fields) VALUES ($values)";
		$results = $this->run_query($query);

		return $this->inserted_id();
	}

	protected function select_value($table, $field, $id_field, $id) {
		$query = "SELECT $field FROM $table WHERE $id_field = '$id'";
		$result = $this->run_query($query);
		$row = mysql_fetch_array($result)or die("Data Retrival Failed");
		return $row[0];
	}
	
	public function update_value($table, $field, $value, $id_field, $id)
	{
		$query = "UPDATE $table SET $field  = '$value' WHERE $id_field = '$id'";
		$this->run_query($query);
	}

}
?>