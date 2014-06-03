<?php
class ProductPricingsController extends AppController {

	var $name = 'ProductPricings';
	var $helpers = array('Html', 'Form');
	#var $uses = array('ProductPricing','PricingDiscount');

	function index() {
		$this->ProductPricing->recursive = 0;
		$this->set('productPricings', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ProductPricing.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('productPricing', $this->ProductPricing->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ProductPricing->create();
			if ($this->ProductPricing->save($this->data)) {
				$this->Session->setFlash(__('The ProductPricing has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductPricing could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ProductPricing', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductPricing->save($this->data)) {
				$this->Session->setFlash(__('The ProductPricing has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductPricing could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductPricing->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ProductPricing', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductPricing->del($id)) {
			$this->Session->setFlash(__('ProductPricing deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->ProductPricing->recursive = 0;
		$this->set('productPricings', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ProductPricing.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('productPricing', $this->ProductPricing->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->ProductPricing->create();
			if ($this->ProductPricing->save($this->data)) {
				$this->Session->setFlash(__('The ProductPricing has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductPricing could not be saved. Please, try again.', true));
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


		#if (!$pricings) { $pricings = array(); }
		$this->set("product_id", $product_id);
		#echo "DATA1=".print_r($this->data,true);
		$product = $this->Product->read(null, $product_id);
		$product_code = $product['Product']['code'];
		$product_name = $product['Product']['name'];
		$this->set("product", $product);

		$this->title = "Edit $product_name Pricing";

		if (!empty($this->data['ProductPricing']))
		{
			# Loop through and if any blank ones, remove if existing in db, ignore if blank.
			#
			$pricing_data = array();
			foreach($this->data['ProductPricing'] as &$pricing)
			{
				if (empty($pricing['price']) && empty($pricing['percent_discount']))
				{
					if ($pricing['price_point_id'] != "") # Delete from db.
					{
						$this->ProductPricing->del($pricing['price_point_id']);
					} else { # Blank, ignore.
						#
					}
				} else {
					$pricing['productCode'] = $product_code;
					$pricing_data[] = $pricing;
				}

			}
			$this->ProductPricing->saveAll($pricing_data);
			$this->Session->setFlash("Pricing updated");
		}
		$pricings = $this->ProductPricing->findAllByProductTypeId($product_id, array(), 'quantity');
		if (!$pricings) { $pricings = array(); }
		foreach($pricings as &$pricing)
		{
			if (empty($pricing['ProductPricing']['percent_discount']))
			{
				$percent = $pricing['ProductPricing']['price']  / $pricings[0]['ProductPricing']['price'] * 100;
				$pricing['ProductPricing']['percent_discount'] = round($percent,2);
				# Calculate!
			}
		}
		$this->data['ProductPricing'] = Set::combine($pricings, '{n}.ProductPricing.price_point_id', '{n}.ProductPricing');  
		$this->data['Product'] = $product['Product'];
		#echo "DAT=".print_r($this->data,true);
		#$this->set("pricings", $pricings);
	}

	function admin_edit_list_ajax($product_id = null)
	{
		Configure::write('debug', 0);
		$this->layout = 'ajax';

		if ($product_id == null)
		{
			$this->action = "no_product";
			return;
		}

		#if (!$pricings) { $pricings = array(); }
		$this->set("product_id", $product_id);
		#echo "DATA1=".print_r($this->data,true);
		$product = $this->Product->read(null, $product_id);
		$product_code = $product['Product']['code'];

		if (!empty($this->data['ProductPricing']))
		{
			# Loop through and if any blank ones, remove if existing in db, ignore if blank.
			#
			$pricing_data = array();
			foreach($this->data['ProductPricing'] as &$pricing)
			{
				if ($pricing['price'] == "")
				{
					if ($pricing['price_point_id'] != "") # Delete from db.
					{
						$this->ProductPricing->del($pricing['price_point_id']);
					} else { # Blank, ignore.
						#
					}
				} else {
					$pricing['productCode'] = $product_code;
					$pricing_data[] = $pricing;
				}

			}
			$this->ProductPricing->saveAll($pricing_data);
			$this->Session->setFlash("Pricing updated");
		}
		$pricings = $this->ProductPricing->findAllByProductTypeId($product_id, array(), 'quantity');
		if (!$pricings) { $pricings = array(); }
		$this->data['ProductPricing'] = Set::combine($pricings, '{n}.ProductPricing.price_point_id', '{n}.ProductPricing');  
		#echo "DAT=".print_r($this->data,true);
		#$this->set("pricings", $pricings);
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ProductPricing', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductPricing->save($this->data)) {
				$this->Session->setFlash(__('The ProductPricing has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ProductPricing could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductPricing->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ProductPricing', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductPricing->del($id)) {
			$this->Session->setFlash(__('ProductPricing deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
