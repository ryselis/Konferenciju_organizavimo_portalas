<?php
session_start();
?>
<html>
	<meta charset="UTF-8">
	<head>
		<title> Esamos patalpos nuomai </title>
	</head>
	<body>
		<?php include("../templates/menu.php"); ?>
		<input type="button" name="add_new" value="Pridėti" onclick="document.location.href='./application_add.php';" />
		<table>
			<tr><th>Pavadinimas</th><th>Nuomoti nuo</th><th>Nuomoti iki</th><th>Aprašymas</th></tr>
			<?php
			include_once "../models/conference_application.php";
			include_once "../helpers/row_builder.php";
			include_once "../helpers/mysql.php";
			$db = new MySQLConnector();
			$db->connect();
			$accessor = new ConferenceApplication();
			$applications = $accessor->filter($_GET);
			$db->disconnect();
			foreach ($applications as $application) {
				$href = "./application_add?id=".$application->id;
				$title = $application->title;
				$rent_from = $application->rent_from;
				$rent_to = $application->rent_to;
				$description = $application->description;
				$params = array($title, $rent_from, $rent_to, $description);
				$builder = new RowBuilder($params, $href);
				echo "<tr>" . $builder->build() . "</tr>";
			}
			?>
		</table>
	</body>
</html>