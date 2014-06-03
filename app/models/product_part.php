<?php
class ProductPart extends AppModel {

	var $name = 'Part';
	var $primaryKey = 'product_part_id';
	var $useTable = "product_part";

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Product' => array('className' => 'Product', # One for each max quantity...
								'foreignKey' => 'product_type_id',
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
	var $belongsTo = array(
			'Part' => array('className' => 'Part', # One for each max quantity...
								'foreignKey' => 'part_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => 'Part.sort_index',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
	);

}
?>