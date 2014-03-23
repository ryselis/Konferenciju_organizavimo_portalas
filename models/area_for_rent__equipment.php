<?php
require_once "base.php";
class AreaForRentEquipment extends Base{
	public $id;
	public $area;
	public $equipment;
	
	public $tablename = "equipment__area_for_rent";
	public $classname = "AreaForRentEquipment";
	
	public $non_string_fields = array("area", "equipment");
	
}
?>