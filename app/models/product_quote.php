<?php
class ProductQuote extends AppModel {

	var $name = 'ProductQuote';
	var $primaryKey = 'product_quote_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Product' => array('className' => 'Product',
								'foreignKey' => 'product_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Quote' => array('className' => 'Quote',
								'foreignKey' => 'quote_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>
