<?php
class TrackingVisit extends AppModel {

	var $name = 'TrackingVisit';
	var $primaryKey = 'tracking_visit_id';

	function get_latest_record($session_id)
	{
		$visit = $this->find("first", array("conditions"=>" TrackingVisit.session_id = '$session_id' ", 'recursive'=>1, 'order'=>'TrackingVisit.session_end DESC'));
		return $visit;
	}

	function get_latest($session_id)
	{
		$visit = $this->get_latest_record($session_id);
		return !empty($visit['TrackingVisit']) ? $visit['TrackingVisit']['tracking_visit_id'] : null;
	}

	function did_goal($goal)
	{
		$internal_ips = Configure::read("internal_ips");
		if(in_array($_SERVER['REMOTE_ADDR'], $internal_ips)) { return; }
		
		$session_id = session_id();
		$visit = $this->get_latest_record($session_id);
		if(empty($visit)) { return; } # Internal...
		$this->id = $visit['TrackingVisit']['tracking_visit_id'];
		$this->saveField("did_$goal", 1);
	}

}

?>
