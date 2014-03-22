<?php
require_once "base.php";
class AreaForRent extends Base{
	public $id;
	public $title;
	public $width;
	public $length;
	public $price;
	public $available_from;
	public $available_to;
	public $capacity;
	
	public $tablename = "area_for_rent";
	public $classname = "AreaForRent";
	
	public $non_string_fields = array('width', 'length', 'price', 'capacity');
}
?>