<?php
class Ribbon extends AppModel {

	var $name = 'Ribbon';
	var $useTable = 'ribbon';
	var $primaryKey = 'ribbon_id';
	var $displayField = "color_name";
	var $order = 'Ribbon.color_name ASC';

}
?>
