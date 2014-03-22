<?php
session_start();
if (isset($_POST['title']) && isset($_POST['length']) && isset($_POST['width']) && isset($_POST['price']) && isset($_POST['available_from']) && isset($_POST['available_to']) && isset($_POST['available_to']) && isset($_POST['capacity'])) {
	include_once "../helpers/mysql.php";
	include_once "../models/area_for_rent.php";
	include_once "../models/equipment.php";
	$mysql = new MySQLConnector();
	$mysql -> connect();

	$area = new AreaForRent($_POST);
	if (isset($_GET['id'])) {
		$area -> id = $_GET['id'];
	}
	$equipment_id = 0;
	while (isset($_POST['equipment_' . $equipment_id])) {
		$equipment = new Equipment();
		$equipment -> title = $_POST['equipment_' . $equipment_id];
		$equipment -> price = $_POST['price_' . $equipment_id];
		$equipment -> area_for_rent = $area -> id;
		if (isset($_POST['id_'.$equipment_id])){
			$equipment->id = $_POST['id_'.$equipment_id];
		}
		$equipment -> save();
		$equipment_id++;
	}
	$area -> save();
	$mysql -> disconnect();
	header("Location: ./area_for_rent_list.php");
} else {
	echo "Užpildykite visus laukus";
}
?>