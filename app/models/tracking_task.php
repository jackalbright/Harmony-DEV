<?php
class TrackingTask extends AppModel {

	var $name = 'TrackingTask';
	var $primaryKey = 'tracking_task_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'TrackingArea' => array('className' => 'TrackingArea',
								'foreignKey' => 'tracking_area_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>