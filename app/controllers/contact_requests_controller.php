<?php
class ContactRequestsController extends AppController {

	var $name = 'ContactRequests';
	#var $components = array('RecaptchaPlugin.Recaptcha');
	#var $helpers = array('RecaptchaPlugin.Recaptcha');
	var $components = array('Captcha.Captcha');

	function index() {
		$this->redirect(array('action'=>'add'));

		#$this->ContactRequest->recursive = 0;
		#$this->set('contactRequests', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid contact request', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('contactRequest', $this->ContactRequest->read(null, $id));
	}

	function add() {
		$this->body_title = "Contact Us";
		if (!empty($this->data)) {
			$this->ContactRequest->create();
				#$this->Session->setFlash(__('The contact request has been saved', true));
				if (empty($this->data['ContactRequest']['message']) || (empty($this->data['ContactRequest']['email']) && empty($this->data['ContactRequest']['phone'])))
				{
					$this->Session->setFlash("Please enter valid contact information and message");
					return;
				}
			if ($this->ContactRequest->save($this->data)) {
				$from = '';
				if (preg_match("/\w+@[\w.]+\w+/", $this->data['ContactRequest']['email']))
				{
					$from = $this->data['ContactRequest']['email'];
				}
				if(empty($this->malysoft)) {
					$this->sendAdminEmail("Website Inquiry", "contact_submission", $this->data['ContactRequest'], $from);
				}
				#$this->Session->setFlash("Thank you for your inquiry. We will contact you shortly.");

				$this->redirect(array('action'=>'thanks'));

				#$this->redirect(array('action' => 'add'));
			} else {
				$this->Session->setFlash(__('Please correct the errors below.', true));
			}
		}
	}

	function thanks()
	{
		$this->action = 'contact_thanks';
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid contact request', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ContactRequest->save($this->data)) {
				$this->Session->setFlash(__('The contact request has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contact request could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ContactRequest->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for contact request', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ContactRequest->delete($id)) {
			$this->Session->setFlash(__('Contact request deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Contact request was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->ContactRequest->recursive = 0;
		$this->set('contactRequests', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid contact request', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('contactRequest', $this->ContactRequest->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->ContactRequest->create();
			if ($this->ContactRequest->save($this->data)) {
				$this->Session->setFlash(__('The contact request has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contact request could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid contact request', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ContactRequest->save($this->data)) {
				$this->Session->setFlash(__('The contact request has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contact request could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ContactRequest->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for contact request', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ContactRequest->delete($id)) {
			$this->Session->setFlash(__('Contact request deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Contact request was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
