<?php
class TrackingTasksController extends AppController {

	var $name = 'TrackingTasks';
	var $helpers = array('Html', 'Form');
	var $paginate = array('order'=>'TrackingTask.tracking_area_id,TrackingTask.sort_index,TrackingTask.tracking_task_id');

	function index() {
		$this->TrackingTask->recursive = 0;
		$this->set('trackingTasks', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TrackingTask.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('trackingTask', $this->TrackingTask->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->TrackingTask->create();
			if ($this->TrackingTask->save($this->data)) {
				$this->Session->setFlash(__('The TrackingTask has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingTask could not be saved. Please, try again.', true));
			}
		}
		$trackingAreas = $this->TrackingTask->TrackingArea->find('list');
		$this->set(compact('trackingAreas'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TrackingTask', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TrackingTask->save($this->data)) {
				$this->Session->setFlash(__('The TrackingTask has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingTask could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TrackingTask->read(null, $id);
		}
		$trackingAreas = $this->TrackingTask->TrackingArea->find('list');
		$this->set(compact('trackingAreas'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TrackingTask', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TrackingTask->del($id)) {
			$this->Session->setFlash(__('TrackingTask deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->TrackingTask->recursive = 0;
		$this->set('trackingTasks', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TrackingTask.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('trackingTask', $this->TrackingTask->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->TrackingTask->create();
			if ($this->TrackingTask->save($this->data)) {
				$this->Session->setFlash(__('The TrackingTask has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingTask could not be saved. Please, try again.', true));
			}
		}
		$trackingAreas = $this->TrackingTask->TrackingArea->find('list');
		$this->set(compact('trackingAreas'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TrackingTask', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TrackingTask->save($this->data)) {
				$this->Session->setFlash(__('The TrackingTask has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingTask could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TrackingTask->read(null, $id);
		}
		$trackingAreas = $this->TrackingTask->TrackingArea->find('list');
		$this->set(compact('trackingAreas'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TrackingTask', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TrackingTask->del($id)) {
			$this->Session->setFlash(__('TrackingTask deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
