<?php
class Stamp extends AppModel {

	var $name = 'Stamp';
	var $useTable = 'stamp';
	var $primaryKey = 'stampID';

	var $hasOne = array(
		'StampSurcharge'=>array(
			'foreignKey'=>'stamp_id',
		),
	);
	var $hasMany = array(
		'BrowseLink'=>array(
			'foreignKey'=>'stamp_id',
		),
	);

	/*
	var $hasMany = array(
		'RecRibbon'=>array(
			'foreignKey'=>"catalog_number",
			'conditions'=>'RecRibbon.Catalog_Number = Stamp.catalog_number'
		),
		'RecCharm'=>array(
			'foreignKey'=>"catalog_number",
			'conditions'=>'RecCharm.Catalog_Number = Stamp.catalog_number'
		),
		'RecBorder'=>array(
			'foreignKey'=>"catalog_number",
			'conditions'=>'RecBorder.Catalog_Number = Stamp.catalog_number'
		),
		'RecTassel'=>array(
			'foreignKey'=>false,
			'foreignKey'=>false,
			'conditions'=>'RecTassel.Catalog_Number = Stamp.catalog_number'
		),
	);
	*/
	#
	var $hasAndBelongsToMany = array(
		'Ribbon'=>array(
			'className'=>'Ribbon',
			'joinTable'=>'rec_ribbon',
			'foreignKey'=>'stamp_id',
			'associationForeignKey'=>'ribbon_id',
		),
		'Charm'=>array(
			'className'=>'Charm',
			'joinTable'=>'rec_charm',
			'foreignKey'=>'stamp_id',
			'associationForeignKey'=>'charm_id',
		),
		'Tassel'=>array(
			'className'=>'Tassel',
			'joinTable'=>'rec_tassel',
			'foreignKey'=>'stamp_id',
			'associationForeignKey'=>'tassel_id',
		),
		'Border'=>array(
			'className'=>'Border',
			'joinTable'=>'rec_border',
			'foreignKey'=>'stamp_id',
			'associationForeignKey'=>'border_id',
		),
		'Quote'=>array(
			'className'=>'Quote',
			'joinTable'=>'rec_quote',
			'foreignKey'=>'stamp_id',
			'associationForeignKey'=>'quote_id',
		),
		'GalleryCategory'=>array(
			'className'=>'GalleryCategory',
			'joinTable'=>'browse_link',
			'foreignKey'=>'stamp_id',
			'associationForeignKey'=>'browse_node_id',
		),
	);

}
?>
