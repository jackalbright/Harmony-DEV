<?php
class TrackingReleasesController extends AppController {

	var $name = 'TrackingReleases';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->TrackingRelease->recursive = 0;
		$this->set('trackingReleases', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TrackingRelease.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('trackingRelease', $this->TrackingRelease->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->TrackingRelease->create();
			if ($this->TrackingRelease->save($this->data)) {
				$this->Session->setFlash(__('The TrackingRelease has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingRelease could not be saved. Please, try again.', true));
			}
		}
		$trackingAreas = $this->TrackingRelease->TrackingArea->find('list');
		$this->set(compact('trackingAreas'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TrackingRelease', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TrackingRelease->save($this->data)) {
				$this->Session->setFlash(__('The TrackingRelease has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingRelease could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TrackingRelease->read(null, $id);
		}
		$trackingAreas = $this->TrackingRelease->TrackingArea->find('list');
		$this->set(compact('trackingAreas'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TrackingRelease', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TrackingRelease->del($id)) {
			$this->Session->setFlash(__('TrackingRelease deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->TrackingRelease->recursive = 0;
		$this->set('trackingReleases', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TrackingRelease.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('trackingRelease', $this->TrackingRelease->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->TrackingRelease->create();
			if ($this->TrackingRelease->save($this->data)) {
				$this->Session->setFlash(__('The TrackingRelease has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingRelease could not be saved. Please, try again.', true));
			}
		}
		$trackingAreas = $this->TrackingRelease->TrackingArea->find('list');
		$this->set(compact('trackingAreas'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TrackingRelease', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TrackingRelease->save($this->data)) {
				$this->Session->setFlash(__('The TrackingRelease has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingRelease could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TrackingRelease->read(null, $id);
		}
		$trackingAreas = $this->TrackingRelease->TrackingArea->find('list');
		$this->set(compact('trackingAreas'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TrackingRelease', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TrackingRelease->del($id)) {
			$this->Session->setFlash(__('TrackingRelease deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>