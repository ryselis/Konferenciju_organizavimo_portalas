<?php
session_start();
if (isset($_GET['id'])) {
	include_once "../helpers/mysql.php";
	include_once "../models/conference_application.php";
	$db = new MySQLConnector();
	$db -> connect();
	$accessor = new ConferenceApplication();
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
	<script type="text/javascript" src="../js/application.js"></script>
		<title>Pridėti paraišką konferencijai</title>
	</head>
	<body>
		<?php
		include ("../templates/menu.php");
		?>
			<div>
				<label> Pavadinimas </label>
				<span> <?php
				echo $object -> title;
					?></span>
			</div>
			<div>
				<label> Nuomoti nuo </label>
				<span> <?php
				echo $object -> rent_from;
					?></span>
			</div>
			<div>
				<label> Nuomoti iki </label>
				<span> <?php
				echo $object -> rent_to;
					?></span>
			</div>
			<div>
				<label> Aprašymas </label>
				<span>
				<?php
				echo $object -> description
				?>
				</span>
			</div>
			<div>
				<label> Patvirtinta </label>
				<span>
				<?php
				$ans = $object ->is_confirmed ? "taio" : "ne";
				echo $ans; 
				?>
				</span>
			</div>
			<div>
				Nuomojamos patalpos
			</div>
			<?php
			if ($object != null) {
				include_once "../models/conference_application__area_for_rent.php";
				include_once "../models/area_for_rent.php";
				$db = new MySQLConnector();
				$db -> connect();
				$accessor = new ConferenceApplicationAreaForRent();
				$items = $accessor -> filter(array("conference_application" => $object -> id));
				foreach ($items as $item) {
					$accessor = new AreaForRent();
					$areas = $accessor -> filter(array("id" => $item -> area_for_rent));
					$area = $areas[0];
					$html = "<div>" . $area -> title . "<div>";
					echo $html;
				}
				$db -> disconnect();
			}
			?>
			<?php
			if (!$object->is_confirmed){
				echo '<input type="button" onclick="confirmApplication('. $_GET['id']. '" value="Patvirtinti" />';
			}
			?>
	</body>
</html>