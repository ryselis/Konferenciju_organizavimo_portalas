<?php
class Base{
	public function __construct($POST=null) {
		if ($POST != null){
		$reflected = get_class_vars("User");
			foreach ($reflected as $key => $value) {
				if (isset($POST[$key])){
					$this -> $key = $POST[$key];
				}
			}
		}
	}

	public function save() {
		if (isset($this -> id)) {
			$query = "UPDATE ";
		} else {
			$reflected = get_class_vars($this->classname);
			$query = "INSERT INTO `".$this->tablename."` (";
			$first_iter = true;
			foreach ($reflected as $key => $value) {
				if ($key == 'classname' || $key == 'tablename'){
					continue;
				}
				if ($first_iter){
					$first_iter = false;
				}
				else{
					$query .= ", ";
				}
				$query .= "" . $key;
			}
			$query .= ") VALUES (";
			$first_iter = true;
			foreach ($reflected as $key => $value) {
				if ($key == 'classname' || $key == 'tablename'){
					continue;
				}
				if ($first_iter){
					$first_iter = false;
				}
				else{
					$query .= ", ";
				}
				if (isset($this -> $key)) {
					$query .= "'" . $this -> $key . "'";
				}
			}
			$query .= ");";
			return mysql_query($query);
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
	
	public function filter($filter_keys){
		$query = "SELECT ";
		$reflected = get_class_vars($this->classname);
		$first_iter = true;
		foreach ($reflected as $key => $value) {
			if ($key == 'classname' || $key == 'tablename'){
				continue;
			}
			if (!$first_iter){
				$query .= ", ";
			}
			else{
				!$first_iter = false;
			}
			$query .= $key;
		}
		$query .= " FROM `" . $this->tablename . "` WHERE ";
		$first_iter = true;
		foreach ($filter_keys as $key => $value) {
			if (!$first_iter){
				$query .= " AND ";
			}
			else{
				$first_iter = !$first_iter;
			}
			$query .= $key . ' = "' . $value . '" ';
		}
		$query .= ";";
		$result = mysql_query($query);
		$filtered_values = array();
		while ($row = mysql_fetch_array($result)){
			$obj = new $this->classname();
			foreach ($reflected as $key => $value) {
				if ($key == 'classname' || $key == 'tablename'){
					continue;
				}
				$this->magic($obj, $key, $row[$key]);
			}
			$filtered_values[] = $obj;
		}
		return $filtered_values;
	}
}
?>
