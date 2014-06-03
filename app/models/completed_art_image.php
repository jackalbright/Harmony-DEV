<?php
class CompletedArtImage extends AppModel {

	var $name = 'CompletedArtImage';
	var $order = 'CompletedArtImage.id DESC';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>
