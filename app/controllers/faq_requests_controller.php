<?php
class FaqRequestsController extends AppController {

	var $name = 'FaqRequests';
	var $paginate = array('order'=>'id DESC');
	#var $components = array('RecaptchaPlugin.Recaptcha');
	var $components = array('Captcha.Captcha');

	function index() {
		$this->FaqRequest->recursive = 0;
		$this->set('faqRequests', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid FaqRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('faqRequest', $this->FaqRequest->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->FaqRequest->create();
			if ($this->FaqRequest->save($this->data)) {
				$id = $this->FaqRequest->id;

				if(!$this->malysoft)
				{
					$this->sendAdminEmail("FAQ Request", "forms/faq_request", array('id'=>$id));
				}

				$this->Session->setFlash("Thank you for your question. You will be contacted within one business day. If you need to contact us in the meantime, our toll-free number is 888.293.1109.");
				$this->redirect("/info/faq.php");

				$this->action = "add_thankyou";
			} else {
				$this->Session->setFlash(__('The FaqRequest could not be saved. Please, try again.', true));
			}
		}
		$faqTopics = $this->FaqRequest->FaqTopic->find('list',array('conditions'=>'FaqTopic.enabled = 1'));
		$this->set(compact('faqTopics'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid FaqRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->FaqRequest->save($this->data)) {
				$this->Session->setFlash(__('The FaqRequest has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The FaqRequest could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->FaqRequest->read(null, $id);
		}
		$faqTopics = $this->FaqRequest->FaqTopic->find('list');
		$this->set(compact('faqTopics'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for FaqRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->FaqRequest->del($id)) {
			$this->Session->setFlash(__('FaqRequest deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The FaqRequest could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}


	function admin_index() {
		$this->FaqRequest->recursive = 0;
		$this->set('faqRequests', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid FaqRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('faqRequest', $this->FaqRequest->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->FaqRequest->create();
			if ($this->FaqRequest->save($this->data)) {
				$this->Session->setFlash(__('The FaqRequest has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The FaqRequest could not be saved. Please, try again.', true));
			}
		}
		$faqTopics = $this->FaqRequest->FaqTopic->find('list');
		$this->set(compact('faqTopics'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid FaqRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->FaqRequest->save($this->data)) {
				$this->Session->setFlash(__('The FaqRequest has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The FaqRequest could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->FaqRequest->read(null, $id);
		}
		$faqTopics = $this->FaqRequest->FaqTopic->find('list');
		$this->set(compact('faqTopics'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for FaqRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->FaqRequest->del($id)) {
			$this->Session->setFlash(__('FaqRequest deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The FaqRequest could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>
