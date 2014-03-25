<?php
session_start();
include_once "../models/user_group.php";
if ($_SESSION['user_group'] != UserGroup::announcer()){
	header('Location: ../permission_denied');
}
if (isset($_GET['id'])) {
	include_once "../helpers/mysql.php";
	include_once "../models/conference_application.php";
	$db = new MySQLConnector();
	$db -> connect();
	$accessor = new ConferenceApplication();
	$objects = $accessor -> filter(array("id" => $_GET['id']));
	$object = $objects[0];
	$db -> disconnect();
} else {
	$object = null;
}
$error = false;
$success = false;
if (!empty($_POST)) {
	if ($_POST['title'] && $_POST['rent_from'] && $_POST['rent_to']) {
		include_once "../helpers/mysql.php";
		include_once "../models/conference_application.php";
		if ($_POST['rent_from'] > $_POST['rent_to']) {
			$error = "Nuoma negali baigtis dar neprasidėjusi";
		} else {
			$mysql = new MySQLConnector();
			$mysql -> connect();
			$application = new ConferenceApplication($_POST);
			if (isset($_GET['id'])) {
				$application -> id = $_GET['id'];
			}
			$application -> user = $_SESSION['user_id'];
			$application -> is_confirmed = 0;
			$application -> save();
			$mysql -> disconnect();
			$success = "Išsaugota";
			header("Location: application_list.php");
		}
	} else {
		$error = "Užpildykite privalomus laukus";
	}
}
?>
<html>
	<meta charset="UTF-8">
	<head>
		<link rel="stylesheet" href="../css/base.css"/>
		<title>
		<?php
		if ($object == null) {
			echo "Pridėti paraišką konferencijai";
		} else {
			echo "Redaguoti paraišką konferencijai " . $object -> title;
		}
		?></title>
	</head>
	<body>
		<?php
		include ("../templates/menu.php");
 ?>
 		<h1>
 		<?php
		if ($object == null) {
			echo "Pridėti paraišką konferencijai";
		} else {
			echo "Redaguoti paraišką konferencijai „" . $object -> title . "“";
		}
		?>
		</h1>
		<?php
		if ($error) {
			echo '<div class="error" >' . $error . '</div>';
		}
		if ($success){
			echo '<div class="success" >' . $success . '</div>';
		}
		?>
		<form method="POST" action="">
			<div>
				<label> Pavadinimas </label>
				<input type="text" name="title"
				<?php
				if ($object != null) {
					echo 'value="' . $object -> title . '"';
				}
				?>
				/>
			</div>
			<div>
				<label> Patalpas nuomoti nuo </label>
				<input type="datetime-local" name="rent_from"
				<?php
				if ($object != null) {
					echo 'value="' . $object -> rent_from . '"';
				}
				?>
				/>
			</div>
			<div>
				<label> Patalpas nuomoti iki </label>
				<input type="datetime-local" name="rent_to"
				<?php
				if ($object != null) {
					echo 'value="' . $object -> rent_to . '"';
				}
				?>
				/>
			</div>
			<div>
				<label class="non-required"> Aprašymas </label>
				<textarea name="description" rows="5">
				<?php
				if ($object != null) {
					echo $object -> description;
				}
				?>
				</textarea>
			</div>
			<input type="submit" />
			<?php
			if ($object != null) {
				echo "<h2>Konferencijos sekcijos</h2>";
				include_once "../models/conference_application__area_for_rent.php";
				include_once "../models/area_for_rent.php";
				$db = new MySQLConnector();
				$db -> connect();
				$accessor = new ConferenceApplicationAreaForRent();
				$items = $accessor -> filter(array("conference_application" => $object -> id));
				foreach ($items as $item) {
					$accessor = new AreaForRent();
					$areas = $accessor -> filter(array("id" => $item -> area_for_rent));
					$area = $areas[0];
					$html = "<div>" . $item->title . " (" . $area -> title . ")";
					$html .= '<div>';
					echo $html;
				}
				$db -> disconnect();
			}
			
			?>
			
		</form>
	</body>
</html>