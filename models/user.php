<?php
class User {
	private $username;
	private $password;
	private $first_name;
	private $last_name;
	private $email_address;
	private $phone_number;
	private $user_group;

	public function __construct($POST) {
		$reflected = get_class_vars("User");
		foreach ($reflected as $key => $value) {
			$this -> $key = $POST[$key];
			var_dump($this->$key);
		}
	}

	public function save() {
		if (isset($this -> id)) {
			$query = "UPDATE ";
		} else {
			$reflected = get_class_vars("User");
			$query = "INSERT INTO `users` (";
			foreach ($reflected as $key => $value) {
				var_dump($key);
				$query .= "`" . $key . "`, ";
			}
			$query .= ") VALUES (";
			foreach ($reflected as $key => $value) {
				var_dump($this->{$key});
				if (isset($this -> $key)) {
					$query .= "`" . $this -> $key . "`, ";
				}
			}
			$test = "username";
			
			$query .= ")";
			var_dump($query);
			var_dump( $this->magic($this, $test));
		}
	}
	
	private function magic(){
		if(func_num_args() == 2 || func_num_args() == 3){
			$obj = func_get_arg(0);
			$key = func_get_arg(1);
			if(func_num_args() == 3)
				return $obj->$key = func_get_arg(2);
			else
				return $obj->$key;
		}else
			throw new Exception('Function requires 2 or 3 arguments!');
	}

}


?>