<?php
include_once "base.php";
class ConferenceApplicationAreaForRent extends Base {
	public $id;
	public $conference_application;
	public $area_for_rent;

	public $tablename = "conference_application__area_for_rent";
	public $classname = "ConferenceApplicationAreaForRent";

	public $non_string_fields = array("conference_application", "area_for_rent");
}
?>