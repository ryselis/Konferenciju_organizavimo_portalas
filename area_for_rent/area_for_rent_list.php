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
		<h1>Patalpos nuomai</h1>
		<h2>Filtras</h2>
		<form action="area_for_rent_list.php" method="GET">
			<div>
				<div>
					Data
				</div>
				<label>Nuo</label>
				<input type="datetime-local" name="available_fromlte" <?php
				if (isset($_GET['available_fromlte'])) {
					echo 'value="' . $_GET['available_fromlte'] . '"';
				}
				?> />
				<label>Iki</label>
				<input type="datetime-local" name="available_togte" <?php
				if (isset($_GET['available_togte'])) {
					echo 'value="' . $_GET['available_togte'] . '"';
				}
				?> />
			</div>
			<div>
			<div>
			Klausytojų skaičius
			</div>
			<label>Nuo</label>
			<input type="number" step="1" name="capacitygte" <?php
			if (isset($_GET['capacitygte'])) {
				echo 'value="' . $_GET['capacitygte'] . '"';
			}
			?>/>
			<label>Iki</label>
			<input type="number" step="1" name="capacitylte" <?php
			if (isset($_GET['capacitylte'])) {
				echo 'value="' . $_GET['capacitylte'] . '"';
			}
			?>/>
			</div>
			<div>
			Įranga
			</div>
			<?php
			include_once "../helpers/mysql.php";
			include_once "../models/equipment.php";
			$db = new MySQLConnector();
			$db -> connect();
			$accessor = new Equipment();
			$all_equips = $accessor -> filter(array());
			foreach ($all_equips as $eq) {
				$html = '<input type="checkbox" name="equipment_';
				$html .= $eq -> id;
				$html .= '" ';
				if (isset($_GET['equipment_' . $eq -> id])) {
					$html .= "checked";
				}
				$html .= '/><div class="checkbox">' . $eq -> title . '</div>';
				echo $html;
			}
			?>

			<input type="submit" />
		</form>
		<?php
include_once "../models/user_group.php";
if ($_SESSION['user_group'] == UserGroup::admin()):
		?>
		<input type="button" name="add_new" value="Pridėti" onclick="document.location.href='./area_for_rent_add.php';" />
		<?php endif; ?>
		<table>
			<tr>
				<th>Pavadinimas</th><th>Ilgis, m</th><th>Plotis, m</th><th>Plotas, m²</th><th>Kaina, Lt/m²</th><th>Kaina, Lt</th><th>Nuomojama nuo</th><th>Nuomojama iki</th><th>Telpa žmonių</th>
			</tr>
			<?php
			include_once "../helpers/row_builder.php";
			include_once "../models/area_for_rent.php";
			include_once "../models/area_for_rent__equipment.php";
			$accessor = new AreaForRent();
			$filter_args = array();
			$has_equip_filter = false;
			foreach ($_GET as $key => $value) {
				if (strpos($key, "equip") === false) {
					if ($value) {
						$filter_args[$key] = $value;
					}
				} else {
					$has_equip_filter = true;
				}
			}
			$areas = $accessor -> filter($filter_args);
			foreach ($areas as $area) {
				if ($has_equip_filter) {
					$skip = true;
					foreach ($all_equips as $eq) {
						$key = "equipment_" . $eq -> id;
						if (isset($_GET[$key])) {
							$accessor = new AreaForRentEquipment();
							$items = $accessor -> filter(array("area" => $area -> id, "equipment" => $eq -> id));
							if (count($items) > 0) {
								$skip = false;
							}
						}
					}
					if ($skip) {
						continue;
					}
				}
				if ($_SESSION['user_group'] == UserGroup::admin()) {
					$href = "./area_for_rent_add?id=" . $area -> id;
				} else {
					$href = "./area_for_rent_view?id=" . $area -> id;
				}
				$title = $area -> title;
				$length = $area -> length;
				$width = $area -> width;
				$size = $length * $width;
				$unit_price = $area -> price;
				$price = $unit_price * $size;
				$rent_from = $area -> available_from;
				$rent_to = $area -> available_to;
				$capacity = $area -> capacity;
				$params = array($title, $length, $width, $size, $unit_price, $price, $rent_from, $rent_to, $capacity);
				$builder = new RowBuilder($params, $href);
				echo "<tr>" . $builder -> build() . "</tr>";
			}
			$db -> disconnect();
			?>
		</table>
	</body>
</html>