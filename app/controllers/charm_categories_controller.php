<?php
class CharmCategoriesController extends AppController {

	var $name = 'CharmCategories';
	var $helpers = array('Html', 'Form');
	var $uses = array("CharmCategory","Charm");

	function index() {
		$this->CharmCategory->recursive = 0;
		$this->set('charmCategories', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CharmCategory.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('charmCategory', $this->CharmCategory->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->CharmCategory->create();
			if ($this->CharmCategory->save($this->data)) {
				$this->Session->setFlash(__('The CharmCategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CharmCategory could not be saved. Please, try again.', true));
			}
		}
		$charms = $this->CharmCategory->Charm->find('list',array('order'=>'Charm.name ASC'));
		$this->set(compact('charms'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CharmCategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CharmCategory->save($this->data)) {
				$this->Session->setFlash(__('The CharmCategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CharmCategory could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CharmCategory->read(null, $id);
		}
		$charms = $this->CharmCategory->Charm->find('list',array('order'=>'Charm.name ASC'));

		$this->set(compact('charms'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CharmCategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CharmCategory->del($id)) {
			$this->Session->setFlash(__('CharmCategory deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->CharmCategory->recursive = 0;
		$this->set('charmCategories', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CharmCategory.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('charmCategory', $this->CharmCategory->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->CharmCategory->create();
			if ($this->CharmCategory->save($this->data)) {
				$this->Session->setFlash(__('The CharmCategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CharmCategory could not be saved. Please, try again.', true));
			}
		}
		$charms = $this->CharmCategory->Charm->find('list',array('order'=>'Charm.name ASC'));
		$this->set(compact('charms'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CharmCategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CharmCategory->save($this->data)) {
				$this->Session->setFlash(__('The CharmCategory has been saved', true));
				#$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CharmCategory could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CharmCategory->read(null, $id);
		}
		$charms = $this->CharmCategory->Charm->find('list',array('order'=>'Charm.name ASC'));
		$this->set(compact('charms'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CharmCategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CharmCategory->del($id)) {
			$this->Session->setFlash(__('CharmCategory deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
