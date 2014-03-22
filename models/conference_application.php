<?php
require_once "base.php";
class ConferenceApplication extends Base{
	public $id;
	public $user;
	public $is_confirmed;
	public $rent_from;
	public $rent_to;
	public $title;
	public $description;
	
	public $tablename = "conference_application";
	public $classname = "ConferenceApplication";
	
	public $non_string_fields = array('is_confirmed', 'user');
}
?>