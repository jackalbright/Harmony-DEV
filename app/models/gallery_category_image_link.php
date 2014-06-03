<?php
class GalleryCategoryImageLink extends AppModel {

	var $name = 'GalleryCategoryImageLink';
	var $useTable = 'browse_link';
	var $primaryKey = 'browse_link_id';

	var $belongsTo = array(
		'GalleryImage'=>array(
			'className'=>'GalleryImage',
			'foreignKey'=>'stamp_id',
			#'foreignKey'=>false,
			#'conditions'=>array('GalleryCategoryImageLink.catalog_number = GalleryImage.catalog_number'),
			#'conditions'=>array('GalleryCategoryImageLink.catalog_number = GalleryImage.catalog_number', 'GalleryImage.catalog_number IS NOT NULL'),
		),

	);

}
?>
