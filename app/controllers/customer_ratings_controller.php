<?php
class CustomerRatingsController extends AppController {

	var $name = 'CustomerRatings';
	var $title = 'Customer Feedback';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->redirect(array('action'=>'add'));

		#$this->CustomerRating->recursive = 0;
		#$this->set('customerRatings', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CustomerRating.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('customerRating', $this->CustomerRating->read(null, $id));
	}

	function add() {
		$this->body_title = 'Customer Feedback Form';
		if (!empty($this->data)) {
			$this->CustomerRating->create();
			if ($this->CustomerRating->save($this->data)) {
				$this->Session->setFlash(__('The CustomerRating has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CustomerRating could not be saved. Please, try again.', true));
			}
		}
		$products = $this->CustomerRating->Product->find('list');
		$customerTypes = $this->CustomerRating->CustomerType->find('list');
		$this->set(compact('products', 'customerTypes'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CustomerRating', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CustomerRating->save($this->data)) {
				$this->Session->setFlash(__('The CustomerRating has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CustomerRating could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CustomerRating->read(null, $id);
		}
		$products = $this->CustomerRating->Product->find('list');
		$customerTypes = $this->CustomerRating->CustomerType->find('list');
		$this->set(compact('products','customerTypes'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CustomerRating', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CustomerRating->del($id)) {
			$this->Session->setFlash(__('CustomerRating deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->CustomerRating->recursive = 0;
		$this->set('customerRatings', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CustomerRating.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('customerRating', $this->CustomerRating->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->CustomerRating->create();
			if ($this->CustomerRating->save($this->data)) {
				$this->Session->setFlash(__('The CustomerRating has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CustomerRating could not be saved. Please, try again.', true));
			}
		}
		$products = $this->CustomerRating->Product->find('list');
		$customerTypes = $this->CustomerRating->CustomerType->find('list');
		$this->set(compact('products', 'customerTypes'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CustomerRating', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CustomerRating->save($this->data)) {
				$this->Session->setFlash(__('The CustomerRating has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CustomerRating could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CustomerRating->read(null, $id);
		}
		$products = $this->CustomerRating->Product->find('list');
		$customerTypes = $this->CustomerRating->CustomerType->find('list');
		$this->set(compact('products','customerTypes'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CustomerRating', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CustomerRating->del($id)) {
			$this->Session->setFlash(__('CustomerRating deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
