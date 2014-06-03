<?php
class TrackingEntriesController extends AppController {

	var $name = 'TrackingEntries';
	var $helpers = array('Html', 'Form');
	var $uses = array('TrackingEntry','TrackingArea','TrackingTask');

	function index() {
		$this->TrackingEntry->recursive = 0;
		$this->set('trackingEntries', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TrackingEntry.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('trackingEntry', $this->TrackingEntry->read(null, $id));
	}

	function admin_area_report($areaname)
	{
		# Timeframe, default to 7 days.
		#$days = 7;
		#$finish = date('Y-m-d H:i:s',time());
		#$start = date('Y-m-d H:i:s', time() - 7*24*60*60);

		$date_start = $this->Session->read("admin.tracking_requests.date_start");
		$date_end = $this->Session->read("admin.tracking_requests.date_end");
		$start = date("Y-m-d 00:00:00", strtotime($date_start));
		$finish = date("Y-m-d 23:59:59", strtotime($date_end));

		$this->set("start", date('m/d/Y', strtotime($start)));
		$this->set("finish", date('m/d/Y', strtotime($finish)));

		$area = $this->TrackingArea->find(" url = '$areaname' ");
		$area_id = $area['TrackingArea']['tracking_area_id'];

		$exclude_internal = " AND ip_address NOT LIKE '71.225.15.%' ";

		$entries = $this->TrackingEntry->find('all', array('conditions'=>" TrackingEntry.tracking_area_id = '$area_id' $exclude_internal AND '$start' <= TrackingEntry.created AND TrackingEntry.created <= '$finish'"));

		$this->set("area", $area); # Includes tasks, to sort.

		$entries_by_task_id = array();
		$unique_entries_by_task_id = array();

		$tasks_by_session_id = array();
		$unique_total_entries = $total_entries = 0;

		foreach($entries as $entry)
		{
			$task_id = $entry['TrackingEntry']['tracking_task_id'];
			# Group by session_id so we skip them going back to page, etc...
			$session_id = $entry['TrackingEntry']['session_id'];

			if (empty($entries_by_task_id[$task_id])) { $entries_by_task_id[$task_id] = array(); }
			if (!empty($tasks_by_session_id[$task_id][$session_id])) { 
				continue;

				if (empty($unique_entries_by_task_id[$task_id])) { $unique_entries_by_task_id[$task_id] = array(); }
				$unique_entries_by_task_id[$task_id][] = $entry;
				$unique_total_entries++;
			}
			$entries_by_task_id[$task_id][] = $entry;
			$tasks_by_session_id[$task_id][$session_id] = 1;
			$total_entries++;
		}

		$this->set("total_entries", $total_entries);
		$this->set("unique_total_entries", $unique_total_entries);
		$this->set("tracking_entries", $entries_by_task_id);
		$this->set("unique_tracking_entries", $unique_entries_by_task_id);
	}

	function track_ajax($area, $task, $id = null) # So button clicks, on a page, register (finer tuned)
	{
		$this->layout = 'ajax';
		Configure::write("debug", 0);
		$params = array();
		foreach($_REQUEST as $key => $value)
		{
			if (!in_array($key, array("PHPSESSID", "url", "customerlogin")))
			{
				$params[$key] = $value;
			}
		}
		$this->track($area, $task, $params, $id);
	}

	function add() {
		if (!empty($this->data)) {
			$this->TrackingEntry->create();
			if ($this->TrackingEntry->save($this->data)) {
				$this->Session->setFlash(__('The TrackingEntry has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingEntry could not be saved. Please, try again.', true));
			}
		}
		$trackingAreas = $this->TrackingEntry->TrackingArea->find('list');
		$trackingTasks = $this->TrackingEntry->TrackingTask->find('list');
		$trackingReleases = $this->TrackingEntry->TrackingRelease->find('list');
		$trackingVisits = $this->TrackingEntry->TrackingVisit->find('list');
		$this->set(compact('trackingAreas', 'trackingTasks', 'trackingReleases', 'trackingVisits'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TrackingEntry', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TrackingEntry->save($this->data)) {
				$this->Session->setFlash(__('The TrackingEntry has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingEntry could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TrackingEntry->read(null, $id);
		}
		$trackingAreas = $this->TrackingEntry->TrackingArea->find('list');
		$trackingTasks = $this->TrackingEntry->TrackingTask->find('list');
		$trackingReleases = $this->TrackingEntry->TrackingRelease->find('list');
		$trackingVisits = $this->TrackingEntry->TrackingVisit->find('list');
		$this->set(compact('trackingAreas','trackingTasks','trackingReleases','trackingVisits'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TrackingEntry', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TrackingEntry->del($id)) {
			$this->Session->setFlash(__('TrackingEntry deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->TrackingEntry->recursive = 0;
		$this->set('trackingEntries', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TrackingEntry.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('trackingEntry', $this->TrackingEntry->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->TrackingEntry->create();
			if ($this->TrackingEntry->save($this->data)) {
				$this->Session->setFlash(__('The TrackingEntry has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingEntry could not be saved. Please, try again.', true));
			}
		}
		$trackingAreas = $this->TrackingEntry->TrackingArea->find('list');
		$trackingTasks = $this->TrackingEntry->TrackingTask->find('list');
		$trackingReleases = $this->TrackingEntry->TrackingRelease->find('list');
		$trackingVisits = $this->TrackingEntry->TrackingVisit->find('list');
		$this->set(compact('trackingAreas', 'trackingTasks', 'trackingReleases', 'trackingVisits'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TrackingEntry', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TrackingEntry->save($this->data)) {
				$this->Session->setFlash(__('The TrackingEntry has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingEntry could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TrackingEntry->read(null, $id);
		}
		$trackingAreas = $this->TrackingEntry->TrackingArea->find('list');
		$trackingTasks = $this->TrackingEntry->TrackingTask->find('list');
		$trackingReleases = $this->TrackingEntry->TrackingRelease->find('list');
		$trackingVisits = $this->TrackingEntry->TrackingVisit->find('list');
		$this->set(compact('trackingAreas','trackingTasks','trackingReleases','trackingVisits'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TrackingEntry', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TrackingEntry->del($id)) {
			$this->Session->setFlash(__('TrackingEntry deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
