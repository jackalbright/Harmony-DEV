<?php
class ProductFeature extends AppModel {

	var $name = 'ProductFeature';
	var $primaryKey = 'product_feature_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		/*
			'Product' => array('className' => 'Product',
								'foreignKey' => 'product_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
		*/
			'ProductOption' => array('className' => 'ProductOption',
								'foreignKey' => 'product_option_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>
