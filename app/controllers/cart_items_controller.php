<?

# Parent wrapper for various shared cart stuff...

class CartItemsController extends AppController
{
	#var $uses = array("Product", "ProductPricing", "ProductPart", "GalleryImage", "CustomImage", "CustomizationOption", "ProductRecommendedQuote", "ImageRecommendedQuote","Quote","Tassel","Charm","Border","Ribbon","Frame","ContactInfo","ShippingPricePoint","CartItem","CreditCard",'Country','ShippingMethod');
	# $uses is ignored here, either used in appcontroller or child controller

	function clear_build()
	{
		$this->build = array();
		$this->Session->write("Build", $this->build);
	}

	function clear_cart()
	{
		#$this->Session->write("shoppingCart", array());
		$customer_id = $this->get_customer_id();
		$session_id = $this->get_session_id();

		$this->CartItem->deleteAll("customer_id = '$customer_id' OR session_id = '$session_id'");

		$this->Session->delete("rush");
		$this->Session->delete("rush_cost");
		$this->Session->delete("rush_date");
	}


	function get_cart_items($cart_item_id = null)
	{
		$db_cart_items = $this->get_cart($cart_item_id);
		list ($shoppingCart, $subtotal, $product_list, $eligible_subtotal) = $this->load_cart_data($db_cart_items);

		list($ship_by_start, $ship_by_end, $rush_ship_by_start, $rush_ship_by_end) = $this->Product->get_shipment_times($product_list);
		if(!empty($rush_ship_by_start))
		{
			$this->set("rush_ships_by_start", date("D M j", $rush_ship_by_start));
		}
		$this->set("ships_by_start", date("D M j", $ship_by_start));
		$this->set("ships_by_end", date("D M j", $ship_by_end));

		$ships_by_time = $this->Product->get_shipment_time($product_list);
		$ships_by = date("D M j", $ships_by_time);

		$this->set("ships_by_time", $ships_by_time);
		$this->set("ships_by", $ships_by);

		$country = "";
		$is_po_pox = false;

		$shipping_id = $this->Session->read("shipping_id");
		#echo "SID=$shipping_id";

		$is_po_box = false;
		$country = 'US';
		$zipCode = null;
		$sessionZip = $this->Session->read("zipCode");
		$sessionCountry = $this->Session->read("country");
		if(!empty($sessionZip)) # Always use if there. Once they set address on checkout, will updated session vars.
		{
			$country = $sessionCountry;
			$zipCode = $sessionZip;
		} else if ($shipping_id) {
			$shippingAddress = $this->ContactInfo->read(null, $shipping_id);
			if(!empty($shippingAddress['ContactInfo']['Zip_Code']))
			{
				$country = $shippingAddress['ContactInfo']['Country'];
				$zipCode = $shippingAddress['ContactInfo']['Zip_Code'];
				$is_po_box = !empty($shippingAddress['ContactInfo']['is_po_box']) ? $shippingAddress['ContactInfo']['is_po_box'] : false;
				#echo "SHIP=$zipCode";
			}
		}

		$this->set("eligible_subtotal", $eligible_subtotal);
		$this->set("subtotal", $subtotal);

		$rush_cost = $this->Session->read("rush_cost");

		$grandTotal = 0;
		$shippingTotal = 0;

		$shipping_method_id = $this->Session->read("shipping_method_id");

		$countries = $this->Country->findAll(" can_order = 'Yes' ", null, 'name ASC');
		$countries_list = Set::combine($countries, '{n}.Country.iso_code', '{n}.Country.name');
		$this->set("countries_map", $countries_list);
		$this->set("zipCode", $zipCode);
		$this->set("country", $country);

		$customer = $this->get_customer();

		$availableShippingOptions = array();

		if ($zipCode)
		{
			$availableShippingOptions = $this->ShippingPricePoint->calculate_shipping_options_list(array($zipCode, $country), $product_list, $subtotal, !empty($customer['is_wholesale']));
			if(empty($availableShippingOptions)) { 
				return array($shoppingCart, $subtotal, $product_list, null,null);
			}
			if(empty($shipping_method_id)) # JUST starting out, no shipping method set. Assume slowest.
			{
				$ixs = array_keys($availableShippingOptions);
				$shipping_method_id = $availableShippingOptions[$ixs[0]]['shippingMethod']['shippingMethodID'];
			}
			# Should AUTOMATICALLY get just the cheapest for each day.

			#print_r($shippingOptions);

			# Get days for all shipping methods since we may be changing carriers when changing zip codes (don't want to lose speed)
			$allShippingMethods = $this->ShippingMethod->findAll();
			$shippingMethodDays = Set::combine($allShippingMethods, '{n}.ShippingMethod.shippingMethodID', '{n}.ShippingMethod.dayMax');
			#error_log("SMEDAYS=".print_r($shippingMethodDays,true));


			$found_shipping_method = false;
			foreach($availableShippingOptions as $shippingOption)
			{
				$smid = $shippingOption['shippingMethod']['shippingMethodID'];
				$name = $shippingOption['shippingMethod']['name'];
				$dayMax = $shippingOption['shippingMethod']['dayMax'];
				#error_log("NAME=$name = $smid");
				#error_log("AVAIL+SMID=$smid, CURRENT_SET=$shipping_method_id");
				if($shipping_method_id == $smid || (!empty($shippingMethodDays[$shipping_method_id]) && $dayMax == $shippingMethodDays[$shipping_method_id]))
				{
					$this->Session->write("shipping_method_id", $smid);
					$found_shipping_method = true;
					$shippingTotal = $shippingOption[0]['cost'];
					$this->set("shippingTotal", $shippingTotal);
					$this->set("shippingOption", $shippingOption);

					if(!empty($shippingOption[0]['original_cost']))
					{
						$this->set("shippingTotalOrig", $shippingOption[0]['original_cost']);
					}

					$grandTotal = $subtotal + $shippingOption[0]['cost'] + $rush_cost;
					$this->set("grandTotal", $grandTotal);
				}
			}
			if(empty($found_shipping_method) &&!empty($availableShippingOptions)) # Lost because change in address.
			# Need to pick first one in list.
			{
				$ixs = array_keys($availableShippingOptions);
				$shippingOption = $availableShippingOptions[$ixs[0]];
				$smid = $shippingOption['shippingMethod']['shippingMethodID'];
				$this->Session->write("shipping_method_id", $smid);
				$shippingTotal = $shippingOption[0]['cost'];
				$this->set("shippingTotal", $shippingTotal);
				$this->set("shippingOption", $shippingOption);

				if(!empty($shippingOption[0]['original_cost']))
				{
					$this->set("shippingTotalOrig", $shippingOption[0]['original_cost']);
				}

				$grandTotal = $subtotal + $shippingOption[0]['cost'] + $rush_cost;
				$this->set("grandTotal", $grandTotal);
			}

			#echo "ASO=".print_r($availableShippingOptions,true);

			$this->set("shippingOptions", $availableShippingOptions);

			list($rush_dates, $fastestShippingMethodID) = $this->Product->get_rush_dates($availableShippingOptions, $product_list, $db_cart_items);
			$this->set("rush_shipping_method_id", $fastestShippingMethodID);
			# date=>cost

			$this->set("rush_dates", $rush_dates);

			$rush_date = $this->Session->read("rush_date");

			if(!empty($rush_date) && empty($rush_dates[$rush_date])) # Not available any more, ie qty changed.
			{
				if(empty($rush_dates)) # None available any more.
				{
					$this->Session->write("rush_cost", null);
					$this->Session->write("rush_date", null);
					$rush_date = null;
				} else { # Set to nearest rush date.
					$nearest = null;
					$rds = strtotime($rush_date);
					$dates = array_keys($rush_dates);
					foreach($dates as $date)
					{
						$ds = strtotime($date);
						if(empty($nearest) || (abs($rds-$ds) > abs($rds-$nearest)))
						{
							$nearest = $ds;
						}
					}
					$rush_date = date("Y-m-d", $nearest);
					$rush_cost = $rush_dates[$rush_date];
					$this->Session->write("rush_cost", $rush_cost);
					$this->Session->write("rush_date", $rush_date);
				}
			}
			$this->set("rush_date", $rush_date);
			$this->set("rush_cost", $this->Session->read("rush_cost"));

			# If it's a bigger order, we MAY have another day as an option.
			# Loop from fastest normal day to fastest rush day.

			# Get soonest day

		}

		$smid = $this->Session->read("shipping_method_id");
		# FORCE defaultShippingMethod to be in list of options.... otherwise no options will show up....

		if (!empty($availableShippingOptions)) # May not have if no zip code yet!
		{
			foreach($availableShippingOptions as $shippingOption)
			{
				if ($smid == $shippingOption['shippingMethod']['shippingMethodID'])
				{
					#print_r($shippingOption);
					$delivery_days = $dayMax = $shippingOption['shippingMethod']['dayMax'];
					$dayMin = $shippingOption['shippingMethod']['dayMin'];
					$hour_of_day = date("H", time());
					$delivery_time = $ships_by_time;

					while($delivery_days > 0)
                                        {
                                                        $delivery_time += 24*60*60;
                                                        $delivery_day = date("D", $delivery_time);
                                                        if ($delivery_day != "Sun" && $delivery_day != "Sat") { $delivery_days--; }
                                        }

					if(!empty($rush_date))
					{
						$this->set("delivery_end", date("D M j", strtotime($rush_date)));
					} else {
						$this->set("delivery_end", date("D M j", $delivery_time));
					}
					$this->set("shippingOption", $shippingOption);
				}
			}
		}
		$this->set("defaultShippingMethod", $smid);

		########################################################



		#
		#
		#
		#
		####################################################################
		$discount = $this->checkCouponDiscount($subtotal, $availableShippingOptions);

		#error_log("D111=$discount");

		return array($shoppingCart, $subtotal, $product_list, $eligible_subtotal, $discount);
	}

