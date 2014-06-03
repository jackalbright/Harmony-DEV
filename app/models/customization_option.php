<?php
class CustomizationOption extends AppModel {

	var $name = 'CustomizationOption';
	var $useTable = "part_type";
	var $primaryKey = 'part_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasAndBelongsToMany = array(
			'Product' => array('className' => 'Product',
						'joinTable' => 'product_part',
						'foreignKey' => 'part_id',
						'associationForeignKey' => 'product_type_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			),
	);
	var $hasMany = array(
			'ProductParts' => array('className' => 'ProductPart',
						'foreignKey' => 'part_id',
						'dependent' => false,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'exclusive' => '',
						'finderQuery' => '',
						'counterQuery' => ''
			),
	);

}
?>
