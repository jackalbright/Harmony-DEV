<?php
class SpecialtyPageController extends AppController {

	var $name = 'SpecialtyPage';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->SpecialtyPage->recursive = 0;
		$this->set('specialtyPages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid SpecialtyPage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('specialtyPage', $this->SpecialtyPage->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->SpecialtyPage->create();
			if ($this->SpecialtyPage->save($this->data)) {
				$this->Session->setFlash(__('The SpecialtyPage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SpecialtyPage could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid SpecialtyPage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->SpecialtyPage->save($this->data)) {
				$this->Session->setFlash(__('The SpecialtyPage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SpecialtyPage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SpecialtyPage->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for SpecialtyPage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SpecialtyPage->del($id)) {
			$this->Session->setFlash(__('SpecialtyPage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->SpecialtyPage->recursive = 0;
		$this->set('specialtyPages', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid SpecialtyPage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('specialtyPage', $this->SpecialtyPage->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->SpecialtyPage->create();
			if ($this->SpecialtyPage->save($this->data)) {
				$this->Session->setFlash(__('The SpecialtyPage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SpecialtyPage could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid SpecialtyPage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->SpecialtyPage->save($this->data)) {
				$this->Session->setFlash(__('The SpecialtyPage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The SpecialtyPage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SpecialtyPage->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for SpecialtyPage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SpecialtyPage->del($id)) {
			$this->Session->setFlash(__('SpecialtyPage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>