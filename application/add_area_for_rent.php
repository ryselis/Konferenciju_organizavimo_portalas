<?php
include_once "../models/conference_application__area_for_rent.php";
include_once "../helpers/mysql.php";
$db = new MySQLConnector();
$db -> connect();
$item = new ConferenceApplicationAreaForRent();
$item -> area_for_rent = $_GET['area_id'];
$item -> conference_application = $_GET['app_id'];
$item -> save();
$db -> disconnect();
header('Location: application_add?id=' . $_GET['app_id']);
?>