	function checkCouponDiscount($subtotal = null, $shippingOptions = array())
	{
		if(empty($subtotal)) { return 0; } # Unknown.

		$coupon_code = $this->Session->read("coupon");
		if(!$coupon_code) { return 0; }

		# LOGIC FOR COUPONS.....
		$coupon = $this->Coupon->findByCode($coupon_code);

		if(empty($coupon) || empty($coupon['Coupon']['active']))
		{
			$theMessage = 'The coupon code is not active.';
			$this->set("invalid_coupon", $theMessage);
			return 0;
		}

		if(!empty($coupon['Coupon']['minimum']) && $subtotal < $coupon['Coupon']['minimum'])
		{
			$theMessage = 'To use this Promo Code, you need to spend $' . $coupon['Coupon']['minimum'] . ' or more.';
			$this->set("invalid_coupon", $theMessage);
			return 0;
		}

		if(!empty($coupon['Coupon']['wholesale_only']) && !$this->Session->read("Auth.Customer.is_wholesale"))
		{
			# Dont apply to retail folk
			return 0;
		}

		# Check expiration/validity of coupon dates....
		$start = !empty($coupon['Coupon']['start']) ? $coupon['Coupon']['start'] : null;
		$end = !empty($coupon['Coupon']['end']) ? $coupon['Coupon']['end'] : null;

		if($start && strtotime($start) > time())
		{
			$this->set("invalid_coupon", true);
			return 0;
		}

		if($end && strtotime($end) < time())
		{
			$this->set("invalid_coupon", true);
			return 0;
		}


		########################################
		# Make sure one-time use isn't used a second time....
		if(empty($coupon['Coupon']['multiple_use']))
		{
			$cond["Purchase.session_id"] = session_id();
			$cid = $this->get_customer_id();
			if(!empty($cid)) 
			{
				$cond['Purchase.customer_id'] = $cid;
			}
			$count = $this->Purchase->findCount(array('coupon'=>$coupon_code, array('OR'=>$cond)));

			if($count) # Used single use before...
			{
				$this->set("invalid_coupon", "Sorry, you've already used this coupon.");
				$this->Session->delete("coupon");
				return 0;
			}

		}
		####################################
		# Check for applicable days of week....
		if(!empty($coupon['Coupon']['day_of_week']))
		{
			if(strtolower($coupon['Coupon']['day_of_week']) != strtolower(date("l")))
			{
				return 0;
			}

		}





		#######################################
		
		$discount = 0;

		$groundShipping = array_shift(array_values($shippingOptions)); # First in list.

		if(!empty($coupon['Coupon']['percent']))
		{
			$discount = $subtotal*$coupon['Coupon']['percent']/100;
		} else if (!empty($coupon['Coupon']['amount'])) { 
			$discount = $coupon['Coupon']['amount'];
		} else if (!empty($coupon['Coupon']['free_shipping'])) { 
			error_log(print_r($groundShipping,true));

			$discount = $groundShipping[0]['cost'];

		}
		# subtotal doesnt include shipping, etc. so we cant be sure
		if($discount > $subtotal) { $discount = $subtotal; } # <= 100%

		#$discount = 100;

		return $discount;
	}

