<?php
class TrackingArea extends AppModel {

	var $name = 'TrackingArea';
	var $primaryKey = 'tracking_area_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'TrackingTask' => array('className' => 'TrackingTask',
								'foreignKey' => 'tracking_area_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => 'TrackingTask.sort_index ASC',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

}
?>
