<?php
class ProductDescription extends AppModel {

	var $name = 'ProductDescription';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			#'Product' => array('className' => 'Product',
			#					'foreignKey' => 'product_type_id',
			#					'conditions' => '',
			#					'fields' => '',
			#					'order' => ''
			#)
	);
}
