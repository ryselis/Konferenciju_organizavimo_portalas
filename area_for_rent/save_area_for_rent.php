<?php
session_start();
if (isset($_POST['title']) && isset($_POST['length']) && isset($_POST['width']) && isset($_POST['price']) && isset($_POST['available_from']) && isset($_POST['available_to']) && isset($_POST['available_to']) && isset($_POST['capacity'])) {
	include_once "../helpers/mysql.php";
	include_once "../models/area_for_rent.php";
	include_once "../models/equipment.php";
	include_once "../models/area_for_rent__equipment.php";
	$mysql = new MySQLConnector();
	$mysql -> connect();
	$area = new AreaForRent($_POST);
	if (isset($_GET['id'])) {
		$area -> id = $_GET['id'];
	}
	$area -> save();
	$accessor = new Equipment();
	$equipments = $accessor -> filter(array());
	$accessor = new AreaForRentEquipment();
	foreach ($equipments as $equipment) {
		$items = $accessor -> filter(array("equipment" => $equipment -> id, "area" => $area -> id));
		var_dump($items);	
		var_dump(isset($_POST['equipment_' . $equipment -> id]));
		if (count($items) > 0 and !isset($_POST['equipment_' . $equipment -> id])) {
			echo "first" . $equipment->id;
			$items[0] -> delete();
		}
		if (count($items) == 0 and isset($_POST['equipment_' . $equipment -> id])) {
			$item = new AreaForRentEquipment();
			$item -> area = $area -> id;
			$item -> equipment = $equipment -> id;
			$item -> save();
			echo "second" . $equipment->id;
		}
	}
	$mysql -> disconnect();
	header("Location: ./area_for_rent_list.php");
} else {
	echo "Užpildykite visus laukus";
}
?>