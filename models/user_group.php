<?php
class UserGroup extends Base{
	public $title;
	public $id;
	public $system_key;
	public $classname = "UserGroup";
	public $tablename = "user_group";
	
	public static function admin()
	{
		return 'admin';
	}
	
	public static function announcer()
	{
		return 'announcer';
	}
	
	public static function participant()
	{
		return 'participant';
	}
}
?>