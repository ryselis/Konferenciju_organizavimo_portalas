<?php
session_start();
?>
<html>
	<meta charset="UTF-8">
	<head>
		<link rel="stylesheet" type="text/css" href="../css/base.css" />
		<title> Esamos patalpos nuomai </title>
	</head>
	<body>
		<?php include("../templates/menu.php"); ?>
		<input type="button" name="add_new" value="Pridėti" onclick="document.location.href='./application_add.php';" />
		<table>
			<tr><th>Konferencijos sekcija</th><th>Vartotojas</th></tr>
			<?php
			include_once "../models/participant_application.php";
			include_once "../models/user.php";
			include_once "../models/conference_application__area_for_rent.php";
			include_once "../helpers/row_builder.php";
			include_once "../helpers/mysql.php";
			$db = new MySQLConnector();
			$db->connect();
			$accessor = new ParticipantApplication();
			$applications = $accessor->filter(array('user' => $_SESSION['user_id']));
			foreach ($applications as $application) {
				$href = '#';
				$user = $application->user;
				$accessor = new User();
				$users = $accessor->filter(array('id' => $application->user));
				$user = $users[0];
				$username = $user->username; 
				$accessor = new ConferenceApplicationAreaForRent();
				$items = $accessor->filter(array('id' => $application->conference_section));
				$item = $items[0];
				$title = $item->title;
				$params = array($title, $username);
				$builder = new RowBuilder($params, $href);
				echo "<tr>" . $builder->build() . "</tr>";
			}
			$db->disconnect();
			?>
		</table>
	</body>
</html>
