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

	private function runQuery($query) {
		return mysql_query($query) or die("Query: <br>$query<br> has Failed..." . mysql_error());
	}

	private function insertedID() {
		$query = "SELECT LAST_INSERT_ID()";
		$result=mysql_query($query) or die("Last Inserted ID query Failed..." . mysql_error());
		$row = mysql_fetch_array($result)or die("Data Retrival Failed");
		return $row[0];
	}

	public function insert($table, $fields, $values)
	{
		$fields = implode(',',$fields);
		$values = "'" . implode("','",$values) . "'";
		$query = "INSERT INTO $table ($fields) VALUES ($values)";
		$results = $this->runQuery($query);

		return $this->insertedID();
	}

	public function selectValue($table, $field, $IDfield, $ID) {
		$query = "SELECT $field FROM $table WHERE $IDfield = '$ID'";
		$results = $this->runQuery($query);
		$row = mysql_fetch_array($result)or die("Data Retrival Failed");
		return $row[0];
	}

}
?>