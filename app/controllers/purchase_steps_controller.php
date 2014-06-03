<?php
class PurchaseStepsController extends AppController {

	var $name = 'PurchaseSteps';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->PurchaseStep->recursive = 0;
		$this->set('purchaseSteps', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid PurchaseStep.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('purchaseStep', $this->PurchaseStep->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PurchaseStep->create();
			if ($this->PurchaseStep->save($this->data)) {
				$this->Session->setFlash(__('The PurchaseStep has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PurchaseStep could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid PurchaseStep', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->PurchaseStep->save($this->data)) {
				$this->Session->setFlash(__('The PurchaseStep has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PurchaseStep could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PurchaseStep->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for PurchaseStep', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PurchaseStep->del($id)) {
			$this->Session->setFlash(__('PurchaseStep deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->PurchaseStep->recursive = 0;
		$this->set('purchaseSteps', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid PurchaseStep.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('purchaseStep', $this->PurchaseStep->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->PurchaseStep->create();
			if ($this->PurchaseStep->save($this->data)) {
				$this->Session->setFlash(__('The PurchaseStep has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PurchaseStep could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid PurchaseStep', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->PurchaseStep->save($this->data)) {
				$this->Session->setFlash(__('The PurchaseStep has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PurchaseStep could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PurchaseStep->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for PurchaseStep', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PurchaseStep->del($id)) {
			$this->Session->setFlash(__('PurchaseStep deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>