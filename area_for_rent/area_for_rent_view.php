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
	<meta charset="UTF-8">
	<head>
		<script type="text/javascript" src="../js/area_for_rent_view.js"></script>
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
		?>
			<div>
				<label> Pavadinimas </label>
				<span>
				<?php
				if ($object != null) {
					echo $object -> title;
				}
				?>
				</span>
			</div>
			<div>
				<label> Ilgis, m </label>
				<span>
				<?php
				if ($object != null) {
					echo $object -> length;
				}
				?>
				</span>
			</div>
			<div>
				<label> Plotis, m </label>
				<span>
				<?php
				if ($object != null) {
					echo $object -> width;
				}
				?>
				</span>
			</div>
			<div>
				<label> Kaina, Lt/m² </label>
				<span>
				<?php
				if ($object != null) {
					echo $object -> price;
				}
				?>
				</span>
			</div>
			<div>
				<label> Galima nuomoti nuo </label>
				<span>
				<?php
				if ($object != null) {
					echo $object -> available_from;
				}
				?>
				</span>
			</div>
			<div>
				<label> Galima nuomoti iki </label>
				<span>
				<?php
				if ($object != null) {
					echo $object -> available_to;
				}
				?>
				</span>
			</div>
			<div>
				<label> Telpa žmonių </label>
				<span>
				<?php
				if ($object != null) {
					echo $object -> capacity;
				}
				?>
				</span>
			</div>
			<div>Papildoma įranga</div>
			<div id="equipment"><?php
			if (isset($_GET['id'])) {
				include_once '../models/equipment.php';
				include_once '../helpers/mysql.php';
				$db = new MySQLConnector();
				$db -> connect();
				$accessor = new Equipment();
				$equipments = $accessor -> filter(array('area_for_rent' => $_GET['id']));
				$db -> disconnect();
				foreach ($equipments as $equipment) {
					$html = '<div><div><label>Pavadinimas</label><span>';
					$html .= $equipment -> title . '</span></div>';
					$html .= '<div><label>Kaina</label><span>';
					$html .= $equipment -> price . '</span></div></div>';
					echo $html;
				}
			}
			?></div>
			<input type="button" value="Rezervuoti" onclick="reserve(<?php echo $_GET['id']; ?>);" />
	</body>
</html>