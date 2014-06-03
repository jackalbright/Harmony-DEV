<?php
class ImageRecommendedQuote extends AppModel {

	var $name = 'ImageRecommendedQuote';
	var $useTable = 'rec_quote';
	var $primaryKey = 'rec_quote_id';
	var $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	#var $hasMany = array(
	#		'GalleryImages' => array('className' => 'GalleryImage',
	#							'foreignKey' => false,
	#							'conditions' => 'GalleryImages.catalog_number = ImageRecommendedQuote.catalog_number',
	#							'dependent' => false,
	#							'conditions' => '',
	#							'fields' => '',
	#							'order' => '',
	#							'limit' => '',
	#							'offset' => '',
	#							'exclusive' => '',
	#							'finderQuery' => '',
	#							'counterQuery' => ''
	#		),
	#);
	var $belongsTo = array(
			'Quote' => array('className' => 'Quote',
								'foreignKey' => 'quote_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

}
?>
