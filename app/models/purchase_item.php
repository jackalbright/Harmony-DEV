<?php
class PurchaseItem extends AppModel {

	var $name = 'PurchaseItem';
	var $primaryKey = 'purchase_item_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Purchase' => array('className' => 'Purchase',
								'foreignKey' => 'purchase_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Product' => array('className' => 'Product',
								'foreignKey' => 'product_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>
