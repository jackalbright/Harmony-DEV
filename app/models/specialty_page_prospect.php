<?php
class SpecialtyPageProspect extends AppModel {

	var $name = 'SpecialtyPageProspect';
	var $primaryKey = 'specialty_page_prospects_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'SpecialtyPage' => array('className' => 'SpecialtyPage',
								'foreignKey' => 'specialty_page_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Sample1' =>array(
				'className'=>'Product',
				'foreignKey'=>"sample1"
			),
			'Sample2' =>array(
				'className'=>'Product',
				'foreignKey'=>"sample2"
			),
			'Sample3' =>array(
				'className'=>'Product',
				'foreignKey'=>"sample3"
			),
			'Product' =>array(
				'foreignKey'=>"product_type_id"
			),
			'PurchaseOrder' =>array(
				'foreignKey'=>"purchase_order_id"
			),
	);

}
?>
