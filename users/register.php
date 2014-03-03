<?php
if (isset($_POST["username"]) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email_address']) && isset($_POST['phone_number'])) {
	include_once '../helpers/mysql.php';
	include_once '../models/user.php';
	$connector = new MySQLConnector();
	$user = new User($_POST);
	$user->save();
	$connector->connect();
	$connector->disconnect();
}
else{
	echo "Užpildykite visus laukus";
}
?>

<html>
	<meta charset="UTF-8">
	<head>
		<title> Registracija </title>
	</head>
	<body>
		<form method="POST" action="./register.php">
			<label>Vartotojo vardas</label>
			<input id="username" type="text" name="username" />
			<label>Slaptažodis</label>
			<input id="password" type="password" name="password" />
			<label>Pakartokite slaptažodį</label>
			<input id="password2" type="password" name="password2" />
			<label>Vardas</label>
			<input id="first_name" type="text" name="first_name" />
			<label>Pavardė</label>
			<input id="last_name" type="text" name="last_name" />
			<label>Elektroninio pašto adresas</label>
			<input id="email" type="text" name="email_address" />
			<label>Telefono numeris</label>
			<input id="phone_number" type="text" name="phone_number" />
			<label>Registruojuosi kaip</label>
			<input type="radio" name="register_to" value="announcer">
			Konferencijos pranešėjas
			<input type="radio" name="register_to" value="participant"/>
			Konferencijos dalyvis
			<input type="submit" />
		</form>

	</body>
</html>