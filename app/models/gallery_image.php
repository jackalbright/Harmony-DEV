<?php
class GalleryImage extends AppModel {

	var $name = 'GalleryImage';
	var $useTable = 'stamp';
	var $primaryKey = 'stampID';
	#var $uses  = array("GalleryImage", "Product");

	#var $belongsTo = array(
	var $hasAndBelongsToMany = array(
		'GalleryCategories'=>array(
			'className'=>'GalleryCategory',
			'joinTable'=>'browse_link',
			'associationForeignKey'=>'browse_node_id',
			'foreignKey'=>'catalog_number',
		),
	);

	var $hasOne = array(
		'StampSurcharge'=>array(
			'foriegnKey'=>'stamp_id',
			#'foreignKey'=>false,
			#'conditions'=>' GalleryImage.catalog_number = StampSurcharge.catalog_number ',
		),
	);

	#var $hasAndBelongsToMany = array( );

	function get_surcharge($catalog_number)
	{
		$configModel = $this->get_model("Config");
		$base_stamp_surcharge = $configModel->field("value", array('name'=>'base_stamp_surcharge'));
		$surcharge = !empty($base_stamp_surcharge) ? $base_stamp_surcharge : 0;
		$stamp_surcharge = $this->StampSurcharge->field("surcharge", array("catalog_number"=>$catalog_number));
		if(!empty($stamp_surcharge))
		{
			$surcharge += $stamp_surcharge;
		}
		return $surcharge;
	}
}
?>
