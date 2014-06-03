<?php

include_once("cart_items_controller.php");

class CartController extends CartItemsController {

	var $name = 'Cart';
	var $helpers = array('Html', 'Form','Ajax');
	var $uses = array("Product", "ProductPricing", "ProductPart", "GalleryImage", "CustomImage", "CustomizationOption", "ProductRecommendedQuote", "ImageRecommendedQuote","Quote","Tassel","Charm","Border","Ribbon","Frame","ContactInfo","ShippingPricePoint","CartItem","CreditCard","TrackingRequest",'Country','ShippingMethod','Purchase');
	var $options = array();
	var $paginate = array(
		'CartItem'=>array('order'=>'cart_item_id DESC'),
	);

	function beforeRender()
	{
		parent::beforeRender();

		# XXX TODO FIGURE OUT WHICH STEP THIS IS SO CAN GENERATE # FOR IT...

		# GENERATE steps lists....

		switch($this->action)
		{
			case 'admin_add':
			case 'admin_edit':
			case 'add':
			case 'edit':
				break;
		}

		$this->set("rightbar_disabled", true);

		#$this->set("status_bar_template", "cart/progress");
		#$this->set("current_build_step", 4);
		$this->set("steps_disabled", true);

		$this->Product->recursive = 1;
		$products = $this->Product->findAll('available = "yes" ');
		$this->set("product_map", Set::combine($products, '{n}.Product.code', '{n}.Product'));
		$this->set("pricing_map", Set::combine($products, '{n}.Product.code', '{n}.ProductPricing'));

		$this->set("in_cart", true);
	}

	function dump()
	{
		list($shoppingCart, $subtotal, $product_list) = $this->get_cart_items();
		header("Content-Type: text/plain");
		print_r($shoppingCart);
		exit(0);
	}

	function checkout()
	{
		$this->redirect("/checkout");
	}


	function checkout_receipt()
	{
	}

	function ajax_change_shipping_method($shipping_method_id = 1)
	{
		$this->Session->write("shipping_method_id", $shipping_method_id);
	}

	function updateother()
	{
		#error_log("F=".print_r($this->params['form']));
		$submit = isset($this->params['form']['submit']) ? $this->params['form']['submit'] : "";
		# Remove from cart, change quantity (and unit pricing), etc...
		$cart_items = $this->Session->read("shoppingCart");
		$revised_cart_items = array();

		foreach($this->data as $item_id => $item_data)
		{
			for($i = 0; $i < count($cart_items); $i++)
			{
				if ($i == $item_id)
				{
					$cart_items[$i]['quantity'] == $item_data['quantity'];
				}
			}

			if (!isset($item_data['remove']))
			{
				$revised_cart_items[] = $cart_items[$item_id];
			}
		}
		$this->Session->write("shoppingCart", $revised_cart_items);

		#error_log("S=$submit");

		if ($submit == 'Checkout')
		{
			$this->redirect("/checkout");
		} else {
			$this->redirect(array('action'=>'display'));
		}
	}

