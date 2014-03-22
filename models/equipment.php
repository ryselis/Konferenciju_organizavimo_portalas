<?php
require_once "base.php";
class Equipment extends Base{
	public $id;
	public $title;
	public $price;
	public $area_for_rent;
	
	public $tablename = "equipment";
	public $classname = "Equipment";
	
}
?>