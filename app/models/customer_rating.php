<?php
class CustomerRating extends AppModel {

	var $name = 'CustomerRating';
	var $primaryKey = 'customer_rating_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'CustomerType' => array('className' => 'CustomerType',
								'foreignKey' => 'customer_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasAndBelongsToMany = array(
			'Product' => array('className' => 'Product',
						'joinTable' => 'product_customer_ratings',
						'foreignKey' => 'customer_rating_id',
						'associationForeignKey' => 'product_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			)
	);

}
?>