	function add_consolidated()
	{
		//echo __line__ . " cart_controller add_consolidated<br>";
		# Take $this->build and put into cart appropriately....
		# Need to make sure it's complete, though. If not, redirect to appropriate page within build.

		if (empty($this->data['productCode']))
		{
			$this->redirect("/products");
		}
		$productCode = $this->data['productCode'];
	##	error_log("P=".print_r($this->data['options'],true));

		$catalogNumber = "";
		if(!empty($this->data['options']['catalogNumber']))
		{
			$catalogNumber = $this->data['options']['catalogNumber'];
		}

		if (empty($this->data['options']['catalogNumber']) && empty($this->data['options']['customImageID']) && $this->data['template'] != 'textonly') 
		{
			$this->redirect("/gallery");
		}

		# If in middle of build, go where left off...
		$this->load_build_options($productCode); # Loads $this->steps_incomplete


		$quantity = !empty($this->data['quantity']) ? $this->data['quantity'] : $this->build['quantity'];

		$cartItem = $this->data; # WHatever we pass, goes into.

		if (($productCode == 'BNT' || $productCode == 'B') && !empty($this->data['options']['charmID']) && $this->data['options']['charmID'] > 0)
		{
			$productCode = 'BC';
		}
		if ($productCode == 'B' && (empty($this->data['options']['tasselID']) || $this->data['options']['tasselID'] <= 0))
		{
			$productCode = 'BNT';
		}
		if ($productCode == 'BNT' && (!empty($this->data['options']['tasselID']) && $this->data['options']['tasselID'] > 0))
		{
			$productCode = 'B';
		}
		if($productCode == 'BC' && (empty($this->data['options']['charmID']) || $this->data['options']['charmID'] <= 0))
		{
			$productCode = 'B';
		}
		if($productCode == 'B' && (empty($this->data['options']['tasselID']) || $this->data['options']['tasselID'] <= 0))
		{
			$productCode = 'BNT';
		}

		if ($productCode == 'PS' && !empty($this->data['options']['poster_frame']))
		{
			$productCode = 'PSF';
		}
		error_log("PC=$productCode");

		$product = $this->Product->find("code = '$productCode'");

		$surcharge = 0;

		if (!empty($this->data['options']['quantity_size']))
		{
			$quantity = 0;
			$this->data['options']['size'] = array();

			foreach($this->data['options']['quantity_size'] as $size => $qty)
			{
				$this->data['options']['size'][$size] = $qty;

				$quantity += $qty;

				if($productCode == 'TS' && !empty($product['Product']["surcharge_$size"]))
				{
					if(empty($this->data['setup_charge'])) { $this->data['setup_charge'] = 0; }
					$this->data['setup_charge'] += $product['Product']["surcharge_$size"] * $qty;
				}
			}
		}

		if (!$quantity || $quantity < $product["Product"]['minimum'])
		{
			$quantity = $product['Product']['minimum'];
		}

		$cartItem['productCode'] = $productCode;
		$cartItem['quantity'] = $quantity;
		$cartItem['surcharge'] = $surcharge;
		$cartItem['setupPrice'] = !empty($this->data['setup_charge']) ? $this->data['setup_charge'] : 0;
		$cartItem['comments'] = $this->data['options']['itemComments'];

		if(empty($this->data['template'])) { $this->data['template'] = 'standard'; }

		if(preg_match("/fullbleed/", $this->data['template']))
		{
			$this->data['options']['fullbleed'] = 1;
			$this->data['template'] = 'imageonly';
		}
		$template = $this->data['template'];
		if($template == 'imageonly_nopersonalization')
		{
			$template = 'imageonly';
			$this->data['options']['personalizationNone'] = 1;
			//unset($this->data['options']['personalizationInput']);
		}
		$cartItem['template'] = $template;
		$cartItem['rotate'] = !empty($this->data['rotate']) ? $this->data['rotate'] : null;

		#print_r($this->build['options']);

		$parts = $this->data['options'];
		unset($parts['x']);
		unset($parts['y']);

		# PREVENT HTML INJECTION HACKING FROM BOTS...
		# Fix personalizationInput and customQuote so stripped of html and/or bbcode, and limited to product limits.
		$parts = $this->filterText($parts, $product);

	#	error_log("PARTS=".print_r($parts,true));

		if (!isset($parts['reproductionStamp']) && !empty($this->data['options']['catalogNumber']))
		{
			$product_image_type = $product['Product']['image_type'];
			$catnum = $this->data['options']['catalogNumber'];
			$stamp = $this->GalleryImage->find(" GalleryImage.catalog_number = '$catnum' ");
			$reproducible = strtolower($stamp['GalleryImage']['reproducible']);
			# ALSO DEPENDS ON PRODUCT!!!!!!
			if ($reproducible == 'no')
			{
				$parts['reproductionStamp'] = 'no';
			} else if ($reproducible == 'only') { 
				$parts['reproductionStamp'] = 'yes';

			} else if ($reproducible == 'yes' && preg_match("/repro/", $product_image_type)) {
				$parts['reproductionStamp'] = 'yes';
			} else { # Can't do repro... (original stamp only)
				$parts['reproductionStamp'] = 'no';
			}
			# Get default for stamp.
		}

		#error_log("ADDINGF TO CART");

		if($this->Image->didSupplyUpload(array('PersonalizationLogo','file')))
		{
			$id = $this->process_image_upload('PersonalizationLogo');

			#error_log("ID=$id");
			$parts['personalization_logo_id'] = $id;
		} else if (!empty($this->data['personalization_logo_id'])) {
			$parts['personalization_logo_id'] = $this->data['personalization_logo_id'];

		}

		# Add crop coordinates.
		$parts['imageCrop'] = !empty($this->build['crop'][$template]) ? join(",", $this->build['crop'][$template]) : null;

		$cartItem['parts'] = serialize($parts);

		$stamp_surcharge = $this->get_stamp_surcharge();
		$unitPrice = $this->Product->get_effective_base_price($productCode, $quantity, $this->Session->read("Auth.Customer"), $stamp_surcharge, $parts, $catalogNumber);
		$cartItem['unitPrice'] = $unitPrice['total'];

		$session_id = $this->get_session_id();
		$customer_id = $this->get_customer_id();
		$cartItem['customer_id'] = $customer_id;
		$cartItem['session_id'] = $session_id;

		if (empty($this->build['cart_item_id']))
		{
			$this->CartItem->create();
		} else {
			$cartItem['cart_item_id'] = $this->data['cart_item_id'];
		}
		$this->TrackingVisit->did_goal("cart");
		$this->CartItem->save(array('CartItem'=>$cartItem));
		$cart_item_id = $this->CartItem->id;

		# Add tracking.
		$this->track("cart", "add", $cartItem);

		$this->Session->delete("Build"); # clear build area once in cart...
		$this->Session->write("Build.cart_item_id", $cart_item_id); # Let us go back properly...
	#	error_log("WRITING CART_ITEM_ID=$cart_item_id, ".print_r($this->Session->read("Build"),true));
		# Keep build set up so we can go back and make changes, ok if duplicates....


		#$this->Session->delete("Build"); # Remove build, qty, etc...
		$this->redirect("/cart/display");

		#exit(0);


		#
		#
	}

