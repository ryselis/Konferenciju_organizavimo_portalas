<?php
session_start();
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
?>
<html>
	<meta charset="UTF-8">
	<head>
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
		<form method="POST" action="./save_application.php<?php
		if (isset($_GET['id']))
			echo "?id=" . $_GET['id'];
 		?>">
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
				<label> Nuomoti nuo </label>
				<input type="datetime-local" name="rent_from"
				<?php
				if ($object != null) {
					echo 'value="' . $object -> rent_from . '"';
				}
				?>
				/>
			</div>
			<div>
				<label> Nuomoti iki </label>
				<input type="datetime-local" name="rent_to"
				<?php
				if ($object != null) {
					echo 'value="' . $object -> rent_to . '"';
				}
				?>
				/>
			</div>
			<div>
				<label> Aprašymas </label>
				<textarea name="description">
				<?php
				if ($object != null) {
					echo $object -> description;
				}
				?>
				</textarea>
			</div>
			<div>Nuomojamos patalpos</div>
			<?php
			if ($object != null) {
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
					$html = "<div>" . $area -> title . "<div>";
					echo $html;
				}
				$db -> disconnect();
			}
			?>
			<input type="submit" />
		</form>
	</body>
</html>