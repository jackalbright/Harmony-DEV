<?php
class ProductOption extends AppModel {

	var $name = 'ProductOption';
	var $primaryKey = 'product_option_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			#'Product' => array('className' => 'Product',
			#					'foreignKey' => 'product_type_id',
			#					'conditions' => '',
			#					'fields' => '',
			#					'order' => ''
			#)
	);

	var $hasMany = array(
			'ProductFeature' => array('className' => 'ProductFeature',
								'foreignKey' => 'product_option_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

}
?>