	function filterText($parts, $product)
	{
		$quoteLimit = $product['Product']['quote_limit'];
		$persLimit = $product['Product']['personalizationLimit'];

		if(!empty($parts['personalizationInput']))
		{
			$parts['personalizationInput'] = strip_tags($parts['personalizationInput']); # Strip HTML
			if(strlen($parts['personalizationInput']) > $persLimit)
			{
				$parts['personalizationInput'] = substr($parts['personalizationInput'], 0, $persLimit);
			}
		}
		if(!empty($parts['customQuote'])) 
		{
			$parts['customQuote'] = strip_tags($parts['customQuote']); # Strip HTML
			if(strlen($parts['customQuote']) > $quoteLimit)
			{
				$parts['customQuote'] = substr($parts['customQuote'], 0, $quoteLimit);
			}
		}
		return $parts;
	}


	function process_image_upload($model = 'PersonalizationLogo')
	{
			$path = $this->getImagePath();
			$filename = $this->Image->saveUpload(array($model,'file'), $path, time().rand(0,10000));
			#error_log("PROCCESSING = $filename");
			# Now need to scale, etc.... and create CustomImage record.
			$viewable_filename = $this->Image->viewable_filename($filename);
				$display_width = 350;
				$thumb_height = 80;

				$rc = $this->Image->scaleFile("$path/$filename", "$path/display/$viewable_filename", $display_width, null, 1);
                                if (is_array($rc))
                                {
                                	$this->Session->setFlash(join("<br/>", $rc));
                                        return;
                                }
                                $rc = $this->Image->scaleFile("$path/$filename", "$path/thumbs/$viewable_filename", null, $thumb_height, 1);
                                if (is_array($rc))
                                {
                                                $this->Session->setFlash(join("<br/>", $rc));
                                                return;
                                }

				# Now save to database.
				$data = array();
				$data['CustomImage']['session_id'] = $this->Session->id();
				$data['CustomImage']['Customer_ID'] = $this->Session->read("Auth.Customer.customer_id");
				$data['CustomImage']['Image_Path'] = $path; 
				$data['CustomImage']['Submission_Date'] = $this->unix_date();

				$data['CustomImage']['Title'] = $this->Image->getOriginalFilenamePrefix(array('PersonalizationLogo','file'));

				$data['CustomImage']['Image_Location'] = "$path/$filename"; # Could be gigantic here

				$data['CustomImage']['display_location'] = "$path/display/$viewable_filename"; # What we'll bother showing on browser for sanity.
				$data['CustomImage']['thumbnail_location'] = "$path/thumbs/$viewable_filename";

				# Now save record.
				$this->CustomImage->save($data);


			$id = $this->CustomImage->id;

			#error_log("SAVING CUSTOM_IMG=$id");

			return $id;
	}

