<?php
class MySQLConnector {
	private $server = 'stud.if.ktu.lt';
	private $username = 'karrys';
	private $password = 'aeWaupho9re0ew1u';
	private $database_name = 'karrys';
	private $connection;

	public function connect() {
		$this -> connection = mysql_connect($this -> server, $this -> username, $this -> password);
		mysql_select_db($this->database_name);
		return $this -> connection;
	}

	public function disconnect() {
		mysql_close($this -> connection);
	}

}
?>
