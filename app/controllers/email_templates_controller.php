<?php
class EmailTemplatesController extends AppController {

	var $name = 'EmailTemplates';
	var $helpers = array('Html', 'Form');
	var $uses = array('EmailTemplate','EmailLetter','EmailMessage');

	function index() {
		$this->EmailTemplate->recursive = 0;
		$this->set('emailTemplates', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid EmailTemplate.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('emailTemplate', $this->EmailTemplate->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->EmailTemplate->create();
			if ($this->EmailTemplate->save($this->data)) {
				$this->Session->setFlash(__('The EmailTemplate has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailTemplate could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid EmailTemplate', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->EmailTemplate->save($this->data)) {
				$this->Session->setFlash(__('The EmailTemplate has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailTemplate could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EmailTemplate->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for EmailTemplate', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EmailTemplate->del($id)) {
			$this->Session->setFlash(__('EmailTemplate deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->EmailTemplate->recursive = 0;
		$this->set('emailTemplates', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid EmailTemplate.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('emailTemplate', $this->EmailTemplate->find(" email_template_id = '$id' OR name = '$id' "));
	}

	function admin_message_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid EmailMessage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->EmailMessage->recursive = 1;
		$this->data = $this->EmailMessage->read(null, $id);
		foreach($this->data['EmailMessage'] as $key=>$val)
		{
			if(empty($this->data['EmailTemplate'][$key]))
			{
				$this->data['EmailTemplate'][$key] = $val;
			}
		}
		# XXX TODO set this->data so will pass throguh on requestAction
		$this->set('emailTemplate', $this->data);
	}

	function admin_message_edit($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid EmailTemplate.', true));
			$this->redirect(array('action'=>'index'));
		}
		if(!empty($this->data['EmailLetter']['email_letter_id']))
		{
			$this->set('emailLetter', $this->EmailLetter->read(null, $this->data['EmailLetter']['email_letter_id']));
		}
		$this->set('emailTemplate', $this->EmailTemplate->find(" email_template_id = '$id' OR name = '$id' "));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->EmailTemplate->create();
			if ($this->EmailTemplate->save($this->data)) {
				$this->Session->setFlash(__('The EmailTemplate has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailTemplate could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid EmailTemplate', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->EmailTemplate->save($this->data)) {
				$this->Session->setFlash(__('The EmailTemplate has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The EmailTemplate could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EmailTemplate->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for EmailTemplate', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EmailTemplate->del($id)) {
			$this->Session->setFlash(__('EmailTemplate deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
