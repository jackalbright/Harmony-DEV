<?php
class ProductPartsController extends AppController {

	var $name = 'ProductParts';
	var $helpers = array('Html', 'Form');
	var $uses = array('ProductPart','Part');

	function index() {
		$this->ProductPart->recursive = 0;
		$this->set('productParts', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ProductPart.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('productPart', $this->ProductPart->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ProductPart->create();
			if ($this->ProductPart->save($this->data)) {
				$this->Session->setFlash(__('The ProductPart has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductPart could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ProductPart', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductPart->save($this->data)) {
				$this->Session->setFlash(__('The ProductPart has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductPart could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductPart->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ProductPart', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductPart->del($id)) {
			$this->Session->setFlash(__('ProductPart deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->ProductPart->recursive = 0;
		$this->set('productParts', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ProductPart.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('productPart', $this->ProductPart->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->ProductPart->create();
			if ($this->ProductPart->save($this->data)) {
				$this->Session->setFlash(__('The ProductPart has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductPart could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit_list($product_id = null)
	{
		#Configure::write('debug', 0);

		if ($product_id == null)
		{
			$this->action = "no_product";
			return;
		}


		#if (!$parts) { $parts = array(); }
		$this->set("product_id", $product_id);
		#echo "DATA1=".print_r($this->data,true);
		$product = $this->Product->read(null, $product_id);
		$product_name = $product['Product']['name'];
		$this->set("product", $product);

		$this->title = "Edit $product_name Customization Parts";

		$all_parts = $this->Part->findAll();
		$this->set("all_parts", $all_parts);
		$product_parts = $this->ProductPart->findAll("ProductPart.product_type_id = '$product_id'");

		if (!empty($this->data['ProductPart']))
		{
			# Loop through and if any blank ones, remove if existing in db, ignore if blank.
			#
			$part_data = array();
			foreach($this->data['ProductPart'] as &$part)
			{
				if ($part['optional'] == "none")
				{
					if ($part['product_part_id'] != "") # Delete from db.
					{
						$this->ProductPart->del($part['product_part_id']);
					} else { # Blank, ignore.
						#
					}
				} else {
					$part['product_type_id'] = $product_id;
					$part_data[] = $part;
				}

			}
			$this->ProductPart->saveAll($part_data);
			$this->Session->setFlash("Customization options updated");
		} else {
			$this->data['ProductPart'] = Set::combine($product_parts, '{n}.ProductPart.part_id', '{n}.ProductPart');  
		}
		$this->data['Product'] = $product['Product'];
		#echo "DAT=".print_r($this->data,true);
		#$this->set("parts", $parts);
	}


	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ProductPart', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductPart->save($this->data)) {
				$this->Session->setFlash(__('The ProductPart has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductPart could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductPart->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ProductPart', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductPart->del($id)) {
			$this->Session->setFlash(__('ProductPart deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>