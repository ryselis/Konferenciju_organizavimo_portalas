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
		<input type="button" name="add_new" value="Pridėti" onclick="document.location.href='./area_for_rent_add.php';" />
		<table>
			<tr><th>Pavadinimas</th><th>Ilgis</th><th>Plotis</th><th>Plotas</th><th>Kaina, Lt/m²</th><th>Kaina, Lt</th><th>Nuomojama nuo</th><th>Nuomojama iki</th><th>Telpa žmonių</th></tr>
			<?php
			include_once "../models/area_for_rent.php";
			include_once "../helpers/row_builder.php";
			include_once "../helpers/mysql.php";
			$db = new MySQLConnector();
			$db->connect();
			$accessor = new AreaForRent();
			$areas = $accessor->filter($_GET);
			$db->disconnect();
			foreach ($areas as $area) {
				$href = "./area_for_rent_add?id=".$area->id;
				$title = $area->title;
				$length = $area->length;
				$width = $area->width;
				$size = $length * $width;
				$unit_price = $area->price;
				$price = $unit_price * $size;
				$rent_from = $area->available_from;
				$rent_to = $area->available_to;
				$capacity = $area->capacity;
				$params = array($title, $length, $width, $size, $unit_price, $price, $rent_from, $rent_to, $capacity);
				$builder = new RowBuilder($params, $href);
				echo "<tr>" . $builder->build() . "</tr>";
			}
			?>
		</table>
	</body>
</html>