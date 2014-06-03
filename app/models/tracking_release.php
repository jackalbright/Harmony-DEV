<?php
class TrackingRelease extends AppModel {

	var $name = 'TrackingRelease';
	var $primaryKey = 'tracking_release_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'TrackingReleaseTrackingArea' => array('className' => 'TrackingReleaseTrackingArea',
								'foreignKey' => 'tracking_release_id',
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

	var $hasAndBelongsToMany = array(
			'TrackingArea' => array('className' => 'TrackingArea',
						'joinTable' => 'tracking_release_tracking_areas',
						'foreignKey' => 'tracking_release_id',
						'associationForeignKey' => 'tracking_area_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			)
	);

	function get_latest($area_id, $task_id = null)
	{
		$release = $this->TrackingReleaseTrackingArea->find("first", array("conditions"=>" TrackingReleaseTrackingArea.tracking_area_id = '$area_id' ", 'recursive'=>2, 'order'=>'tracking_release_tracking_area_id DESC'));
		return !empty($release['TrackingReleaseTrackingArea']) ? $release['TrackingReleaseTrackingArea']['tracking_release_id'] : null;
	}

}
?>
