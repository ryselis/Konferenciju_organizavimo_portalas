<?php
session_start();

$error = false;
$success = false;
if (!empty($_POST)) {
	if ($_POST['title'] && $_POST['price']) {
		include_once "../helpers/mysql.php";
		include_once "../models/equipment.php";
		$mysql = new MySQLConnector();
		$mysql -> connect();
		$application = new Equipment($_POST);
		if (isset($_GET['id'])) {
			$application -> id = $_GET['id'];
		}
		$application -> save();
		$mysql -> disconnect();
		$success = "Išsaugota";
	} else {
		$error = "Užpildykite visus laukus";
	}
}
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
		<link rel="stylesheet" href="../css/base.css"/>
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