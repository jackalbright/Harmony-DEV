<?php
class WorkRequest extends AppModel {

	var $name = 'WorkRequest';
	var $primaryKey = 'work_request_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Product' => array('className' => 'Product',
								'foreignKey' => 'product_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'CreditCard' => array('className' => 'CreditCard',
								'foreignKey' => 'credit_card_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'BillingAddress' => array('className' => 'ContactInfo',
								'foreignKey' => 'billing_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'ShippingAddress' => array('className' => 'ContactInfo',
								'foreignKey' => 'shipping_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>
