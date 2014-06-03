<?php
class TrackingAreasController extends AppController {

	var $name = 'TrackingAreas';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->TrackingArea->recursive = 0;
		$this->set('trackingAreas', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TrackingArea.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('trackingArea', $this->TrackingArea->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->TrackingArea->create();
			if ($this->TrackingArea->save($this->data)) {
				$this->Session->setFlash(__('The TrackingArea has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingArea could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TrackingArea', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TrackingArea->save($this->data)) {
				$this->Session->setFlash(__('The TrackingArea has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingArea could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TrackingArea->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TrackingArea', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TrackingArea->del($id)) {
			$this->Session->setFlash(__('TrackingArea deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->TrackingArea->recursive = 0;
		$this->set('trackingAreas', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TrackingArea.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('trackingArea', $this->TrackingArea->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->TrackingArea->create();
			if ($this->TrackingArea->save($this->data)) {
				$this->Session->setFlash(__('The TrackingArea has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingArea could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TrackingArea', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->TrackingArea->save($this->data)) {
				$this->Session->setFlash(__('The TrackingArea has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The TrackingArea could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TrackingArea->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TrackingArea', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->TrackingArea->del($id)) {
			$this->Session->setFlash(__('TrackingArea deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>