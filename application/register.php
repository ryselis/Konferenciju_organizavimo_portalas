<?php
include "../helpers/mysql.php";
include "../models/conference_application__area_for_rent.php";
include "../models/participant_application.php";
session_start();
$db = new MySQLConnector();
$db->connect();
$application = new ParticipantApplication();
$application->conference_section = $_GET['id'];
$application->user = $_SESSION['user_id'];
$application->save();
$db->disconnect();
header('Location: ../participant_applications/participant_application_list.php');
?>