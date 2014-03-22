<?php
session_start();
if (isset($_POST['title']) && isset($_POST['rent_from']) && isset($_POST['rent_to']) ) {
	include_once "../helpers/mysql.php";
	include_once "../models/conference_application.php";
	$mysql = new MySQLConnector();
	$mysql->connect();
	
	$application = new ConferenceApplication($_POST);
	if (isset($_GET['id'])){
		$application->id = $_GET['id'];	
	}
	$application->user = $_SESSION['user_id'];
	$application->is_confirmed = 0;
	$application->save();
	$mysql->disconnect();
	header("Location: ./application_list.php");
}
else{
	echo "Užpildykite visus laukus";
}
?>