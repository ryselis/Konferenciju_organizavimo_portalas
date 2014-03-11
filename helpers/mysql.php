<?php
class MySQLConnector {
	private $server = 'localhost';
	private $username = 'root';
	private $password = 'root';
	private $database_name = 'conference_portal';
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