	function addnew()
	{
		# Take $this->build and put into cart appropriately....
		# Need to make sure it's complete, though. If not, redirect to appropriate page within build.

		if (empty($this->build['Product'])) 
		{
			$this->redirect("/products");
		}
		if (empty($this->build['GalleryImage']) && empty($this->build['CustomImage'])) 
		{
			$this->redirect("/gallery");
		}

		# If in middle of build, go where left off...
		$this->load_build_options(); # Loads $this->steps_incomplete
		if (!empty($this->steps_incomplete))
		{
		#	error_log("INC=".print_r($this->steps_incomplete,true));
			foreach($this->steps_incomplete as $step => $stepname)
			{
				$this->redirect("/build/step/$step");
			}
		}

		$quantity = !empty($this->params['form']['quantity']) ? $this->params['form']['quantity'] : $this->build['quantity'];
		if (!$quantity || $quantity < $this->build["Product"]['minimum'])
		{
			$quantity = $this->build["Product"]['minimum'];
		}


		$cartItem = array();
		$productCode = $this->build['Product']['code'];
		if ($productCode == 'B' && !empty($this->build['options']['charm']))
		{
			$productCode = 'BC';
		}
		else if ($productCode == 'B' && empty($this->build['options']['tassel']))
		{
			$productCode = 'BNT';
		}
		else if ($productCode == 'PS' && !empty($this->build['options']['poster_frame']))
		{
			$productCode = 'PSF';
		}


		$cartItem['productCode'] = $productCode;
		$cartItem['quantity'] = $quantity;
		$cartItem['comments'] = $this->build['options']['comments']['itemComments'];

		#print_r($this->build['options']);


		if (!empty($this->build['CustomImage']))
		{
			$parts['customImageID'] = $this->build['CustomImage']['Image_ID'];
		}
		$catalogNumber = null;
		if (!empty($this->build['GalleryImage']))
		{
			$parts['catalogNumber'] = $this->build['GalleryImage']['catalog_number'];
			$catalogNumber = $this->build['GalleryImage']['catalog_number'];
		}

		foreach($this->build['options'] as $stepkey => $stepdata)
	        {
	                #echo "SK=$stepkey";
	                foreach($stepdata as $field => $value)
	                {
				if ($value == 'Custom')
				{
					$customfield = null;
					if(preg_match("/(.*)ID$/", $field, $fieldparts))
					{
						$customfield = "custom".$fieldparts[1];
					}
					if ($customfield && !empty($this->params['form'][$customfield]))
					{
						$value = $stepdata[$customfield];
						unset($stepdata[$customfield]);
					}
				}
					/*
					ribbon_ID
					tassel_ID
					charm_ID
					quote_ID
					border_ID
					custom_quote
					personalization
					personalizationStyle
					imageID
					catalogNumber
					stampNumber
					reproductionStamp
					frameID
					pinStyle
					posterFrame
					Size
					PrintSide
					handles
					postCardAddress
					purchase_ID          
					*/
				$parts[$field] = $value;
	                }
	        }

		$cartItem['parts'] = serialize($parts);

		$stamp_surcharge = $this->get_stamp_surcharge();
		$unitPrice = $this->Product->get_effective_base_price($productCode, $quantity, $this->Session->read("Auth.Customer"), $stamp_surcharge, $parts, $catalogNumber);
		$cartItem['unitPrice'] = $unitPrice['total'];

		$session_id = $this->get_session_id();
		$customer_id = $this->get_customer_id();
		$cartItem['customer_id'] = $customer_id;
		$cartItem['session_id'] = $session_id;

		if (empty($this->build['cart_item_id']))
		{
			$this->CartItem->create();
		} else {
			$cartItem['cart_item_id'] = $this->build['cart_item_id'];
		}
		$this->TrackingVisit->did_goal("cart");
		$this->CartItem->save(array('CartItem'=>$cartItem));

		$this->Session->delete("Build"); # clear build area once in cart...


		#$this->Session->delete("Build"); # Remove build, qty, etc...
		$this->redirect("/cart/display");

		#exit(0);


		#
		#
	}

	function add()
	{
		# We need to redo since we're saving into db now....
		# Standard stuff gets saved to db, tho parts gets saved to xml....
		$form = !empty($this->params['form']) ? $this->params['form'] : $this->params['url'];
		if (empty($form))
		{
			$this->redirect("/cart/display");
		}

		$this->Session->delete("Preview"); # Clear.

		unset($form['action']);

		$productCode = $form['productCode'];
		$product = $this->Product->find(" code = '$productCode' ");
		#error_log("PR=".print_r($product,true));
		if (empty($product['Product'])) { $this->redirect("/cart/display"); }
		$minimum = $product['Product']['minimum'];

		$quantity = $form['quantity'];
		if ($quantity < $minimum)
		{
			$quantity = $minimum;
			$this->Session->setFlash("Minimum is $minimum");
		}

		$cartItem = array();
		$cartItem['productCode'] = $productCode;
		$cartItem['quantity'] = $quantity;
		unset($form['quantity']);
		$cartItem['comments'] = !empty($form['itemComments']) ? $form['itemComments'] : null;
		unset($form['itemComments']);

		$parts = array();

		#error_log("FORM=".print_r($form,true));

		$customized = !empty($this->params['form']['customized']) ? $this->params['form']['customized'] : null;

		if($customized == 'logo' && $this->Image->didSupplyUpload(array('PersonalizationLogo','file')))
		{
			$id = $this->process_image_upload("PersonalizationLogo");

			$parts['personalization_logo_id'] = $id;
			$parts['customized'] = 1;
		} else if($customized == 'logo' && !empty($this->data['options']['personalization_logo_id'])) {
			$parts['personalization_logo_id'] = $this->data['options']['personalization_logo_id'];
			$parts['customized'] = 1;
		} else if($customized == 'personalization' && !empty($this->data['options']['personalizationInput'])) {
			$parts['personalizationInput'] = $this->data['options']['personalizationInput'];
			$parts['customized'] = 1;
		} else {
			$parts['customized'] = 0; # Clear.
			$parts['personalizationInput'] = null;
			$parts['personalization_logo_id'] = null;
		}

		if(!empty($form['quoteID']))
		{
			$parts['quoteID'] = $form['quoteID'];
		}

		# PREVENT HTML INJECTION HACKING FROM BOTS...
		# Fix personalizationInput and customQuote so stripped of html and/or bbcode, and limited to product limits.
		$parts = $this->filterText($parts, $product);

		$catalogNumber = !empty($form['catalogNumber']) ? $form['catalogNumber'] : null;

		# Other stuff....

		# Switch id's over if from dropdown vs radio
		foreach($form as $field => $value)
		{
			if (preg_match("/_data$/", $field)) { continue; }
			if (preg_match("/^action_*/", $field)) { continue; }
			if (preg_match("/next_step/", $field)) { continue; }

			#if ($value == 'None') { continue; }
			# Should preserve 'None' when reload for modification, etc...
			if ($value == 'Custom')
			{
				$customfield = null;
				if(preg_match("/(.*)ID$/", $field, $fieldparts))
				{
					$customfield = "custom".$fieldparts[1];
				}
				if ($customfield && !empty($form[$customfield]))
				{
					$value = $form[$customfield];
					unset($form[$customfield]);
				}
			}
			$parts[$field] = $value;
		}

		#if ($productCode == 'B' && !empty($parts['charm']))
		#{
		#	$productCode == 'BC';
		#}

		#$parts_xml = $this->encode_xml($parts);
		#$cartItem['parts'] = $parts_xml;
		$cartItem['parts'] = serialize($parts);

		###$cartItem['unitPrice'] = $this->calculate_item_unit_price($productCode, $quantity, $parts);
		# Need to know which options are included (ie charm, etc) to calculate accurate price.
		$stamp_surcharge = $this->get_stamp_surcharge();
		$unitPrice = $this->Product->get_effective_base_price($productCode, $quantity, $this->Session->read("Auth.Customer"), $stamp_surcharge, $parts, $catalogNumber);
		$cartItem['unitPrice'] = $unitPrice['total'];

		# Identify with user....

		$session_id = $this->get_session_id();
		$customer_id = $this->get_customer_id();
		$cartItem['customer_id'] = $customer_id;
		$cartItem['session_id'] = $session_id;

		# Add setup price for customized versions.

		$cartItem['setupPrice'] = (!empty($parts['customized']) && !empty($product['Product']['setup_charge'])) ? $product['Product']['setup_charge'] : 0;

		if (empty($form['cart_item_id']))
		{
			$this->CartItem->create();
		} else {
			$this->CartItem->id = $form['cart_item_id'];
			$cartItem['cart_item_id'] = $form['cart_item_id'];
		}

		$this->TrackingVisit->did_goal("cart");
		$this->CartItem->save(array('CartItem'=>$cartItem));

		#print_r($cartItem);
		$this->Session->delete("Build"); # Remove build, qty, etc...
		$this->redirect("/cart/display");
	}

