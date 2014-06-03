<?php
class EmailLettersController extends AppController {

	var $name = 'EmailLetters';
	var $helpers = array('Html', 'Form');
	var $uses = array('EmailLetter','Border','Ribbon','Charm','Tassel');

	function index() {
		$this->EmailLetter->recursive = 0;
		$this->set('emailLetters', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid EmailLetter.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('emailLetter', $this->EmailLetter->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->EmailLetter->create();
			if ($this->EmailLetter->save($this->data)) {
				$this->Session->setFlash(__('The EmailLetter has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailLetter could not be saved. Please, try again.', true));
			}
		}
		$emailTemplates = $this->EmailLetter->EmailTemplate->find('list');
		$this->set(compact('emailTemplates'));

		$this->set("borders", $this->Border->find('list',array('order'=>'name ASC')));
		$this->set("ribbons", $this->Ribbon->find('list',array('fields'=>'color_name','order'=>'color_name ASC')));
		$this->set("tassels", $this->Tassel->find('list',array('fields'=>'color_name','order'=>'color_name ASC')));
		$this->set("charms", $this->Charm->find('list',array('order'=>'name ASC')));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid EmailLetter', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->EmailLetter->save($this->data)) {
				$this->Session->setFlash(__('The EmailLetter has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailLetter could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EmailLetter->read(null, $id);
		}
		$emailTemplates = $this->EmailLetter->EmailTemplate->find('list');
		$this->set(compact('emailTemplates'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for EmailLetter', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EmailLetter->del($id)) {
			$this->Session->setFlash(__('EmailLetter deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->EmailLetter->recursive = 0;
		$this->set('emailLetters', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid EmailLetter.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('emailLetter', $this->EmailLetter->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->EmailLetter->create();
			if ($this->EmailLetter->save($this->data)) {
				$this->Session->setFlash(__('The EmailLetter has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailLetter could not be saved. Please, try again.', true));
			}
		}
		$emailTemplates = $this->EmailLetter->EmailTemplate->find('list');
		$this->set(compact('emailTemplates'));
		$this->set("borders", $this->Border->find('list',array('order'=>'name ASC')));
		$this->set("ribbons", $this->Ribbon->find('list',array('fields'=>'color_name','order'=>'color_name ASC')));
		$this->set("tassels", $this->Tassel->find('list',array('fields'=>'color_name','order'=>'color_name ASC')));
		$this->set("charms", $this->Charm->find('list',array('order'=>'name ASC')));

		$this->action = 'admin_edit';
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid EmailLetter', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->EmailLetter->save($this->data)) {
				$this->Session->setFlash(__('The EmailLetter has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailLetter could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EmailLetter->read(null, $id);
		}
		$emailTemplates = $this->EmailLetter->EmailTemplate->find('list');
		$this->set(compact('emailTemplates'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for EmailLetter', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EmailLetter->del($id)) {
			$this->Session->setFlash(__('EmailLetter deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
