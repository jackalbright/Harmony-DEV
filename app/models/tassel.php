<?php
class Tassel extends AppModel {

	var $name = 'Tassel';
	var $useTable = 'tassel';
	var $primaryKey = 'tassel_id';
	var $displayField = "color_name";
	var $order = 'Tassel.color_name ASC';

	var $hasMany = array(
	);

	var $hasOne = array(
	);

}
?>
