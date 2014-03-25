<?php
session_start();
include_once "../helpers/mysql.php";
$db = new MySQLConnector();
$db -> connect();
if (isset($_GET['id'])) {
	include_once "../models/conference_application.php";
	$accessor = new ConferenceApplication();
	$objects = $accessor -> filter(array("id" => $_GET['id']));
	$object = $objects[0];

} else {
	$object = null;
}
$success = false;
if (!empty($_POST)) {
	include_once "../models/user.php";
	$accessor = new ConferenceApplication();
	$apps = $accessor -> filter(array("id" => $_GET['id']));
	$app = $apps[0];
	$app -> is_confirmed = 1;
	$app -> save();
	$accessor = new User();
	$user = $accessor -> filter(array('id' => $_SESSION['user_id']));
	$user = $user[0];
	$text = file_get_contents("../misc/email_template");
	$success = "Konferencijos prašymas patvirtintas";
	mail($user -> email_address, 'Paraiškos patvirtinimas', $text);
}
$db -> disconnect();
?>
<html>
	<meta charset="UTF-8">
	<head>
	<script type="text/javascript" src="../js/application.js"></script>
	<link rel="stylesheet" href="../css/base.css"/>
		<title>Paraiška</title>
	</head>
	<body>
		<?php
		include ("../templates/menu.php");
		?>
		<?php
		if ($success) {
			echo '<div class="success" >' . $success . '</div>';
		}
		?>
			<h1>Konferencija „<?php echo $object -> title; ?>“</h1>
			<div>
				<label> Pradžia </label>
				<span> <?php
				echo $object -> rent_from;
					?></span>
			</div>
			<div>
				<label> Pabaiga </label>
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
			<?php
			include_once "../models/user_group.php";
			if ($_SESSION['user_group'] == UserGroup::admin()): ?>
			<div>
				<label> Patvirtinta </label>
				<span><img src="
				<?php
				$ans = $object -> is_confirmed ? "https://cdn1.iconfinder.com/data/icons/musthave/256/Check.png" : "http://icons.iconarchive.com/icons/kyo-tux/phuzion/256/Sign-Error-icon.png";
				echo $ans;
				?>" height="15" width="15" />
				</span>
			</div>
			<?php endif; ?>
			<h2>
				Konferencijos sekcijos
			</h2>
			<?php
			if ($object != null) {
				include_once "../models/conference_application__area_for_rent.php";
				include_once "../models/area_for_rent.php";
				include_once "../models/participant_application.php";
				$db = new MySQLConnector();
				$db -> connect();
				$accessor = new ConferenceApplicationAreaForRent();
				$items = $accessor -> filter(array("conference_application" => $object -> id));
				foreach ($items as $item) {
					$accessor = new AreaForRent();
					$areas = $accessor -> filter(array("id" => $item -> area_for_rent));
					$area = $areas[0];
					$html = "<div>" . $item -> title . " (" . $area -> title . ")";
					if ($_SESSION['user_group'] == UserGroup::participant()) {
						$accessor = new ParticipantApplication();
						$apps = $accessor -> filter(array("conference_Section" => $item -> id));
						if (count($apps) < intval($area -> capacity)) {
							$html .= ' <a href="register.php?id=' . $item -> id . '">Registruotis</a>';
						}
					}
					$html .= '<div>';

					echo $html;

				}
				if (count($items) == 0) {
					$html = '<div>Nėra</div>';
					echo $html;
				}
				$db -> disconnect();
			}
			?>
			<form method="POST" action="">
			<?php
			if (!$object -> is_confirmed && $_SESSION['user_group'] == UserGroup::admin()) {
				echo '<input type="submit" value="Patvirtinti" name="submit" />';
			}
			?>
			</form>
	</body>
</html>