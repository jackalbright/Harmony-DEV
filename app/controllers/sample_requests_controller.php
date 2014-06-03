<?php
class SampleRequestsController extends AppController {

	var $name = 'SampleRequests';
	var $uses = array('SampleRequest','Product');
	var $components = array('Captcha.Captcha');

	function index() {
		$this->SampleRequest->recursive = 0;
		$this->set('sampleRequests', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid SampleRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('sampleRequest', $this->SampleRequest->read(null, $id));
	}

	function add($prod = '') {
		return $this->redirect("/");


		####################################################



		$this->layout = 'default_plain';
		if(empty($_REQUEST['debug'])) { Configure::write("debug", 0); }
		#

		if (!empty($this->data)) {
			$this->SampleRequest->create();
			error_log("SAVE_ALL");
			if ($this->SampleRequest->saveAll($this->data)) {
				error_log("POST_SAVE1");
				$id = $this->SampleRequest->id;
				#$this->Session->setFlash(__('The SampleRequest has been saved', true));
				# Send email todo...
				if(!$this->malysoft)
				{
					$this->sendAdminEmail("Online Sample Request", "forms/sample_request", array('sample_request_id'=>$id));
				}

				if(!empty($this->params['isAjax']))
				{
					$this->Session->setFlash("Thank you for your request. Your sample will be shipped within 24 hours. If you need to contact us in the meantime, our toll-free number is 888.293.1109.");
					$this->data = null;
				} else {
					$this->action = "add_thankyou";
				}
				#$this->redirect(array('action' => 'index'));
			} else {
				error_log("POST_SAVE2");
				$this->Session->setFlash(__('The SampleRequest could not be saved. Please, try again.', true));
			}
		}
		$product_types = $this->Product->find('list',array('conditions'=>array('available'=>'yes','is_stock_item'=>0)));
		$this->set(compact('product_types'));
		$product = !empty($prod) ? $this->Product->find(" code = '$prod' ") : null;
		$this->data['SampleRequest']['product_type_id'] = $pid = $product['Product']['product_type_id']; 
		$ppid = $product['Product']['parent_product_type_id']; 
		$parent_product = !empty($ppid) ? $this->Product->read(null, $ppid) : $product;

		if(!empty($product)) { 
			$related_products = $this->Product->find('all',array('conditions'=>" (product_type_id = '$pid' OR parent_product_type_id = '$pid' OR product_type_id = '$ppid' OR parent_product_type_id = '$ppid') AND available = 'yes' AND free_sample = 1",'order'=>'choose_index'));
			$this->set("related_products", $related_products);
		
		}
		$this->set("product", $parent_product);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid SampleRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->SampleRequest->save($this->data)) {
				$this->Session->setFlash(__('The SampleRequest has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The SampleRequest could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SampleRequest->read(null, $id);
		}
		$products = $this->SampleRequest->Product->find('list');
		$this->set(compact('products'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for SampleRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->SampleRequest->del($id)) {
			$this->Session->setFlash(__('SampleRequest deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The SampleRequest could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

	function admin_search()
	{
		if(!empty($this->data['SampleRequest']['id']))
		{
			$this->redirect(array('action'=>'view', $this->data['SampleRequest']['id']));
		} else {
			$this->Session->setFlash("No ID provided in search.");
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->SampleRequest->recursive = 2;
		$this->set('sampleRequests', $this->paginate());
	}

	function admin_view($id = null) {
		$this->SampleRequest->recursive = 2;
		if (!$id) {
			$this->Session->setFlash(__('Invalid SampleRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('sampleRequest', $this->SampleRequest->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->SampleRequest->create();
			if ($this->SampleRequest->save($this->data)) {
				$this->Session->setFlash(__('The SampleRequest has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The SampleRequest could not be saved. Please, try again.', true));
			}
		}
		$products = $this->SampleRequest->Product->find('list');
		$this->set(compact('products'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid SampleRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->SampleRequest->save($this->data)) {
				$this->Session->setFlash(__('The SampleRequest has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The SampleRequest could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SampleRequest->read(null, $id);
		}
		$products = $this->SampleRequest->Product->find('list');
		$this->set(compact('products'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for SampleRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->SampleRequest->del($id)) {
			$this->Session->setFlash(__('SampleRequest deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The SampleRequest could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>
