<?php
session_start();
?>
<html>
	<meta charset="UTF-8" />
	<head>
		<link rel="stylesheet" type="text/css" href="../css/base.css" />
		<script type="text/javascript" src="../js/pick_application.js"></script>
		<title> Pasirinkite paraišką </title>
	</head>
		<body>
			
			<?php
			include ("../templates/menu.php");
			?>
			<h1>Pasirinkite konferencijos sekciją</h1>
			<?php
			include_once "../models/conference_application.php";
			include_once "../models/conference_application__area_for_rent.php";
			include_once "../models/area_for_rent.php";
			include_once "../helpers/mysql.php";
			$db = new MySQLConnector();
			$db->connect();
			$accessor = new AreaForRent();
			$areas = $accessor->filter(array("id" => $_GET['app_id']));
			$area = $areas[0];
			$accessor = new ConferenceApplicationAreaForRent();
			$items = $accessor->filter(array("area_for_rent" => $area->id));
			var_dump($items);
			$app_accessor = new ConferenceApplication();
			$my_apps = $app_accessor->filter(array("user" => $_SESSION['user_id']));
			foreach($my_apps as $app){
				$available = true;
				foreach($items as $item){
					$other_apps = $app_accessor->filter(array("id" => $item->area_for_rent));
					if (count($other_apps) == 0){
						continue;
					}
					$other_app = $other_apps[0];
					$before_start = $app->rent_from > $other_app->rent_from;
					$before_end = $app->rent_from > $other_app->rent_to;
					$after_start = $app->rent_to < $other_app->rent_from;
					$after_end = $app->rent_to < $other_app->rent_to;
					var_dump($app->rent_from);
					var_dump($app->rent_to);
					var_dump($other_app->rent_from);
					var_dump($other_app->rent_to);
					if ($after_end == $after_start && $before_start == $before_end){
						continue;	
					}
					$available = false;
				}
				if ($available){
					$html = '<div><a href="#" onclick="pick('.$area->id .','.$app->id.');">' . $app->title . "</a></div>";
					echo $html;
				}
			}
			$db->disconnect();
			?>			
		</body>
	
</html>