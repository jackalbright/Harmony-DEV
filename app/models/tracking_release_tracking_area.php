<?php
class TrackingReleaseTrackingArea extends AppModel {

	var $name = 'TrackingReleaseTrackingArea';
	var $primaryKey = 'tracking_release_tracking_area_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'TrackingRelease' => array('className' => 'TrackingRelease',
								'foreignKey' => 'tracking_release_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'TrackingArea' => array('className' => 'TrackingArea',
								'foreignKey' => 'tracking_area_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>