	function clear()
	{
		$sid = session_id();
		$this->CartItem->deleteAll(array("session_id"=>$sid));
		if($cid = $this->customer_id())
		{
			$this->CartItem->deleteAll(array("customer_id"=>$cid));
		}
		$this->Session->setFlash("Your cart has been emptied");
		$this->redirect("/cart/display");

	}

	function update_review($in_checkout = false)
	{
		# Figure out what rush dates/costs are so we can display (in view) AND put in DB (here)

		# RUSH IS DONE ON ALL PRODUCTS.... not just what's in build!
		# XXX TODO
		# TOMAS_MALY

		############################## 
		# CONSIDER CHANGES ###########
		$this->set("checkout", $in_checkout);

		$zipCode = $this->Session->read("zipCode");
		$country = $this->Session->read("country");
		# Load properly.

		# Let them change if desired.
		if(isset($this->params['form']['zipCode']))
		{
			$zipCode = $this->params['form']['zipCode'];
		}

		if(isset($this->data['Country']))
		{
			$country = $this->data['Country'];
		}

		$shipping_id = $this->Session->read("shipping_id");
		if($in_checkout && !empty($shipping_id)) # Load.
		# Load from prefs if in checkout instead. save into session for later.
		{
			$address = $this->ContactInfo->read(null, $shipping_id);
			if(!empty($address))
			{
				$zipCode = $address['ContactInfo']['Zip_Code'];
				$country = $address['ContactInfo']['Country'];
			}
		} 
		if(empty($country)) { $country = 'US'; }

		$this->Session->write("zipCode", $zipCode);
		$this->Session->write("country", $country);
		# If they go back to adding new items, the zip/country should reflect what
		# they selected upon checkout.
		# (otherwise, only let them use session var in cart)


		if(!empty($this->params['form']['shipping_method']))
		{
			$this->Session->write("shipping_method_id", $this->params['form']['shipping_method']);
		}

		list($shoppingCart, $subtotal, $product_list) = $this->get_cart_items();

		if(!empty($this->data))
		{
			if (!empty($this->data['receive_by']))
			{
				# Encoded as ship_meth_id:rush_date
				$receive_info = split(":", $this->data['receive_by']);
				$shipping_method_id = $receive_info[0];

				if(!empty($receive_info[1]) && !empty($this->viewVars['rush_dates'][$receive_info[1]]))
				{
					$rush_date = $receive_info[1];
					# Calculate rush costs.
					$rush_cost = $this->viewVars['rush_dates'][$rush_date];
					$this->Session->write('rush', true);
					$this->Session->write('rush_date', $rush_date);
					$this->Session->write('rush_cost', $rush_cost);
				} else {
					$rush_date = null;
					$this->Session->write('rush', null);
					$this->Session->write('rush_date', null);
					$this->Session->write('rush_cost', null);
				}
				$this->Session->write("shipping_method_id", $shipping_method_id);
			}
			list($shoppingCart, $subtotal, $product_list) = $this->get_cart_items();
			# Reload...
		}

		# This considers rush costs, because we set grand_total, etc in here.
		$this->set("subtotal", $subtotal);
		$this->set("shoppingCart", $shoppingCart);

		$this->set("rush", $this->Session->read("rush"));
		$rush_cost = $this->Session->read("rush_cost");
		$this->set("rush_cost", $rush_cost);
		$rush_date = $this->Session->read("rush_date");
		$this->set("rush_date", $rush_date);
	}


