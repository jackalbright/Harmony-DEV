<?php
class StaticController extends AppController {

	var $name = 'Static';
	var $helpers = array('Html', 'Form');
	var $uses = array();
	#var $uses = array("Product", "GalleryImage", "CustomImage","Charm","CharmCategory","CharmCategoryCharm","Tassel","Part");
	var $breadcrumbs = false;
	var $controller_crumbs = false;

	function beforeFilter()
	{
		
		parent::beforeFilter();
	}

	function workrequest()
	{
		$this->require_https();
		$this->body_title = "Request For Work";


		$products = $this->Product->findAll("available = 'yes' AND is_stock_item = 0",null, 'is_stock_item, name');
		$product_map = Set::combine($products, '{n}.Product.product_type_id', '{n}.Product.name');
		$product_mins = Set::combine($products, '{n}.Product.product_type_id', '{n}.Product.minimum');
		$this->set("product_map", $product_map);
		$this->set("product_minimums", $product_mins);
		$default_min = 1;
		foreach($product_mins as $pid => $min)
		{
			$default_min = $min;
			break;
		}
		$this->set("default_min", $default_min);

		$customer = $this->get_customer();

		if (!empty($customer))
		{
			# If logged in and contact/billing info available, show select buttons INSTEAD OF form.
			# XXX TODO

		}

		if (!empty($this->data))
		{
			# Save into db.

			# REALLY SHOULD SAVE SHIPPING, BILLING, etc into contact_info, credit_card, tables etc...

			$this->sendAdminEmail("Request For Work Website Inquiry", "workrequest_submission", $this->data);
			$this->Session->setFlash("Thank you for your inquiry. We will contact you within 2 business days.");
		}
	}

	function contact()
	{
		$this->body_title = "Contact Us";
		if(!empty($this->data))
		{
			if (!$this->data['message'] || !($this->data['email'] || $this->data['phone']) || $this->data['message'] == 1 || $this->data['email'] == 1)
			{
				$this->Session->setFlash("Please enter in a valid contact info and message to send");
				return;
			}
			$from = '';
			if (preg_match("/\w+@[\w.]+\w+/", $this->data['email']))
			{
				$from = $this->data['email'];
			}
			$this->sendAdminEmail("Website Inquiry", "contact_submission", $this->data, $from);
			$this->action = 'contact_thanks';
			#$this->Session->setFlash("Thank you for your inquiry. We will contact you before the end of business day.");
		}
	}

	function page()
	{
	}

}
