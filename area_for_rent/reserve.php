<?php
include_once "../helpers/mysql.php";
include_once "../models/area_for_rent.php";
$area_id = $_GET['id'];
$db = new MySQLConnector();
$db->connect();
$accessor = new AreaForRent();
$areas = $accessor->filter(array('id' => $area_id));
$area = $areas[0];
$db->disconnect();
?>