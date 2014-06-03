<?php
class GalleryFilter extends AppModel {

	var $name = 'GalleryFilter';
	var $primaryKey = 'category_filter_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'GalleryCategory' => array('className' => 'GalleryCategory',
								'foreignKey' => 'browse_node_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'GalleryFilterKeyword' => array('className' => 'GalleryFilterKeyword',
								'foreignKey' => 'filter_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>
