<?php
include_once 'base.php';

class User extends Base {
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $email_address;
	public $phone_number;
	public $user_group;
	public $classname = "User";
	public $tablename = 'user';
}


?>