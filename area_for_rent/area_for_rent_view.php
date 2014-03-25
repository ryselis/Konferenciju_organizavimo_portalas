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
		<link rel="stylesheet" type="text/css" href="../css/base.css" />
		<script type="text/javascript" src="../js/area_for_rent_view.js"></script>
		<title>
			Pridėti naują patalpą
		</title>
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
				include_once '../models/area_for_rent__equipment.php';
				$db = new MySQLConnector();
				$db -> connect();
				$accessor = new AreaForRentEquipment();
				$items = $accessor->filter(array('area' => $_GET['id']));
				$accessor = new Equipment();
				foreach ($items as $item) {
					$equipments = $accessor -> filter(array('id' => $item->equipment));
					$equipment = $equipments[0];
					$html = '<div><div><label>Pavadinimas</label><span>';
					$html .= $equipment -> title . '</span></div>';
					$html .= '<div><label>Kaina</label><span>';
					$html .= $equipment -> price . '</span></div></div>';
					echo $html;
				}
				$db -> disconnect();
			}
			?></div>
			<input type="button" value="Rezervuoti" onclick="reserve(<?php echo $_GET['id']; ?>);" />
	</body>
</html>