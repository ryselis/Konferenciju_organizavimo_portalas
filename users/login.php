<?php
include_once '../helpers/mysql.php';
include_once '../models/user.php';
include_once '../models/user_group.php';

$accessor = new User();
if (isset($_POST["username"])) {
	$connector = new MySQLConnector();
	$connector->connect();
	$objects = $accessor -> filter(array("username" => $_POST["username"], "password" => md5($_POST["password"])));
	$connector->disconnect();
	if (count($objects) > 0) {
		$user = $objects[0];
		$_SESSION['user_id'] = $user -> id;
		$_SESSION['username'] = $user -> username;
		echo "Sveiki, " . $_SESSION["username"];
	}
}
?>
<html>
	<meta charset="UTF-8">
	<head>
		<title> Prisijungimas </title>
	</head>
	<form method="POST" action="./login.php">
		<div>
			<label> Vartotojo vardas </label>
			<input type="text" name="username"/>
		</div>
		<div>
			<label> Slaptažodis </label>
			<input type="password" name="password" />
		</div>
		<input type="submit" />
	</form>

</html>