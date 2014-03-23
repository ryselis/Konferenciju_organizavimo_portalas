<?php
class Base {
	public function __construct($POST = null) {
		if ($POST != null) {
			$reflected = get_class_vars($this -> classname);
			foreach ($reflected as $key => $value) {
				if (isset($POST[$key])) {
					$this -> $key = $POST[$key];
				}
			}
		}
	}

	public function save() {
		$update = isset($this -> id);
		if ($update) {
			return $this -> update();
		} else {
			return $this -> save_new();
		}
	}

	private function save_new() {
		$reflected = get_class_vars($this -> classname);
		$query = "INSERT INTO `" . $this -> tablename . "` (";
		$first_iter = true;
		foreach ($reflected as $key => $value) {
			if ($key == 'classname' || $key == 'tablename' || $key == 'non_string_fields' || $key == "id") {
				continue;
			}
			if ($first_iter) {
				$first_iter = false;
			} else {
				$query .= ", ";
			}
			$query .= "" . $key;
		}
		$query .= ") VALUES (";
		$first_iter = true;
		foreach ($reflected as $key => $value) {
			if ($key == 'classname' || $key == 'tablename' || $key == 'non_string_fields' || $key == "id") {
				continue;
			}
			if ($first_iter) {
				$first_iter = false;
			} else {
				$query .= ", ";
			}
			if (isset($this -> $key)) {
				if (isset($this -> non_string_fields) && in_array($key, $this -> non_string_fields)) {
					$query .= $this -> $key;
				} else {
					$query .= "'" . $this -> $key . "'";
				}
			}
		}
		$query .= ");";
		var_dump($query);
		$res = mysql_query($query);
		echo mysql_error();
		return $res;
	}

	private function update() {
		$reflected = get_class_vars($this -> classname);
		$query = "UPDATE `" . $this -> tablename . "` SET ";
		$first_iter = true;
		foreach ($reflected as $key => $value) {
			if ($key == 'classname' || $key == 'tablename' || $key == 'non_string_fields') {
				continue;
			}
			if (!$first_iter) {
				$query .= ", ";
			} else {
				$first_iter = !$first_iter;
			}
			$query .= $key . ' = ';
			if (isset($this -> non_string_fields) && in_array($key, $this -> non_string_fields)) {
				$query .= $this->$key;
			} else {
				$query .= "'" . $this->$key . "'";
			}
		}
		$query .= " WHERE id = " . $this->id . ";";
		mysql_query($query);
		echo $query;
	}

	private function magic() {
		if (func_num_args() == 2 || func_num_args() == 3) {
			$obj = func_get_arg(0);
			$key = func_get_arg(1);
			if (func_num_args() == 3)
				return $obj -> $key = func_get_arg(2);
			else
				return $obj -> $key;
		} else
			throw new Exception('Function requires 2 or 3 arguments!');
	}

	public function filter($filter_keys) {
		$query = "SELECT ";
		$reflected = get_class_vars($this -> classname);
		$first_iter = true;
		foreach ($reflected as $key => $value) {
			if ($key == 'classname' || $key == 'tablename' || $key == 'non_string_fields') {
				continue;
			}
			if (!$first_iter) {
				$query .= ", ";
			} else {
				!$first_iter = false;
			}
			$query .= $key;
		}
		$query .= " FROM `" . $this -> tablename . "`";
		if (count($filter_keys) > 0) {
			$query .= " WHERE ";
		}
		$first_iter = true;
		foreach ($filter_keys as $key => $value) {
			if (!$first_iter) {
				$query .= " AND ";
			} else {
				$first_iter = !$first_iter;
			}
			
			
			if (substr_compare($key, "gte", -3, 3) === 0){
				$cmp= ' >= ';
				$key = str_replace("gte", "", $key);
			} elseif (substr_compare($key, "lte", -3, 3) === 0){
				$cmp = ' <= ';
				$key = str_replace("lte", "", $key);
			} else {
				$cmp = ' = ';
			}
			if (isset($this->non_string_fields) && in_array($key, $this->non_string_fields)){
				$sep = "";
			}
			else {
				$sep = '"';
			}
			$query .= $key . $cmp . $sep . $value . $sep . " ";
		}
		$query .= ";";
		$result = mysql_query($query);
		if (!$result){
			var_dump($query);
			echo mysql_error();
		}
		$filtered_values = array();
		while ($row = mysql_fetch_array($result)) {
			$obj = new $this->classname();
			foreach ($reflected as $key => $value) {
				if ($key == 'classname' || $key == 'tablename' || $key == 'non_string_fields') {
					continue;
				}
				$this -> magic($obj, $key, $row[$key]);
			}
			$filtered_values[] = $obj;
		}
		return $filtered_values;
	}

	public function delete(){
		$query = "DELETE FROM `" . $this->tablename ."` WHERE id=" . $this->id . ";";
		mysql_query($query);
		$this->id = null;
	}

}
?>
