<?php
class BuildEmailsController extends AppController {

	var $name = 'BuildEmails';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->BuildEmail->recursive = 0;
		$this->set('buildEmails', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid BuildEmail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('buildEmail', $this->BuildEmail->read(null, $id));
	}

	function add() {
		$this->layout = 'default_plain';
		if(empty($_REQUEST['debug'])) { Configure::write("debug",0); }

		if (!empty($this->data)) {
			$this->BuildEmail->create();
			$this->data['BuildEmail']['build_data'] = serialize($this->build);
			if ($this->BuildEmail->save($this->data)) {
				# Process email.
				$your_name = $this->data['BuildEmail']['your_name'];
				$email = $this->data['BuildEmail']['recipient'];
				$subject = $this->data['BuildEmail']['subject'];
				$custom_message = $this->data['BuildEmail']['custom_message'];
				$this->sendEmail($email, $subject, 'build_email', array('build_email_id'=>$this->BuildEmail->id,'build'=>$this->build,'custom_message'=>$custom_message,'your_name'=>$your_name));
				$this->Session->setFlash("Email sent");
				$this->set("sent", true);
				$this->data = null;
			} else {
				$this->Session->setFlash(__('The BuildEmail could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid BuildEmail', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->BuildEmail->save($this->data)) {
				$this->Session->setFlash(__('The BuildEmail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The BuildEmail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->BuildEmail->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for BuildEmail', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->BuildEmail->del($id)) {
			$this->Session->setFlash(__('BuildEmail deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The BuildEmail could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}


	function admin_index() {
		$this->BuildEmail->recursive = 0;
		$this->set('buildEmails', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid BuildEmail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('buildEmail', $this->BuildEmail->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->BuildEmail->create();
			if ($this->BuildEmail->save($this->data)) {
				$this->Session->setFlash(__('The BuildEmail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The BuildEmail could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid BuildEmail', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->BuildEmail->save($this->data)) {
				$this->Session->setFlash(__('The BuildEmail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The BuildEmail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->BuildEmail->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for BuildEmail', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->BuildEmail->del($id)) {
			$this->Session->setFlash(__('BuildEmail deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The BuildEmail could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>
