<?php
class WorkRequestsController extends AppController {

	var $name = 'WorkRequests';
	var $helpers = array('Html', 'Form');
	var $uses = array('WorkRequest','ContactInfo','CreditCard');
	var $paginate = array('order'=>'work_request_id DESC');
	var $wholesale = false;

	#function index() {
	#	$this->WorkRequest->recursive = 1;
	#	$this->set('workRequests', $this->paginate());
	#}
#
#	function view($id = null) {
#		if (!$id) {
#			$this->Session->setFlash(__('Invalid WorkRequest.', true));
#			$this->redirect(array('action'=>'index'));
#		}
#		$this->set('workRequest', $this->WorkRequest->read(null, $id));
#	}

	function add()
	{
		$this->require_https();
		#print_r($this->params);
		$params = !empty($this->params['pass']) ? $this->params['pass'] : array();
		$mode =  !empty($params) ? $params[0] : null;
		$this->set("mode", $mode);

		if ($mode == 'wholesale')
		{
			$this->wholesale = true;
		}
		$this->set("wholesale", $this->wholesale);

		if ($mode == 'build')
		{
			# Load image....
			$image = !empty($this->build['CustomImage']) ? $this->build['CustomImage'] : null;
			$this->set("custom_image", $image);

			$product = !empty($this->build['Product']) ? $this->build['Product'] : null;
			$this->set("product", $product);
		}


		$this->body_title = "Request For Work " . ($this->wholesale ? " - Wholesale " :"");

		$this->js_required_fields[] = "WorkRequestName";
		$this->js_required_fields[] = "WorkRequestEmail";
		$this->js_required_fields[] = "WorkRequestPhone";

		$this->js_required_fields[] = "ShippingAddress";
		$this->js_required_fields[] = "ShippingCity";
		$this->js_required_fields[] = "ShippingState";
		$this->js_required_fields[] = "ShippingZip";

		# require card type...

		# and if type is not paypal, require other stuff too!

		$this->js_required_fields[] = "CreditCardCardType";
		$this->js_required_fields_if["$('CreditCardCardType').value != 'Paypal'"] = array("CreditCardNumberPlain", "BillingAddress", "BillingCity", "BillingState", "BillingZip");

		#$this->js_required_fields[] = "CreditCardNumberPlain";
#
#		$this->js_required_fields[] = "BillingAddress";
#		$this->js_required_fields[] = "BillingCity";
#		$this->js_required_fields[] = "BillingState";
#		$this->js_required_fields[] = "BillingZip";

		$this->js_required_fields[] = "WorkRequestProductTypeId";



		#$products = $this->Product->findAll("available = 'yes' AND is_stock_item = 0",null, 'is_stock_item, name');
		$products = $this->Product->findAll("available = 'yes'",null, 'is_stock_item, name');
		$product_map = Set::combine($products, '{n}.Product.product_type_id', '{n}.Product.name');
		$product_mins = Set::combine($products, '{n}.Product.product_type_id', '{n}.Product.minimum');
		$products_by_id = Set::combine($products, '{n}.Product.product_type_id', '{n}');

		$stock_items = array();
		foreach($products as $p)
		{
			if ($p['Product']['is_stock_item'])
			{
				$pid = $p['Product']['product_type_id'];
				$stock_items[] = $pid;
			}
		}

		$this->set("products_by_id", $products_by_id);
		$this->set("stock_items", $stock_items);
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
		#	error_log("GOT=".print_r($this->data,true));

			# VERIFY CREDIT CARD and save...
			# XXX TODO
			$this->data['CreditCard']['Expiration'] = $this->data['CreditCard']['Expiration']['year'] . '-' . $this->data['CreditCard']['Expiration']['month'] . '-01';
			# Verify completedness....

			# Make assumption...
			$this->data['CreditCard']['Cardholder'] = $this->data['WorkRequest']['name'];
			#if (!$this->data['CreditCard']['Cardholder'])
			#{
			#	$this->Session->setFlash("Missing cardholder name");
			#	return;
			#} else 
			if ($this->data['CreditCard']['Card_Type'] != 'Paypal')
			{
				if (!$this->CreditCard->is_valid_credit_card($this->data['CreditCard']['NumberPlain'])) {
					$this->Session->setFlash("<div class='warn'>Invalid card number</div>");
					return;
				} else if (strtotime($this->data['CreditCard']['Expiration']) < time()) {
				#	error_log("EXP=".print_r($this->data['CreditCard'],true));
					$this->Session->setFlash("<div class='warn'>Invalid expiration date. Card has expired.</div>");
					return;
				}
				$this->data['CreditCard']['Number'] = $this->CreditCard->encrypt($this->data['CreditCard']['NumberPlain']);
		
				$this->CreditCard->save($this->data);
				$credit_card_id = $this->CreditCard->id;
				$this->data['WorkRequest']['credit_card_id'] = $credit_card_id;

				if (!empty($this->data['Billing']))
				{
					$this->data['Billing']['In_Care_Of'] = $this->data['WorkRequest']['name'];
					$this->ContactInfo->save(array('ContactInfo'=>$this->data['Billing']));
					$billing_id = $this->ContactInfo->id;
					$this->data['WorkRequest']['billing_id'] = $billing_id;
				}
			} else {
				$this->data['WorkRequest']['paypal'] = 1;
			}

		#	error_log("DATA=".print_r($this->data,true));


			# Save billing, shipping address...

			if(!empty($this->data['Shipping']))
			{
				$this->ContactInfo->id = null; # CLEAR!
				$this->data['Shipping']['In_Care_Of'] = $this->data['WorkRequest']['name'];
				$this->ContactInfo->save(array('ContactInfo'=>$this->data['Shipping']));
				$shipping_id = $this->ContactInfo->id;
				$this->data['WorkRequest']['shipping_id'] = $shipping_id;
			}



			# PROCESS IMAGE UPLOAD
			$image_path = "/images/workrequests";
			$image_prefix = time() . rand(0, 10000);
			$this->Image->allowed = $this->Image->all_types;
			if ($this->Image->didSupplyUpload('file')) # Otherwise, we don't care!
			{
				$return = $this->Image->saveUpload('file', $image_path, $image_prefix); # Done separately from actual db
				if ($return && is_array($return))
				{
					$this->Session->setFlash("<div class='warn'>Sorry, we are unable to save your image: " .  join("<br/>\n", $return) .'</div>');
					return;
				}
				$filename = $return;
				$this->data['WorkRequest']['image_location'] = "$image_path/$filename";
			}

			$this->WorkRequest->save($this->data);
			$work_request_id = $this->WorkRequest->id;
			$this->data["WorkRequest"]["work_request_id"] = $work_request_id;

			if (!$this->malysoft) { $this->sendAdminEmail("Request For Work Website Inquiry", "workrequest_submission", $this->data); }
			#$this->sendEmail('t_maly@comcast.net', "Request For Work Website Inquiry", "workrequest_submission", $this->data);
			$this->action = "submitted";

			$this->body_title = "Request For Work Submitted";
		}
	}

	function pricing()
	{
		$wholesale = !empty($this->data['WorkRequest']['wholesale']);

		$this->set_ajax();
		$price = 0;
		if (!empty($this->data))
		{
			$customer =array();
			if ($wholesale) { $customer['pricing_level'] = 100; }
			$pid = $this->data['WorkRequest']['product_type_id'];
			$qty = $this->data['WorkRequest']['quantity'];
			$pricing = $this->Product->get_effective_base_price($pid, $qty, $customer);
			$price = $pricing['total'] * $qty;
		#	error_log("PID=$pid, QTY=$qty, PRICE=$price");
		}
		$this->set("price", $price);
	}

	function add_old() {
		if (!empty($this->data)) {
			$this->WorkRequest->create();
			if ($this->WorkRequest->save($this->data)) {
				$this->Session->setFlash(__('The WorkRequest has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The WorkRequest could not be saved. Please, try again.', true));
			}
		}
		$products = $this->WorkRequest->Product->find('list');
		$creditCards = $this->WorkRequest->CreditCard->find('list');
		$billingAddresses = $this->WorkRequest->BillingAddress->find('list');
		$shippingAddresses = $this->WorkRequest->ShippingAddress->find('list');
		$this->set(compact('products', 'creditCards', 'billingAddresses', 'shippingAddresses'));
	}

	#function edit($id = null) {
	#	if (!$id && empty($this->data)) {
	#		$this->Session->setFlash(__('Invalid WorkRequest', true));
	#		$this->redirect(array('action'=>'index'));
	#	}
	#	if (!empty($this->data)) {
	#		if ($this->WorkRequest->save($this->data)) {
	#			$this->Session->setFlash(__('The WorkRequest has been saved', true));
	#			$this->redirect(array('action'=>'index'));
	#		} else {
	#			$this->Session->setFlash(__('The WorkRequest could not be saved. Please, try again.', true));
	#		}
	#	}
	#	if (empty($this->data)) {
	#		$this->data = $this->WorkRequest->read(null, $id);
	#	}
	#	$products = $this->WorkRequest->Product->find('list');
	#	$creditCards = $this->WorkRequest->CreditCard->find('list');
	#	$billingAddresses = $this->WorkRequest->BillingAddress->find('list');
	#	$shippingAddresses = $this->WorkRequest->ShippingAddress->find('list');
	#	$this->set(compact('products','creditCards','billingAddresses','shippingAddresses'));
	#}