	function update()
	{
	#	error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
		$action = !empty($this->params['form']['action']) ? $this->params['form']['action'] : null;
		$zipCode = !empty($this->params['form']['zipCode']) ? $this->params['form']['zipCode'] : null;
		$country = !empty($this->data['Country']) ? $this->data['Country'] : 'US';

		#error_log("FORM=".print_r($this->params['form'],true));

		# Always make sure shipping method is updated properly...
		$shippingMethod = !empty($this->params['form']['shipping_method']) ? $this->params['form']['shipping_method'] : null;
		$this->Session->write("zipCode", $zipCode);
		$this->Session->write("country", $country);

		if ($shippingMethod)
		{
			$this->Session->write("defaultShippingMethod", $shippingMethod);
			#error_log("SHIP=$shippingMethod");
		}

		if ($action == 'checkout')
		{
			$this->redirect("/checkout");
		}

		$session_id = $this->get_session_id();
		$customer_id = $this->get_customer_id();

		if($this->Image->didSupplyUpload(array('PersonalizationLogo','file')))
		{
			$id = $this->process_image_upload("PersonalizationLogo");

			$this->build['options']['personalization_logo_id'] = $id;
		} else if (!empty($this->data['personalization_logo_id'])) {
			$this->build['options']['personalization_logo_id'] = $this->data['personalization_logo_id'];

		}


		# Else, update quantity....
		foreach($this->params['form'] as $field => $value)
		{
			$setupPrice = null;
			if (preg_match("/(quantity|quantity_size)(\d+)$/", $field, $matches))
			{
				$type = $matches[1];
				$id = $matches[2];
				#$cartItem = $this->CartItem->find(" cart_item_id = '$id' AND (session_id = '$session_id' OR customer_id = '$customer_id') ");
				$cartItem = $this->CartItem->find(" cart_item_id = '$id' AND session_id = '$session_id' ");
				if (!empty($cartItem))
				{
					$code = $cartItem['CartItem']['productCode'];
					$product = $this->Product->find("code = '$code'");
					#echo "CI=".print_r($cartItem,true);

					error_log("CI=".print_r($cartItem['CartItem'],true));

					$parts = unserialize($cartItem['CartItem']['parts']);
					$parts2 = unserialize($cartItem['CartItem']['parts2']);

					$quantity = 0;

					# XXX tshirt surcharge todo...

					if(is_array($value))
					{
						$parts['size'] = array();
			
						foreach($value as $size => $qty)
						{
							$parts['size'][$size] = $qty;
		
							$quantity += $qty;

							# XXX tshirt surcharge possibly...
							error_log("SURCH$size=".$product['Product']["surcharge_$size"]);
							if(!empty($product['Product']["surcharge_$size"]))
							{
								if(empty($setupPrice)) { $setupPrice = 0; }
								$setupPrice += $qty*$product['Product']["surcharge_$size"];
							}
						}
						$cartItem['CartItem']['parts'] = serialize($parts);
					} else {
						$quantity = $value;
					}
					if($quantity == 0) # REMOVE!
					{
						#$value = $product['Product']['minimum']; 
						#$this->Session->setFlash("Minimum quantity is $value. To delete an item from your cart, click the Remove link");
						$this->CartItem->del($id);
						continue;
					}
					if ($quantity < $product['Product']['minimum']) { $value = $product['Product']['minimum']; $this->Session->setFlash("Minimum quantity is $value"); } # Don't let them get any less than min, in case of JS error.

					$cartItem['CartItem']['quantity'] = $quantity;

				#	error_log("CI=".print_r($cartItem,true));

					# Update unit pricing for this quantity....
					$catalogNumber = !empty($parts['catalogNumber']) ? $parts['catalogNumber'] : null;
					$stamp_surcharge = $catalogNumber ? $this->get_stamp_surcharge($cartItem['CartItem']['productCode'], $catalogNumber) : null;

					if(!empty($parts2))
					{
						$parts['printing_back'] = 1;
					}

					error_log("PARTS=".print_r($parts,true));

					$unitPrice = $this->Product->get_effective_base_price($cartItem['CartItem']['productCode'], $quantity, $this->Session->read("Auth.Customer"), $stamp_surcharge, $parts, $catalogNumber);
					$cartItem['CartItem']['unitPrice'] = $unitPrice['total'];

					if(!empty($unitPrice['surcharge']))
					{
						$cartItem['CartItem']['surcharge'] = $unitPrice['surcharge'];
					}


					if($setupPrice !== null)
					{
						error_log("SETUP=$setupPrice");
						$cartItem['CartItem']['setupPrice'] = $setupPrice;
					}

					#$this->CartItem->create();
					#$this->CartItem->id = $cartItem["CartItem"]['cart_item_id'];
					$this->CartItem->save($cartItem);
				}
				#$cartItem = $this->Session->read("shoppingCart.$id");
				#$cartItem->quantity = $value;
				#$this->Session->write("shoppingCart.$id", $cartItem);
			}
		}

	#	error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());

		$this->redirect("/cart/display.php");
	}

