<?php
class PageFoldersController extends AppController {

	var $name = 'PageFolders';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->PageFolder->recursive = 0;
		$this->set('pageFolders', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid PageFolder.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('pageFolder', $this->PageFolder->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->PageFolder->create();
			if ($this->PageFolder->save($this->data)) {
				$this->Session->setFlash(__('The PageFolder has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PageFolder could not be saved. Please, try again.', true));
			}
		}
		$parentFolders = $this->PageFolder->ParentFolder->find('list');
		$this->set(compact('parentFolders'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid PageFolder', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->PageFolder->save($this->data)) {
				$this->Session->setFlash(__('The PageFolder has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PageFolder could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PageFolder->read(null, $id);
		}
		$parentFolders = $this->PageFolder->ParentFolder->find('list');
		$this->set(compact('parentFolders'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for PageFolder', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PageFolder->del($id)) {
			$this->Session->setFlash(__('PageFolder deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->PageFolder->recursive = 0;
		$this->set('pageFolders', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid PageFolder.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('pageFolder', $this->PageFolder->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->PageFolder->create();
			if ($this->PageFolder->save($this->data)) {
				$this->Session->setFlash(__('The PageFolder has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PageFolder could not be saved. Please, try again.', true));
			}
		}
		$parentFolders = $this->PageFolder->ParentFolder->find('list');
		$this->set(compact('parentFolders'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid PageFolder', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->PageFolder->save($this->data)) {
				$this->Session->setFlash(__('The PageFolder has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The PageFolder could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PageFolder->read(null, $id);
		}
		$parentFolders = $this->PageFolder->ParentFolder->find('list');
		$this->set(compact('parentFolders'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for PageFolder', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PageFolder->del($id)) {
			$this->Session->setFlash(__('PageFolder deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>