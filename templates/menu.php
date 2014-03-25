<div class="menu">
	<div>
		<a href="/konferencijos/schedule/schedule.php"> Užimtumo tvarkaraštis</a>
	</div>
	<?php
	include_once "../models/user_group.php";
	if ($_SESSION['user_group'] != UserGroup::participant()): ?>
	<div >
		<a href="/konferencijos/area_for_rent/area_for_rent_list.php"> Patalpų nuoma </a>
	</div>
	<?php endif; ?>
	<div>
		<a href="/konferencijos/application/application_list.php"> Konferencijos </a>
	</div>
	<?php
	if ($_SESSION['user_group'] == UserGroup::participant()): ?>
	<div>
		<a href="/konferencijos/participant_applications/participant_application_list.php"> Dalyvio paraiškos </a>
	</div>
	<?php endif; ?>
	<?php
	if ($_SESSION['user_group'] == UserGroup::admin()): ?>
	<div>
		<a href="/konferencijos/equipment/equipment_list.php">Papildoma įranga</a>
	</div>
	<?php endif; ?>
	<div class="username">
		Sveiki, <?php echo $_SESSION["username"]; ?>
	</div>
	<div>
		<a href="/konferencijos/logout.php"> Atsijungti </a>
	</div>
</div>
<div><img src="/konferencijos/img/logo2.png" width="137px" height="79px" /></div>
