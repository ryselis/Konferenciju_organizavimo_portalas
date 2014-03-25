<?php
$error = false;
if (!empty($_POST)) {
	if ($_POST['username'] && $_POST['password'] && $_POST['first_name'] && $_POST['last_name'] && $_POST['email_address'] && $_POST['phone_number'] && $_POST['register_to']) {
		if ($_POST['password'] != $_POST['password2']) {
			$error = "Slaptažodžiai nesutampa";
		} else {
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
			if (count($user -> filter(array("username" => $_POST['username']))) > 0) {
				$error = "Vartotojas tokiu prisijungimo vardu jau egzistuoja";
				$connector -> disconnect();
			} else {
				$user -> save();
				$connector -> disconnect();
				header("Location: login.php");
			}
		}
	} else {
		if (isset($_POST['submit'])) {
			$error = "Užpildykite visus laukus!";
		}
	}
}
?>

<html>
	<meta charset="UTF-8">
	<head>
		<link rel="stylesheet" href="../css/base.css"/>
		<link rel="stylesheet" href="../css/register.css"/>
		<title> Registracija </title>
	</head>
	<body>
		<div><img src="../img/logo2.png" width="137px" height="79px" />
		</div>
		<?php
		if ($error) {
			echo '<div class="error" >' . $error . '</div>';
		}
		?>
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
				<div class="list-container">
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
				</div>
			</div>
			<input type="submit" name="submit" />
		</form>

	</body>
</html>