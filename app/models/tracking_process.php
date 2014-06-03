<?php
class TrackingProcess extends AppModel {

	var $name = 'TrackingProcess';
	var $primaryKey = 'tracking_process_id';

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
			)
	);

	var $hasMany = array(
			'TrackingTaskStep' => array('className' => 'TrackingTaskStep',
								'foreignKey' => 'tracking_process_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

}
?>