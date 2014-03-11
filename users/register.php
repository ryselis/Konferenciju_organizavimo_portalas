<?php
if (isset($_POST["username"]) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email_address']) && isset($_POST['phone_number'])) {
	include_once '../helpers/mysql.php';
	include_once '../models/user.php';
	include_once '../models/user_group.php';
	$connector = new MySQLConnector();
	$user = new User($_POST);
	$connector -> connect();
	$accessor = new UserGroup();
	if ($_POST['register_to'] == 'announcer') {
		$user_group = $accessor -> filter(array("system_key" => "announcer"));
	} else {
		$user_group = $accessor -> filter(array("system_key" => "participant"));
	}
	$user -> user_group = $user_group[0] -> id;
	$user -> password = md5($_POST["password"]);
	$user -> save();
	$connector -> disconnect();
} else {
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
			<div>
				<label>Vartotojo vardas</label>
				<input id="username" type="text" name="username" />
			</div>
			<div>
				<label>Slaptažodis</label>
				<input id="password" type="password" name="password" />
			</div>
			<div>
				<label>Pakartokite slaptažodį</label>
				<input id="password2" type="password" name="password2" />
			</div>
			<div>
				<label>Vardas</label>
				<input id="first_name" type="text" name="first_name" />
			</div>
			<div>
				<label>Pavardė</label>
				<input id="last_name" type="text" name="last_name" />
			</div>
			<div>
				<label>Elektroninio pašto adresas</label>
				<input id="email" type="email" name="email_address" />
			</div>
			<div>
				<label>Telefono numeris</label>
				<input id="phone_number" type="tel" name="phone_number" />
			</div>
			<div>
				<label>Registruojuosi kaip</label>
				<ul>
					<li>
						<input type="radio" name="register_to" value="announcer">
						Konferencijos pranešėjas
					</li>
					<li>
						<input type="radio" name="register_to" value="participant"/>
						Konferencijos dalyvis
					</li>
				</ul>
				<input type="submit" />
			</div>
		</form>

	</body>
</html>