#
#	function delete($id = null) {
#		if (!$id) {
#			$this->Session->setFlash(__('Invalid id for WorkRequest', true));
#			$this->redirect(array('action'=>'index'));
#		}
#		if ($this->WorkRequest->del($id)) {
#			$this->Session->setFlash(__('WorkRequest deleted', true));
#			$this->redirect(array('action'=>'index'));
#		}
#	}
#
#
	function admin_index() {
		$this->WorkRequest->recursive = 1;
		$this->set('workRequests', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid WorkRequest.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('workRequest', $this->WorkRequest->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->WorkRequest->create();
			if ($this->WorkRequest->save($this->data)) {
				$this->Session->setFlash(__('The WorkRequest has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The WorkRequest could not be saved. Please, try again.', true));
			}
		}
		$products = $this->WorkRequest->Product->find('list');
		$creditCards = $this->WorkRequest->CreditCard->find('list');
		$billingAddresses = $this->WorkRequest->BillingAddress->find('list');
		$shippingAddresses = $this->WorkRequest->ShippingAddress->find('list');
		$this->set(compact('products', 'creditCards', 'billingAddresses', 'shippingAddresses'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid WorkRequest', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->WorkRequest->save($this->data)) {
				$this->Session->setFlash(__('The WorkRequest has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The WorkRequest could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->WorkRequest->read(null, $id);
		}
		$products = $this->WorkRequest->Product->find('list');
		$creditCards = $this->WorkRequest->CreditCard->find('list');
		$billingAddresses = $this->WorkRequest->BillingAddress->find('list');
		$shippingAddresses = $this->WorkRequest->ShippingAddress->find('list');
		$this->set(compact('products','creditCards','billingAddresses','shippingAddresses'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for WorkRequest', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->WorkRequest->del($id)) {
			$this->Session->setFlash(__('WorkRequest deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
