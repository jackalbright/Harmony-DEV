<?php
class CharmsController extends AppController {

	var $name = 'Charms';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Charm->recursive = 0;
		$this->set('charms', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Charm.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('charm', $this->Charm->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Charm->create();
			if ($this->Charm->save($this->data)) {
				$this->Session->setFlash(__('The Charm has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Charm could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Charm', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Charm->save($this->data)) {
				$this->Session->setFlash(__('The Charm has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Charm could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Charm->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Charm', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Charm->del($id)) {
			$this->Session->setFlash(__('Charm deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->Charm->recursive = 0;
		$this->set('charms', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Charm.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('charm', $this->Charm->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Charm->create();
			if ($this->Charm->save($this->data)) {
				$this->Session->setFlash(__('The Charm has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Charm could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Charm', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Charm->save($this->data)) {
				$this->Session->setFlash(__('The Charm has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Charm could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Charm->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Charm', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Charm->del($id)) {
			$this->Session->setFlash(__('Charm deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
