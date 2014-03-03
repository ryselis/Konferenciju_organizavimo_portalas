<?php
class MySQLConnector {
	private $server = 'localhost';
	private $username = 'root';
	private $password = 'root';
	private $connection;

	public function connect() {
		$this -> connection = mysql_connect($this -> server, $this -> username, $this -> password);
		return $this -> connection;
	}

	public function disconnect() {
		mysql_close($this -> connection);
	}

}
?>