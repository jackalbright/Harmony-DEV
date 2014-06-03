<?php
class FaqsController extends AppController {

	var $name = 'Faqs';
	var $uses = array('FaqRequest','Faq','Product','FaqTopic'); // FaqRequest needs to go first so recaptcha attaches to IT
	#var $components = array('RecaptchaPlugin.Recaptcha');
	var $components = array('Captcha.Captcha');

	function index() {
		$this->set("faqs", $this->Faq->findAll(" Faq.enabled = 1 AND Faq.faq_topic_id IS NULL "));
		$this->FaqTopic->recursive = 1;
		$this->set("faq_topics", $this->FaqTopic->findAll(" FaqTopic.enabled = 1 "));
		$this->set("faqTopics", $this->Faq->FaqTopic->find('list',array("conditions"=>array("FaqTopic.enabled = 1"))));
	}

	function add() {
		if (!empty($this->data)) {
			$this->FaqRequest->create();
			if((empty($this->data['FaqRequest']['email']) && empty($this->data['FaqRequest']['phone'])) || empty($this->data['FaqRequest']['email']))
			{
				$this->Session->setFlash('Missing contact information');
				$this->setAction("index"); # Keep form data.
			}
			/*
			else if(!isset($this->params['form']['recaptcha_response_field']))
			{
				error_log("OOPS");
				$this->Session->setFlash('Your request could not be submitted. Missing CAPTCHA validation.');
				#$this->redirect(array('action'=>'index'));
				$this->setAction("index"); # Keep form data.
			}
			*/
			else if ($this->FaqRequest->save($this->data)) {
				$id = $this->FaqRequest->id;

				if(!$this->malysoft)
				{
					$this->sendAdminEmail("FAQ Request", "forms/faq_request", array('id'=>$id));
				}

				$this->Session->setFlash("Thank you for your question. You will be contacted within one business day. If you need to contact us in the meantime, our toll-free number is 888.293.1109.");
				$this->redirect(array('action'=>'index'));

				$this->action = "add_thankyou";
			} else {
				$this->Session->setFlash(__('Your request could not be submitted. Please fix the errors below.', true),'warn');
				#$this->action = 'index';
				$this->setAction("index");
			}
		}
		$faqTopics = $this->FaqRequest->FaqTopic->find('list',array('conditions'=>'FaqTopic.enabled = 1'));
		$this->set(compact('faqTopics'));
	}

	function admin_index()
	{
		$this->set("faqs", $this->Faq->findAll(" Faq.enabled = 1 AND Faq.faq_topic_id IS NULL "));
		$this->set("disabled_faqs", $this->Faq->findAll(" Faq.enabled = 0 AND Faq.faq_topic_id IS NULL "));
		$this->FaqTopic->recursive = 1;
		$this->set("faqTopics", $this->FaqTopic->findAll(" FaqTopic.enabled = 1 "));
		$this->set("disabled_faq_topics", $this->FaqTopic->findAll(" FaqTopic.enabled = 0 "));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Faq.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('faq', $this->Faq->read(null, $id));
	}


	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Faq', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Faq->save($this->data)) {
				$this->Session->setFlash(__('The Faq has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Faq could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Faq->read(null, $id);
		}
		$faqTopics = $this->Faq->FaqTopic->find('list');
		$productTypes = $this->Faq->Product->find('list');
		$parts = $this->Faq->Part->find('list');
		$this->set(compact('faqTopics','productTypes','parts'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Faq', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Faq->del($id)) {
			$this->Session->setFlash(__('Faq deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_product($code) 
	{
		# SHow faq's for specific product...
		$product = $this->Product->find("code = '$code' OR product_type_id = '$code'");
		$product_type_id = $product['Product']['product_type_id'];
		$this->Faq->recursive = 1;
		$this->set('faqs', $this->paginate('Faq',array("product_type_id = '$product_type_id'")));
		$this->set("product", $product);
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Faq.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('faq', $this->Faq->read(null, $id));
	}

	function admin_add($ref_id = '') {
		if (!empty($this->data)) {
			$this->Faq->create();
			if ($this->Faq->save($this->data)) {
				$this->Session->setFlash(__('The Faq has been saved', true));
				if (!empty($this->data['Faq']['product_type_id']))
				{
					$this->redirect(array('action'=>'product', $this->data['Faq']['product_type_id']));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('The Faq could not be saved. Please, try again.', true));
			}
		}
		if ($ref_id != "")
		{
			if (is_numeric($ref_id))
			{
				$this->data['Faq']['faq_topic_id'] = $ref_id;
			} else if ($ref_id) { 
				$product = $this->Product->find("code = '$ref_id'");
				$topic = $this->FaqTopic->find("topic_name = 'Specific Products'");
				$this->data['Faq']['faq_topic_id'] = $topic['FaqTopic']['faq_topic_id'];
				$this->data['Faq']['product_type_id'] = $product['Product']['product_type_id'];
			}
		}
		$faqTopics = $this->Faq->FaqTopic->find('list',array('conditions'=>array("FaqTopic.enabled = 1")));
		$productTypes = $this->Faq->Product->find('list');
		$parts = $this->Faq->Part->find('list');
		$this->set(compact('faqTopics', 'productTypes', 'parts'));
	}

	function admin_resort()
	{
		$this->layout = 'ajax';
		error_log("ORDER=".print_r($this->params['form'],true));

		foreach($this->params['form'] as $topic => $order)
		{
			preg_match("/faqs_(\d+)/", $topic, $matches);
			$faq_topic_id = $matches[1];
			foreach($order as $ix => $faq_id)
			{
				#$this->Faq->read(null, $faq_id);
				$this->Faq->id = $faq_id;
				error_log("SAVING $faq_id TO $faq_topic_id, IX=$ix");
				$this->Faq->saveField("faq_topic_id", empty($faq_topic_id) ? null : $faq_topic_id);
				$this->Faq->saveField("sort_index", $ix);
			}
		}
		exit(0);

	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Faq', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Faq->save($this->data)) {
				$this->Session->setFlash(__('The Faq has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Faq could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Faq->read(null, $id);
		}
		#$faqTopics = $this->Faq->FaqTopic->find('list');
		$faqTopics = $this->Faq->FaqTopic->find('list',array('conditions'=>array("FaqTopic.enabled = 1")));
		$productTypes = $this->Faq->Product->find('list');
		$parts = $this->Faq->Part->find('list');
		$this->set(compact('faqTopics','productTypes','parts'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Faq', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Faq->del($id)) {
			$this->Session->setFlash(__('Faq deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
