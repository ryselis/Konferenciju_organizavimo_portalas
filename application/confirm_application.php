<?php
include_once "../helpers/mysql.php";
include_once "../models/conference_application.php";
include_once "../models/user.php";
$db = new MySQLConnector();
$db -> connect();
$accessor = new ConferenceApplication();
$apps = $accessor -> filter(array("id" => $_GET['id']));
$app = $apps[0];
$app -> is_confirmed = 1;
$app -> save();
$accessor = new User();
$user = $accessor->filter(array('id' => $_SESSION['user_id']));
$user = $user[0];
$text = file_get_contents("../misc/email_template");
mail($user->email, 'Paraiškos patvirtinimas', $text);
$db -> disconnect();
header('Location: application_view.php?id=' . $_GET['id']);
?>