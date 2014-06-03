<?php
class TrackingTaskStep extends AppModel {

	var $name = 'TrackingTaskStep';
	var $primaryKey = 'tracking_task_step_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'TrackingProcess' => array('className' => 'TrackingProcess',
								'foreignKey' => 'tracking_process_id',
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
			'TrackingNextTask' => array('className' => 'TrackingNextTask',
								'foreignKey' => 'tracking_next_task_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>