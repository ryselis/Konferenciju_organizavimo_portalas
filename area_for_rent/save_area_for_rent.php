<?php
session_start();
if (isset($_POST['title']) && isset($_POST['length']) && isset($_POST['width']) && isset($_POST['price']) && isset($_POST['available_from']) && isset($_POST['available_to']) && isset($_POST['available_to']) && isset($_POST['capacity'])) {
	include_once "../helpers/mysql.php";
	include_once "../models/area_for_rent.php";
	$mysql = new MySQLConnector();
	$mysql->connect();
	
	$area = new AreaForRent($_POST);
	echo $_GET['id'];
	if (isset($_GET['id'])){
		$area->id = $_GET['id'];	
	}
	$area->save();
	$mysql->disconnect();
	header("Location: ./area_for_rent_list.php");
}
else{
	echo "Užpildykite visus laukus";
}
?>