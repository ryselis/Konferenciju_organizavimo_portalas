<?php
session_start();
if (isset($_GET['id'])) {
	include_once "../helpers/mysql.php";
	include_once "../models/equipment.php";
	$db = new MySQLConnector();
	$db -> connect();
	$accessor = new Equipment();
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
			echo "Pridėti įrangą";
		} else {
			echo "Redaguoti įrangą " . $object -> title;
		}
		?></title>
	</head>
	<body>
		<?php
		include ("../templates/menu.php");
 ?>
		<form method="POST" action="./save_equipment.php<?php
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
				<label> Kaina </label>
				<input type="number" name="price" step="0.01"
				<?php
				if ($object != null) {
					echo 'value="' . $object -> price . '"';
				}
				?>
				/>
			</div>
			<input type="submit" />
		</form>
	</body>
</html>