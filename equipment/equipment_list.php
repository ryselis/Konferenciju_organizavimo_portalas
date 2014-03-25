<?php
session_start();
?>
<html>
	<meta charset="UTF-8">
	<head>
		<link rel="stylesheet" href="../css/base.css"/>
		<title> Esama įranga </title>
	</head>
	<body>
		<?php
		include ("../templates/menu.php");
		?>
		<input type="button" name="add_new" value="Pridėti" onclick="document.location.href='./equipment_add.php';" />
		<table>
			<tr>
				<th>Pavadinimas</th><th>Kaina</th>
			</tr>
			<?php
			include_once "../models/equipment.php";
			include_once "../helpers/row_builder.php";
			include_once "../helpers/mysql.php";
			$db = new MySQLConnector();
			$db -> connect();
			$accessor = new Equipment();
			$equipments = $accessor -> filter($_GET);
			$db -> disconnect();
			foreach ($equipments as $equipment) {
				$href = "./equipment_add?id=" . $equipment -> id;
				$title = $equipment -> title;
				$price = $equipment -> price;
				$params = array($title, $price);
				$builder = new RowBuilder($params, $href);
				echo "<tr>" . $builder -> build() . "</tr>";
			}
			?>
		</table>
	</body>
</html>