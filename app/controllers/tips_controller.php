<?php
class TipsController extends AppController {

	var $name = 'Tips';
	var $helpers = array('Html', 'Form');


	function admin_index() {
		$this->Tip->recursive = 0;
		$this->set('tips', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Tip.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('tip', $this->Tip->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Tip->create();
			if ($this->Tip->save($this->data)) {
				$this->Session->setFlash(__('The Tip has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tip could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Tip', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Tip->save($this->data)) {
				$this->Session->setFlash(__('The Tip has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Tip could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Tip->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Tip', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Tip->del($id)) {
			$this->Session->setFlash(__('Tip deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
