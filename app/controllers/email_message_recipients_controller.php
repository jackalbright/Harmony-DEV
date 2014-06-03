<?php
class EmailMessageRecipientsController extends AppController {

	var $name = 'EmailMessageRecipients';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->EmailMessageRecipient->recursive = 0;
		$this->set('emailMessageRecipients', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid EmailMessageRecipient.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('emailMessageRecipient', $this->EmailMessageRecipient->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->EmailMessageRecipient->create();
			if ($this->EmailMessageRecipient->save($this->data)) {
				$this->Session->setFlash(__('The EmailMessageRecipient has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailMessageRecipient could not be saved. Please, try again.', true));
			}
		}
		$emailMessages = $this->EmailMessageRecipient->EmailMessage->find('list');
		$customers = $this->EmailMessageRecipient->Customer->find('list');
		$this->set(compact('emailMessages', 'customers'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid EmailMessageRecipient', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->EmailMessageRecipient->save($this->data)) {
				$this->Session->setFlash(__('The EmailMessageRecipient has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailMessageRecipient could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EmailMessageRecipient->read(null, $id);
		}
		$emailMessages = $this->EmailMessageRecipient->EmailMessage->find('list');
		$customers = $this->EmailMessageRecipient->Customer->find('list');
		$this->set(compact('emailMessages','customers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for EmailMessageRecipient', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EmailMessageRecipient->del($id)) {
			$this->Session->setFlash(__('EmailMessageRecipient deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->EmailMessageRecipient->recursive = 0;
		$this->set('emailMessageRecipients', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid EmailMessageRecipient.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('emailMessageRecipient', $this->EmailMessageRecipient->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->EmailMessageRecipient->create();
			if ($this->EmailMessageRecipient->save($this->data)) {
				$this->Session->setFlash(__('The EmailMessageRecipient has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailMessageRecipient could not be saved. Please, try again.', true));
			}
		}
		$emailMessages = $this->EmailMessageRecipient->EmailMessage->find('list');
		$customers = $this->EmailMessageRecipient->Customer->find('list');
		$this->set(compact('emailMessages', 'customers'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid EmailMessageRecipient', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->EmailMessageRecipient->save($this->data)) {
				$this->Session->setFlash(__('The EmailMessageRecipient has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailMessageRecipient could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EmailMessageRecipient->read(null, $id);
		}
		$emailMessages = $this->EmailMessageRecipient->EmailMessage->find('list');
		$customers = $this->EmailMessageRecipient->Customer->find('list');
		$this->set(compact('emailMessages','customers'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for EmailMessageRecipient', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EmailMessageRecipient->del($id)) {
			$this->Session->setFlash(__('EmailMessageRecipient deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>