<?php
session_start();
if (isset($_GET['id'])) {
	include_once "../helpers/mysql.php";
	include_once "../models/area_for_rent.php";
	$db = new MySQLConnector();
	$db -> connect();
	$accessor = new AreaForRent();
	$objects = $accessor -> filter(array("id" => $_GET['id']));
	$object = $objects[0];
	$db -> disconnect();
} else {
	$object = null;
}
?>
<html>
	<script type="text/javascript" src="../js/area_for_rent.js"></script>
	<meta charset="UTF-8">
	<head>
		<title>
		<?php
		if ($object == null) {
			echo "Pridėti naują patalpą";
		} else {
			echo "Redaguoti patalpą " . $object -> title;
		}
		?></title>
	</head>
	<body>
		<?php include("../templates/menu.php"); ?>
		<form method="POST" action="./save_area_for_rent.php<?php
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
				<label> Ilgis, m </label>
				<input type="number" name="length" step="0.01"
				<?php
				if ($object != null) {
					echo 'value="' . $object -> length . '"';
				}
				?>
				/>
			</div>
			<div>
				<label> Plotis, m </label>
				<input type="text" name="width" step="0.01"
				<?php
				if ($object != null) {
					echo 'value="' . $object -> width . '"';
				}
				?>
				/>
			</div>
			<div>
				<label> Kaina, Lt/m² </label>
				<input type="text" name="price" step="0.01"
				<?php
				if ($object != null) {
					echo 'value="' . $object -> price . '"';
				}
				?>
				/>
			</div>
			<div>
				<label> Galima nuomoti nuo </label>
				<input type="datetime-local" name="available_from"
				<?php
				if ($object != null) {
					echo 'value="' . $object -> available_from . '"';
				}
				?>
				/>
			</div>
			<div>
				<label> Galima nuomoti iki </label>
				<input type="datetime-local" name="available_to"
				<?php
				if ($object != null) {
					echo 'value="' . $object -> available_to . '"';
				}
				?>
				/>
			</div>
			<div>
				<label> Telpa žmonių </label>
				<input type="number" name="capacity" step="1"
				<?php
				if ($object != null) {
					echo 'value="' . $object -> capacity . '"';
				}
				?>
				/>
			</div>
			<div>Papildoma įranga</div>
			<div id="equipment"></div>
			<input type="button" onclick="addEquipmentField();" />
			<input type="submit" />
		</form>
	</body>
</html>