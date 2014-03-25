<?php
include_once '../helpers/mysql.php';
include_once '../models/user.php';
include_once '../models/user_group.php';

$accessor = new User();
if (isset($_SESSION['username'])){
	header('Location: ../dashboard/dashboard.php');
}
if (isset($_POST["username"])) {
	$connector = new MySQLConnector();
	$connector->connect();
	$objects = $accessor -> filter(array("username" => $_POST["username"], "password" => md5($_POST["password"])));
	if (count($objects) > 0) {
		session_start();
		$user = $objects[0];
		$_SESSION['user_id'] = $user -> id;
		$_SESSION['username'] = $user -> username;
		$accessor = new UserGroup();
		$groups = $accessor->filter(array('id' => $user->user_group));
		$user_group = $groups[0];
		$_SESSION['user_group'] = $user_group->system_key;
		header('Location: ../dashboard/dashboard.php');
	} else {
		$password_incorrect = true;
	}
	$connector->disconnect();
}
?>
<html>
	<meta charset="UTF-8">
	<head>
		<link rel="stylesheet" type="text/css" href="../css/base.css" />
		<title> Prisijungimas </title>
	</head>
	<div><img src="../img/logo2.png" width="137px" height="79px" /></div>
	<?php
	if (isset($password_incorrect)) {
		if ($password_incorrect){
			echo '<div class="error"> Neteisingas vartotojo vardas ar slaptažodis</div>';
		}
	} 
	?>
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