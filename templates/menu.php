<body>
	<a href="../schedule/schedule.php"> Užimtumo tvarkaraštis</a>
	<a href="../area_for_rent/area_for_rent_list.php"> Patalpų nuoma </a>
	<a href="../application/application_list.php"> Paraiškos </a>
	<a> Mano info </a>
	<div>
		<?php echo $_SESSION["username"]; ?>
	</div>
	<a href="/konferencijos/logout.php"> Atsijungti </a>
</body>