	function admin_update()
	{
		error_log("UIPDATE");
		$cid = null;

		if($this->Image->didSupplyUpload(array('PersonalizationLogo','file')))
		{
			$id = $this->process_image_upload("PersonalizationLogo");

			$this->build['options']['personalization_logo_id'] = $id;
		} else if (!empty($this->data['personalization_logo_id'])) {
			$this->build['options']['personalization_logo_id'] = $this->data['personalization_logo_id'];

		}


		# Else, update quantity....
		foreach($this->params['form'] as $field => $value)
		{
			$setupPrice = null;
			if (preg_match("/(quantity|quantity_size)(\d+)$/", $field, $matches))
			{
				$type = $matches[1];
				$id = $matches[2];
				$cartItem = $this->CartItem->find(" cart_item_id = '$id' ");
				$cid = $customer_id = $cartItem['CartItem']['customer_id'];
				$customer = $this->Customer->read(null, $cid);
				error_log("ITEM=$id, CID=$cid");
				if (!empty($cartItem))
				{
					$code = $cartItem['CartItem']['productCode'];
					$product = $this->Product->find("code = '$code'");
					#echo "CI=".print_r($cartItem,true);

					$parts = unserialize($cartItem['CartItem']['parts']);

					$quantity = 0;

					# XXX tshirt surcharge todo...

					if(is_array($value))
					{
						$parts['size'] = array();
			
						foreach($value as $size => $qty)
						{
							$parts['size'][$size] = $qty;
		
							$quantity += $qty;

							# XXX tshirt surcharge possibly...
							error_log("SURCH$size=".$product['Product']["surcharge_$size"]);
							if(!empty($product['Product']["surcharge_$size"]))
							{
								if(empty($setupPrice)) { $setupPrice = 0; }
								$setupPrice += $qty*$product['Product']["surcharge_$size"];
							}
						}
						$cartItem['CartItem']['parts'] = serialize($parts);
					} else {
						$quantity = $value;
					}
					if($quantity == 0) # REMOVE!
					{
						$value = $product['Product']['minimum']; 
						$this->Session->setFlash("Minimum quantity is $value. To delete an item from your cart, click the Remove link");
						continue; #SKIP REMOVAL, ACCIDENTAL
						#$this->CartItem->del($id);
						#continue;
					}
					if ($quantity < $product['Product']['minimum']) { $value = $product['Product']['minimum']; $this->Session->setFlash("Minimum quantity is $value"); } # Don't let them get any less than min, in case of JS error.

					$cartItem['CartItem']['quantity'] = $quantity;

				#	error_log("CI=".print_r($cartItem,true));

					# Update unit pricing for this quantity....
					$catalogNumber = !empty($parts['catalogNumber']) ? $parts['catalogNumber'] : null;
					$stamp_surcharge = $catalogNumber ? $this->get_stamp_surcharge($cartItem['CartItem']['productCode'], $catalogNumber) : null;

					$unitPrice = $this->Product->get_effective_base_price($cartItem['CartItem']['productCode'], $quantity, $customer['Customer'], $stamp_surcharge, $parts, $catalogNumber);
					$cartItem['CartItem']['unitPrice'] = $unitPrice['total'];

					if(!empty($unitPrice['surcharge']))
					{
						$cartItem['CartItem']['surcharge'] = $unitPrice['surcharge'];
					}


					if($setupPrice !== null)
					{
						error_log("SETUP=$setupPrice");
						$cartItem['CartItem']['setupPrice'] = $setupPrice;
					}

					#$this->CartItem->create();
					#$this->CartItem->id = $cartItem["CartItem"]['cart_item_id'];
					$this->CartItem->save($cartItem);
				}
				#$cartItem = $this->Session->read("shoppingCart.$id");
				#$cartItem->quantity = $value;
				#$this->Session->write("shoppingCart.$id", $cartItem);
			}
		}

	#	error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());

		if(!empty($cid))
		{
			$this->redirect("/admin/account/view/$cid#CartItems");
		} else {
			$this->redirect("/admin/account");
		}
	}

