<?php
class TemplateRequestsController extends AppController {

	var $name = 'TemplateRequests';
	var $components = array('Captcha.Captcha');

	function index() {
		$this->TemplateRequest->recursive = 1;
		$this->set('templateRequests', $this->paginate());
	}

	function view($id = null) {
		$this->TemplateRequest->recursive = 1;
		if (!$id) {
			$this->Session->setFlash(__('Invalid TemplateRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('templateRequest', $this->TemplateRequest->read(null, $id));
	}

	function add($prod = '') {
		$this->layout = 'default_plain';
		if(empty($_REQUEST['debug'])) { Configure::write("debug", 0); }

		if (!empty($this->data)) {
			$this->TemplateRequest->create();
			$product_ids = is_array($this->data['TemplateRequest']['product_id']) ? $this->data['TemplateRequest']['product_id'] : array($this->data['TemplateRequest']['product_id']);

			foreach($product_ids as $pid)
			{
				$this->data['TemplateRequest']['product_id'] = $pid;

				if ($this->TemplateRequest->save($this->data)) {
					$id = $this->TemplateRequest->id;
					if(!$this->malysoft)
					{
						$this->sendAdminEmail("Online Template Request", "forms/template_request", array('template_request_id'=>$id));
					}
					$this->action = "add_thankyou";
				} else {
					$this->Session->setFlash(__('The Template request could not be submitted. Please, try again.', true));
				}
			}

		}
		$this->set("products", $this->Product->find('list',array('conditions'=>"available = 'yes' AND is_stock_item = 0",'order'=>'name ASC','fields'=>array('product_type_id','pricing_name'))));

		$product = !empty($prod) ? $this->Product->find(" code = '$prod' ") : null;
		$this->data['SampleRequest']['product_type_id'] = $pid = $product['Product']['product_type_id']; 
		$ppid = $product['Product']['parent_product_type_id']; 
		$parent_product = !empty($ppid) ? $this->Product->read(null, $ppid) : $product;

		if(!empty($product) && !in_array($prod, array('B','BB','BNT','BC'))) { 
			$related_products = $this->Product->find('list',array('conditions'=>" (product_type_id = '$pid' OR parent_product_type_id = '$pid' OR product_type_id = '$ppid' OR parent_product_type_id = '$ppid') AND available = 'yes' ",'fields'=>array('product_type_id','pricing_name'),'order'=>'choose_index'));
			$this->set("related_products", $related_products);
		
		}
		$this->set("product", $parent_product);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TemplateRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->TemplateRequest->save($this->data)) {
				$this->Session->setFlash(__('The TemplateRequest has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The TemplateRequest could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TemplateRequest->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TemplateRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->TemplateRequest->del($id)) {
			$this->Session->setFlash(__('TemplateRequest deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The TemplateRequest could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}


	function admin_index() {
		$this->TemplateRequest->recursive = 0;
		$this->set('templateRequests', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid TemplateRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('templateRequest', $this->TemplateRequest->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->TemplateRequest->create();
			if ($this->TemplateRequest->save($this->data)) {
				$this->Session->setFlash(__('The TemplateRequest has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The TemplateRequest could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid TemplateRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->TemplateRequest->save($this->data)) {
				$this->Session->setFlash(__('The TemplateRequest has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The TemplateRequest could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->TemplateRequest->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for TemplateRequest', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->TemplateRequest->del($id)) {
			$this->Session->setFlash(__('TemplateRequest deleted', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('The TemplateRequest could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>
