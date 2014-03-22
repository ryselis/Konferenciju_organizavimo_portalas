<?php
include_once '../helpers/mysql.php';
include_once '../models/user.php';
include_once '../models/user_group.php';

$accessor = new User();
if (isset($_SESSION['username'])){
	header('Location: ../dashboard.php');
}
if (isset($_POST["username"])) {
	$connector = new MySQLConnector();
	$connector->connect();
	$objects = $accessor -> filter(array("username" => $_POST["username"], "password" => md5($_POST["password"])));
	$connector->disconnect();
	if (count($objects) > 0) {
		session_start();
		$user = $objects[0];
		$_SESSION['user_id'] = $user -> id;
		$_SESSION['username'] = $user -> username;
		echo "Sveiki, " . $_SESSION["username"];
		header('Location: ../dashboard.php');
	} else {
		$password_incorrect = true;
	}
}
?>
<html>
	<meta charset="UTF-8">
	<head>
		<title> Prisijungimas </title>
	</head>
	<?php
	if (isset($password_incorrect)) {
		if ($password_incorrect){
			echo "<div> Neteisingas slaptažodis</div>";
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