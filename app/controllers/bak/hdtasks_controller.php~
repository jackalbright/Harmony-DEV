<?php
class HdtasksController extends AppController {

	var $name = 'Hdtasks';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Hdtask->recursive = 0;
		$this->set('hdtasks', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Hdtask.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('hdtask', $this->Hdtask->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Hdtask->create();
			if ($this->Hdtask->save($this->data)) {
				$this->Session->setFlash(__('The Hdtask has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Hdtask could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Hdtask', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Hdtask->save($this->data)) {
				$this->Session->setFlash(__('The Hdtask has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Hdtask could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Hdtask->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Hdtask', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Hdtask->del($id)) {
			$this->Session->setFlash(__('Hdtask deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->Hdtask->recursive = 0;
		$this->set('hdtasks', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Hdtask.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('hdtask', $this->Hdtask->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Hdtask->create();
			if ($this->Hdtask->save($this->data)) {
				$this->Session->setFlash(__('The Hdtask has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Hdtask could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Hdtask', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Hdtask->save($this->data)) {
				$this->Session->setFlash(__('The Hdtask has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Hdtask could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Hdtask->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Hdtask', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Hdtask->del($id)) {
			$this->Session->setFlash(__('Hdtask deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>