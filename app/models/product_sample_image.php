<?php
class ProductSampleImage extends AppModel {

	var $name = 'ProductSampleImage';
	var $useTable = 'product_sample_images';
	var $primaryKey = 'product_image_id';

	var $belongsTo = array(
		#'Product' => array('className' => 'Product',
		#	'foreignKey' => 'product_type_id',
		#),
	);

}
?>
