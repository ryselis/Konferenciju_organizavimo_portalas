function pick(area_id, app_id) {
	var title = prompt("Įveskite konferencijos sekcijos pavadinimą");
	document.location.href = '../application/add_area_for_rent.php?area_id=' + area_id + '&app_id=' + app_id + "&title=" + title;
}
