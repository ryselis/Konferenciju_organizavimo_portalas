<?php
session_start();
?>
<html>
	<meta charset="UTF-8" />
	<head>
		<title> Pasirinkite paraišką </title>
		<body>
			<?php
			include ("../templates/menu.php");
			?>
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
			$app_accessor = new ConferenceApplication();
			$my_apps = $app_accessor->filter(array("user" => $_SESSION['user_id']));
			foreach($my_apps as $app){
				$available = true;
				foreach($items as $item){
					$other_apps = $app_accessor->filter(array("id" => $item->area_for_rent));
					$other_app = $other_apps[0];
					$before_start = $app->rent_from > $item->rent_from;
					$before_end = $app->rent_from > $item->rent_to;
					if ($before_end == $before_start){
						continue;
					}
					$after_start = $app->rent_to < $item->rent_from;
					$after_end = $app->rent_to < $item->rent_to;
					if ($after_end == $after_start){
						continue;	
					}
					$available = false;
				}
				if ($available){
					$html = '<div><a href="../application/add_area_for_rent.php?area_id='.$area->id .'&app_id='.$app->id.'">' . $app->title . "</a></div>";
					echo $html;
				}
			}
			$db->disconnect();
			?>
			<input type="button" value="Pridėti naują" />
			
		</body>
	</head>
</html>