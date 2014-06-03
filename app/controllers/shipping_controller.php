<?php
class ShippingController extends AppController {

	var $name = 'Shipping';
	var $helpers = array('Html', 'Form');
	var $uses = array("Product", "ShippingPricePoint");

	function beforeFilter()
	{
		
		parent::beforeFilter();

		switch($this->action)
		{
			case 'admin_add':
			case 'admin_edit':
			case 'add':
			case 'edit':
				break;
		}
	}

	function beforeRender()
	{
		parent::beforeRender();

		switch($this->action)
		{
			case 'admin_add':
			case 'admin_edit':
			case 'add':
			case 'edit':
				break;
		}
	}

	function calculator_item($num = 0)
	{
		Configure::write("debug", 0);
		$this->layout = 'ajax';
		$this->set("i", $num);
		$all_products = $this->Product->findAll(null, null, 'name');
		$all_products_map = Set::combine($all_products, '{n}.Product.code', '{n}.Product.name');
		$this->set("all_products_map", $all_products_map);
	}

	function shipping($prod = null)
	{
		Configure::write("debug", 0);
		if (!empty($this->data))
		{
			$quantity = $this->data['Shipping']['quantity'];
			$zipCode = $this->data['Shipping']['zipCode'];
			if (!$prod) { $prod = $this->data['Shipping']['prod']; }
			$shippingOptions = $this->ShippingPricePoint->calculate_shipping_options_us($zipCode, $prod, $quantity);
			#print_r($shippingOptions);
			$this->set("shippingOptions", $shippingOptions);
		}
		#$this->Product->recursive = -2;
		$this->set("products", $this->Product->findAll("available = 'yes' AND buildable = 'yes' AND parent_product_type_id IS NULL", array(),"name ASC"));
		if ($prod)
		{
			$this->set("prod", $prod);
			$product = $this->Product->find("code = '$prod'");
			$this->set("product", $product);
			if (!isset($this->data['Shipping']['quantity']))
			{
				$this->data['Shipping']['quantity'] = $product['ProductPricing'][0]['quantity'];
			}
		}
	}
}
?>
