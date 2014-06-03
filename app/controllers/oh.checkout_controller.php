<?php

include_once(dirname(__FILE__)."/../../includes/product_pricing.php");

include_once("cart_items_controller.php");

class CheckoutController extends CartItemsController {

	var $name = 'Checkout';
	var $helpers = array('Html', 'Form','Ajax');
	var $uses = array("Product", "ProductPricing", "ProductPart", "GalleryImage", "CustomImage", "CustomizationOption", "ProductRecommendedQuote", "ImageRecommendedQuote","Quote","Tassel","Charm","Border","Ribbon","Frame","ContactInfo","ShippingPricePoint","CartItem","CreditCard","Country","Purchase","OrderItem","ItemPart","ShippingMethod",'Coupon');
	var $components = array('AuthorizeNet','AddressBook','Payment','Paypal','Cim','Amazon');
	var $options = array();
	#var $checkout_step = 1;
	var $controller_crumbs = false;
	var $complete = array();
	var $public_methods = array('form','shipping_options','update_shipping_speed','form_address_edit','form_address_select','form_address_view','form_address_delete','form_data','admin_save_cart_item','redeem_coupon');
	var $logged = false;

	function generate_breadcrumbs()
	{
		$this->breadcrumbs["/cart"] = "Cart";
	}


	function setFlash($msg, $level = 'default', $params=array(), $key = 'flash') # Intercept/log
	{
		$this->log($msg); # Always log the messages THEY see.
		return $this->Session->setFlash($msg,$level,$params,$key);
	}

	function require_wholesale()
	{
		#error_log("AUTH HCEKC");
		#error_log("WHOLE=".Configure::read("wholesale_site"));
		#error_log("USER=".$this->Auth->user("is_wholesale"));
		if($this->Auth->user() && Configure::read("wholesale_site") && !$this->Auth->user("is_wholesale"))
		{
			$this->setFlash("You currently have a retail account. Please call to request a wholesale account: 888.293.1109 or <a href='https://www.harmonydesigns.com/checkout/'>continue to checkout as a retail customer</a>", "warn");
			return false;
		}
		return true;
	}

	function beforeFilter()
	{
		#error_log("TRACE=".Debugger::trace());
		if(!empty($this->params['admin'])) { return parent::beforeFilter(); } # Dont mess up auth....
		#error_log("XO BEFORE=".print_r($this->Session->read(),true));
		parent::beforeFilter();
		#error_log("ACT1".$this->action.", PM=".print_r($this->public_methods,true));

		$customer = $this->Session->read("Auth.Customer");
		if (empty($customer) && $this->action != 'index')
		{
			#$cart = $this->get_cart_items();
			#if (empty($cart))
			#{
			if ($this->action == 'index') { 
				$this->redirect("/");
			} else if (!in_array($this->action, $this->public_methods) && empty($this->params['isAjax'])) { 
				error_log("ACT=".$this->action.", PM=".print_r($this->public_methods,true));
				$this->redirect("/checkout");
			}
			#} else {
			#	$this->redirect("/cart/display");
			#}
		}

		$this->complete = $this->Session->read("checkout_complete");

		if (!empty($customer['billme']))
		{
			$this->billme = true;
		}
		$this->require_https();


		$this->set("in_checkout", true);
	}

	function beforeRender()
	{
		parent::beforeRender();
		#$this->set("checkout_step", $this->checkout_step);
		#$this->set("status_bar_template", "checkout/progress");
		$this->set("customer_po", $this->Session->read("customer_po"));

		$products = $this->Product->findAll('available = "yes" ');
		$productMap = Set::combine($products, '{n}.Product.code', '{n}.Product');
		$productList = Set::combine($products, '{n}.Product.product_type_id', '{n}.Product');
		$this->set("product_map", $productMap);
		$parentProductMap = array();
		foreach($productMap as $code=>$p)
		{
			if(!empty($p['parent_product_type_id']))
			{
				$parentProductMap[$code] = $productList[$p['parent_product_type_id']];
			}
		}

		$this->set("parent_product_map", $parentProductMap);
		#

		$this->set("pricing_map", Set::combine($products, '{n}.Product.code', '{n}.ProductPricing'));
	}

	function index()
	{
		#if($this->Session->read("Auth.Customer.is_admin"))
		#{
			error_log("IOND");
			return $this->redirect(array('action'=>'form'));
		#}

		##############

		$this->body_title = 'Checkout';
			chmod($fileName, 0644);
		# If logged in, redirect
		$customer = $this->Session->read("Auth.Customer");

		$this->load_cart(); # Loads shipping stuff...

		# Erase purchase ID if modified cart, etc... since stores purchase price, etc.
		$purchase_id = $this->Session->read("purchase_id");
		if(!empty($purchase_id))
		{
			$this->Purchase->del($purchase_id); # Remove record!
			$this->Session->delete("purchase_id");
		}

		# Clear out defaults so we prompt them for everything.
		#$this->Session->delete('shipping_method_id');
		$this->Session->delete("shipping_id");
		$this->Session->delete("billing_id");
		$this->Session->delete("payment_id");
		

		# TODO FORCE LOGIN NO MATTER WHAT. page will always show!
		#return $this->render("/account/login");


		if(!empty($customer) && empty($customer['guest']))
		{
			$this->redirect("/checkout/review");
		}
		# Going to checkout page.
		$this->track("checkout","index");
		# Asked to choose account path.
	}

	function form_address_view($address_type = 'shipping', $address_id = null, $edited = false)
	{
		$guest = $this->Session->read("Auth.Customer.guest");
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		if(empty($address_id))
		{
			$address_id = $this->Session->read("{$address_type}_id");
		}
		if(empty($address_id))
		{
			$address_id = $this->Session->read("Auth.Customer.{$address_type}_id_pref");
		}
		if(!empty($address_id))
		{
			$this->Session->write("{$address_type}_id",$address_id);
		}

		$addresses = !empty($customer_id) ? $this->ContactInfo->findAll("ContactInfo.customer_id = '$customer_id'") : null;
		$addresses_by_id = Set::combine($addresses, "{n}.ContactInfo.Contact_ID", "{n}");
		# If nothing in system, go to edit (add) form
		if(empty($addresses))
		{
			#$this->redirect(array('action'=>'form_address_edit',$address_type));
			$this->setAction("form_address_edit", $address_type);
		}
		$this->set("addresses", $addresses);

		$address = !empty($address_id) && !empty($addresses_by_id[$address_id]) ? $addresses_by_id[$address_id] : $addresses[0];
		$this->set("address", $address);
		$address_id = $address['ContactInfo']['Contact_ID'];
		$this->set("address_id", $address_id);

		$this->set("edited", $edited);

		$this->set("address_type", $address_type);

		$this->set("shipping_id", $this->Session->read("shipping_id"));
		$this->set("billing_id", $this->Session->read("billing_id"));
	}
	function form_address_edit($address_type = 'shipping', $id = null)
	{
		$addresses = !empty($customer_id) ? $this->ContactInfo->findAll("ContactInfo.customer_id = '$customer_id'") : null;
		$this->set("addresses", $addresses);

		$addressModel = Inflector::classify("{$address_type}_address");
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$guest = $this->Session->read("Auth.Customer.guest");
		if(!empty($this->data[$addressModel]))  # Saving...
		{
			# If not saving customer id,, wont be able to get list.
			$this->data[$addressModel]['Customer_ID'] = $customer_id;
			$this->ContactInfo->save(array('ContactInfo'=>$this->data[$addressModel]));
			$id = $this->ContactInfo->id;

			if (!empty($customer_id)) {
				#error_log("REDIR SINCE CUST=$customer_id");
				$this->redirect(array('action'=>'form_address_view',$address_type,$id,1));
			} else { 
				#error_log("LOADING FAV $id");
				$this->set("address_id", $id);
				$this->set("address", $this->ContactInfo->read(null, $id));
				# XXX TODO need to double check contact info has customer id on it....
				$this->action = 'form_address_view';
			}
			# Show view version, since saving....
		}

		$this->set("countries", $this->Country->findAll(" can_order = 'Yes' "));

		if(!empty($id))
		{
			$address = $this->ContactInfo->read(null,$id);
			$this->data[$addressModel] = $address['ContactInfo'];
		}
		if($addressModel == 'ShippingAddress' && empty($this->data[$addressModel]['Zip_Code']) && $zipCode = $this->Session->read("zipCode"))
		{
			#error_log("POPULATING ZIPCODE=$zipCode");
			$this->data[$addressModel]['Zip_Code'] = $zipCode;
			$this->data[$addressModel]['Country'] = $this->Session->read("country");
		}
		$this->set("shipping_id", $this->Session->read("shipping_id"));
		$this->set("billing_id", $this->Session->read("billing_id"));

		$this->set("address_id", $id);
		$this->set("address_type", $address_type);
		$addresses = !empty($customer_id) ? $this->ContactInfo->findAll("ContactInfo.customer_id = '$customer_id'") : null;
		$this->set("addresses", $addresses);
	}
	function form_address_select($address_type = 'select',$edited = false)
	{
		$guest = $this->Session->read("Auth.Customer.guest");
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$addresses = !empty($customer_id) ? $this->ContactInfo->findAll("ContactInfo.customer_id = '$customer_id'") : null;
		if(empty($addresses))
		{
			$this->setAction("form_address_edit", $address_type);
		}
		$this->set("addresses", $addresses);
		$this->set("address_type", $address_type);
		$this->set("edited", $edited);
	}
	function form_address_delete($address_type = 'select', $id)
	{
		$this->ContactInfo->delete($id);
		$this->redirect(array('action'=>'form_address_select',$address_type,1));
	}

	#################################################################
	function form_data()
	{
	}

