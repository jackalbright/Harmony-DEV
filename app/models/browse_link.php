<?php
class BrowseLink extends AppModel {

	var $name = 'BrowseLink';
	var $useTable = 'browse_link';
	var $primaryKey = 'browse_link_id';

	var $hasOne = array(
		'GalleryImage'=>array(
			'className'=>'GalleryImage',
			'foreignKey'=>'stampID',
			#'foreignKey'=>false,
			#'conditions'=>array('GalleryCategoryImageLink.catalog_number = GalleryImage.catalog_number'),
			#'conditions'=>array('GalleryCategoryImageLink.catalog_number = GalleryImage.catalog_number', 'GalleryImage.catalog_number IS NOT NULL'),
		),

	);

}
?>
