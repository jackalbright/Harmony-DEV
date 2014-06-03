<?php
class CompletedImage extends AppModel {
	var $name = 'CompletedImage';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $order = 'CompletedImage.id DESC';

	var $actsAs = array('Upload');//=>array('required'=>true));

	var $belongsTo = array(
		'CompletedProject' => array(
			'className' => 'CompletedProject',
			'foreignKey' => 'completed_project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
