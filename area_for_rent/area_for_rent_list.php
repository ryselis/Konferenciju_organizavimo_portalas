<?php
session_start();
?>
<html>
	<meta charset="UTF-8">
	<head>
		<title> Esamos patalpos nuomai </title>
	</head>
	<body>
		<?php
		include ("../templates/menu.php");
		?>
		<form action="area_for_rent_list.php" method="GET">
			<div>
				<div>
					Data
				</div>
				<label>Nuo</label>
				<input type="datetime-local" name="available_fromlte" />
				<label>Iki</label>
				<input type="datetime-local" name="available_togte" />
			</div>
			<div>
			<div>
			Klausytojų skaičius
			</div>
			<label>Nuo</label>
			<input type="number" step="1" name="capacitygte"/>
			<label>Iki</label>
			<input type="number" step="1" name="capacitylte"/>
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
				$html .= '" />' . $eq -> title;
				echo $html;
			}
			//$db -> disconnect();
			?>

			<input type="submit" />
		</form>
		<input type="button" name="add_new" value="Pridėti" onclick="document.location.href='./area_for_rent_add.php';" />
		<table>
			<tr>
				<th>Pavadinimas</th><th>Ilgis</th><th>Plotis</th><th>Plotas</th><th>Kaina, Lt/m²</th><th>Kaina, Lt</th><th>Nuomojama nuo</th><th>Nuomojama iki</th><th>Telpa žmonių</th>
			</tr>
			<?php

			include_once "../helpers/row_builder.php";
			include_once "../models/area_for_rent.php";
			include_once "../models/area_for_rent__equipment.php";
			//$db = new MySQLConnector();
			//$db -> connect();
			$accessor = new AreaForRent();
			$filter_args = array();
			$has_equip_filter = false;
			foreach ($_GET as $key => $value) {
				if (strpos($key, "equip") < 0) {
					$filter_args[$key] = $value;
				} else {
					$has_equip_filter = true;
				}
			}
			$areas = $accessor -> filter($filter_args);

			foreach ($areas as $area) {
				if ($has_equip_filter) {
					$skip = false;
					foreach ($all_equips as $eq) {
						$key = "equipment_" . $eq -> id;
						if (isset($_GET[$key])) {
							$accessor = new AreaForRentEquipment();
							$items = $accessor -> filter(array("area" => $area -> id, "equipment" => $eq -> id));
							var_dump($area, $eq, $items);
							if (count($items) == 0) {
								echo "count zero";
								$skip = true;
							}
						} else {
							$skip = true;
							echo "not set";
						}
					}
					if ($skip){
						continue;
					}
				}
				$href = "./area_for_rent_add?id=" . $area -> id;
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