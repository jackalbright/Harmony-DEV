<?php
class CustomerController extends AppController {

	var $name = 'Customer';
	var $helpers = array('Html', 'Form');
	var $components = array('Auth');
	var $uses = array('Customer','CustomImage');


	function beforeFilter()
	{
		$this->Auth->allow('forgot','signup','index'); # Anonymous pages....
		parent::beforeFilter();
	}

	function index() {
		$this->body_title = "My Account";
		#$this->Customer->recursive = 0;
		#$this->set('customers', $this->paginate());
		$this->set("customer", $this->get_customer());
	}


	function signup() {
		exit(1);
		if (!empty($this->data)) {
			$this->Customer->create();
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The Customer has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Customer could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		exit(1);
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Customer', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The Customer has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Customer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Customer->read(null, $id);
		}
	}

	function delete($id = null) {
		exit(1);
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Customer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Customer->del($id)) {
			$this->Session->setFlash(__('Customer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->Customer->recursive = 0;
		$this->set('customers', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Customer.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('customer', $this->Customer->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Customer->create();
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The Customer has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Customer could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Customer', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The Customer has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Customer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Customer->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Customer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Customer->del($id)) {
			$this->Session->setFlash(__('Customer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
