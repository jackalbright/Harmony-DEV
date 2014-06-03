<?php
class StaticPagesController extends AppController {

	var $name = 'StaticPages';
	var $helpers = array('Html', 'Form');
	var $uses = array('StaticPage');

	function index() {
		$this->redirect("/");
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid StaticPage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('staticPage', $this->StaticPage->read(null, $id));
	}

	function admin_index() {
		$this->StaticPage->recursive = 0;
		$this->set('staticPages', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid StaticPage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('staticPage', $this->StaticPage->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->StaticPage->create();
			if ($this->StaticPage->save($this->data)) {
				$this->Session->setFlash(__('The StaticPage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The StaticPage could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid StaticPage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->StaticPage->save($this->data)) {
				$this->Session->setFlash(__('The StaticPage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The StaticPage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->StaticPage->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for StaticPage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->StaticPage->del($id)) {
			$this->Session->setFlash(__('StaticPage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
