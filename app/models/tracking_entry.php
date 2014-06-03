<?php
class TrackingEntry extends AppModel {

	var $name = 'TrackingEntry';
	var $primaryKey = 'tracking_entry_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'TrackingArea' => array('className' => 'TrackingArea',
								'foreignKey' => 'tracking_area_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'TrackingTask' => array('className' => 'TrackingTask',
								'foreignKey' => 'tracking_task_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'TrackingRelease' => array('className' => 'TrackingRelease',
								'foreignKey' => 'tracking_release_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'TrackingVisit' => array('className' => 'TrackingVisit',
								'foreignKey' => 'tracking_visit_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>