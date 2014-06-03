<?php
class UpdateCommentsController extends AppController {

	var $name = 'UpdateComments';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->UpdateComment->recursive = 0;
		$this->set('updateComments', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid UpdateComment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('updateComment', $this->UpdateComment->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->UpdateComment->create();
			if ($this->UpdateComment->save($this->data)) {
				$this->Session->setFlash(__('The UpdateComment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The UpdateComment could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid UpdateComment', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->UpdateComment->save($this->data)) {
				$this->Session->setFlash(__('The UpdateComment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The UpdateComment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UpdateComment->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for UpdateComment', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->UpdateComment->del($id)) {
			$this->Session->setFlash(__('UpdateComment deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The UpdateComment could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}


	function admin_index() {
		$this->UpdateComment->recursive = 0;
		$this->set('updateComments', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid UpdateComment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('updateComment', $this->UpdateComment->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->UpdateComment->create();
			if ($this->UpdateComment->save($this->data)) {
				$this->action = 'admin_add_ok';
			} else {
				$this->Session->setFlash(__('The UpdateComment could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid UpdateComment', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->UpdateComment->save($this->data)) {
				$this->Session->setFlash(__('The UpdateComment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The UpdateComment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->UpdateComment->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for UpdateComment', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->UpdateComment->del($id)) {
			$this->Session->setFlash(__('UpdateComment deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The UpdateComment could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>
