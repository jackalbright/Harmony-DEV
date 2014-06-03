<?php
class SampleRequestProductType extends AppModel {

	var $name = 'SampleRequestProductType';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'SampleRequest' => array(
			'className' => 'SampleRequest',
			'foreignKey' => 'sample_request_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>