	function form() # one-pager.
	{
		if(!empty($this->data['coupon']))
		{
			error_log("COUPON!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
			$coupon = $this->data['coupon'];
			$this->Session->write("coupon", $coupon); # Apply before loading cart...
		}

		error_log("IN FORM");
		$this->body_title = 'Checkout';
		list($shoppingCart, $subtotal, $product_list, $eligible_subtotal, $discount) = $this->load_cart();

		error_log("DISCOUNT=$discount");



		# Load auth.net profile
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$is_wholesale = $this->Session->read("Auth.Customer.is_wholesale");
		error_log("CUSTOMER_ID=$customer_id");
		$admin = $this->Session->read("Auth.Customer.is_admin");

		if($is_wholesale && $subtotal < $this->get_config_value('wholesale_purchase_minimum'))
		{
			$this->setFlash(true, null, null, "under_wholesale_minimum");
			# They haven't met the minimum for wholesale checkout
			$this->redirect("/cart/display.php"); # Cart suggests adding more always for wholesale customers
		}

		error_log("POST_DATA=".print_r($this->data,true));

		if($this->require_wholesale() && !empty($this->data)) # Process order.
		{
			error_log("PROCESSING ORDER");
			$this->Session->write("Checkout", $this->data); # Save.

			if(empty($this->data['Customer']['eMail_Address']))
			{
				$this->flashError("Email cannot be left blank.");
				return $this->loadFormVars();
			}
			if(empty($this->data['Customer']['Phone']) || !preg_match("/\d+/", $this->data['Customer']['Phone']))
			{
				$this->flashError("Phone number invalid or not provided");
				return $this->loadFormVars();
			}
			#######################################

			# Check password, if given.
			if(isset($this->data['Customer']['guest']) && empty($this->data['Customer']['guest'])) {
				$password = $this->data['Customer']['Password'];
				$password2 = $this->data['Customer']['Password2'];
				if(empty($password))
				{
					$this->flashError("Please enter a password to create your account");
					return $this->loadFormVars();
				} else if(strlen($password) < 6) { 
					$this->flashError("Password must be 6 or more characters.");
					return $this->loadFormVars();
				} else if($password != $password2) {
					$this->flashError("Passwords do not match.");
					return $this->loadFormVars();
				}


				# Check to see if existing customer, and password not matching.
				$customer = $this->Customer->findByEmailAddress($this->data['Customer']['eMail_Address']);
				error_log("CUSTOMER BT EMAIL=".print_r($customer,true));
				if(!empty($customer) && $customer['Customer']['Password'] != $password)
				{
					$this->flashError("You already have an account in our system. <a href='/account/login'>Sign in to your existing account</a> or uncheck 'Create an account' to continue as a guest");
					return $this->loadFormVars();
				} else if (!empty($customer) && !empty($password) && $customer['Customer']['Password'] == $password) {
					$customer_id = $customer['Customer']['customer_id'];
					error_log("CUSTOMER_ID MATCH=$customer_id");
					$this->Auth->login($customer_id); # log them in....
				}
				#error_log("CID=$customer_id, C=$customer, P=$password");
			}

			$shipping_id = !empty($this->data['ShippingAddress']['Contact_ID']) ? $this->data['ShippingAddress']['Contact_ID'] : null;# = $this->Session->read("shipping_id");
			$billing_id = !empty($this->data['BillingAddress']['Contact_ID']) ? $this->data['BillingAddress']['Contact_ID'] : null;# = $this->Session->read("billing_id");

			if(!empty($this->data['billing_same'])) { $billing_id = $shipping_id; $this->data['BillingAddress'] = $this->data['ShippingAddress']; }

			# Get billing/shipping info if not there...
			$billing = $shipping = null;
			if(!empty($billing_id))
			{
				$billing = $this->ContactInfo->read(null, $billing_id);
			}
			if(!empty($shipping_id))
			{
				$shipping = $this->ContactInfo->read(null, $shipping_id);
			}

			# If currently logged in and email mismatches (changed),
			# create a guest account
			$user_email = $this->Session->read("Auth.Customer.eMail_Address");
			$form_email = !empty($this->data['Customer']['eMail_Address']) ? 
				$this->data['Customer']['eMail_Address'] : null;
				
			if($user_email != $form_email)
			{
				unset($customer_id); # New/guest user.
			}

			if(empty($customer_id)) # Create a new customer
			{
				error_log("NEW CUSTOMER");
				# Check password matching... (maybe in js too)

				# Guest vs permanent account.
				$this->Customer->create();

				$customer = $this->data;

			} else {
				error_log("EXIST CUSTOMER=$customer_id");
				$this->Customer->id = $customer_id;
				$customer = $this->Customer->read();
			}

			#error_log("CUSTOMER (ID=$customer_id)=".print_r($customer,true));

				$billing_incareof = null;
				if(!empty($this->data['BillingAddress']['Name']))
				{
					$billing_incareof = split(" ", join(" ", $this->data['BillingAddress']['Name']));
				} else if (!empty($billing['ContactInfo']['In_Care_Of'])) {
					$billing_incareof = split(" ", $billing['ContactInfo']['In_Care_Of']);
				}
				$shipping_incareof = null;
				if(!empty($this->data['ShippingAddress']['Name']))
				{
					$shipping_incareof = split(" ", join(" ", $this->data['ShippingAddress']['Name']));
				} else if (!empty($shipping['ContactInfo']['In_Care_Of'])) {
					$shipping_incareof = split(" ", $shipping['ContactInfo']['In_Care_Of']);
				}

				if(empty($customer['Customer']['First_Name']))
				{
					if(!empty($billing_incareof[0]))
					{
						$this->data['Customer']['First_Name'] =
							$billing_incareof[0];
					} else if(!empty($shipping_incareof[0])) {
						$this->data['Customer']['First_Name'] =
							$shipping_incareof[0];
					}
				}
				if(empty($customer['Customer']['Last_Name']))
				{
					if(!empty($billing_incareof[count($billing_incareof)-1]))
					{
						$this->data['Customer']['Last_Name'] =
							$billing_incareof[count($billing_incareof)-1];
					} else if(!empty($shipping_incareof[count($shipping_incareof)-1])) {
						$this->data['Customer']['Last_Name'] =
							$shipping_incareof[count($shipping_incareof)-1];
					}
				}
				if(empty($customer['Customer']['Company']))
				{
					if(!empty($this->data['BillingAddress']['Company']))
					{
						$this->data['Customer']['Company'] =
							$this->data['BillingAddress']['Company'];
					} else if(!empty($billing['ContactInfo']['Company'])) {
						$this->data['Customer']['Company'] =
							$billing['ContactInfo']['Company'];
					}
					else if(!empty($this->data['ShippingAddress']['Company']))
					{
						$this->data['Customer']['Company'] =
							$this->data['ShippingAddress']['Company'];
					} else if(!empty($shipping['ContactInfo']['Company'])) {
						$this->data['Customer']['Company'] =
							$shipping['ContactInfo']['Company'];
					}
				}

			# SOME FIELDS ARE IGNORED WHEN SAVING.
			# THE ONLY DATA WE CHANGE IN THE USER ACCOUNT IS HERE:

			$valid_keys = array('Phone','eMail_Address','Password','Company','First_Name','Last_Name','customer_id','guest');
			# MUST INCLUDE 'guest' FIELD SO ACCOUNT ISN'T DUPLICATED AS NON-GUEST
			$valid_customer_data = array_intersect_key($this->data['Customer'], array_flip($valid_keys));

			#if(!empty($customer['Customer']['is_admin']) && 
			if(!($customer = $this->Customer->save(array('Customer'=>$valid_customer_data))))
			{
				error_log("UPDATED ACCOUNT=".print_r($customer,true));
				$this->flashError(!empty($customer_id) ? "Could not update your account" : "Could not create your account.");
				$this->loadFormVars();
				return;
			}
			$customer_id = $this->Customer->id;
			error_log("CUSTOMER_ID3=$customer_id");
			$this->Auth->login($customer_id); # Exact info, not mixing up with customer in system.

			# Assign anon images to customer, so we can see their info/email/etc in admin38
			$session_id = session_id();
			$this->CustomImage->moveAnonymousImages($session_id, $customer_id);

			#########################


			if(empty($shipping_id)) # Create shipping profile.
			{
				$this->ContactInfo->create();
			}

			# Always update.
			if(empty($this->data['ShippingAddress'])) # Must be select page...
			{
				$this->flashError("Please choose a shipping address.");
				$this->loadFormVars();
				return;
			}
			if(!$this->ContactInfo->save(array('ContactInfo'=>$this->data['ShippingAddress'])))
			{
				$this->flashError("Could not save shipping information.");
				$this->loadFormVars();
				return;
			}
			$this->data['ShippingAddress']['Contact_ID'] = $shipping_id = $this->ContactInfo->id;
			$this->Session->write("shipping_id",$shipping_id);



			if(empty($billing_id)) # Create shipping profile.
			{
				$this->ContactInfo->create();
			}

			# Always update
			if(empty($this->data['BillingAddress'])) # Must be select page...
			{
				$this->flashError("Please choose a billing address.");
				$this->loadFormVars();
				return;
			}
			if($shipping_id != $billing_id)
			{
				if(!$this->ContactInfo->save(array('ContactInfo'=>$this->data['BillingAddress'])))
				{
					$this->flashError("Could not save billing information.");
					$this->loadFormVars();
					return;
				}
				$this->data['BillingAddress']['Contact_ID'] = $billing_id = $this->ContactInfo->id;
			}
			$billing = $this->ContactInfo->read(null, $billing_id);
			$this->data['BillingAddress'] = $billing['ContactInfo'];
			# Re-read in case we only got ID's
			$this->Session->write("billing_id",$billing_id);
			# 
			$email = $this->data['Customer']['eMail_Address'];
			$name = $this->data['BillingAddress']['In_Care_Of'];
			if(empty($name) && !empty($this->data['CreditCard']['Cardholder']))
			{
				$name = $this->data['CreditCard']['Cardholder'];
			}

			$payment_method = !empty($this->data['payment_method']) ? $this->data['payment_method'] : null;

			$payment_profile_id = null;

			$profile_id = $this->getCustomerProfileId();
			$profile = $this->Cim->get_profile($profile_id);

			if(is_numeric($payment_method))
			{
				$payment_profile_id = $payment_method;
			}

			if($payment_method == 'card') # Add/update.
			{
				if(!$this->updateCustomerPaymentCard($profile_id, $this->data['BillingAddress'], $this->data['CreditCard']))
				{
					# Exact warnin already printed
					$this->loadFormVars();
					return;
				}
				$payment_profile_id = $this->getCustomerPaymentProfileId();
			}

			/*if(!empty($payment_profile_id))
			{
				# ALSO get payment last four digits...
				$cardLast4 = substr((string) $this->Cim->getResponseData("paymentProfile/payment/creditCard/cardNumber"), -4);
					#error_log("CARD LAST 4.a=$cardLast4");
			}
			*/



			# XXX  GET AMOUNT FROM CART!
			list($shoppingCart, $subtotal, $product_list, $eligible_subtotal, $discount) = $this->get_cart_items();
			#$this->set("shoppingCart", $shoppingCart);

			#$this->Session->write("billing_id", $billing_id);
			#$this->Session->write("shipping_id", $shipping_id);



			error_log("INITIALIZING PURCHASE... DSC=$discount");
			$purchase_id = $this->initialize_purchase($shoppingCart, $product_list, $subtotal-$discount, $profile_id, $payment_profile_id, $discount);
			error_log("PURCHASE_ID=$purchase_id");
			if(empty($purchase_id))
			{
				#$this->setFlash("Could not initialize order submission");
				# Only one message allowed, better from inside initialize
				return $this->loadFormVars();
			}
			$description = "Harmony Designs Order #$purchase_id";
		 	$purchase = $this->Purchase->read(null, $purchase_id);
		 	$amount = $purchase['Purchase']['Charge_Amount']; # INCLUDES shipping costs


			# Now everything is set up. Charge.
			if($payment_method == 'billme')
			{
				# Nothing needed to do.

			} else if($payment_method == 'amazon') {
				$response = $this->process_payment_amazon($purchase_id);
			} else if($payment_method == 'paypal') {
				# XXX TODO go to paypal site...
				$response = $this->process_payment_paypal($purchase_id);

			} else if((is_numeric($payment_method) || $payment_method == 'card') && !$this->Cim->charge($profile_id, $payment_profile_id, $amount, $description, $purchase_id)) {
				$msg = "Could not charge your card. ".$this->Cim->error;
				if($admin)
				{
					$msg .= join("<br/>", $this->Cim->debug)
					."<br/><textarea style='width: 100%;' rows=8>".$this->Cim->cim->response."</textarea>Request: <textarea style='width: 100%;' rows=8>". $this->Cim->cim->xml."</textarea>";
				}


				$this->flashError($msg,true);

				if($this->Cim->expired)
				{
					# Delete card so can enter a new one.
					$this->Cim->delete_payment_profile($profile_id, $payment_profile_id);
				}
				$this->Purchase->delete($purchase_id);
				$this->loadFormVars();
				return;
			}

			$this->log("\n\n****** PAYMENT SUCCESSFUL ******\n");

			# Finalize purchase after charged ok.
			$this->set("purchase_id", $purchase_id);
			error_log("FINALIZING ORDER");
			$this->finalize_purchase($purchase_id);
			error_log("ORDER DONE! THANKS");

			# Now show thankyou page...
			$this->action = 'receipt';
			$this->body_title = 'Thank you for your order';
			$this->loadFormVars();

			$this->set("zipCode", $this->data['ShippingAddress']['Zip_Code']);
			$this->set("country", $this->data['ShippingAddress']['Country']);

			return;
		}	
		$this->loadFormVars();

		#print_r($this->data);
	}

	function admin_save_cart_item($cart_item_id) # Move to saved orders.
	{
		$cart_item = $this->CartItem->read(null, $cart_item_id);
		$cart_items = array($cart_item);
		$customer_id = $cart_item['CartItem']['customer_id'];
		#$this->data['payment_method'] = 'billme'; # Default.
		list($shoppingCart, $subtotal, $product_list) = $this->get_cart_items($cart_item_id);
		# XXX TODO

		$purchase_id = $this->_initialize_purchase($customer_id, $shoppingCart, $product_list);
		error_log("PURCHASE_ID=$purchase_id");
		if(empty($purchase_id))
		{
			$this->json_set("error", "Can't initialize purchase");
			return $this->json_render();
		} else {
			if(!$this->_finalize_purchase($purchase_id, $cart_items, $customer_id))
			{
				$this->json_set("error", "Can't finalize purchase");
				return $this->json_render();
			}

			# Delete cart item.
			if(!empty($this->live)) {
				$this->CartItem->delete($cart_item_id);
			}

			$this->setFlash("Moved item to 'Saved Orders'");
			$this->json_set("purchase_id", $purchase_id);
		
			$this->json_set("location", Router::url(
				array('controller'=>'account','action'=>'view',$customer_id,'?rand='.rand(),'#SavedOrders')));
		}

		$this->json_render();

	}

	# Delay, unlikely to be needed for now.
	function removeCard($profile_id, $payment_profile_id)
	{
	}

	function updateCard($profile_id, $payment_profile_id)
	{
		# Load mini form.
		# When save later, id should be considered.
	}

	function loadFormVars()
	{
		$checkout_data = $this->Session->read("Checkout");
		if(empty($checkout_data)) { $checkout_data = array(); }
		foreach($checkout_data as $key => $values)
		{
			if(empty($this->data[$key])) { $this->data[$key] = array(); }
			if(is_array($values))
			{
				foreach($values as $vk=>$vv)
				{
					if(empty($this->data[$key][$vk]))
					{
						$this->data[$key][$vk] = $vv;
					}
				}
			} else {
				if(empty($this->data[$key])) { $this->data[$key] = $values; }
			}
		}

		# NEED TO LOAD CART STUFF...
		$this->set("countries", $this->Country->findAll(" can_order = 'Yes' "));

		$guest = $this->Session->read("Auth.Customer.guest");
		$shipping_id = $this->Session->read("Auth.Customer.shipping_id_pref");
		$billing_id = $this->Session->read("Auth.Customer.billing_id_pref");

		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$profile_id = $this->Session->read("Auth.Customer.profile_id");

		/*
		$sess_shipping_id = $this->Session->read("shipping_id");
		$sess_billing_id = $this->Session->read("billing_id");

		if(!empty($sess_shipping_id)) { $shipping_id = $sess_shipping_id; }
		if(!empty($sess_billing_id)) { $billing_id = $sess_billing_id; }
		*/


		$zipCode = $this->Session->read("zipCode");
		$country = $this->Session->read("country");

		# Load shipping/billing addresses.... if not guest.
		$addresses = !empty($customer_id) ? $this->ContactInfo->findAll("ContactInfo.customer_id = '$customer_id'") : null;

		if(!empty($addresses))
		{
			if(count($addresses) > 1)
			{
				$address_ids = Set::extract("/ContactInfo/Contact_ID", $addresses);
				#error_log("SHIP=$shipping_id, BIL=$billing_id, ADD=".print_r($address_ids,true));
				if(empty($shipping_id) || !in_array($shipping_id, $address_ids))
				{
					$shipping_id = $addresses[0]['ContactInfo']['Contact_ID'];
				}
				if(empty($billing_id) || !in_array($billing_id, $address_ids))
				{
					$billing_id = $addresses[0]['ContactInfo']['Contact_ID'];
				}
			} else { # Only one address, assume it's both.
				$shipping_id = $addresses[0]['ContactInfo']['Contact_ID'];
				$billing_id = $addresses[0]['ContactInfo']['Contact_ID'];
			}
			# 
		}
		if(!empty($this->data['billing_same']))
		{
			$billing_id = $shipping_id;
		}
		$this->set("addresses", $addresses);
		$this->set("shipping_id", $shipping_id);
		$this->set("billing_id", $billing_id);

		$this->Session->write("shipping_id", $shipping_id);
		$this->Session->write("billing_id", $billing_id);
		# Just in case.

		if(!empty($profile_id) && empty($guest)) # Don't load previous credit cards if a guest.
		{
			if($profile = $this->Cim->get_profile($profile_id))
			{
				$this->set("authnet_profile", $profile);
			} else {
				error_log("Unable to retrieve billing profile: ".$this->Cim->error);
				# won't help end user to know.
			}
		}

		if(empty($this->data['Customer']) && !$guest)
		{
			$customer = $this->Session->read("Auth.Customer");
			$this->data['Customer'] = $customer;
		}

		if(!empty($shipping_id) && (empty($this->data['ShippingAddress']) || empty($this->data['ShippingAddress']['Zip_Code'])))
		{
			$shippingInfo = $this->ContactInfo->read(null, $shipping_id);
			$this->data['ShippingAddress'] = $shippingInfo['ContactInfo'];
		} else {
			if(!empty($zipCode))
			{
				$this->data['ShippingAddress']['Zip_Code'] = $zipCode;
			}

			if(!empty($country))
			{
				$this->data['ShippingAddress']['Country'] = $country;
			}
		}

		if(!empty($billing_id))# && empty($this->data['BillingAddress'])) # We already saved earlier, so just in case just Contact_ID, we want whole set...
		{
			$billingInfo = $this->ContactInfo->read(null, $billing_id);
			$this->data['BillingAddress'] = $billingInfo['ContactInfo'];
		}

	}

	function shipping_options()#$zipCode = null)#, $country = 'US')
	{
		$zipCode = !empty($this->params['named']['zipCode']) ? $this->params['named']['zipCode'] : null;
		$country = !empty($this->params['named']['country']) ? $this->params['named']['country'] : "US";

		# This here is saving session info and affecting going back after form submit.
		$this->Session->write("zipCode", $zipCode);
		$this->Session->write("country", $country);

		$this->load_cart(); # Loads shipping stuff...
		$this->set("zipCode", $zipCode);
		$this->set("country", $country);
	}

	function update_shipping_speed()
	{
		error_log("UPDATE _SHIP_SEED=".print_r($this->params['form'],true));
		$this->body_title = "Select shipping speed";

		$this->load_cart(); # Loads shipping stuff...

		if (!empty($this->data['receive_by']))
		{
			# Encoded as ship_meth_id:rush_date
			$receive_info = split(":", $this->data['receive_by']);
			$shipping_method_id = $receive_info[0];
			if(!empty($receive_info[1]))
			{
				$rush_date = $receive_info[1];
				# Calculate rush costs.
				$rush_cost = $this->viewVars['rush_dates'][$rush_date];
				$this->Session->write('rush', true);
				$this->Session->write('rush_date', $rush_date);
				$this->Session->write('rush_cost', $rush_cost);
			} else {
				$this->Session->write('rush', null);
				$this->Session->write('rush_date', null);
				$this->Session->write('rush_cost', null);
			}
		#error_log("UPDATE_SHIP_SPEED ($shipping_method_id)=".$this->data['receive_by']);
			$this->Session->write("shipping_method_id", $shipping_method_id);
			$this->complete_step("shipping_method");
		}

		$this->load_cart(); # Loads shipping stuff...
	}

	function shipping_method()
	{
		$this->body_title = "Select shipping speed";
		$this->checkout_step = 2;

		$this->load_cart(); # Loads shipping stuff...
		$this->track("checkout","shipping_method");

		if (!empty($this->data['receive_by']))
		{
			# Encoded as ship_meth_id:rush_date
			$receive_info = split(":", $this->data['receive_by']);
			$shipping_method_id = $receive_info[0];
			if(!empty($receive_info[1]))
			{
				$rush_date = $receive_info[1];
				# Calculate rush costs.
				$rush_cost = $this->viewVars['rush_dates'][$rush_date];
				$this->Session->write('rush', true);
				$this->Session->write('rush_date', $rush_date);
				$this->Session->write('rush_cost', $rush_cost);
			} else {
				$this->Session->write('rush', null);
				$this->Session->write('rush_date', null);
				$this->Session->write('rush_cost', null);
			}
		#error_log("UPDATE_SHIP_SPEED 2 ($shipping_method_id)=".$this->data['receive_by']);
			$this->Session->write("shipping_method_id", $shipping_method_id);
			$this->complete_step("shipping_method");
			$this->redirect("/checkout/review");
		}

	}

	function complete_step($step)
	{
		$this->Session->write("checkout_complete.$step", true);
	}

	function clear_step($step)
	{
		$this->Session->delete("checkout_complete.$step");
	}

	function shipping_select()
	{
		$this->body_title = 'Select shipping address';
		$customer = $this->Session->read("Auth.Customer");
		$customer_id = $customer['customer_id'];
		$addresses = $this->ContactInfo->findAll("ContactInfo.Customer_ID = '$customer_id'");
		if (!count($addresses)) { $this->redirect("/checkout/shipping_edit"); }
		$this->set("addresses", $addresses);

		if (count($addresses) && empty($customer['shipping_id_pref'])) { $customer['shipping_id_pref'] = $addresses[0]['ContactInfo']['Contact_ID']; }

		$this->set("preferredAddress", $customer['shipping_id_pref']);

		#print_r($this->Session->read());
		
		$this->track("checkout","shipping_address");


		if(!empty($this->data['ContactInfo']))
		{
			$contact_id = $this->data['ContactInfo']['Contact_ID'];
			if (empty($contact_id))
			{
				$contact_id = $this->AddressBook->save_address();
			}

			if (!empty($this->data['billing_same']))
			{
				$this->Session->write("billing_id", $contact_id);
				$this->complete_step("billing_address");
			}

				#error_log("COD=$contact_id");

			if ($contact_id)
			{
				$this->Session->write("shipping_id", $contact_id);
				#error_log("SETTING SID=".$this->Session->read('shipping_id'));
				$address = $this->ContactInfo->read(null, $contact_id);
				$this->Session->write("zipCode", $address['ContactInfo']['Zip_Code']);
				$this->Session->write("country", $address['ContactInfo']['Country']);

				$this->clear_step("shipping_method");
				#$this->Session->delete("shipping_method_id"); # Clear so ask again.
				# clear step completed, but ask again - tho defualt to correct one.

				$this->complete_step("shipping_address");
				$this->redirect("/checkout/review");
			}
		}
		$this->set("countries", $this->Country->findAll(" can_order = 'Yes' "));
		$this->set("shipping_id", $this->Session->read("shipping_id"));
		$this->set("billing_id", $this->Session->read("billing_id"));

		$this->js_required_fields[] = "ContactInfoInCareOf";
		$this->js_required_fields[] = "ContactInfoName0";
		$this->js_required_fields[] = "ContactInfoName1";
		$this->js_required_fields[] = "ContactInfoAddress1";
		$this->js_required_fields[] = "ContactInfoCity";
		$this->js_required_fields[] = "ContactInfoZipCode";
		$this->js_required_conditions = '($("new_address") && $("new_address").checked)'; # We have 'new' selected.

		$this->load_cart();
		$this->action = 'address_select';
		$this->set("type", 'shipping');
	}

	function billing_delete($contact_id)
	{
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$address = $this->ContactInfo->read(null, $contact_id);
		if($address['ContactInfo']['Customer_ID'] == $customer_id)
		{
			$this->ContactInfo->del($contact_id);
			$this->setFlash("Address removed.");
		}
		$this->redirect("/checkout/billing_select"); 
	}

	function billing_edit($contact_id = '')
	{
		$this->checkout_step = 1;
		$this->body_title = $contact_id ? 'Update billing address' : 'Add billing address';
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$customer = $this->get_customer();
		$editing = !empty($contact_id);

		$this->track("checkout","billing_address");

		if (!empty($this->data))
		{
		#	error_log("D2");
			# Process.
			$contact_id = $this->AddressBook->save_address();
			if ($contact_id)
			{
				# Save billing id for default.
				$this->Session->write("Auth.Customer.billing_id_pref", $contact_id);
				$this->complete_step("billing_address");
				$this->Customer->save(array('Customer'=>$this->Session->read("Auth.Customer")));
				if($editing)
				{
					$this->redirect("/checkout/billing_select");
				} else {
					$this->redirect("/checkout/review");
				}
			}
		}

		$this->data = $this->ContactInfo->find("ContactInfo.Contact_ID = '$contact_id' AND ContactInfo.customer_id = '$customer_id'");
		#if (!$this->data) { $this->redirect("/checkout/billing_select"); }
		if (empty($this->data['ContactInfo']['Name']))
		{
			# Default to their name...
			$this->data['ContactInfo']['Name'][0] = $customer['First_Name'];
			$this->data['ContactInfo']['Name'][1] = $customer['Last_Name'];
		}

		$this->set("countries", $this->Country->findAll(" can_order = 'Yes' "));
		$this->set("type", "billing");
		$this->set("shipping_id", $this->Session->read("shipping_id"));
		$this->set("billing_id", $this->Session->read("billing_id"));

		$this->load_cart();

		$this->js_required_fields[] = "ContactInfoInCareOf";
		$this->js_required_fields[] = "ContactInfoName0";
		$this->js_required_fields[] = "ContactInfoName1";
		$this->js_required_fields[] = "ContactInfoAddress1";
		$this->js_required_fields[] = "ContactInfoCity";
		$this->js_required_fields[] = "ContactInfoZipCode";

		$this->action = "address_edit";
	}

	function shipping_delete($contact_id)
	{
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$address = $this->ContactInfo->read(null, $contact_id);
		if($address['ContactInfo']['Customer_ID'] == $customer_id)
		{
			$this->ContactInfo->del($contact_id);
			$this->setFlash("Address removed.");
		}
		$this->redirect("/checkout/shipping_select"); 
	}

	function shipping_edit($contact_id = '')
	{
		$this->checkout_step = 1;
		$this->body_title = $contact_id ? 'Update shipping address' : 'Enter shipping address';
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$customer = $this->get_customer();

		$this->track("checkout","shipping_address");

	#	error_log("DATA=".print_r($this->data,true));

		if (!empty($this->data))
		{
			# Process.
			$contact_id = $this->AddressBook->save_address();
			if ($contact_id)
			{
				if (!empty($this->data['billing_same']))
				{
					$this->Session->write("billing_id", $contact_id);
					$this->complete_step("billing_address");
				}
				# Save shipping id for default.
				$this->Session->write("shipping_id", $contact_id);
				$this->complete_step("shipping_address");

				$this->Session->write("zipCode", $this->data['ContactInfo']['Zip_Code']);
				$this->Session->write("country", $this->data['ContactInfo']['Country']);

				$this->clear_step("shipping_method");
				#$this->Session->delete("shipping_method_id"); # Clear so ask again.

				$this->Session->write("Auth.Customer.shipping_id_pref", $contact_id);
				$this->Customer->save(array('Customer'=>$this->Session->read("Auth.Customer")));
				$this->redirect("/checkout/review");
			}
		}

		if ($contact_id) { $this->data = $this->ContactInfo->find("ContactInfo.Contact_ID = '$contact_id' AND ContactInfo.customer_id = '$customer_id'"); }
	#	if (!$this->data) { $this->redirect("/checkout/billing_select"); }
		if (empty($this->data['ContactInfo']['Name']))
		{
			# Default to their name...
			$this->data['ContactInfo']['Name'][0] = $customer['First_Name'];
			$this->data['ContactInfo']['Name'][1] = $customer['Last_Name'];
		}

		$this->set("countries", $this->Country->findAll(" can_order = 'Yes' "));
		$this->set("shipping_id", $this->Session->read("shipping_id"));
		$this->set("billing_id", $this->Session->read("billing_id"));

		$this->load_cart();

		$this->js_required_fields[] = "ContactInfoInCareOf";
		$this->js_required_fields[] = "ContactInfoName0";
		$this->js_required_fields[] = "ContactInfoName1";
		$this->js_required_fields[] = "ContactInfoAddress1";
		$this->js_required_fields[] = "ContactInfoCity";
		$this->js_required_fields[] = "ContactInfoZipCode";

		$this->action = "address_edit";
	}

	function billing_select()
	{
		$this->checkout_step = 1;
		$this->body_title = 'Select billing address';
		$customer = $this->Session->read("Auth.Customer");
		$customer_id = $customer['customer_id'];
		$addresses = $this->ContactInfo->findAll("ContactInfo.customer_id = '$customer_id'");
		if (!count($addresses)) { $this->redirect("/checkout/billing_edit"); }
		$this->set("addresses", $addresses);
		if (count($addresses) && empty($customer['billing_id_pref'])) { $customer['billing_id_pref'] = $addresses[0]['ContactInfo']['Contact_ID']; }
		$this->set("preferredAddress", $customer['billing_id_pref']);

		$this->track("checkout","billing_address");

		#print_r($this->Session->read());

		if(!empty($this->data))
		{
			$contact_id = $this->data['ContactInfo']['Contact_ID'];
			if (empty($contact_id))
			{
				$contact_id = $this->AddressBook->save_address();
			}

			if ($contact_id)
			{
				$this->Session->write("billing_id", $contact_id);
				$this->complete_step("billing_address");
				$this->redirect("/checkout/review");
			}
		}

		$this->js_required_fields[] = "ContactInfoInCareOf";
		$this->js_required_fields[] = "ContactInfoName0";
		$this->js_required_fields[] = "ContactInfoName1";
		$this->js_required_fields[] = "ContactInfoAddress1";
		$this->js_required_fields[] = "ContactInfoCity";
		$this->js_required_fields[] = "ContactInfoZipCode";
		$this->js_required_conditions = '($("new_address") && $("new_address").checked)'; # We have 'new' selected.


		$this->set("countries", $this->Country->findAll(" can_order = 'Yes' "));
		$this->set("shipping_id", $this->Session->read("shipping_id"));
		$this->set("billing_id", $this->Session->read("billing_id"));

		$this->load_cart();
		$this->action = 'address_select';
		#$this->action = 'address_edit';
		$this->set("type", 'billing');

	}

	function payment_delete($payment_id)
	{
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$card = $this->CreditCard->read(null, $payment_id);
		if($card['CreditCard']['Customer_ID'] == $customer_id)
		{
			$this->CreditCard->del($payment_id);
			$this->setFlash("Payment method removed.");
		}
		$this->redirect("/checkout/payment_select"); 
	}

	function payment_select()
	{
		$this->checkout_step = 3;
		$this->body_title = 'Select payment method';
		$customer = $this->Session->read("Auth.Customer");
		$customer_id = $customer['customer_id'];
		$payments = $this->CreditCard->findAll("CreditCard.customer_id = '$customer_id'");
		if (empty($payments)) { $this->redirect("/checkout/payment_edit"); }
		foreach($payments as &$payment)
		{
			$payment['CreditCard']['NumberPlain'] = $this->CreditCard->decrypt($payment['CreditCard']['Number']);
		}
		$this->set("paymentMethods", $payments);

		$this->track("checkout","payment_select");

		$this->load_cart();

		$this->js_required_fields[] = "CreditCardCardType";
		$this->js_required_fields[] = "CreditCardCardholder";
		#$this->js_required_conditions = 'alert($($("CreditCardForm").elements["data[CreditCard][credit_card_id]"])';
		#$this->js_required_conditions = '$("new_credit_card").checked'; # We have 'new' selected.

		if(!empty($this->data['CreditCard']))
		# Only update if we specify a NEW card....
		{
			$this->Session->write("customer_po", $this->data['customer_po']);
			$card_id = $this->data['CreditCard']['credit_card_id'];
			if (empty($card_id))
			{
				$card_id = $this->save_credit_card();
				if (!$card_id) { return; }
			}
			$this->Session->write("payment_id", $card_id);
			$this->complete_step("payment");
			$this->redirect("/checkout/review");
		}
		$this->set("payment_id", $this->Session->read("payment_id"));
	}

	function payment_edit($payment_id = '')
	{
		$editing = !empty($payment_id);
		$this->checkout_step = 3;
		$this->body_title = $payment_id ? 'Update payment information' : 'Enter payment information';
		$customer_id = $this->Session->read("Auth.Customer.customer_id");

		$this->load_cart(); # Loads shipping stuff...

		if (!empty($this->data))
		{
			$this->Session->write("customer_po", $this->data['customer_po']);
			if ($this->data['CreditCard']['credit_card_id'] == -1 || $this->data['CreditCard']['credit_card_id'] == -2)
			{
				# Paypal.
				$payment_id = $this->data['CreditCard']['credit_card_id'];
				$this->Session->write("payment_id", $payment_id);
				$this->complete_step("payment");
				$this->redirect("/checkout/review");
			} else {
				# Process.
				#error_log("SAVING CC");
				$payment_id = $this->save_credit_card();
				if(empty($payment_id))
				{
					return; # Oops.
				}
			}
			$this->Session->write("payment_id", $payment_id);
			$this->complete_step("payment");
			# Assume when they 'update', theyre selecting.
			# If we're editing one (instead of adding one), go back to list.
			# else, go to review.
			#if ($editing)
			#{
			#	$this->redirect("/checkout/payment_select");
			#} else {
				$this->redirect("/checkout/review");
			#}
		}

		$this->track("checkout","payment_select");

		$this->js_required_functions[] = "credit_card_expiration_valid";

		$this->data = $this->CreditCard->find("CreditCard.credit_card_id = '$payment_id' AND CreditCard.customer_id = '$customer_id'");

		#if (!$this->data) { $this->redirect("/checkout/payment_select"); }
		if (!empty($this->data['CreditCard']))
		{
			$this->data['CreditCard']['NumberPlain'] = $this->CreditCard->decrypt($this->data['CreditCard']['Number']);
		}

		$this->load_cart();

		$this->js_required_fields[] = "CreditCardNumberPlain";
		$this->js_required_fields[] = "CreditCardCardholder";

		#$this->action = "payment_select";
	}

	function save_credit_card()
	{
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$card_id = $this->data['CreditCard']['credit_card_id'];
		if (!$card_id || !$this->CreditCard->findCount("CreditCard.credit_card_id = '$card_id' AND CreditCard.Customer_ID = '$customer_id'"))
		# Make sure it's one of theirs.... ,else create
		{
			unset($this->data['CreditCard']['credit_card_id']);
			$this->CreditCard->create();
		}

		# May only be given id field....

		$this->data['CreditCard']['Customer_ID'] = $customer_id;
		$this->data['CreditCard']['Expiration'] = $this->data['CreditCard']['Expiration']['year'] . '-' . $this->data['CreditCard']['Expiration']['month'] . '-01';
		# Verify completedness....
		if (!$this->data['CreditCard']['Cardholder'])
		{
			$this->setFlash("Missing cardholder name");
			#$this->redirect("/checkout/payment_edit");
			return;
		} else if (strtotime($this->data['CreditCard']['Expiration']) < time()) {
	#	error_log("EXP=".print_r($this->data['CreditCard'],true));
			$this->setFlash("Invalid expiration date. Card has expired.");
			return;
		} else if (!$this->CreditCard->is_valid_credit_card($this->data['CreditCard']['NumberPlain'])) {
			$this->setFlash("Invalid card number");
			return;
		}
		$this->data['CreditCard']['Card_Type'] = $this->CreditCard->get_card_type($this->data['CreditCard']['NumberPlain']);
		$this->data['CreditCard']['Number'] = $this->CreditCard->encrypt($this->data['CreditCard']['NumberPlain']);

		$this->CreditCard->save($this->data);
		$card_id = $this->CreditCard->id;

		return $this->CreditCard->id;
	}

	function review()
	{
		$this->TrackingVisit->did_goal("checkout");
		#error_log("REVIEWING");
		$this->checkout_step = 4;
		$this->body_title = "Review your order";

		# Load customer info....
		$customer = $this->Session->read("Auth.Customer");
		$customer_id = $customer['customer_id'];
		$this->set("customer", $customer);


		# If not preferred shipping, prompt
		$shipping_id = $this->Session->read("shipping_id");
		if (!$shipping_id || !$this->ContactInfo->findCount("ContactInfo.Contact_ID = '$shipping_id' AND ContactInfo.Customer_ID = '$customer_id'") || empty($this->complete['shipping_address']))
		{
			#error_log("REMOVING SHIPING ID=$shipping_id");
			# FORCE THEM TO PUT IN....
			#echo "FOOD";
			#exit(0);
			$this->Session->delete("shipping_id");
			#$this->clear_step("shipping_method");
			#$this->Session->delete("shipping_method_id"); # Clear so ask again.
			$this->redirect("/checkout/shipping_select");
		}
		# If not preferred billing method, prompt.

		#echo("SHIP=$shipping_id");

		# Load shipping address
		# (allow us to specify preference just for this session, OR default for ALL sessions)
		$shippingAddress = $this->ContactInfo->read(null, $shipping_id); # XXX allow for custom one just per this transaction.

		$this->set("shippingAddress", $shippingAddress['ContactInfo']);

		# If not preferred billing, prompt
		$billing_id = $this->Session->read("billing_id");
		if (!$billing_id)
		{
			$billing_id = $customer['billing_id_pref'];
			$this->Session->write("billing_id", $billing_id);
		}
		if (!$billing_id || !$this->ContactInfo->findCount("ContactInfo.Contact_ID = '$billing_id' AND ContactInfo.Customer_ID = '$customer_id'") || empty($this->complete['billing_address']))
		{
			# FORCE THEM TO PUT IN....
			$this->Session->delete("billing_id");
			$this->redirect("/checkout/billing_select");
		}

		$billingAddress = $this->ContactInfo->read(null, $billing_id); # XXX allow for custom one just per this transaction.
		$this->set("billingAddress", $billingAddress['ContactInfo']);

		# Load page asking for shipping method.

		$shipping_method_id = $this->Session->read("shipping_method_id");
		if (!$shipping_method_id || empty($this->complete['shipping_method']))
		{
			$this->redirect("/checkout/shipping_method");
		}

		$this->set("shipping_id", $shipping_method_id);


		$shippingMethod = $this->ShippingMethod->read($shipping_method_id);

		$this->set('shippingMethod', $shippingMethod);

		# Load cart items....
		$this->load_cart();

		# Load billing
		# (allow us to specify preference just for this session, OR default for ALL sessions)
		$customer_id = $this->get_customer_id();
		$billingMethods = $this->CreditCard->findAll(" customer_id = '$customer_id' ");
		$this->set("billingMethods", $billingMethods);

		$payment_id = $this->Session->read("payment_id");

		if (empty($payment_id) || ($payment_id != -1 && $payment_id != -2 && !$this->CreditCard->findCount("CreditCard.credit_card_id = '$payment_id' AND CreditCard.Customer_ID = '$customer_id'")) || empty($this->complete['payment']))
		{
			$this->Session->delete("payment_id");
			$this->redirect("/checkout/payment_select");
		}

		if ($payment_id > 0)
		{
			$billingMethod = $this->CreditCard->read(null, $payment_id);

			$billingMethod['CreditCard']['NumberPlain'] = $this->CreditCard->decrypt($billingMethod['CreditCard']['Number']);
			$this->set("billingMethod", $billingMethod['CreditCard']); 
		}

		if ($payment_id == -1) { $this->set("paypal", true); }
		if ($payment_id == -2) { $this->set("billme", true); }
		if ($payment_id == -3) { $this->set("amazon", true); }


		$this->verify_account_name();


		# Verify we have contact info...
		$this->verify_contact_info();



		# Load shipping costs....

		# XXX Load grand total for the currently selected shipping option.....
		# TODO

		$this->track("checkout","review");

	}

	function verify_account_name()
	{
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$customer = $this->Customer->read($customer_id);

		$billing_id = $this->Session->read("billing_id");
		$billing_address = $this->ContactInfo->read(null, $billing_id);
		$in_care_of = array("","");
		if (!empty($billing_address['ContactInfo']))
		{
			$in_care_of = preg_split("/[ ]+/", $billing_address['ContactInfo']['In_Care_Of']);
		}

		if (empty($customer['Customer']['First_Name']) && count($in_care_of))
		{
			# Assume from chosen credit card.
			$customer['Customer']['First_Name'] = $in_care_of[0];
		}

		if (empty($customer['Customer']['Last_Name']) && count($in_care_of) >= 2)
		{
			# Assume from chosen credit card.
			$customer['Customer']['Last_Name'] = $in_care_of[count($in_care_of)-1];
		}
		$this->Customer->id = $customer_id;
		$this->Customer->save($customer);
	}

	function verify_contact_info()
	{
		$customer = $this->Session->read("Auth.Customer");

		$email = $customer['eMail_Address'];
		$phone = $customer['Phone'];

		#$this->setFlash("C=".print_r($customer,true));

		if (!$email || !$phone)
		{
			$this->redirect("/checkout/contact_edit");
		}
	}

	function contact_edit()
	{
		$this->checkout_step = 3;
		$this->body_title = "Contact information for receipt / shipping";
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$customer = $this->get_customer();

		$this->track("checkout","contact");

		if (!empty($this->data))
		{
			$this->data['Customer']['customer_id'] = $customer_id; # ONLY THEM! can't manipulate in form....

			$other_customer_id = $this->Customer->other_valid_existing_customer_id($this->data);
			#error_log("OCID=$other_customer_id");

			if (empty($other_customer_id) &&
				!(
				#$this->Customer->verify_name($this->data) &&
				$this->Customer->verify_email($this->data) &&
				$this->Customer->verify_phone($this->data) &&
				(empty($this->data['Customer']['create_account']) || $this->Customer->verify_password($this->data,false))
				)
	
			)
			{
				#error_log("ERRORS=".join("<br/>", $this->Customer->errors));
				$this->setFlash(join("<br/>", $this->Customer->errors));
			} else {
				if(!empty($other_customer_id))
				{
					if($other_customer_id != $this->data['Customer']['customer_id'])
					{
						# Delete other guest.
						$this->Customer->del($this->data['Customer']['customer_id']);
					}
					$this->data['Customer']['customer_id'] = $other_customer_id;
				}
				#error_log("CREATRING");

				if (empty($this->data['Customer']['create_account']))
				{
					# Ignore password if they don't have account creation checked.... (they may have changed their mind)
					unset($this->data['Customer']['Password']);
					unset($this->data['Customer']['Password2']);
				}
				#print_r($_SESSION);
				#exit(0);
				if ($this->save_account($this->data))
				{
					#print_r($_SESSION);
					$this->redirect("/checkout/review");
				}
			}

			# Now load remainder of account stuff, so we don't forget...
			$customer = $this->get_customer();
			foreach($customer as $k=>$v)
			{
				if(!isset($this->data['Customer'][$k])) { $this->data['Customer'][$k] = $v; }
			}
		}

		if (!$this->data)
		{
			$this->data = $this->Customer->read(null, $customer_id);

			# Make assumptions for name (from billing name)
			$billing_id = $this->Session->read("billing_id");
			$billing_name = array();
			if ($billing_id)
			{
				$billing_address = $this->ContactInfo->read(null, $billing_id);
				$billing_name = preg_split("/\s+/", $billing_address['ContactInfo']['In_Care_Of']);
			}
			if (empty($this->data['Customer']['First_Name']) && count($billing_name) > 0)
			{
				$this->data['Customer']['First_Name'] = $billing_name[ 0 ];
			}
			if (empty($this->data['Customer']['Last_Name']) && count($billing_name) > 1)
			{
				$this->data['Customer']['Last_Name'] = $billing_name[ count($billing_name) - 1 ];
			}
		}

		#$this->js_required_fields[] = "CustomerFirstName";
		#$this->js_required_fields[] = "CustomerLastName";
		$this->js_required_fields[] = "CustomerEMailAddress";
		$this->js_required_fields[] = "CustomerPhone";

		$this->set("customer", $this->data);
		$this->load_cart();
	}

	function receipt()
	{
		$this->log("Submitting payment for=".print_r($this->Session->read(),true));
		$this->TrackingVisit->did_goal("order");
		$this->checkout_step = 0;
		# Process order....
		$this->body_title = "Your order has been submitted";

		if(empty($this->params['form']))
		{
			$this->redirect("/checkout/review");
		}
		$this->_receipt();
	}

	function log($msg)
	{
		$cid = $this->Auth->user('customer_id');
		if(empty($this->logged))
		{
			# Start new...
			parent::log("\n\n====================================================================",'payment');
		}
		$this->logged = true;
		return parent::log("$cid: $msg", 'payment');
	}

	function _receipt($purchase_id = '')
	{

		$this->track("checkout","receipt");

		# Get shipping method.
		#$shipping_method_id = $this->params['form']['shipping_method'];

		# Get everything in cart...
		list($shoppingCart, $subtotal, $product_list) = $this->get_cart_items();
		$this->log("SUBTOTAL=$subtotal, CART=".print_r($shoppingCart,true));

		$this->set("shoppingCart", $shoppingCart);
		$this->set("subtotal", $subtotal);
		#$this->set("defaultShippingMethod", $shipping_method_id);

		$this->set("product_map", Set::combine($this->Product->findAll(), '{n}.Product.code', '{n}.Product'));

		###########return; # FOR NOW...


		if(empty($purchase_id))
		{
			$this->log("Processing payment...");
			# Initialize purchase
			$purchase_id = $this->initialize_purchase($shoppingCart, $product_list, $subtotal);
			$this->log("PURCHASE_ID=$purchase_id");
			# Charge card & finalize transaction
			$payment_id = $this->Session->read("payment_id");
			$this->log("PAYMENT_ID=$payment_id");
			$response = $this->process_payment($purchase_id, $payment_id);
		} else {
			$this->log("Payment gateway done");
			$response = true; # paypal done...
		}
		$this->set("purchase_id", $purchase_id);

		if ($response === true)
		{
			$this->log("Finalizing purchase $purchase_id");
			$this->finalize_purchase($purchase_id);
		}
		else # Declined or error....
		{
			$this->log("PAYMENT ERROR ($purchase_id): $response");

			# Remove blank purchase entry...
			$this->Purchase->del($purchase_id);
			#
			$this->setFlash("Could not process payment: $response");
			$this->redirect("/checkout/review");
		}
	}

	function receipt_amazon($purchase_id, $callback = '') # Page to go back to when done paying.
	{
	#	error_log("PURCHASE_ID=$purchase_id, CALL=$callback");
		$purchase = $this->Purchase->read(null, $purchase_id);
		$amount = $purchase['Purchase']['Charge_Amount'];
		# Do we need some ref code so they cant fake this? (stored in session?)
		$this->log("Paying by Amazon = $amount");

		if (!$callback)
		{
			$this->log("Redirecting to Amazon for Purchase #$purchase_id");
			$url = $this->Amazon->authorize($purchase_id, $amount);
			return $this->redirect($url);
		} else if ($callback == 'pay') {
			$this->log("Payment response from Amazon for Purchase #$purchase_id");
			error_log("REQUEST=".print_r($_REQUEST,true));
			$token = $_REQUEST['tokenID'];
			$status = $_REQUEST['status'];

			# ??? possible status values????
			# (avoid duplicate tokens/transactions)
			# is there a timeframe?

			# XXX only charge if status is success... (hmmm not sure what that means)
			if(in_array($status, array('SA','SB','SC')))
			{
				$rc = $this->Amazon->charge($purchase_id, $amount, $token);
				if(!empty($rc) && $rc !== true)
				{
					$this->log("CHARGE ERROR=$rc");
					$this->setFlash($rc); # Warning/error message
					$rc = false;
				} else {
					$this->log("PAYMENT SUCCESS!");
				}
			} else {
				if($status == 'SE')
				{
					$this->log("PAYMENT PROCESS SYSTEM ERROR");
					$this->setFlash("We could not process your payment due to an interal system error");
				} else if ($status == 'CE') {
					$this->log("PAYMENT CREATE SYSTEM ERROR");
					$this->setFlash("We could not create your order due to an interal system error");
				}
				# Message of problem???
				$this->redirect(array('action'=>'form'));
			}
		} else if ($callback == 'cancel') {
			$this->log("User CANCELED payment");
			$this->redirect(array('action'=>'form'));
		}

		if ($callback == 'pay' && $rc) # DONE
		{
		#	error_log("DONE WITH ORDER");
			$transaction_id = $rc;
			#$this->finalize_purchase($purchase_id);

			$this->log("SUCCESSFUL PAYMENT");

			$this->body_title = "Your order has been submitted";
			$this->action = 'receipt';
			return $this->_receipt($purchase_id);
		}
	}

	function receipt_paypal($purchase_id, $callback = '') # Page to go back to when done paying.
	{
	#	error_log("PURCHASE_ID=$purchase_id, CALL=$callback");
		$purchase = $this->Purchase->read(null, $purchase_id);
		$amount = $purchase['Purchase']['Charge_Amount'];
		# Do we need some ref code so they cant fake this? (stored in session?)

		$this->Payment->setOrder($amount, "Harmony Designs Order #$purchase_id");

		$this->log("Paying by Paypal = $amount, purchase #$purchase_id");

		if (!$callback)
		{
			$rc = $this->paypalExpressCheckout($callback);
		} else if ($callback == 'pay') {
			$rc = $this->paypalExpressCheckout($callback);
		} else if ($callback == 'cancel') {
			$this->redirect(array('action'=>'form'));
		}

		$this->log("Paypal RESPONSE = ".print_r($rc,true));

		if ($callback == 'pay' && $rc) # DONE
		{
			$this->log("Payment COMPLETE for purchase #$purchase_id");
		#	error_log("DONE WITH ORDER");
			$transaction_id = $rc;
			#$this->finalize_purchase($purchase_id);

			$this->body_title = "Your order has been submitted";
			$this->action = 'receipt';
			return $this->_receipt($purchase_id);
		} else if($callback == 'pay') {
			$this->log("Payment Response ERROR");
			$this->setFlash("Could not complete order");
			$this->redirect(array('action'=>'form'));
		}
	}

	function paypalExpressCheckout($callback = null) # Generic such that can be moved to app_controller.php!
	{
	    if (!empty($callback) && !empty($_REQUEST['csid']))
	    {
	        // Restore session
	        
	        if (!$this->Payment->restoreSession($_REQUEST['csid']))
	        {
	    		#$this->setFlash(__('Could not restore session.',true));
	    		$this->setFlash(__('Could not complete transaction (retrieving session). Please try again.',true));
			$this->redirect("/checkout/review");
	        }
	    }


	    if (empty($callback))
	    {
		if (!$this->Payment->submitCheckout())
		{
	    		$this->setFlash(__('Could not submit order: ' . $this->Payment->getError(),true));
			$this->redirect("/checkout/review");
		}
	    }
	    else if ($callback == 'cancel')
	    {
	    	#$this->setFlash(__('Payment canceled.',true));
		$this->redirect("/checkout/form"); # Maybe to change payment method, etc.
	        #echo 'SNIFF... Why not?';
	        #exit;
	    }
	    else if ($callback == 'pay')
	    {
	        // Second call, make payment via PayPal

		$result = $this->Payment->getCheckoutResponse();
	        
	        if ($result === false)
	        {
	    	    $this->log('Unable to process payment: ' . $this->Payment->getError());
	    	    $this->setFlash(__('Unable to process payment: ' . $this->Payment->getError(), true));
	   	    $this->redirect("/checkout/review");
	        }
	        else # Did payment... so do post-processing....
	        {
		    $transaction_id = $result["transaction"];
		    return $transaction_id;
		    # Save transaction_id into 'sales' so can do refund, etc...
		    #$this->setAction($this->payment_process_callback, $transaction_id);
	        }
	    }
	}

	function process_payment_amazon($purchase_id)
	{
		$this->redirect("/checkout/receipt_amazon/$purchase_id");
	}

	function process_payment_paypal($purchase_id)
	{
		$this->redirect("/checkout/receipt_paypal/$purchase_id");
	}

	function process_payment($purchase_id, $payment_id)
	{
		$this->log("ROUTING PROCESS PAYMENT...");
		$this->set("purchase_id", $purchase_id);

		if($payment_id == -1) # Paypal
		{
			$response = $this->process_payment_paypal($purchase_id);
		} else if ($payment_id == -2) { # Billme
			return true;
		} else if ($payment_id == -3) { # amazon.
			$response = $this->process_payment_amazon($purchase_id);
		} else { # CC, auth.net
			$response = $this->process_payment_authnet($purchase_id);
			list($response_code,$response_msg,$reason_code,$reason_text) = $response;
			if ($response_code == $this->AuthorizeNet->APPROVED) {
				return true;
			} 
			else if ($response_code == 3 && $reason_code == 11) # Duplicate transaction....
			{
				# Duplicate, let through...
				return true;
			} else {
				return $reason_text;
			}
		}
	}

	function process_payment_authnet($purchase_id)
	{
		 ### $response:Array = $this->AuthorizeNet->chargeCard($loginid:String, $trankey:String, $ccnum:String, $ccexpmonth:String, $ccexpyear:String, $ccver:String, $live:Boolean, $amount:Number, $tax:Number, $shipping:Number, $desc:String, $billinginfo:Array, $email:String, $phone:String, $shippinginfo:Array);

		 $authnet = array(
		 	'login'=>'harmony90',
			'trankey'=>'99x2YU522Jwmt3Vu',
		 );

		 $card_id = $this->Session->read("payment_id");
		 $card = $this->CreditCard->read(null, $card_id);

		 $cardNumberPlain = $this->CreditCard->decrypt($card['CreditCard']['Number']);
		 $cardExpTime = strtotime($card['CreditCard']['Expiration']);
		 $cardExpMonth = date('m', $cardExpTime);
		 $cardExpYear = date('Y', $cardExpTime);
		 $cardVer = ""; # Don't use...

		 $billing_id = $this->Session->read("billing_id");
		 $billingAddress = $this->ContactInfo->read(null, $billing_id);
		 $billingName = preg_split("/\s+/", $billingAddress['ContactInfo']['In_Care_Of']);
		 $billinginfo = array(
		 	'fname'=>array_shift($billingName),
			'lname'=>join(" ", $billingName),
			'address'=>$billingAddress['ContactInfo']['Address_1'].' '.$billingAddress["ContactInfo"]['Address_2'],
			'city'=>$billingAddress["ContactInfo"]['City'],
			'state'=>$billingAddress["ContactInfo"]['State'],
			'zip'=>$billingAddress["ContactInfo"]['Zip_Code'],
			'country'=>$billingAddress["ContactInfo"]['Country']
		 );

		 $shipping_id = $this->Session->read("shipping_id");
		 $shippingAddress = $this->ContactInfo->read(null, $shipping_id);
		 $shippingName = preg_split("/\s+/", $shippingAddress['ContactInfo']['In_Care_Of']);
		 $shippinginfo = array(
		 	'fname'=>array_shift($shippingName),
			'lname'=>join(" ", $shippingName),
			'address'=>$shippingAddress['ContactInfo']['Address_1'].' '.$shippingAddress["ContactInfo"]['Address_2'],
			'city'=>$shippingAddress["ContactInfo"]['City'],
			'state'=>$shippingAddress["ContactInfo"]['State'],
			'zip'=>$shippingAddress["ContactInfo"]['Zip_Code'],
			'country'=>$shippingAddress["ContactInfo"]['Country']
		 );

		 # Now get order info.
		 $purchase = $this->Purchase->read(null, $purchase_id);
		 $amount = $purchase['Purchase']['Charge_Amount'];
		 $shipping = 0; # Not sure what this is used for....
		 $tax = 0;

		 $desc = "Harmony Designs Order";
		 $customer = $this->Session->read("Auth.Customer");
		 $email = $customer['eMail_Address'];
		 $phone = $customer['Phone'];

		 $live = !$this->is_admin && preg_match("/harmonydesigns[.]com$/", $_SERVER["HTTP_HOST"]);  # ONLY ON LIVE SERVER

		 if ($this->malysoft)
		 {
			return array($this->AuthorizeNet->APPROVED,"appproved",null,"");
		 } else {
		 	$this->log("AUTHORIZE.NET CHARGING CARD {$authnet['login']}, {$authnet['trankey']}, $cardNumberPlain, $cardExpMonth, $cardExpYear, $cardVer, LIVE=$live, AMOUNT=$amount ...");
		 	$response = $this->AuthorizeNet->chargeCard($authnet['login'], $authnet['trankey'], $cardNumberPlain, $cardExpMonth, $cardExpYear, $cardVer, $live, $amount, $tax, $shipping, $desc, $billinginfo, $email, $phone, $shippinginfo, $purchase_id);
		 }

		 return $response;
	}

	function finalize_purchase($purchase_id)
	{
		# put in items.
		$customer_id = $this->get_customer_id();
		$session_id = $this->get_session_id();

		$cart_items = $this->get_cart();


		$this->_finalize_purchase($purchase_id, $cart_items, $customer_id, $session_id);
		$this->Purchase->recursive = 2; # Get orderItem AND Product...
		$purchase = $this->Purchase->getOrderDetails($purchase_id);

		$this->set("purchase", $purchase);
		$this->set("billingAddress", $billingAddress = $this->ContactInfo->read(null, $purchase['Purchase']['Billing_ID']));
		$this->set("shippingAddress", $shippingAddress = $this->ContactInfo->read(null, $purchase['Purchase']['Shipping_ID']));

		$this->log("Billing Address=".print_r($billingAddress,true));
		$this->log("Shipping Address=".print_r($shippingAddress,true));

		if (!$this->malysoft && empty($_SESSION['checkout_debug']))
		{
			$this->clear_cart();
			$this->clear_build();
			$this->Session->delete("customer_po");
		}

		$this->Session->delete("checkout_complete");
		$this->Session->delete("purchase_id");

		if($this->Session->read("Auth.Customer.guest")) # Clear account. Next orders won't be as them (especially if they change things!).
		{
			error_log("GUEST, DEL AUTH");
			$this->Session->delete("Auth");
		} else {
			$this->Customer->id = $customer_id;
			$this->Customer->saveField("billing_id_pref", $purchase['Purchase']['Billing_ID']);
			$this->Customer->saveField("shipping_id_pref", $purchase['Purchase']['Shipping_ID']);
			$this->Session->write("Auth.Customer.billing_id_pref", $purchase['Purchase']['Billing_ID']);
			$this->Session->write("Auth.Customer.shipping_id_pref", $purchase['Purchase']['Shipping_ID']);
		}
		$this->Session->delete("Checkout"); # Remove checkout form.

		# Clear shipment/billing stuff so chosen again next order.
		$this->Session->delete("shipping_id");
		$this->Session->delete("billing_id");
		$this->Session->delete("shipping_method_id");
		$this->Session->delete("zipCode");


		# Send email to buyer and admin.
		$this->order_notification($purchase_id);
		$this->log("ORDER COMPLETE!!!\n\n");
	}

	function redeemCoupon($purchase_id) # Only once payment has gone through.
	{
		if($coupon = $this->Session->read("coupon"))
		{
			$this->Purchase->id = $purchase_id;
			$this->Purchase->saveField("coupon", $coupon);
			$this->Session->delete("coupon");
		}
	}

	function _finalize_purchase($purchase_id, $cart_items, $customer_id = null, $session_id = null)
	{
		error_log("FINALIZING ORDER");
		$customer = $this->Customer->read(null, $customer_id);
		$customer_email = $customer['Customer']['eMail_Address'];

		$purchase = $this->Purchase->read(null, $purchase_id);

		# Only redeem coupon once billed.
		$this->redeemCoupon($purchase_id);

		#echo "PID=$purchase_id\n<br/>";

		#$cart_items = $this->CartItem->findAll(" customer_id = '$customer_id' OR session_id = '$session_id' ");
		# Match cartItem query with initialize(), so WE don't
		# get abandoned customer products into an order while not charging in init()

		$cart_item_id_map = array();

		foreach($cart_items as $cart_item)
		{
			$order_item = array();
			$parts = unserialize($cart_item['CartItem']['parts']);
			$parts2 = !empty($cart_item['CartItem']['parts2']) ? unserialize($cart_item['CartItem']['parts2']) : null;
			# Second side.

			$new_build = !empty($cart_item['CartItem']['new_build']) ? true : false;

			#print_r($parts);
			$quantity = $cart_item['CartItem']['quantity'];
			$unitPrice = $cart_item['CartItem']['unitPrice'];
			$setupPrice = $cart_item['CartItem']['setupPrice'];
			$productCode = $cart_item["CartItem"]['productCode'];
			$proof = $cart_item["CartItem"]['proof'];
			$template = $cart_item["CartItem"]['template'];
			if($template == 'imageonly_nopersonalization')
			{
				$template = 'imageonly';
				$parts['personalizationNone'] = 1;
			}
			$parts['template'] = $template;

			$rotate = $cart_item["CartItem"]['rotate'];

			#error_log("FINALIZING...=".print_r($parts,true));

			if ($productCode == 'B' && !empty($parts['charmID']) && $parts['charmID'] > 0)
			{
				$productCode = 'BC';
			}
			if ($productCode == 'BC' && (empty($parts['charmID']) || $parts['charmID'] <= 0))
			{
				$productCode = 'B';
			}
			if ($productCode == 'B' && empty($parts['tasselID']))
			{
				$productCode = 'BNT';
			}

			$product = $this->Product->find(" code = '$productCode' ");
			$productID = $product['Product']['product_type_id'];
			$specialID = null;
			$comments = $cart_item["CartItem"]['comments'];
			#$reproduction_bool = (empty($parts['reproductionStamp']) || $parts['reproductionStamp'] == 'no') ? false : true;
			$reproduction_bool = isset($parts['reproductionStamp']) ? $parts['reproductionStamp'] : false;
			$customization_xml = "";

			$cart_item_id = $cart_item['CartItem']['cart_item_id'];

			# order_item stores the product info.
			$order_item = array(
				'proof' => $proof,
				'Quantity' => $quantity,
                                'Price' => $unitPrice,
				'setupPrice'=>$setupPrice,
                                'Purchase_id' => $purchase_id,
                                'product_type_id' => $productID,
                                'specialID' => $specialID,
                                'template' => $template,
                                'rotate' => $rotate,
                                'reproduction' => $reproduction_bool,
                                'comments' => $comments,
                                'customization_xml' => $customization_xml, 
				'new_build'=>$new_build
			);

			$this->OrderItem->create();
			$this->OrderItem->save(array('OrderItem'=>$order_item));
			$item_id = $this->OrderItem->id;
			#echo "OID=$item_id\n<br/>";

			$cart_item_id_map[$cart_item_id] = $item_id;

			$size = null;

			if(!empty($parts['shirtSize'])) {
				$size = $parts['shirtSize'];
			}

			if(!empty($parts['size']) && is_array($parts['size']))
			{
				$size = null;
				foreach($parts['size'] as $s => $qty)
				{
					if(empty($qty)) { continue; }
					$size .= "$qty $s, ";
				}
			}

			$sides = array($parts);
			if(!empty($parts2)) { $sides[] = $parts2; }

			foreach($sides as $side) # one or two sides, ie item_parts
			{
				# may not need cropXYWH if imageCrop is compatible....
				$cropXYWH = array();
				if(isset($side['crop_x'])) { $cropXYWH[0] = $side['crop_x']; }
				if(isset($side['crop_y'])) { $cropXYWH[1] = $side['crop_y']; }
				if(isset($side['crop_w'])) { $cropXYWH[2] = $side['crop_w']; }
				if(isset($side['crop_h'])) { $cropXYWH[3] = $side['crop_h']; }

				$quoteXY = array();
				if(isset($side['quote_x'])) { $quoteXY[0] = $side['quote_x']; }
				if(isset($side['quote_y'])) { $quoteXY[1] = $side['quote_y']; }

				$personalizationXY = array();
				if(isset($side['personalization_x'])) { $personalizationXY[0] = $side['personalization_x']; }
				if(isset($side['personalization_y'])) { $personalizationXY[1] = $side['personalization_y']; }



				# item_parts stores the customization info.
				$item_part = array(
					"order_Item_ID"=>$item_id,
					"purchase_ID"=>$purchase_id,
	                                "ribbon_ID"=>(!empty($side['ribbonID']) ? $side['ribbonID'] : null),
	                                "tassel_ID"=>(!empty($side['tasselID']) ? $side['tasselID'] : null),
	                                "charm_ID"=>(!empty($side['charmID']) ? $side['charmID'] : null),
	                                "quote_ID"=>(!empty($side['quoteID']) ? $side['quoteID'] : null),
	                                "centerQuote"=>(!empty($side['centerQuote']) ? $side['centerQuote'] : null),
	                                "alignQuote"=>(!empty($side['alignQuote']) ? $side['alignQuote'] : null),
					"fullbleed"=>(!empty($side['fullbleed']) ? $side['fullbleed'] : null),
	                                "Size"=>$size,
	                                "PrintSide"=>(!empty($side['printSide']) ? $side['printSide'] : null),
	                                "border_ID"=>(!empty($side['borderID']) ? $side['borderID'] : null),
	                                "custom_quote"=>(!empty($side['customQuote']) ? $side['customQuote'] : null),
	                                "textSize"=>(!empty($side['textSize']) ? $side['textSize'] : null),
	                                "personalization"=>(!empty($side['personalizationInput']) ? $side['personalizationInput'] : null),
	                                "personalization_logo_id"=>(!empty($side['personalization_logo_id']) ? $side['personalization_logo_id'] : null),
	                                "personalizationColor"=>(!empty($side['personalizationColor']) ? $side['personalizationColor'] : null),
	                                "personalizationStyle"=>(!empty($side['personalizationStyle']) ? $side['personalizationStyle'] : null),
	                                "personalizationSize"=>(!empty($side['personalizationSize']) ? $side['personalizationSize'] : null),
	                                "catalogNumber"=>(!empty($side['catalogNumber']) ? $side['catalogNumber'] : null),
	                                "stampNumber"=>(!empty($side['catalogNumber']) ? $side['catalogNumber'] : null),
	                                "reproductionStamp"=>(!empty($reproduction_bool) ? $reproduction_bool : null),
	                                "imageID"=>(!empty($side['customImageID']) ? $side['customImageID'] : null),
	                                "frameID"=>(!empty($side['frameID']) ? $side['frameID'] : null),
	                                "pinStyle"=>(!empty($side['pinStyle']) ? $side['pinStyle'] : null),
	                                "handles"=>(!empty($side['handles']) ? $side['handles'] : null),
	                                "postCardAddress"=>(!empty($side['postcardAddress']) ? $side['postcardAddress'] : null),
	                                "template"=>(!empty($side['template']) ? $side['template'] : null),
	                                "customized"=>(!empty($side['customized']) ? $side['customized'] : null),
	                                "imageCrop"=>(!empty($side['imageCrop']) ? $side['imageCrop'] : null),
					'backgroundColor'=>(!empty($side['backgroundColor']) ? $side['backgroundColor'] : null),
					'picture_only'=>(!empty($cart_item['CartItem']['picture_only']) ? $cart_item['CartItem']['picture_only'] : null),





					# need to save other NEWER details.....
						'crop_xywh'=>join(",", $cropXYWH),
						'quote_attribution'=>!empty($side['quote_attribution'])?$side['quote_attribution']:null,
						'quote_font'=>!empty($side['quote_font'])?$side['quote_font']:null,
						'quote_font_size'=>!empty($side['quote_font_size'])?$side['quote_font_size']:null,
						'quote_color'=>!empty($side['quote_color'])?$side['quote_color']:null,
						'quote_xy'=>join(",",$quoteXY),
						'personalization_font'=>!empty($side['personalization_font'])?$side['personalization_font']:null, 
						'personalization_font_size'=>!empty($side['personalization_font_size'])?$side['personalization_font_size']:null, 
						'personalization_xy'=>join(",", $personalizationXY),
						'border1_y'=>!empty($side['border1_y'])?$side['border1_y']:null, 
						'border2_y'=>!empty($side['border2_y'])?$side['border2_y']:null, 
				);
	
				$this->ItemPart->create();
				if(!$this->ItemPart->save(array('ItemPart'=>$item_part)))
				{
					$this->setFlash("Could not save item_part");
					return false;
				}
			}
			#echo "IP=".$this->ItemPart->id;
		}

		
		####$this->clear_cart();

		#print_r($cart_item_id_map);

		$this->set("cart_item_id_map", $cart_item_id_map);
		return true;
	}


	function order_notification($purchase_id)
	{
		$this->log("ORDER NOTIFICATION FOR $purchase_id");

		$purchase = $this->Purchase->read(null, $purchase_id);
		$shipping_id = $purchase['Purchase']['Shipping_ID'];
		# Guest users cannot rely upon account in system, since not there.
		$customer_id = $purchase['Purchase']['Customer_ID'];
		$customer = $this->Customer->read(null, $customer_id);
		$customer_email = $customer['Customer']['eMail_Address'];

		$order_items = $this->OrderItem->findAll(" OrderItem.purchase_id = '$purchase_id' ");
		$product_list = array();
		foreach($order_items as $order_item)
		{
			$product_id = $order_item['OrderItem']['product_type_id'];
			$product = $this->Product->read(null, $product_id);
			$code = $product['Product']['code'];
			if ($code == 'B'  && !empty($order_item['ItemPart']['charm_ID']))
			{
				$code = 'BC';
			}
			if ($code == 'B'  && empty($order_item['ItemPart']['tassel_ID']))
			{
				$code = 'BNT';
			}
			$product_list[$code] = $order_item['OrderItem']['Quantity'];
		}

		$subtotal = ($purchase['Purchase']['Charge_Amount'] - $purchase['Purchase']['Shipping_Cost']);
		
		$shippingOptions = $this->get_all_shipping_options($shipping_id, $product_list, $subtotal);
		# This unfortunately considers the shipping cost as well - we need to subtract it to figure out the real shipping options...

		if(!empty($_SESSION['email_debug']))
		{
			print_r($shippingOptions);
		}

		$subject = "Harmony Designs Order # $purchase_id";
		$template = "checkout/order_submit_customer";
		$admin_template = "checkout/order_submit_admin";
		$vars = array(
			'purchaseID'=>$purchase_id,
			'customer'=>$customer['Customer'],
			'database'=>$this->database,
			'host'=>$_SERVER['HTTP_HOST'],
			'shippingOptions'=>$shippingOptions,
			#'shippingOptions'=>$shippingOptions,
		);

		#print_r($vars);
		#exit(0);

		#if (!$this->malysoft)
		#{
			$this->sendAdminEmail($subject, $admin_template, $vars);
		#}

		#$this->sendEmail($customer_email, $subject, $admin_template, $vars);
		error_log("CUSTOMER_EMAIL=$customer_email ($subject)");
		if ($customer_email)
		{
			$this->sendEmail($customer_email, $subject, $template, $vars);
		}
	}


	function initialize_purchase($shoppingCart, $product_list, $subtotal, $profile_id = null, $payment_profile_id = null, $discount = 0)
	{
			#error_log("PAYMENT ($profile_id) PROFILE_ID2=$payment_profile_id");
		$purchase_id = $this->Session->read("purchase_id");
		$this->log("INITIALIZING PURCHASE....");
		$this->log("CUSTOMER=".print_r($this->Auth->user(),true));
		$this->log("ORDERING=".print_r($product_list,true));
		$this->log("CART_DETAILS=".print_r($shoppingCart,true));
		if(!empty($purchase_id))
		{
			# Remove purchase record. Since done part-way.
			$this->Purchase->del("purchase_id");
		}

		$this->log("Profile ID=$profile_id, Payment Profile ID=$payment_profile_id");

		if($payment_profile_id > 0 &&!($paymentProfile = $this->Cim->get_payment_profile($profile_id, $payment_profile_id)))
		{
			$this->log("PAYMENT PROFILE=".print_r($paymentProfile,true));
			$this->flashError("There was an error processing your payment information. ".$this->Cim->error,true);
			return false;
		}

		if(!empty($paymentProfile))
		{
			list($cardNumber) = $paymentProfile->xpath("payment/creditCard/cardNumber");
		}
		$cardLast4 = !empty($cardNumber) ? (string)$cardNumber:null;
		$this->log("CARD LAST 4: $cardLast4");

		$shipping_id = $this->Session->read("shipping_id");
		$billing_id = $this->Session->read("billing_id");
		# Make sure addresses have customer id.
		$this->ContactInfo->id = $billing_id;
		$this->ContactInfo->saveField("Customer_ID", $this->get_customer_id());
		$this->ContactInfo->id = $shipping_id;
		$this->ContactInfo->saveField("Customer_ID", $this->get_customer_id());

		$this->log("Shipping ID=$shipping_id, Billing ID=$billing_id");

		$payment_method = $this->data['payment_method'];

		$shippingOptions = $this->get_all_shipping_options($shipping_id, $product_list, $subtotal);
		$shippingInfo = null;

		$shipping_method_id = !empty($this->params['form']['shipping_method']) ? $this->params['form']['shipping_method'] : $this->Session->read("shipping_method_id");

		#print_r($shippingOptions);
		#echo "SMID ($shipping_id, SUZ=$subtotal, PL=".join(",", $product_list)."=$shipping_method_id";

		foreach($shippingOptions as $shippingOption)
		{
			if($shippingOption['shippingMethod']['shippingMethodID'] == $shipping_method_id)
			{
				$shippingInfo = $shippingOption;
			}
		}

		if (!$shippingInfo)
		{
			$this->flashError("Could not submit order, shipping information missing.",true);
			return false;
			#$this->redirect("/checkout/form");
		}

		#$this->log("Shipment Details=".print_r($shippingInfo,true));

		# CONTINUE HERE>...
		$shipping_cost = $shippingInfo[0]['cost'];
		$old_shipping_cost = !empty($shippingInfo[0]['original_cost']) ? $shippingInfo[0]['original_cost'] : $shipping_cost;


		$rush_date = $this->Session->read("rush_date");
		$rush_cost = $this->Session->read("rush_cost");

		$customer_id = $this->get_customer_id();

		$this->log("RUSH date=$rush_date, cost=$rush_cost");

		return $this->_initialize_purchase($customer_id, $shoppingCart, $product_list, $shipping_id, $billing_id, $payment_method, $shipping_method_id, $shipping_cost, $old_shipping_cost, $rush_cost, $rush_date, $profile_id, $payment_profile_id, $cardLast4, $discount);
	}

	function _initialize_purchase($customer_id, $shoppingCart, $product_list, $shipping_id = null, $billing_id = null, $payment_method = null, $shipping_method_id = null, $shipping_cost = null, $old_shipping_cost = null, $rush_cost = null, $rush_date = null, $profile_id = null, $payment_profile_id = null, $cardLast4 = null, $discount = 0)
	{
		$free_shipping = ($shipping_cost == 0);

		$this->log("Starting purchase, Customer ID=$customer_id, Shipping ID=$shipping_id, Billing ID=$billing_id, Payment Method=$payment_method, Shipping Method=$shipping_method_id, Shipping Cost=$shipping_cost, Profile ID=$profile_id, Payment Profile ID=$payment_profile_id, Card4=$cardLast4, Discount=$discount");



		error_log("DATA (date)=".print_r($this->data,true));

		error_log("INITIALIZING ORDER");
                $order_status = 'Submitted';
                $order_date = !empty($this->data['Purchase']['Order_Date']) ? 
                	$this->data['Purchase']['Order_Date'] :
			date('Y-m-d H:i:s');

		#print_r($this->Session->read());
		#$payment_id = $this->Session->read("payment_id");
		$payment_id =  null;

		if($payment_method == 'paypal') { $payment_id = -1; }
		if($payment_method == 'billme') { $payment_id = -2; }
		if($payment_method == 'amazon') { $payment_id = -3; }

		$subtotal = 0;

		$product_list = array();
		#print_r($shoppingCart);

		foreach($shoppingCart as $cartItem)
		{
			$code = $cartItem['productCode'];
			$parts = $cartItem['parts'];
			#echo "PARTS=".print_r($parts);
			if ($code == 'B'  && !empty($parts['charmID']))
			{
				$code = 'BC';
			}
			if ($code == 'B'  && empty($parts['tasselID']))
			{
				$code = 'BNT';
			}
			$item_price = $cartItem['quantity'] * $cartItem['unitPrice'];
			$subtotal += $item_price;
			if(!empty($cartItem['setupPrice'])) { $subtotal += $cartItem['setupPrice']; }
			if (empty($product_list[$code])) { $product_list[$code] = 0; }
			$product_list[$code] += $cartItem['quantity'];
		}
		#print_r($product_list);


		$purchase = array();
		$purchase['profile_id'] = $profile_id;
		$purchase['payment_profile_id'] = $payment_profile_id;
		$purchase['cardLast4'] = $cardLast4;
		$purchase['Order_Date'] = $order_date;
		$purchase['Order_Status'] = $order_status;
		$purchase['Shipping_Method'] = $shipping_method_id;
		$purchase['Customer_ID'] = $customer_id;
		#echo "SID=$shipping_id\n<br/>";
		$purchase['Shipping_ID'] = $shipping_id;
		$purchase['Shipping_Cost'] = $shipping_cost;
		$purchase['Old_Shipping_Cost'] = $old_shipping_cost;
		$purchase['Billing_ID'] = $billing_id;
		$purchase['Credit_Card_ID'] = $payment_id;
		$purchase['order_comment'] = !empty($this->params['form']['orderComment']) ? $this->params['form']['orderComment'] : null;
		$purchase['free_shipping'] = $free_shipping;
		$purchase['session_id'] = session_id();
		$purchase['discount'] = $discount;
		$purchase['customer_po'] = !empty($this->data['Purchase']['customer_po']) ? $this->data['Purchase']['customer_po'] : $this->Session->read("customer_po");


		list($ships_by, $ships_buffer, $rush_ships_by, $rush_ships_buffer) = 
			$this->Product->get_shipment_times($product_list);


		if(!empty($rush_date) && !empty($rush_cost))
		{
			$ships_by = $rush_ships_by;
			# Could ship sooner since rush processing.
			$purchase['rush_date'] = $rush_date;
			$purchase['rush_cost'] = $rush_cost;
		}

		$purchase['Charge_Amount'] = $subtotal+$shipping_cost+$rush_cost-$discount;

		$ships_by_stamp = date('Y-m-d H:i:s', $ships_by);
		$purchase['ships_by'] = $ships_by_stamp;

		if(!empty($purchase_id))
		{
			$this->Purchase->id = $purchase_id;
			$purchase['purchase_id'] = $purchase_id;
		} else {
			$this->Purchase->create();
		}

		error_log("PURCHASE=".print_r($purchase,true));

		$this->Purchase->save(array('Purchase'=>$purchase));
		$purchase_id = $this->Purchase->id;

		$this->log("Purchase RECORD ($purchase_id)=".print_r($purchase,true));

		$this->Session->write("purchase_id", $purchase_id); # Save in case jump back and forth.

		return $purchase_id;
	}


	function load_cart()
	{
		#error_log(Debugger::trace());
		list($shoppingCart, $subtotal, $product_list, $eligible_subtotal, $discount) = $this->get_cart_items();
		$this->set("shoppingCart", $shoppingCart);
		$this->set("subtotal", $subtotal);
		$this->set("discount", $discount);

		$this->set("eligible_subtotal", $eligible_subtotal);
		$this->set("product_map", Set::combine($this->Product->findAll(), '{n}.Product.code', '{n}.Product'));
		$buildable_products = $this->Product->findAll("buildable = 'yes' AND available = 'yes' AND is_stock_item = 0");
		$this->set("products", $buildable_products);

		$shipping_id = $this->Session->read("shipping_id");
		$shippingAddress = $this->ContactInfo->read(null, $shipping_id); # XXX allow for custom one just per this transaction.

		#error_log("CART=".print_r($shoppingCart,true));

		if (empty($shoppingCart)) { $this->redirect("/cart/display"); } # Nothing in cart, abort!

		return array($shoppingCart, $subtotal, $product_list, $eligible_subtotal, $discount);

		#$this->set("grandtotal", $subtotal);
	}

	function redeem_coupon()
	{
		error_log("PASSED=".print_r($this->params,true));
		if(isset($this->params['form']['coupon']))
		{
			$this->Session->write("coupon", $this->params['form']['coupon']);
		}
		$this->setAction("update_shipping_speed");
	}


}
