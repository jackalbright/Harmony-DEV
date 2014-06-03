<?php
class PageEmailsController extends AppController {

	var $name = 'PageEmails';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->PageEmail->recursive = 0;
		$this->set('pageEmails', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid PageEmail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('pageEmail', $this->PageEmail->read(null, $id));
	}

	function add($prod)
	{
		$this->set("prod", $prod);
		$this->body_title = 'Email this page';
		Configure::write("debug",0);
		$this->layout = 'default_plain';
		if(!empty($this->data))
		{
			if($this->PageEmail->save($this->data))
			{

			# Process email.
			$your_name = $this->data['PageEmail']['your_name'];
			$email = $this->data['PageEmail']['recipient'];
			$subject = $this->data['PageEmail']['subject'];
			$url = $this->data['PageEmail']['url'];
			$custom_message = $this->data['PageEmail']['custom_message'];

			$this->sendEmail($email, $subject, 'page_email', array('url'=>$url,'custom_message'=>$custom_message,'your_name'=>$your_name));

			$this->Session->setFlash("Email sent");
			$this->set("sent", true);
			$this->data = null;
			} else {
				$this->Session->setFlash("Please correct the following errors");
			}
		}
		$this->set("product", $this->Product->find(" code = '$prod' "));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid PageEmail', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->PageEmail->save($this->data)) {
				$this->Session->setFlash(__('The PageEmail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The PageEmail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PageEmail->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for PageEmail', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->PageEmail->del($id)) {
			$this->Session->setFlash(__('PageEmail deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The PageEmail could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}


	function admin_index() {
		$this->PageEmail->recursive = 0;
		$this->set('pageEmails', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid PageEmail', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('pageEmail', $this->PageEmail->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->PageEmail->create();
			if ($this->PageEmail->save($this->data)) {
				$this->Session->setFlash(__('The PageEmail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The PageEmail could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid PageEmail', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->PageEmail->save($this->data)) {
				$this->Session->setFlash(__('The PageEmail has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The PageEmail could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->PageEmail->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for PageEmail', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->PageEmail->del($id)) {
			$this->Session->setFlash(__('PageEmail deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The PageEmail could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>
