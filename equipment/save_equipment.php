<?php
session_start();
if (isset($_POST['title']) && isset($_POST['price'])) {
	include_once "../helpers/mysql.php";
	include_once "../models/equipment.php";
	$mysql = new MySQLConnector();
	$mysql->connect();
	
	$application = new Equipment($_POST);
	if (isset($_GET['id'])){
		$application->id = $_GET['id'];	
	}
	$application->save();
	$mysql->disconnect();
	header("Location: ./equipment_list.php");
}
else{
	echo "Užpildykite visus laukus";
}
?>