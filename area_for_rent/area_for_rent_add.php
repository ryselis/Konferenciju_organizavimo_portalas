<?php
session_start();
$error = false;
$success = false;
if (!empty($_POST)) {
	if ($_POST['title'] && $_POST['length'] && $_POST['width'] && $_POST['price'] && $_POST['available_from'] && $_POST['available_to'] && $_POST['available_to'] && $_POST['capacity']) {
		include_once "../helpers/mysql.php";
		include_once "../models/area_for_rent.php";
		include_once "../models/equipment.php";
		include_once "../models/area_for_rent__equipment.php";
		if ($_POST['available_from'] > $_POST['available_to']) {
			$error = "Nuomos pabaiga yra ankstesnė už nuomos pradžią";
		} else {
			$mysql = new MySQLConnector();
			$mysql -> connect();
			$area = new AreaForRent($_POST);
			if (isset($_GET['id'])) {
				$area -> id = $_GET['id'];
			}
			$area -> save();
			$accessor = new Equipment();
			$equipments = $accessor -> filter(array());
			$accessor = new AreaForRentEquipment();
			foreach ($equipments as $equipment) {
				$items = $accessor -> filter(array("equipment" => $equipment -> id, "area" => $area -> id));
				if (count($items) > 0 and !isset($_POST['equipment_' . $equipment -> id])) {
					echo "first" . $equipment -> id;
					$items[0] -> delete();
				}
				if (count($items) == 0 and isset($_POST['equipment_' . $equipment -> id])) {
					$item = new AreaForRentEquipment();
					$item -> area = $area -> id;
					$item -> equipment = $equipment -> id;
					$item -> save();
					echo "second" . $equipment -> id;
				}
			}
			$mysql -> disconnect();
			$success = "Išsaugota";
		}
	} else {
		$error = "Užpildykite visus laukus";
	}
}
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
	<meta charset="UTF-8">
	<head>
		<link rel="stylesheet" href="../css/base.css"/>
		<script type="text/javascript" src="../js/area_for_rent.js"></script>
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
		<?php
		include ("../templates/menu.php");
 ?><h1>
 <?php
if ($object == null) {
	echo "Pridėti naują patalpą";
} else {
	echo "Redaguoti patalpą " . $object -> title;
}
		?>
		</h1>
 		<?php
		if ($error) {
			echo '<div class="error" >' . $error . '</div>';
		}
		if ($success) {
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
			<div id="equipment"><?php
			if (isset($_GET['id'])) {
				$equipment_count = 0;
				include_once '../models/equipment.php';
				include_once '../helpers/mysql.php';
				include_once '../models/area_for_rent__equipment.php';
				$db = new MySQLConnector();
				$db -> connect();

				$all_items = $accessor -> filter(array());
				$accessor = new Equipment();
				$all_eqs = $accessor -> filter(array());
				$accessor = new AreaForRentEquipment();
				foreach ($all_eqs as $equipment) {
					$html = '<div><input type="checkbox" name="equipment_';
					$html .= $equipment -> id . '"';
					$items = $accessor -> filter(array('area' => $_GET['id'], 'equipment' => $equipment -> id));
					if (count($items) > 0) {
						$html .= 'checked';
					}
					$html .= '/>' . $equipment -> title . ' (' . $equipment -> price . ' Lt)';
					$html .= '</div>';
					echo $html;
				}
				$db -> disconnect();
			}
			?></div>
			<input type="submit" />
		</form>
	</body>
</html>