<?php
session_start();
?>
<html>
	<meta charset="UTF-8">
	<head>
		<link rel="stylesheet" href="../css/base.css"/>
		<title> Esamos patalpos nuomai </title>
	</head>
	<body>
		<?php
		include ("../templates/menu.php");
		?>
		<?php
include_once "../models/user_group.php";
if ($_SESSION['user_group'] == UserGroup::announcer()):
		?>
		<input type="button" name="add_new" value="Pridėti naują" onclick="document.location.href='./application_add.php';" />
		<?php endif; ?>
		<table>
			<tr>
				<th>Pavadinimas</th><th>Pridėjo</th><th>Nuomoti nuo</th><th>Nuomoti iki</th><th>Aprašymas</th>
			</tr>
			<?php
			include_once "../models/conference_application.php";
			include_once "../helpers/row_builder.php";
			include_once "../helpers/mysql.php";
			include_once "../models/user.php";
			$db = new MySQLConnector();
			$db -> connect();
			$accessor = new ConferenceApplication();
			$applications = $accessor -> filter($_GET);
			foreach ($applications as $application) {
				if ($_SESSION['user_group'] == UserGroup::announcer()) {
					if ($application -> user != $_SESSION['user_id']) {
						continue;
					}
					$href = "./application_add?id=" . $application -> id;
				} else {
					$href = "./application_view?id=" . $application -> id;
				}
				$title = $application -> title;
				$rent_from = $application -> rent_from;
				$rent_to = $application -> rent_to;
				$description = $application -> description;
				$acc = new User();
				$user = $acc -> filter(array("id" => $application -> user));
				$user = $user[0];
				$params = array($title, $user -> first_name . " " . $user -> last_name, $rent_from, $rent_to, $description);
				$builder = new RowBuilder($params, $href);
				echo "<tr>" . $builder -> build() . "</tr>";
			}
			$db -> disconnect();
			?>
		</table>
	</body>
</html>