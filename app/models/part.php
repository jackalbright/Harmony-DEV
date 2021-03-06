<?php
class Part extends AppModel {

	var $name = 'Part';
	var $primaryKey = 'part_id';
	var $useTable = "part_type";
	var $displayField = 'part_name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'ProductParts' => array('className' => 'ProductPart', # One for each max quantity...
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
			'PartPricing'=>array('className'=>'PartPricing',
				'order'=>'quantity ASC'
			)
	);

}
?>
