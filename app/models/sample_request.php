<?php
class SampleRequest extends AppModel {

	var $name = 'SampleRequest';
	var $order = "id DESC";

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $XXXbelongsTo = array(
		'XXXProduct' => array(
			'className' => 'Product',
			'foreignKey' => 'product_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'SampleRequestProductType'=>array(
			'className'=>'SampleRequestProductType',
			'foreignKey'=>'sample_request_id',
		),
	);

	var $hasAndBelongsToMany = array(
		 'Product' => array(
		 	'className' => 'Product', 
			'joinTable' => 'sample_request_product_types', 
			'foreignKey' => 'sample_request_id',
		       	'associationForeignKey' => 'product_type_id', 
		),


	);

}
?>
