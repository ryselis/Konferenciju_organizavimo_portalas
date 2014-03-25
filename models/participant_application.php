<?php
require_once "base.php";
class ParticipantApplication extends Base{
	public $id;
	public $user;
	public $conference_section;
	
	public $tablename = "participant_application";
	public $classname = "ParticipantApplication";
	
	public $non_string_fields = array('user', 'conference_section');
}
?>