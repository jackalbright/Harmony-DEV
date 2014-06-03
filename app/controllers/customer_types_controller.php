<?php
class CustomerTypesController extends AppController {

	var $name = 'CustomerTypes';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->CustomerType->recursive = 0;
		$this->set('customerTypes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CustomerType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('customerType', $this->CustomerType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->CustomerType->create();
			if ($this->CustomerType->save($this->data)) {
				$this->Session->setFlash(__('The CustomerType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CustomerType could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CustomerType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CustomerType->save($this->data)) {
				$this->Session->setFlash(__('The CustomerType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CustomerType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CustomerType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CustomerType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CustomerType->del($id)) {
			$this->Session->setFlash(__('CustomerType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->CustomerType->recursive = 0;
		$this->set('customerTypes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CustomerType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('customerType', $this->CustomerType->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->CustomerType->create();
			if ($this->CustomerType->save($this->data)) {
				$this->Session->setFlash(__('The CustomerType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CustomerType could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CustomerType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CustomerType->save($this->data)) {
				$this->Session->setFlash(__('The CustomerType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CustomerType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CustomerType->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CustomerType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CustomerType->del($id)) {
			$this->Session->setFlash(__('CustomerType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>