	function admin_index() {
		$this->CartItem->recursive = 0;
		$this->set('cartItems', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CartItem.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('cartItem', $this->CartItem->read(null, $id));
	}

	function admin_add() {
		$this->setAction("admin_edit");
	}

	function admin_upload($customer_id) # Uploading image.
	{
		if($this->action == 'admin_upload') # Called directly.
		{
			$this->layout = 'ajax';
			Configure::write("debug", 0);
		}
		if(!empty($this->data))
		{
			$custom_image_id = null;
			if(!empty($this->data['CustomImage']['file']))
			{
				$custom_image_id = $this->save_custom_image('CustomImage.file', $customer_id);

				error_log("UPLOADING.... for $customer_id, IMID=$custom_image_id");
			} else {
				error_log("NOT UPLOADING");

			}

			if($custom_image_id !== null)
			{
				if(!empty($custom_image_id)) # Success
				{
					$this->data['options']['customImageID'] = $custom_image_id;

				} else { # FAIL! already warned.
					return;
				}
			}
		}

		if(!empty($customer_id))
		{
			$this->CustomImage->virtualFields['title'] = "CONCAT(CustomImage.Image_ID, ' - ', CustomImage.Title)";
			$this->set("custom_images", $this->CustomImage->find('list', array('fields'=>array('Image_ID','title'), 'order'=>'Image_ID','conditions'=>array('Customer_ID'=>$customer_id))));
		}
	}

	function admin_edit($id = null)
	{
		error_log("D=".print_r($this->data,true));

		if(!empty($id)) { $this->CartItem->id = $id; }
		if (!empty($this->data)) {
			$cid = $this->data['CartItem']['customer_id'];

			if(!empty($this->data['template']) && $this->data['template'] == 'imageonly_nopersonalization')
			{
				$this->data['template'] = 'imageonly';
				$this->data['options']['personalizationNone'] = 1;
			}


			if(!empty($this->data['options']['quantity_size']))
			{
				$this->data['options']['size'] = $this->data['options']['quantity_size'];
			}

			$this->data['CartItem']['parts'] = serialize($this->data['options']);
			error_log("PARTS=".print_r($this->data['CartItem'],true));

			if ($this->CartItem->saveAll($this->data)) {
				$this->Session->setFlash(__('The item has been added to the customer cart', true));
				$this->redirect(array('controller'=>'account','action'=>'view', $this->data['CartItem']['customer_id']));
			} else {
				$this->Session->setFlash(__('The CartItem could not be saved. Please, try again.', true));
			}
		}
		#
		if(!empty($this->params['named']))
		{
			foreach($this->params['named'] as $k=>$v)
			{
				list($m,$k) = pluginSplit($k);
				if(empty($m)) { $m = 'CartItem'; }
				$this->data[$m][$k] = $v;
			}
		}

		$this->Customer->virtualFields["Name"] = "CONCAT(Customer.Last_Name, ', ', Customer.First_Name, ' (', Customer.eMail_Address, ')')";
		$customers = $this->Customer->find('list', array('order'=>'Last_Name, First_Name, eMail_Address', 'conditions'=>array('eMail_Address != ""'), 'fields'=>array('customer_id',"Name")));
		$this->set("customers", $customers);

		if(!empty($id))
		{
			$this->data = $this->CartItem->read(null, $id);
			$this->data['options'] = unserialize($this->data['CartItem']['parts']);
			error_log("LOADED PARTS=".print_r($this->data,true));
			#print_r($this->data);
			$this->parts($this->data['CartItem']['productCode']);
			if(!empty($this->data['options']['personalizationNone']))
			{
				$this->data['template'] = 'imageonly_nopersonalization'; # Get dropdown fixed.
			}
		}

		$customer_id = null;
		if(!empty($this->data['CartItem']['customer_id']))
		{
			$this->set("customer", $this->Customer->read(null, $this->data['CartItem']['customer_id']));
			$customer_id = $this->data['CartItem']['customer_id'];
		}

		$this->set("products", $this->Product->find('list', array('conditions'=>array('available'=>'yes','is_stock_item'=>0),'order'=>'is_stock_item, pricing_name','fields'=>array('code','pricing_name'))));
		$this->set("product_minimums", $this->Product->find('list', array('conditions'=>array('available'=>'yes'), 'order'=>'is_stock_item, pricing_name','fields'=>array('code','minimum'))));

		$this->GalleryImage->virtualFields['title'] = "CONCAT(GalleryImage.catalog_number, ' - ', GalleryImage.stamp_name)";
		$this->set("stamps", $this->GalleryImage->find('list', array('conditions'=>array('available'=>'yes'), 'order'=>'catalog_number','fields'=>array('catalog_number','title'))));

		$this->admin_upload($customer_id); # Get list of images.
	}

	function save_custom_image($field = 'CustomImage.file', $customer_id = null)
	{
		if(empty($customer_id)) { $customer_id = $this->Session->read("Auth.Customer.customer_id"); }

		$filename = null;
		if(!$this->Image->didSupplyUpload($field))
		{
			error_log("NO UPLOAD PROVIDED=".print_r($this->data['CustomImage']['file'],true));
			$size_limit = ini_get("upload_max_filesize");
			if (!$size_limit) { $size_limit = "5M"; }
			$this->Session->setFlash("We are unable to save your image. Please make sure you have provided your image and that it is $size_limit or less");
			return null; # DOH!
		} else {
			$this->Image->allowed = $this->Image->all_types;
			$path = "/images/custom/customers/$customer_id";
			$prefix = time().rand(0,10000);
			$return = $this->Image->saveUpload('CustomImage.file', $path, $prefix);
			if ($return && is_array($return))
			{
				$this->Session->setFlash("Sorry, we are unable to save your image: " .  join("<br/>\n", $return) );
				return false;
			}

			if (!$return) 
			{
				$this->Session->setFlash("Sorry, we are unable to save your image. Unknown error.");
				return;
			}
			$filename = $return;
		}
		# Now save db portion. Create thumbnails.
		$viewable_filename = $this->Image->viewable_filename($filename);

		####################
		# XXX TODO
		# We MAY change our mind  to make 'display' file full-sized....
		# Since we'd use that image for previews....

		# Now save smaller images.
		$display_width = 350;
		$thumb_height = 80;

		# FORCE PNG, so no odd black lines from jpeg scaling.
		$viewable_filename = preg_replace("/[.](\w+)$/", '.png', $viewable_filename);
		error_log("VP=$viewable_filename");

		error_log("SCALING $path/$filename => $path/display/$viewable_filename");

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
		####$this->data['CustomImage']['session_id'] = $this->Session->id();
		$this->data['CustomImage']['Customer_ID'] = $customer_id;
		$this->data['CustomImage']['Image_Path'] = $path; 
		$this->data['CustomImage']['Submission_Date'] = $this->unix_date();

		if(empty($this->data['CustomImage']['Title'])) { 
			list($fileprefix, $ext) = preg_split("/[.]/", $this->data['CustomImage']['file']['name']);
			$this->data['CustomImage']['Title'] = Inflector::humanize(Inflector::underscore(preg_replace("/[-]/", '_', $fileprefix)));
		}

		$this->data['CustomImage']['Image_Location'] = "$path/$filename"; # Could be gigantic here

		$this->data['CustomImage']['display_location'] = "$path/display/$viewable_filename"; # What we'll bother showing on browser for sanity.
		$this->data['CustomImage']['thumbnail_location'] = "$path/thumbs/$viewable_filename";

		$this->CustomImage->save($this->data);

		return $this->CustomImage->id; # return id.
	}

	function unit_price()
	{
		$response = array();

		if(!empty($this->data))
		{
			$productCode = $this->data['CartItem']['productCode'];
			$product = $this->Product->findByCode($productCode);
			$customer_id = $this->data['CartItem']['customer_id'];
			$catalogNumber = !empty($this->data['CartItem']['catalogNumber']) ? $this->data['CartItem']['catalogNumber'] : null;
			$customer = $this->Customer->read(null, $customer_id);

			# Assume not stamp, for now.
			$parts = null; # $this->data['options'];
			# For now, some parts may have extra charge???
			# (XXX may need to convert from cartItem to build parts)

			$stamp_surcharge = null; # TODO


			$quantity = $this->data['CartItem']['quantity'];
			$unitPrice = $this->Product->get_effective_base_price($productCode, $quantity, $customer['Customer'], $stamp_surcharge, $parts, $catalogNumber);
			$setupPrice = 0;

			#####
			# XXX TODO tshirt quantity_size
			if($productCode == 'TS' && !empty($this->data['options']['quantity_size']))
			{
				foreach($this->data['options']['quantity_size'] as $size => $qty)
				{
					if(!empty($product['Product']["surcharge_$size"]))
					{
						$setupPrice += $qty*$product['Product']["surcharge_$size"];
					}
				}
			}

			if(!empty($setupPrice))
			{
				$response['setupPrice'] = $setupPrice;
			}


			####

			$response['price'] = $unitPrice;

		}

		header("Content-Type: application/json");
		echo json_encode($response);
		exit(0);
	}

	function parts($code)
	{
		$this->set("prod", $code);
		$this->set_build_product($code);

		$parts = $this->load_product_options($code);
		$this->set("parts", $parts);

		# Loop thru each to generate dataset for each.
		foreach($parts as $part)
		{
			$step = $part['Part']['part_code'];
			$this->load_variables_step($step);
		}

	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CartItem', true));
			$this->redirect(array('action'=>'index'));
		}
		$cartItem = $this->CartItem->read(null, $id);
		if ($this->CartItem->del($id)) {
			$this->Session->setFlash(__('Cart Item deleted', true));
			if(!empty($cartItem['CartItem']['customer_id']))
			{
				$this->redirect(array('controller'=>'account','action'=>'view',$cartItem['CartItem']['customer_id'],'#CartItems'));
			} else {
				$this->redirect(array('action'=>'index'));

			}
		}
	}
}
?>