	function save()
	{
		$customer = $this->Session->read("Auth.Customer");
		if (empty($customer))
		{
			$this->redirect("/account/login?goto=/cart/save");
		}

		$cart_items = $this->Session->read("shoppingCart");
		#$shoppingCart = $this->load_cart_data($cart_items);
		#print_r($shoppingCart);
		#$this->set("shoppingCart", $shoppingCart);

		foreach($cart_items as $cart_item_object)
		{
			#$cart_item_xml = $this->encode_xml($cart_item_object, "cart_item");
			$cart_item_json = serialize($cart_item_object);
			# Encode as XML
		}

	}

	function remove($id = '')
	{
		$session_id = $this->get_session_id();
		$customer_id = $this->get_customer_id();

		if ($id != "")
		{
			$cartItem = $this->CartItem->find(" cart_item_id = '$id' AND (session_id = '$session_id' OR customer_id = '$customer_id') ");
			# Admin can enter in so sess_id is null. need to match cust_id instead.
			#$cartItem = $this->CartItem->find(" cart_item_id = '$id' AND (session_id = '$session_id' ");
			if (!empty($cartItem))
			{
				$this->CartItem->delete($id);
			}
			#$shoppingCart = $this->Session->read("shoppingCart");
			#unset($shoppingCart[$id]);
			#$this->Session->write("shoppingCart", $shoppingCart);
		}
		$this->redirect("/cart/display");
	}


	function display()
	{
		$this->set("stepname", "cart");

		$this->body_title = "Items in your cart";

		list($shoppingCart, $subtotal, $product_list) = $this->get_cart_items();
		if (!count($shoppingCart))
		{
			$this->action = 'display_empty';
			return;
		}

		$this->set("subtotal", $subtotal);
		$this->set("shoppingCart", $shoppingCart);

		$this->Product->recursive = 1;
		$buildable_products = $this->Product->findAll("buildable = 'yes' AND available = 'yes' AND is_stock_item = 0");
		$this->set("products", $buildable_products);

		$products = $this->Product->findAll('available = "yes" ');
		$this->set("product_map", Set::combine($products, '{n}.Product.code', '{n}.Product'));
		$this->set("pricing_map", Set::combine($products, '{n}.Product.code', '{n}.ProductPricing'));

		$related_products = array();

		$product_id_map = Set::combine($products, '{n}.Product.product_type_id', '{n}');
		foreach($products as $product)
		{
			$product_id = $product['Product']['product_type_id'];
			$parent_id = $product['Product']['parent_product_type_id'];
			$code = $product['Product']['code'];
			
			if ($parent_id)
			{
				$parent = $product_id_map[$parent_id];
				$parent_products[$code] = $parent['Product'];
				$related_products[$code] = array();
				foreach($products as $related)
				{
					if ($parent_id == $related['Product']['product_type_id'])
					{
						$related_products[$code][] = $related;
					}
					if ($parent_id == $related['Product']['parent_product_type_id'] && $related['Product']['product_type_id'] != $product_id)
					{
						$related_products[$code][] = $related;
					}
				}
			}
		}

	#	error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
			
		$this->set("related_product_map", $related_products);
		$this->set("parent_product_map", $parent_products);

	#	error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());

		$this->track("cart", "display");

	}

	function admin_send_email($customer_id, $session_id = '')
	{
		$this->Customer->recursive = 1;
		$customer = $this->Customer->read(null, $customer_id);
		$customer_email = !empty($customer) ? $customer['Customer']['eMail_Address'] : null;
		$cart_items = $this->CartItem->findAll(" customer_id = '$customer_id' ");
		$last_visit = $this->TrackingRequest->find( "customer_id = '$customer_id' ", null, "tracking_request_id DESC");
		$all_products = $this->Product->findAll("available = 'yes' ");
		$all_products_map = Set::combine($all_products, '{n}.Product.code', '{n}');

		if(!empty($this->data) && $customer_email)
		{
			$msg = $this->data['message'];
			# Send email to customer...
			$this->sendEmail($customer_email, "Items in your cart", "cart_items", array('customer'=>$customer,'cart_items'=>$cart_items,'custom_message'=>$msg,'all_products'=>$all_products_map, 'last_visit'=>$last_visit));
			#$this->sendAdminEmail("Items in your cart", "cart_items", array('customer'=>$customer,'cart_items'=>$cart_items,'custom_message'=>$msg,'all_products'=>$all_products_map, 'last_visit'=>$last_visit));

		}

		if ($session_id)
		{
			$this->Session->setFlash("Email sent.");
			$this->redirect("/admin/tracking_requests/session/$session_id");
		} else {
			$this->redirect("/admin/tracking_requests");
		}
	}

	function admin_index() {
		$this->CartItem->recursive = 0;
		$this->set('cartItems', $this->paginate('CartItem'));
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CartItem.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('cartItem', $this->CartItem->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->CartItem->create();
			if ($this->CartItem->save($this->data)) {
				$this->Session->setFlash(__('The CartItem has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CartItem could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CartItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CartItem->save($this->data)) {
				$this->Session->setFlash(__('The CartItem has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CartItem could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CartItem->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CartItem', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CartItem->del($id)) {
			$this->Session->setFlash(__('CartItem deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


}
?>
