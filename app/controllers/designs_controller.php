<?
/*
Lorem ipsum dolor sit amet, flada shada, walla bing pang.

King kong, wish wash, peter patter, lucy choosie. Oscar meyer dooter looter, wish upon a star.
*/
require_once "MIME/Type.php";
require_once "font_attributes.php";

class DesignsController extends AppController
{
	var $uses = array('CustomImage','CartItem','Quote','ProductQuote','GalleryCategory','OrderItem','Part','SavedItem');
	var $raster = false; # Whether drawing picture will be used for PNG, etc.

	# XXX MOVE OPTIONS INTO A SINGLE VAR - easier to add..
	var $textOptions = array(
		//'dropcapMarginRight' => 0.15,
		'lineHeight' => 1.15,
		'quotedMargin'=>0.35, # Percent.
		'quotedFont'=>"adobe-garamond-pro",
		'leftQuoteOffsetX'=>0.5,
		'leftQuoteOffsetY'=>0.1,
		'leftQuoteSize'=>1.5,
		'attributionMargin'=>1, # em
		'attributionSize'=>0.70,
		#'bufferFactor'=>0.0, # Tolerance near edge. relative to font size
		'rightEdging'=>5, # pixel tolerance.

		'dropcapFactor' => 2.65,#2.35,
		'dropcapDrop'=>0.8, # How much of a line to move down.
		'dropcapMarginRight'=>0.20,#0.05, # percent of font size
		'dropcapLineHeightFudge'=>0.85,
		'dropcapMarginRightFudge'=>0.5,
		#'dropcapMarginTop'=>-0.03, # neg means move up; only used on web, not in SVG
		'dropcapMarginTop'=>0.005, # neg means move up; only used on web, not in SVG

		'dropcapTextIndent'=>-0.15, # Indent of first line
		'dropcapTextIndentFudge'=>2.5,

		'rightShaveFudge'=>0, # PIXELS. Web browser renders fonts outside of bounding box if script, so we must compensate.
	);

	var $nsurl = array(
		"svg"=>"http://www.w3.org/2000/svg",
		"xlink"=>"http://www.w3.org/1999/xlink"
	);

	var $fontTweaks = array( 
		'tk-adobe-garamond-pro'=>array( # FF,IE,SVG
			#'dropcapMarginRight'=>0.25,
			'dropcapDrop'=>0.77,
			'dropcapLineHeightFudge'=>0.60,
			'dropcapMarginTop'=>0.04,
			'dropcapMarginRightFudge'=>0.40,
		),
		'tk-bickham-script-pro'=>array( # FF,IE,SVG
			'dropcapWidth'=>1.5, # em's
			'dropcapMarginRight'=>0.12,# could be negative for script fonts since so wide
			'dropcapMarginRightFudge'=>-0.65,
			'dropcapFactor'=>3.25,
			'dropcapDrop'=>0.65,
			#'dropcapTextIndent'=>-0.05, # Indent of first line
			'dropcapLineHeightFudge'=>0.93,
			#'rightShaveFudge'=>13.5, # 13 is not enough, 14 too much.
					# maybe pixels isn't a good idea?
			#'rightShaveFudge'=>0.45, # em's
			#'rightShaveFudge'=>0.42, # Good enough...
		),
		'tk-caliban-std'=>array( # FF,IE,SVG
			'dropcapFactor'=>3.5,
			'dropcapDrop'=>0.55,
			'dropcapMarginRight'=>0.15,
			#'dropcapMarginTop'=>0.003,
			'dropcapLineHeightFudge'=>0.73,
			'dropcapMarginRightFudge'=>0.45,#0.01,
			'dropcapMarginTop'=>-0.02, # neg means move up; only used on web, not in SVG
		),
		'tk-cooper-black-std'=>array( # FF,IE,SVG
			#'dropcapMarginRight'=>0.25,
			'dropcapLineHeightFudge'=>0.8,
			'dropcapMarginRightFudge'=>0.25,
		),
		'tk-hypatia-sans-pro'=>array( # FF,IE,SVG
			#'dropcapMarginRight'=>0.25,#0.05, # percent of font size
			'dropcapLineHeightFudge'=>0.75,
			'dropcapMarginRightFudge'=>0.35,
			'dropcapFactor'=>2.50,
			'dropcapDrop'=>0.85,
			'dropcapMarginTop'=>0.02,
		),
		'tk-leander-script-pro'=>array( # FF,IE,SVG
			'dropcapMarginRight'=>0.10,
			'dropcapMarginRightFudge'=>1.2,
			'dropcapFactor'=>1.75,
			'dropcapDrop'=>1.05,
			'rightShaveFudge'=>0.3, # Good enough... in EM's
			'dropcapMarginTop'=>0.07,
		),
		'tk-poetica-std'=>array( # FF,IE,SVG
			'dropcapFactor'=>3.00,
			'dropcapDrop'=>0.62,
			'dropcapMarginRight'=>0.15,
			'dropcapMarginRightFudge'=>0.35,
			'dropcapLineHeightFudge'=>0.55,
			'dropcapMarginTop'=>0.03,
		),
		'tk-sanvito-pro'=>array( # FF,IE,SVG
			'dropcapFactor'=>3.0,
			'dropcapDrop'=>0.7,
			#'dropcapMarginRight'=>0.25,
			'dropcapLineHeightFudge'=>0.7,
			'dropcapMarginRightFudge'=>0.30,
			'dropcapMarginTop'=>0.015,
		),
	);

	var $fontFiles = array( # font WOFF file to name.
		'bickham.woff'=>'Bickham-Script-Pro-Regular',
		'caslon.woff'=>'Adobe-Caslon-Pro-Regular',
		'caliban.woff'=>'Caliban-Std-Regular',//'Caliban-Std-Regular',
		'garamond.woff'=>'Adobe-Garamond-Pro-Regular',
		'century.woff'=>'Century-Old-Style-Std-Regular',
		'cooper.woff'=>'Cooper-Std-Black-Regular',
		'hypatia.woff'=>'Hypatia-Sans-Pro-Regular',
		'leander.woff'=>'Leander-Script-Pro-Regular',
		'nueva.woff'=>'Nueva-Std-Regular',
		'penna.woff'=>'Penna-Connected-Regular',
		'poetica.woff'=>'Poetica-Std-Regular', 
		'sanvito.woff'=>'Sanvito-Pro-Regular',
		'warnock.woff'=>'Warnock-Pro-Regular',
		#'voluta.woff'=>'Voluta-Script-Pro-Regular'
	);

	var $fontFamilies = array( # Needed for SVG/CSS identification. And Form Dropdowns
		#'tk-adobe-caslon-pro'=>'Adobe Caslon Pro',
		'tk-adobe-garamond-pro'=>'Adobe Garamond Pro',
		'tk-bickham-script-pro'=>'Bickham Script Pro Regular',
		'tk-caliban-std'=>'Caliban Std',//'Caliban-Std-Regular',
		#'tk-century-old-style-std'=>'Century Old Style Std',
		'tk-cooper-black-std'=>'Cooper Std Black',
		'tk-hypatia-sans-pro'=>'Hypatia Sans Pro',
		'tk-leander-script-pro'=>'Leander Script Pro',
		#'tk-nueva-std'=>'Nueva Std',
		#'tk-penna-connected'=>'Penna Connected',
		'tk-poetica-std'=>'Poetica Std', 
		'tk-sanvito-pro'=>'Sanvito Pro',
		#'tk-warnock-pro'=>'Warnock Pro',
		#'tk-voluta-script-pro'=>'Voluta Script Pro'
	);
	# Add/remove above to change form dropdowns.

	var $fontTTF = array( # Needed for SVG/CSS identification.
		'tk-adobe-caslon-pro'=>'caslon.otf',
		'tk-bickham-script-pro'=>'bickham.otf',
		'tk-caliban-std'=>'caliban.otf',
		'tk-adobe-garamond-pro'=>'garamond.otf',
		'tk-century-old-style-std'=>'century.otf',
		'tk-cooper-black-std'=>'cooper.otf',
		'tk-hypatia-sans-pro'=>'hypatia.otf',
		'tk-leander-script-pro'=>'leander.otf',
		'tk-nueva-std'=>'nueva.otf',
		'tk-penna-connected'=>'penna.otf',
		'tk-poetica-std'=>'poetica.otf',
		'tk-sanvito-pro'=>'sanvito.otf',
		'tk-warnock-pro'=>'warnock.otf',
	);

	var $fontNames = array( # Font class to system (imagemagick) name.
		'tk-adobe-caslon-pro'=>'Adobe-Caslon-Pro-Regular',
		'tk-bickham-script-pro'=>'Bickham-Script-Pro',
		'tk-caliban-std'=>'Caliban-Std-Regular',//'Caliban-Std-Regular',
		'tk-adobe-garamond-pro'=>'Adobe-Garamond-Pro-Regular',
		'tk-century-old-style-std'=>'Century-Old-Style-Std-Regular',
		'tk-cooper-black-std'=>'Cooper-Std-Black-Regular',
		'tk-hypatia-sans-pro'=>'Hypatia-Sans-Pro-Regular',
		'tk-leander-script-pro'=>'Leander-Script-Pro-Regular',
		'tk-nueva-std'=>'Nueva-Std-Regular',
		'tk-penna-connected'=>'Penna-Connected',
		'tk-poetica-std'=>'Poetica-Std-Regular', 
		'tk-sanvito-pro'=>'Sanvito-Pro-Regular',
		'tk-warnock-pro'=>'Warnock-Pro-Regular',
		'tk-voluta-script-pro'=>'Voluta-Script-Pro-Regular'
	);

	var $orderDesignMap = array(
	);

	var $orderItemDesignSideMap = array( # What we need for DESIGN...
		# item_part field => design field
		'imageID'=>'customImageID',
		'custom_quote'=>'quote',
		'backgroundColor'=>'background_color',
		#'personalizationColor'=>'personalizationColor',
		# XXX load quote and attribution (older orders)
	);
	var $cartItemPartFields = array(
		'tasselID'=>'tassel_id',
		'charmID'=>'charm_id',
		'borderID'=>'border_id',
		'tasselID'=>'tassel_id',
		'quoteID'=>'quote_id',
		'customQuote'=>'quote',
		'personalizationInput'=>'personalization',
		'backgroundColor'=>'background_color'
	);

	var $fontFactors = array(
		'Large'=>1.6,
		'Medium'=>1,
		'Small'=>0.8
	);

	var $filename = "Design.svg";
	var $design = null;

	var $restrictedActions = array('save_design'); # Require account/login for these

	function beforeFilter()
	{
		parent::beforeFilter();
		$this->disableCache();
	}

	function index()
	{
		$this->redirect(array('action'=>'add'));
	}

	function edit($cart_item_id)
	{
		# load cart item info.
		$design = $this->load_cart_design($cart_item_id);
		$this->Session->write("Design", $design);

		$this->setAction('add');

		#$this->action = 'add'; # Keep side param...

		#$this->redirect(array('action'=>'add'));
	}

	function tips($step)
	{
		$part = $this->Part->findByPartCode($step);
		$this->set("part", $part);
	}

	function load_saved_design($id)
	{
		$saved = $this->SavedItem->read(null, $id);
		$design = unserialize($saved['SavedItem']['build_data']);

		# Re-load product. pricing/features/etc may have changed...
		$product = $this->Product->findByCode($design['Design']['productCode']);
		$design['Product'] = $product['Product'];

		return $design;
	}

	function saved_edit($id)
	{
		# Re-load a saved item...
		$design = $this->load_saved_design($id);
		$this->Session->write("Design", $design);

		$this->setAction('add');
	}

	function save_later()
	{
		$this->Session->setFlash("To save your design for later, please sign in or create an account below",'info');
		$this->redirect(array('action'=>'save_design'));
	}

	function save_design() # Account required...
	{
		$design = $this->Session->read("Design");
		$product = $design['Product'];
		unset($design['Product']); # Not needed. Prices may change, etc.
		#unset($design['CustomImage']); # Not needed. Pics may move around...

		$savedItem = array(
			'new_build'=>true,
			'customer_id'=>$this->get_customer_id(),
			'name'=>$product['name'],
			'build_data'=>serialize($design),
		);

		$this->SavedItem->create();
		$this->SavedItem->save(array('SavedItem'=>$savedItem));

		$vars = array('savedItem'=>$this->SavedItem->read());
		$this->sendAdminEmail("A design has been saved", "admin_saved_item", $vars);

		$this->Session->setFlash("Your design has been saved for later. You'll be able to continue with your saved items by going to your <a href='/account'>My Account</a> page.");

		$this->redirect(array('action'=>'add'));#"/saved_items");
		# Go back.
	}

	function debug()
	{
		$this->Session->write("debug", true);
		$this->redirect(array('action'=>'add'));
	}

	function orient($code, $orient = null)
	{
		$code = $this->productCode($code); 
		# If vertical uses parent product then horizontal must also...

		# Ignore orientation if file doesn't exist.
		if($orient == 'horizontal' && file_exists(APP."/webroot/images/designs/products/horizontal/$code.svg"))
		{
			return $orient;
		}
		return null;
	}

	function cart() # Adds to cart.
	{

		if(!empty($this->data))
		{
			$parts = array_merge($this->data['Design'], !empty($this->data['DesignSide']['1']) ? $this->data['DesignSide']['1'] : array()); #this->load_build_parts();
			# Side 2 never has own add-on (ie physical) costs.... (for now)

			$code = $this->data['Design']['productCode'];
			$quantity = $this->data['Design']['quantity'];
			$orient = $this->orient($code, !empty($this->data['Design']['orientation']) ? $this->data['Design']['orientation'] : null);
			$setup = !empty($this->data['Design']['setupPrice']) ? $this->data['Design']['setupPrice'] : 0; # May need to add product setup, if any.
			$pricing = $this->Product->get_effective_base_price($code, $quantity, $this->Session->read("Auth.Customer"), null, $parts, null); # NO STAMP SUPPORT RIGHT NOW.

			$unitPrice = $pricing['total'];

			$side1 = !empty($this->data['DesignSide']['1']) ? ($this->data['DesignSide']['1']) : null;
			$side2 = !empty($this->data['DesignSide']['2']) ? ($this->data['DesignSide']['2']) : null;
			$sides = array();
			if(!empty($side1)) { $sides[] = $side1; }
			if(!empty($side2)) { $sides[] = $side2; }

			# Map field names.
			$partsMap = array(
				'tassel_id'=>'tasselID',
				'charm_id'=>'charmID',
				'quote_id'=>'quoteID',
				'border_id'=>'borderID',
				'ribbon_id'=>'ribbonID',
				'background_color'=>'backgroundColor',
				'quote'=>'customQuote',
				'personalization'=>'personalizationInput',
				'personalizationColor'=>'personalizationColor',
			);
			$colorKeys = array(
				'backgroundColor',
				'personalizationColor',
				'quote_color',
			);

			# Now fix side parts for compatability.
			foreach($sides as &$side)
			{
				# Fix dropcap/center text.
				$side['centerQuote'] = (!empty($side['quote_style']) && $side['quote_style'] != 'dropcap') ? 1 : 0;

				foreach($partsMap as $newKey=>$oldKey)
				{
					if(isset($side[$newKey]))
					{
						$side[$oldKey] = $side[$newKey];
					}
					if(in_array($oldKey, $colorKeys) && preg_match("/^#(.)(.)(.)$/", $side[$oldKey], $matches))
					{
						# Make sure it's 6 digit hex.
						$side[$oldKey] = "#".$matches[1].$matches[1].
							$matches[2].$matches[2].
							$matches[3].$matches[3];
					}
				}
			}
			/*
			header("Content-Type: text/plain");
			print_r($sides);
			exit(0);
			*/

			$cartItem = array(
				'session_id'=>session_id(),
				'customer_id' => $this->Auth->user("customer_id"),
				'quantity'=>$quantity,
				'productCode'=>$code,
				'setupPrice'=>$setup,
				'unitPrice'=>$unitPrice,
				'orientation'=>$orient,
				'comments'=>(!empty($this->data['Design']['comments']) ? 
					$this->data['Design']['comments'] : null),
				'parts'=>serialize($sides[0]), # Make sure to reference altered data....
				'parts2'=>!empty($sides[1]) ? serialize($sides[1]) : null,
				'proof'=>!empty($this->data['Design']['proof']) ? $this->data['Design']['proof'] : 'no',
				'new_build'=>1
			);
			#########################
			/*
			header("Content-Type: text/plain");
			print_r($cartItem);
			echo "\n---------------------\n";
			print_r($this->data);
			exit(0);
			*/

			#$this->Session->delete("Design");
			# XXX ADD LATER...
			if(!empty($this->data['Design']['cart_item_id']))
			{
				$this->CartItem->id = $this->data['Design']['cart_item_id'];
			} else {
				$this->CartItem->create();
			}
			$this->CartItem->save(array('CartItem'=>$cartItem));
			
			// save raw data in session vars for debugging purposes.
			$testCartItem = json_encode($cartItem);
			$this->Session->write("testCartItem",$testCartItem);
			$testCartParts = json_encode($sides[0]); // Jack Albright test data
			$this->Session->write("parts_side_1",$testCartParts);// Jack Albright test data
			$testCartParts = json_encode($sides[1]); // Jack Albright test data
			$this->Session->write("parts_side_2",$testCartParts);// Jack Albright test data
			# Now remove from session.
			#$this->Session->delete("Design");

			# Update session with cart_item_id... so back button will update (not duplicate)
			error_log("CID=".$this->CartItem->id);
			$this->Session->write("Design.Design.cart_item_id", $this->CartItem->id);

			$this->redirect("/cart/display.php"); # Go to cart.
		} else {
			$this->redirect(array('action'=>'add'));
		}
	}

	function price_chart()
	{

		$this->savedata(); # Update data.

		$code = $this->Session->read("Design.Product.code"); # Load product AFTER saved, could be changing.

		$pricing = array();
		$pricing['price_list'] = $this->get_effective_base_price_list($code, false);
		$pricing['Product'] = $this->Session->read("Design.Product");
		$this->set("pricing", $pricing); # Save for chart.

		return $pricing;
	}

	function pricing()
	{
		$catalog_number = false;

		$real_stamp = false;#$this->real_only_product || $real_only_stamp || (!empty($this->build['options']['reproductionStamp']) && strtolower($this->build['options']['reproductionStamp']) == 'no');
		$stamp_surcharge = $catalog_number ? $this->GalleryImage->find("GalleryImage.catalog_number = '$catalog_number'") : null;

		$product_type_id = $this->Session->read("Design.Product.product_type_id");

		$this->ProductPart->recursive = 2;
		$options = $this->ProductPart->findAllByProductTypeId($product_type_id);
		$this->set("options", $options);
		$option_list = Set::extract("/Part/part_code", $options);
		$optionsByCode = Set::combine($options, "{n}.Part.part_code", "{n}");
		$this->set("optionsByCode", $optionsByCode);
		$this->set("option_list", $option_list);
		#error_log("OPTIONz=".print_r($options,true));
		#error_log("OPTION_LIST=".print_r($option_list,true));

		#############################

		##################
		$build = $this->Session->read("Design");
		$prod = $code = !empty($this->data['Design']['productCode']) ? $this->data['Design']['productCode'] : $this->Session->read("Design.Product.code");

		$pricing = $this->price_chart($code);

		# Save quantity_price_list, retail_price_list onto Session->Design
		# also need 'next_tier' var set

		#error_log("QTY=".print_r($build['Design']['quantity'],true));




		$this->Product->recursive = 2;
		$product = $this->Product->find(array('code'=>$code)); 

		// Posted into form.
		$quantity = !empty($this->data['Design']['quantity']) ? $this->data['Design']['quantity'] : $this->Session->read("Design.Design.quantity");

		if(empty($quantity))
		{
			$quantity = $product['Product']['minimum']; # DEFAULT
			#return; # irrelevent.
		}

		#error_log("OK_QTY=$quantity");

		# Odd bug fix...
		if(is_array($quantity))
		{
			$quantity = $quantity[0];
		}

		$minimum = $this->Session->read("Design.Product.minimum");
		if(!$quantity || $quantity < $minimum)
		{
			#error_log("BAD/LOW QTY");
			$this->set("pricing", $pricing); # Save for chart.
			return;
			#$quantity = $minimum;
		}

		$this->Session->write("Design.Design.quantity", $quantity);

		$product_type_id = $product['Product']['product_type_id'];

		#error_log("CONTINUING");


		$parts = array_merge($build['Design'], !empty($build['DesignSide']['1']) ? $build['DesignSide']['1'] : array()); #this->load_build_parts();
		# Side 2 never has added-cost parts.....
		# need to take general parts, + side 1 parts
		#
		$price_list = $this->Product->get_effective_base_price($code, $quantity, $this->Session->read("Auth.Customer"), $real_stamp?$stamp_surcharge:null, $parts, $catalog_number);
		$pricing['quantity_price_list'] = $price_list;
		#error_log("QPL=".print_r($pricing['quantity_price_list'],true));
		$pricing['retail_price_list'] = $this->Product->get_effective_base_price($code, $minimum, null, $real_stamp?$stamp_surcharge:null, $parts, $catalog_number);
		$price = $price_list['total'];
		$pricing['quantity_price'] = $price;

		# Get pricing details.


		$next_tier = "";

		$i = 0;
		foreach($product['ProductPricing'] as $price)
		{
			if ($price['quantity'] > $quantity && $i+1 < count($product['ProductPricing']))
			{
				$next_tier = $price['quantity'];
				break;
			}
			$i++;
		}
		$this->set('next_tier', $next_tier);

		$pricing['quantity'] = $quantity;

		$this->set("sides", $this->Session->read("Design.Design.sides"));

		$this->set('pricing', $pricing);

		# Now try to get SHIPPING info....
		$zipCode = $this->Session->read("Design.zip_code");
		$country = 'US'; # Assume.
		$product_list = array($code=>$quantity);
		#error_log("T=".$pricing['quantity_price_list']['total']);
		#error_log("Q=".print_r($quantity,true));
		$subtotal = $quantity * $pricing['quantity_price_list']['total'];
		# XXX

		$customer = $this->Auth->user();
		$wholesale = !empty($customer['is_wholesale']) || Configure::read("wholesale_site");

		# Not sure if needed.
		if(!empty($product['Product']['setup_charge']))
		{
			$subtotal += $product['Product']['setup_charge'];
		}

		#error_log("ZIP=$zipCode");

		if(!empty($zipCode))
		{
			list($ship_by_start, $ship_by_end, $rush_ship_by_start, $rush_ship_by_end) = $this->Product->get_shipment_times($product_list);

			$shippingOptions = $this->ShippingPricePoint->calculate_shipping_options_list(array($zipCode, $country), $product_list, $subtotal, $wholesale);

		#error_log("Subt=$subtotal, SHIPOPT=".print_r($shippingOptions,true));

			$this->set('ships_by_start', date("D m j", $ship_by_start));
			$this->set('ships_by_end', date("D m j", $ship_by_end));
			$this->set('shippingOptions', $shippingOptions);

		}

		#error_log("DONE PRICING");
	}

	function add($prod = null)
	{

		$qs = $this->params['url']; 
		unset($qs['url']); unset($qs['ext']);
		if(!empty($this->params['url']['start_over']))
		{
			# Keep product.
			$p = $this->Session->read("Design.Design.productCode");
			$this->Session->delete("Design");
			$this->Session->write("Design.Design.productCode", $p);
			# Redirect to self, w/params minus start_over....
			# So when we 'go back' from cart, we dont erase!
			unset($qs['start_over']); 
		}

		if(!empty($prod)) # Hide from url in case we refresh page after switching product variant.
		{
			$this->Session->write("Design.Design.productCode", $prod);
		}

		# Put here after so we properly designate product.

		if(!empty($this->params['url']['start_over']) || !empty($prod))
		{
			$this->redirect("/designs/add?".http_build_query($qs));
		}

		if(!empty($this->params['named']['sides'])) # How many sides we want.
		{
			$this->Session->write("Design.sides", $this->params['named']['sides']);
		}

		error_log("SESSION_ADD=".print_r($this->Session->read(),true));
		if(!$this->Session->read("Design.Design.productCode")) { 
			$defaultProd = 'B';
			$this->Session->write("Design.Design.productCode", $defaultProd);
		} # Default

		$prod = $this->Session->read("Design.Design.productCode");

		#error_log("DATA=".print_r($this->data,true));

		$action = !empty($this->data['form_submit']) ? strtolower($this->data['form_submit']) : null;

		$this->form($prod);

		$side = 1;

		#print_r($this->Session->read("Design.CustomImage"));

		# Fix images... on refresh, may have logged in and url have changed.
		$sides = $this->Session->read("Design.DesignSide");
		if(!empty($sides))
		{
			foreach($sides as $i=>$side)
			{
				if(!empty($side['customImageID']))
				{
					$imgid = $side['customImageID'];
					$image = $this->CustomImage->read(null, $imgid);
					$this->Session->write("Design.CustomImage.$i", $image['CustomImage']);
				} # Else ignore.
			}
		}

		#error_log("ACTION=$action");

		if(preg_match("/side 2/", $action))
		{
			$side = 2;
		} else if (preg_match("/cart/", $action)) { # Add to cart.
			$this->_add2cart();
		}
		$this->set("side", $side);

		$this->set("design", $this->Session->read("Design.Design"));
		$this->data = $this->Session->read("Design"); # Load.
	}

	function dump() 
	{
		$design = $this->Session->read("Design");
		header("Content-Type: text/plain");
		print_r($design);
		exit(0);
	}

	function review() # Modal.
	{
		if(empty($this->data) && !$this->Session->check("Design")) { 
			$this->redirect(array('action'=>'add'));
		}
		$this->savedata();
		$design = $this->Session->read("Design");
		$this->set("design", $design);

		$this->pricing(); # Process pricing stuff...

		$this->set("product", $this->Product->findByCode($design['Design']['productCode']));
		
		/*
		header("Content-Type: text/plain");
		print_r($this->data);
		exit(0);
		*/
	}

	function _add2cart()
	{
		# need to just throw most stuff into "parts" field.
		# 'parts2' = side 2 stuff.
		# DesignSide => parts encoded

		#$cartItem = $this->data[

		# Get full data dump so we know what fields to create.
		header("Content-Type: text/plain");
		print_r($this->data);
		exit(0);
	}

	function preview($side = 1) # ajaxy
	{
		$this->form();
		$this->set("side", $side);
	}

	function preview_css() # For changing product ie dome => rect
	{
		$this->form();
	}

	function reset_side($side = 1)
	{
		$this->Session->delete("Design.DesignSide.$side");
		$this->Session->delete("Design.CustomImage.$side");
		$this->form();

		#error_log("CORODS=".print_r($this->Session->read("Design.DesignSide.$side"),true));
		$this->set("side", $side);
		$this->action = 'side';
	}

	function side($side = 1) # Ajaxy load of side.
	{
		$this->form();
		$this->set("side", $side);
	}

	function quotes($side = 1) # Browse quote library. MODAL
	{
		# XXX getting product when page first loaded. needs to be saved somehow.
		# 
		# Get recommended quotes for product.
		$pid = $this->Session->read("Design.Product.product_type_id");

		if(!empty($pid))
		{
			$productQuotes = $this->ProductQuote->find('all', array(
				'conditions'=>array('ProductQuote.product_type_id'=>$pid)
			));
			#echo "PC($pid)=".print_r($productQuotes,true);
			$this->set("productQuotes", $productQuotes);
		}

		# Otherwise, get quote categories for browsing.
		$categories = $this->GalleryCategory->find('list', array(
			'conditions'=>"GalleryCategory.parent_node = 1",
			'fields'=>array('GalleryCategory.browse_node_id','GalleryCategory.browse_name'),
			'order'=>"GalleryCategory.browse_name")
		);
		$this->set("categories", $categories);

		$maxLength = $this->Session->read("Design.Product.quote_limit");

		if(!empty($this->data['Quote']['browse_node_id'])) # Browse cat.
		{
			# For now, make all one page, just make them scroll down...

			$category = $this->GalleryCategory->read(null, $this->data['Quote']['browse_node_id']);

			$kw = $category['GalleryCategory']['browse_name'];

			$browseQuotes = $this->Quote->findAll(array(" (subjects LIKE '%$kw%') " . ($maxLength > 0 ? " AND (LENGTH(text)+LENGTH(attribution)) <= '$maxLength' " : "")));

			$this->set("browseQuotes", $browseQuotes);
		}
		else if(!empty($this->data['Quote']['keywords'])) # Search
		{
			# For now, make all one page, just make them scroll down...

			$keywords = split(" ", mysql_escape_string($this->data['Quote']['keywords']));

			$keywhere = array();
			foreach($keywords as $kw)
			{
				$keywhere[] = "CONCAT(text,attribution,subjects)  LIKE '%$kw%'";
			}
			$keyword_where = join(" AND ", $keywhere);
			$searchQuotes = $this->paginate('Quote', array( " ($keyword_where) " . ($maxLength > 0 ? " AND (LENGTH(text)+LENGTH(attribution)) <= '$maxLength' " : "")) );

			$this->set("searchQuotes", $searchQuotes);

		}

		$this->set("side", $side); # So we know where to inject results.

	}

	function productCode($prod)
	{
		# If has parent and no files, prefer parent's
		$product = $this->Product->findByCode($prod);
		$parent = !empty($product['Product']['parent_product_type_id']) ? $this->Product->read(null, $product['Product']['parent_product_type_id']) : null;
		$parentProd = !empty($parent) ? $parent['Product']['code'] : null;


		if(!empty($parentProd) && !file_exists(APP."/webroot/images/designs/products/$prod.svg") && file_exists(APP."/webroot/images/designs/products/$parentProd.svg"))
		{
			$prod = $parentProd;
		}
		return $prod;
	}

	function product_prefix($prod, $orient = null) # Gets proper filename prefix, prefers parent if only one available.
	{
		$prod = $this->productCode($prod);
		return "/images/designs/products/".($orient == 'horizontal' ? "horizontal/":"").$prod;
		# Return relative, for direct client access.
	}

	function savedata()
	{
		if(!empty($this->params['url']['image_id'])) # Side 1 image selected from somewhere...
		{
			$customImage = $this->CustomImage->read(null, $this->params['url']['image_id']);
			$this->Session->write("Design.CustomImage.1", $customImage['CustomImage']);
		}

		if(!empty($this->data)) # Save data.
		{
			foreach($this->data as $model=>$data)
			{
				if(!is_array($data))
				{
					$this->Session->write("Design.$model", $data);
				} else {
					# If "side" key is set, divide properly.
					$side = !empty($data['side']) ? $data['side'] : null;
					foreach($data as $k=>$v)
					{
						$this->Session->write(($side ? "Design.$model.$side.$k" : "Design.$model.$k"), $v);
					}
				}
			}
		}

		// Fix change in type of product
		if(!empty($this->data['Design']['sides']) && $this->data['Design']['sides'] == 1)
		{
			$this->Session->delete("Design.DesignSide.2");
			$this->Session->delete("Design.CustomImage.2");
		}

		# Fix missing product details....
		if(!$this->Session->read("Design.Product") || $this->Session->read("Design.Design.productCode") != $this->Session->read("Design.Product.code")) # INit for pricing checks.
		{
			$prod = $this->Session->read("Design.Design.productCode");
			$product = $this->Product->findByCode($prod);
			$this->Session->write("Design.Product", $product['Product']);
			$this->Session->write("Design.productCode", $product['Product']['code']);
		}
	}

	function form($prod = null) # Stuff needed for form
	{
		#error_log("FORM=".print_r($this->data,true));
		$this->savedata();
		#error_log("DESIGN=".print_r($this->Session->read("Design"),true));
		#error_log("PROD1=====$prod");
		if(empty($prod))
		{
			$prod = $this->Session->read("Design.Design.productCode");
			#error_log("PRODsess=====$prod");
		}
		$meta = $this->meta($prod);
		$this->set($meta);

		$product = $this->Session->read("Design.Product");

		error_log("PRODUCT_CODE=".print_r($prod,true));

		$this->pricing();

		$orient = $this->orient($prod, $this->Session->read("Design.Design.orientation"));

		$file_prefix = $this->product_prefix($prod, $orient);
		# Get proper files, may be parent's


		# Now load xml stuff....
		# Load xml from svg.

		$product_svg = APP."/webroot/$file_prefix.svg";

		$product_xmlstring = file_get_contents($product_svg);
		#print_r($product_xmlstring);
		
		$svg_xml = simplexml_load_string($product_xmlstring);
		$svg_xml->registerXPathNamespace("svg", "http://www.w3.org/2000/svg");
		
		$dragimg = $svg_xml->xpath("//svg:image[@clip-path]");
		$dragrect = $svg_xml->xpath("//svg:rect[@clip-path]");
		
		$coords = $svg_xml->xpath("//svg:rect[not(@clip-path)]");
		$parts = $svg_xml->xpath("//svg:image[not(@clip-path)]");
		$fullbleed = $svg_xml->xpath("//svg:rect[@id='fullbleed']");
		
		$itemList = $svg_xml->xpath("//svg:rect|//svg:image");
		
		$items = array();
		foreach($itemList as $item) { $items[(string)$item['id']] = $item; }
		#echo "PL=".print_r($items,true);
		
		$product_image = "$file_prefix.png";
		$product_image_overlay = "{$file_prefix}-trans.png";
		# Load some product info.
		list($product_width,$product_height) = getimagesize(APP."/webroot/$product_image");

		$vars = compact("product","dragimg", "dragrect", "coords", "parts", "fullbleed", "items", "product_image", "product_image_overlay", "product_width","product_height","body_title");
		$this->set($vars);

		if($this->params['action'] == 'form' && !empty($this->params['isAjax'])) # Respond via json, ONLY if queried directly.
		{
			header("Content-Type: application/json");
			echo json_encode($this->viewVars);#array_merge($meta, $vars, $pricing));
			exit(0);
		}
	}

	function step($step, $side = 1) # Ajax load step.
	{
		$this->set("side", $side);

		$this->form();
		$this->set("step", $step);
		# XXX ought to be able to load multiple, so all load at once.
		$this->set("i", 1); # Dummy.
	}

	function images() # Ajaxy display of images.
	{
		$customer_id = !empty($_SESSION['Auth']['Customer']['customer_id']) ? $_SESSION['Auth']['Customer']['customer_id'] : null;
		$session_id = session_id();
		$images = $this->CustomImage->findAll( ($customer_id?" CustomImage.customer_id = '$customer_id' OR " : "") . " CustomImage.session_id = '$session_id' ", null, "Image_ID desc");
		$this->set("images", $images);
	}

	function steps($side = 1)
	{
		$this->set("side", $side);

		$this->form();
		$steps = !empty($this->params['form']['step']) ? $this->params['form']['step'] : array();
		$this->set('stepNames', $steps);
	}

	function meta($prod = 'B') # Data for objects, for retrieval/listing.
	{
		# FONTS
		#$fontFamilies = $this->fontFamilies();
		#$fonts = $this->fonts($fontFamilies);

		# TASSELS
		$tassels = $this->Tassel->find('all',array('conditions'=>array('available'=>'yes')));
		$tasselList = array(); $tasselImages = array(); $tasselThumbs = array(); $tasselHorizontalImages = array();
		foreach($tassels as $t) { 
			$tasselList[$t['Tassel']['tassel_id']] = ucwords($t['Tassel']['color_name']); 
			$tasselImages[$t['Tassel']['tassel_id']] = "/images/designs/tassels/".preg_replace("/\s+/", "-", $t['Tassel']['color_name']).".png"; 
			$tasselThumbs[$t['Tassel']['tassel_id']] = "/images/designs/tassels/thumbs/".preg_replace("/\s+/", "-", $t['Tassel']['color_name']).".png"; 

			$tasselHorizontalImages[$t['Tassel']['tassel_id']] = "/images/designs/tassels/horizontal/".preg_replace("/\s+/", "-", $t['Tassel']['color_name']).".png"; 
		}

		# CHARMS
		$charms = $this->Charm->find('all',array('conditions'=>array('available'=>'yes')));
		$charmList = array(); $charmImages = array(); $charmThumbs = array();
		foreach($charms as $c) { 
			$charmList[$c['Charm']['charm_id']] = $c['Charm']['name']; 
			$charmImages[$c['Charm']['charm_id']] = "/images/designs/charms/".preg_replace("/\s+/", "-", $c['Charm']['charm_code']).".gif"; 
			$charmThumbs[$c['Charm']['charm_id']] = "/images/designs/charms/thumbs/".preg_replace("/\s+/", "-", $c['Charm']['charm_code']).".jpg"; 
		}

		# BORDERS
		$borders = $this->Border->find('all',array('conditions'=>array('available'=>'yes','name !='=>"None"),'order'=>'border_id ASC')); # Skip none.
		$borderList = array(); $borderImages = array(); $borderHorizontalImages = array();
		foreach($borders as $b) { 
			$borderList[$b['Border']['border_id']] = ucwords($b['Border']['name']); 
			$borderImages[$b['Border']['border_id']] = "/images/designs".preg_replace("/[.]gif$/", ".png", $b['Border']['location']);

			$borderHorizontalImages[$b['Border']['border_id']] = "/images/designs/borders/horizontal/".preg_replace("/[.]gif$/", ".png", preg_replace("/^\/borders\//", "", $b['Border']['location']));
		}

		# Load related styles
		$styles = array();
		$product = $this->Product->findByCode($prod);
		$parent_id = !empty($product['Product']['parent_product_type_id']) ? $product['Product']['parent_product_type_id'] : $product['Product']['product_type_id'];
		$parent = $this->Product->read(null, $parent_id);
		$parentCode = !empty($parent) ? $parent['Product']['code'] : null;

		$styles = $this->Product->find('all', array(
			'recursive'=>-1,
			'conditions'=>array('available'=>'yes','OR'=>array('product_type_id'=>$parent_id,'parent_product_type_id'=>$parent_id)),
			#'fields'=>array('code','pricing_name','pricing_description'),
			'order'=>'choose_index'
		));

		# Get parts for active product.
		$steps1 = $this->load_product_options($prod, array('image'), null, null, true);


		$sides = $this->Session->read("Design.Design.sides");
		if(empty($sides)) { $sides = 1; }

		$steps2 = $sides > 1 ? $this->load_product_options($prod, array('tassel','charm','printing_back','image'), null, null, true) : array();

		#error_log("SIDES=$sides, steps2=".print_r($steps2,true));

		#error_log("TO=".print_r($this->textOptions,true));

		$orientations = array();

		# Get all pricings & orientations
		$pricings = array();
		foreach($styles as $style)
		{
			$styleCode = $style['Product']['code'];
			$pricings[$styleCode]['price_list'] = $this->get_effective_base_price_list($styleCode, false);
			$pricings[$styleCode]['Product'] = $this->Session->read("Design.Product");

			if(file_exists(APP."/webroot/images/designs/products/horizontal/$styleCode.svg")
				|| ($parentCode && file_exists(APP."/webroot/images/designs/products/horizontal/$parentCode.svg") && 
				!file_exists(APP."/webroot/images/designs/products/$styleCode.svg")) 
			)
			{
				$orientations[$styleCode] = true;
			}
		}


		# data
		return array(
			'productCode'=>$prod,
			'prod'=>$prod,
			'steps'=>array($steps1, $steps2),
			'tassels'=>$tasselList,
			'tasselImages'=>$tasselImages,
			'tasselHorizontalImages'=>$tasselHorizontalImages,
			'tasselThumbs'=>$tasselThumbs,
			'charms'=>$charmList,
			'charmImages'=>$charmImages,
			'charmThumbs'=>$charmThumbs,
			'borders'=>$borderList,
			'borderImages'=>$borderImages,
			'borderHorizontalImages'=>$borderHorizontalImages,
			"fontFamilies"=>$this->fontFamilies,
			"fontNames"=>$this->fontNames,
			"fontTweaks"=>$this->fontTweaks,
			"textOptions"=>$this->textOptions,
			'parent'=>$parent, # Other related products.
			'product_styles'=>$styles, # Other related products.
			'sides'=>$sides,
			'pricings'=>$pricings,
			'orientations'=>$orientations
		);
	}

	function save()
	{
		$this->savedata();
		/*
		if(!empty($this->data))
		{
			$this->Session->write("Design", $this->data);
		}
		*/
		header("Content-Type: application/json");
		echo json_encode($this->Session->read("Design"));
		exit(0);
	}

	function upload($side = 1)
	{
		$this->layout = 'ajax';
		$this->action = 'form';
		$error = null;
		if(!empty($this->data['CustomImage'])) # Process upload.
		{
			$this->CustomImage->Behaviors->attach("Upload", array('formats'=>array('jpeg','jpg','png','gif','tif','pdf')));
			foreach($this->data['CustomImage'] as $side=>$data)
			{
				if($cid = $this->Auth->user("customer_id"))
				{
					$data['Customer_ID'] = $cid;
				}
				$data['session_id'] = session_id();
				if(!$this->CustomImage->save(array('CustomImage'=>$data)))
				{
					$error = join(". ", $this->CustomImage->validationErrors);
				} else {
					$customImage = $this->CustomImage->read();
					$imgid = $this->CustomImage->id;
					$this->Session->write("Design.CustomImage.$side", $customImage['CustomImage']);
					$this->Session->write("Design.DesignSide.customImageID", $imgid);
				}
			}
		}
		# Return form
		#$this->form();

		if(!$this->RequestHandler->isAjax()) { 
			header("Content-Type: text/html");
			echo "<textarea>\n"; 
		}
		if(!empty($error))
		{
			echo json_encode(array('error'=>$error));
		} else {
			echo json_encode($this->Session->read("Design"));
		}
		if(!$this->RequestHandler->isAjax()) { echo "\n</textarea>\n"; }
		exit(0);
	}

	function upload_delete() # Text only.
	{
		$this->layout = 'ajax';
		$this->action = 'form';

		$this->Session->write("Design.CustomImage", null);

		if(!$this->RequestHandler->isAjax()) { 
			header("Content-Type: text/html");
			echo "<textarea>\n"; 
		}
		echo json_encode($this->Session->read("Design"));
		if(!$this->RequestHandler->isAjax()) { echo "\n</textarea>\n"; }
		exit(0);
	}

	function fonts($fonts = array()) # Takes fontdir=>[Family1, Family2] etc and makes dropdown nice.
	{
		if(empty($fonts)) { $fonts = $this->fontFamilies(); }
		$fontList = array();
		foreach($fonts as $font=>$families)
		{
			foreach($families as $family)
			{
				$fontList[$family] = Inflector::humanize(Inflector::underscore($family));
			}
		}
		#error_log("FONTLIST=".print_r($fontList,true));

		return $fontList;
	}

	function reset() { $this->clear(); }

	function clear()
	{
		$this->Session->delete("Design");
		#error_log("CLEARING SESSION=".print_r($this->Session->read(),true));
		$this->redirect(array('action'=>'add'));
	}

	function fontFamilies() # parses css files for fonts and gets full list of font-family optiosn (ie bold, italic, regular, etc) - for dropdowns.
	{ # dirname=>[dirnameReg, dirnameBold, dirnameItal], etc...
		$families = array();

		$basepath = APP."/webroot/fonts";
		$fonts_dir = new Folder($basepath);
		$entries = $fonts_dir->read(true, true);
		foreach($entries[0] as $font) # Dirs are [0], files are [1]
		{
			$cssfile = "$basepath/$font/stylesheet.css";
			if(file_exists($cssfile))
			{
				$css = file_get_contents($cssfile);
				preg_match_all("/font-family:\s+'([^']+)';/", $css, $matches);
				foreach($matches as $family)
				{
					$families[$font] = $family;
				}
			}
		}
		#error_log("FAMILIES=".print_r($families,true));
		return $families;
	}

	function png($side = 1)
	{
		#$this->raster = true;
		$xmldoc = $this->draw($side);


		$xml = $xmldoc->saveXML();

		$time = date("Y-m-d-H-i-s");
		$sid = session_id();

		#file_put_contents(APP."/webroot/tmp/svgdump-$sid.svg", $xml);
		# Dump a copy.



		#error_log("SIZE=".strlen($xml));

		$image = new Imagick();
		$image->readImageBlob($xml);
		$image->setImageFormat("png");
		$geo = $image->getImageGeometry();
		$w2h = $geo['width']/$geo['height'];

		if(!empty($this->params['named']['width']))
		{
			$width = $this->params['named']['width'];
			$height = $width / $w2h;
			$image->scaleImage($width, $height);
		}
		else if(!empty($this->params['named']['height']))
		{
			$height = $this->params['named']['height'];
			$width = $height * $w2h;
			$image->scaleImage($width, $height);
		}

		if(empty($_REQUEST['debug'])) { 	
			header("Content-Type: image/png");
		}
		echo $image;
		exit(0);
	}

	function svg($side = 1)
	{
		$xmldoc = $this->draw($side);

		if(!empty($this->params['named']['order_item_id']))
		{
			$order_item_id = $this->params['named']['order_item_id'];
			$orderItem = $this->OrderItem->read(null, $order_item_id);
			$purchase_id = $orderItem['OrderItem']['Purchase_id'];
			$code = $this->design['Product']['code'];
			$imgid = !empty($this->design['CustomImage']['Image_ID']) ?
				$this->design['CustomImage']['Image_ID'] : null;
			$this->filename = "Order-$purchase_id-$code-$imgid-side$side.svg";
		} else {
			$this->filename = "Design-".date("Y-m-d:H:i:s").".svg";
		}

		if(!empty($this->params['named']['print']) && empty($this->params['named']['debug']))
		{
			header("Content-Type: application/octet-stream");
		} else {
			header("Content-Type: image/svg+xml");
		}
		header("Content-Transfer-Encoding: Binary");
		header("Content-Disposition: inline; {$this->filename}");
		echo $xmldoc->saveXML();

		exit(0);
	}


	function load_order_design($order_item_id)
	{

		# Load from order, ie picture or details for modification....
		# XXX TODO
		$item = $this->OrderItem->read(null, $order_item_id);

		$design = array();

		$design['Design'] = array();
		foreach($item['OrderItem'] as $k=>$v)
		{
			$design["Design"][strtolower($k)] = 
				$design["Design"][$k] = $v; 
			# Lowercase fields, most sensible translation.
		}
		$design['DesignSide'] = array();

		# Map fields...
		foreach($this->orderDesignMap as $ok=>$dk)
		{
			$design['Design'][$dk] = $design['Design'][$ok];
		}

		# Load sides.
		$i = 1; foreach($item['ItemPart'] as $side)
		{
			$design["DesignSide"][$i] = array();
			foreach($side as $k=>$v)
			{ # Lowercase.
				$design["DesignSide"][$i][strtolower($k)] = 
					$design["DesignSide"][$i][$k] = $v;
			}
			foreach($this->orderItemDesignSideMap as $ik=>$sk)
			{
				$design["DesignSide"][$i][$sk] = $design["DesignSide"][$i][$ik];
			}


			# Decode coordinates...
			$crop = split(",", $design['DesignSide'][$i]['crop_xywh']);
			if(isset($crop[0])) { $design['DesignSide'][$i]['crop_x'] = $crop[0]; }
			if(isset($crop[1])) { $design['DesignSide'][$i]['crop_y'] = $crop[1]; }
			if(isset($crop[2])) { $design['DesignSide'][$i]['crop_w'] = $crop[2]; }
			if(isset($crop[3])) { $design['DesignSide'][$i]['crop_h'] = $crop[3]; }

			$quoteXY = split(",", $design['DesignSide'][$i]['quote_xy']);
			if(isset($quoteXY[0])) { $design['DesignSide'][$i]['quote_x'] = $quoteXY[0]; }
			if(isset($quoteXY[1])) { $design['DesignSide'][$i]['quote_y'] = $quoteXY[1]; }

			$personalizationXY = split(",", $design['DesignSide'][$i]['personalization_xy']);
			if(isset($personalizationXY[0])) { $design['DesignSide'][$i]['personalization_x'] = $personalizationXY[0]; }
			if(isset($personalizationXY[1])) { $design['DesignSide'][$i]['personalization_y'] = $personalizationXY[1]; }

		$i++; }

		$design['Design']['sides'] = count($design['DesignSide']);
		$design['Design']['printing_back'] = ($design['Design']['sides'] > 1);


		$product = $this->Product->read(null, $design['Design']['product_type_id']);
		$design['Product'] = $product['Product']; # Load product...

		######################################

		# Load images.
		$design['CustomImage'] = array();
		if(!empty($design['DesignSide'][1]['customImageID']))
		{
			$image1 = $this->CustomImage->read(null, $design['DesignSide'][1]['customImageID']);
			$design['CustomImage'][1] = $image1['CustomImage'];
		}
		if(!empty($design['DesignSide'][2]['customImageID']))
		{
			$image2 = $this->CustomImage->read(null, $design['DesignSide'][2]['customImageID']);
			$design['CustomImage'][2] = $image2['CustomImage'];
		}
		# todo load stamp, if any.



		return $design;
	}

	function load_cart_design($cart_item_id) # Whether picture OR modify page...
	{
		$item = $this->CartItem->read(null, $cart_item_id);

		$design = array();

		$design['Design'] = $item['CartItem']; # Not sure if missing stuff... fields will carry over.

		$product = $this->Product->findByCode($item['CartItem']['productCode']);
		$design['Product'] = $product['Product'];

		# Load sides.
		$design['DesignSide'] = array();
		$design['DesignSide'][1] = unserialize($item['CartItem']['parts']);
		if(!empty($item['CartItem']['parts2']))
		{
			$design['DesignSide'][2] = unserialize($item['CartItem']['parts2']);
		}
		$design['Design']['sides'] = count($design['DesignSide']);
		$design['Design']['printing_back'] = ($design['Design']['sides'] > 1);

		# Convert old field names for compatibility.
		foreach($design['DesignSide'] as &$side)
		{
			foreach($this->cartItemPartFields as $ok=>$nk)
			{
				if(isset($side[$ok]) && !isset($side[$nk]))
				{
					$side[$nk] = $side[$ok];
				}
			}

			# Other fixes should be in the main load code.

			#error_log("SIDE=".print_r($side,true));
		}

		# Load images.
		$design['CustomImage'] = array();
		if(!empty($design['DesignSide'][1]['customImageID']))
		{
			$image1 = $this->CustomImage->read(null, $design['DesignSide']['1']['customImageID']);
			$design['CustomImage']['1'] = $image1['CustomImage'];
		}
		if(!empty($design['DesignSide']['2']['customImageID']))
		{
			$image2 = $this->CustomImage->read(null, $design['DesignSide']['2']['customImageID']);
			$design['CustomImage']['2'] = $image2['CustomImage'];
		}
		# todo load stamp, if any.

		return $design;
	}

	function defaults_compatibility($design) # Also compatibility stuff...
	{
		if(empty($design["DesignSide"])) { return; }

		foreach($design['DesignSide'] as &$side)
		{


			# Fix quote/attribution
			if(!empty($side['quoteID']))
			{
				$quote = $this->Quote->read(null, $side['quoteID']);
				$side['quote'] = $quote['Quote']['text'];
				$side['quote_attribution'] = $quote['Quote']['attribution'];
			}

			# Fix dropcap/center text.
			if(empty($side['quote_style']) && isset($side['centerQuote']))
			{
				$side['quote_style'] = empty($side['centerQuote']) ? "dropcap" : "center";
			}

			# Fix quote/pers font sizes....
			if(empty($side['quote_font_size']))
			{
				$side['quote_font_size'] = 22;
				if(!empty($side['textSize']))
				{
					$side['quote_font_size'] *= $this->fontFactors[$side['textSize']];
				}
			}
			if(empty($side['personalization_font_size']))
			{
				$side['personalization_font_size'] = 12;
				if(!empty($side['personalizationSize']))
				{
					$side['personalization_font_size'] *= $this->fontFactors[$side['personalizationSize']];
				}
			}

			if(!empty($side['personalizationStyle'])) # script vs block.
			{
				if($side['personalizationStyle'] == 'script')
				{
					$side['personalization_font'] = 'tk-leander-script-pro';
				} else { # block
					$side['personalization_font'] = 'tk-adobe-garamond-pro';
				}
			}

			# Split quote into attribution (old orders)
			if(!empty($side['quote_id']) && empty($side['quote']))
			{
				$quote = $this->Quote->read(null, $side['quote_id']);
				$side['quote'] = $quote['Quote']['text'];
				$side['attribution'] = $quote['Quote']['attribution'];
			}
			# Fix dropcap/quote_style
			if(empty($side['quote_style']))
			{
				$side['quote_style'] = 
					!empty($side['centerQuote']) ? "center" : "dropcap";
			}
		}
		return $design;
	}

	function draw($side = 1) # Generate SVG
	{
		$basepath = APP."/webroot/images/designs";


		# XXX TODO LOAD parent files if needed.

		if(!empty($this->params['named']['saved_item_id'])) 
		{
			$design = $this->load_saved_design($this->params['named']['saved_item_id']);
		} else if(!empty($this->params['named']['cart_item_id']))  {
		# load cart_item_id for cart.
			$design = $this->load_cart_design($this->params['named']['cart_item_id']);
		} else if (!empty($this->params['named']['order_item_id'])) { 
			# load order_item_id for order sheets...
			$design = $this->load_order_design($this->params['named']['order_item_id']);
			#print_r($design);
			#exit();
		} else { # Live.
			$design = $this->Session->read("Design");
		}

		$design = $this->defaults_compatibility($design);

		# Temporarily, remove coordinates, page itself will update session.
		if(!empty($this->params['url']['reset_coords']))
		{
			$coord_fields = array(
				'crop_x','crop_y','crop_w','crop_h',
				'border1_x','border1_y','border2_x','border2_y',
				'quote_x','quote_y','quote_width',
				'personalization_x','personalization_y','personalization_width',
			);

			foreach($design['DesignSide'] as $i=>&$designSide)
			{
				foreach($coord_fields as $f)
				{
					unset($designSide[$f]);
				}
			}
		}

		$prod = null;

		if(!empty($design['Design']['product_type_id']))
		{
			$prod = $this->Product->field('code', array('product_type_id'=>$design['Design']['product_type_id']));
		} else if (!empty($design['Design']['productCode'])) { 
			$prod = $design['Design']['productCode'];
		}

		$prod = $this->productCode($prod); 
		# May be using PARENT svg files...
		$product = $this->Product->findByCode($prod);

		error_log("CODE=$prod");

		$orient = $this->orient($prod, !empty($design['Design']['orientation']) ? $design['Design']['orientation'] : null);
		$svgpath = ($orient == 'horizontal' ? "$basepath/products/horizontal/$prod.svg" : "$basepath/products/$prod.svg");

		#error_log("SVG $svgpath=".file_get_contents($svgpath));

		# Load SVG file
		#$svg = simplexml_load_file($svgpath);
		#$svg->registerXPathNamespace("svg", "http://www.w3.org/2000/svg");   
		#$svg->registerXPathNamespace("xlink", "http://www.w3.org/1999/xlink");

		$xmldoc = new DOMDocument();
		$xmldoc->load($svgpath);
		$svg = $xmldoc->documentElement;

		# Product URL needs to be relative to server.
		#$produrl = "/images/designs/products/$prod.png";
		$produrl = ($orient == 'horizontal' ? "/images/designs/products/horizontal/$prod.png" : "/images/designs/products/$prod.png");
		$overurl = ($orient == 'horizontal' ? "/images/designs/products/horizontal/$prod-trans.png" : "/images/designs/products/$prod-trans.png");
		error_log("PU=$produrl");
		if(!empty($this->params['named']['print']))
		{
			$this->set_image($svg, "product", null);
			$this->set_image($svg, "overlay", null);
		} else { 
			$this->set_image($svg, "product", $produrl);
			$this->set_image($svg, "overlay", $overurl);
		}

		# Load meta about parts.
		$meta = $this->meta();

		#error_log("META=".print_r($meta,true));

		#print_r($design);

		if(!empty($design))
		{
			$d = $design['Design'];
			$s = !empty($design['DesignSide'][$side]) ? $design['DesignSide'][$side] : array();
			$i = !empty($design['CustomImage'][$side]) ? $design['CustomImage'][$side] : array();
			$orient = $this->orient($prod, $d['orientation']);
			# NOW LETS MODIFY
			#error_log("I($side)=".print_r($i,true));#DATA=".print_r($design,true));


			# filename alone may be relative to dir.
			$filename = null;
			if(!empty($i['filename'])) # Path is irrelevant (and harmful) if filename is empty.
			{
				$filename = (!empty($i['path']) ? ($i['path'].'/') : "") . $i['filename'];
			}

			#error_log("F({$side})=$filename");

			# Support LEGACY images...
			if(!empty($i['Image_Location'])) {  # Prefer since others may be pdf.
				$filename = $i['Image_Location'];
				# XXX What if we have a pdf file, etc?
				# display version is scaled down. (bad for printing)
				# image_loc version is raw/unconverted...
			}


			# If it's a PDF, etc, there should be a .png version.
			$filename_png = preg_replace("/([.]\w+)$/i", ".png", $filename);
			if($filename != $filename_png && file_exists(APP."/webroot/$filename_png"))
			{
				$filename = $filename_png;
			}

			error_log("FILENAME=$filename, PNG=$filename_png");


			#error_log("FILENAME=$filename");

			# insert picture.

			# Fix other stuff
			$b1x = ($orient == 'horizontal' && !empty($s['border1_x'])) ? $s['border1_x'] : null;
			$b1y = ($orient != 'horizontal' && !empty($s['border1_y'])) ? $s['border1_y'] : null;
			$b2x = ($orient == 'horizontal' && !empty($s['border2_x'])) ? $s['border2_x'] : null;
			$b2y = ($orient != 'horizontal' && !empty($s['border2_y'])) ? $s['border2_y'] : null;
			# Don't set y coords for border when horizontal product, and vice versa

			# (check to see what parts are available, from svg search? all img under #parts ?)
			$borderType = ($orient == 'horizontal' ? 'borderHorizontalImages': 'borderImages');
			$tasselType = ($orient == 'horizontal' ? 'tasselHorizontalImages': 'tasselImages');
			$this->set_image($svg, "border1", (!empty($s['border_id']) && $s['border_id'] > 0) ? $meta[$borderType][$s['border_id']] : null, $b1x, $b1y);
			$this->set_image($svg, "border2", (!empty($s['border_id']) && $s['border_id'] > 0) ? $meta[$borderType][$s['border_id']] : null, $b2x, $b2y);

			if(!empty($this->params['named']['print']))
			{
				$this->set_image($svg, "tassel", null);
				$this->set_image($svg, "charm", null);
			} else { 
				$this->set_image($svg, "tassel", !empty($s['tassel_id']) ? $meta[$tasselType][$s['tassel_id']] : null);
				$this->set_image($svg, "charm", !empty($s['charm_id']) ? $meta['charmImages'][$s['charm_id']] : null);
			}

			# Set text
			# Add fonts to file
			#$this->embed_fonts($svg); # Must add all options, since dont know css file.

			# XXX SVG needs to accept a URL since name isnt good enough for imagemagick render to png
			# font-face?
			# XXX FontAttributes CLASS XXX TODO

			if(!empty($s['quote']))
			{
				$attribution = !empty($s['quote_attribution']) ? $s['quote_attribution'] : null;
				$quote_font = !empty($s['quote_font']) ? $s['quote_font'] : 'tk-adobe-garamond-pro';
				$quote_font_size = !empty($s['quote_font_size']) ? $s['quote_font_size'] : 22;
				$quote_x = isset($s['quote_x']) ? $s['quote_x'] : null;
				$quote_y = isset($s['quote_y']) ? $s['quote_y'] : null;
				$quote_w = isset($s['quote_width']) ? $s['quote_width'] : null;
				$quote_style = !empty($s['quote_style']) ? $s['quote_style'] : null;
				$quote_color = !empty($s['quote_color']) ? $s['quote_color'] : null;

				list($quoteEndX,$quoteEndY) = $this->set_text($svg, "quote", $s['quote'],
					$quote_font, $quote_font_size, $quote_x, $quote_y, $quote_w, $quote_style, $quote_color);

				# DO ATTRIBUTION
				if(!empty($attribution))
				{
					# XXX this may be relative to canvas and not offset from default.
					$attribution_x = 0; # Default X position.
					$attribution_y = $quoteEndY + $s['quote_font_size']*($this->textOptions['attributionMargin']);
					$this->set_text($svg, "quote", $attribution,
						$s['quote_font'], $s['quote_font_size']*$this->textOptions['attributionSize'],
						$attribution_x, $attribution_y, null, 'attribution', $quote_color);
				}
			} else { # Clear.
				$this->set_text($svg, "quote", null);
			}

			if(!empty($s['personalization']))
			{
				$personalization_font = !empty($s['personalization_font']) ? $s['personalization_font'] : 'tk-leander-script-pro';
				$personalization_font_size = !empty($s['personalization_font_size']) ? $s['personalization_font_size'] : 12;
				$personalization_x = isset($s['personalization_x']) ? $s['personalization_x'] : null;
				$personalization_y = isset($s['personalization_y']) ? $s['personalization_y'] : null;
				$personalization_width = !empty($s['personalization_width']) ? $s['personalization_width'] : null;
				$personalizationColor = !empty($s['personalizationColor']) ? $s['personalizationColor'] : null;

				error_log("PERS ($personalization_x,$personalization_y)=".print_r($s['personalization'],true));

				$this->set_text($svg, "personalization", $s['personalization'], $personalization_font, $personalization_font_size, $personalization_x, $personalization_y, $personalization_width, 'center', $personalizationColor);
			} else { # clear
				$this->set_text($svg, "personalization", null);
			}

			#error_log("S=".print_r($s,true));

			#error_log("BG=".$s['background_color']);

			if(!empty($s['background_color']) && ($background = $this->xpath($svg, "//svg:rect[@id='background']")))
			{
				if(!preg_match("/^#/", $s['background_color']))
				{
					$s['background_color'] = "#".$s['background_color'];
				}
				$background[0]->setAttribute('style', "fill: {$s['background_color']};");
				if(!empty($this->params['named']['print']))
				{
					$background[0]->setAttribute('clip-path', "url(#clipFullbleedPrint)");
				}
			}

			# DO IMAGE LAST SINCE BIGGEST

			if(!empty($filename))
			{
				# Work on coords for scaling, etc.
				$x = !empty($s['crop_x']) ? $s['crop_x'] : null;
				$y = !empty($s['crop_y']) ? $s['crop_y'] : null;
				$w = !empty($s['crop_w']) ? $s['crop_w'] : null;
				$h = !empty($s['crop_h']) ? $s['crop_h'] : null;
				#$x = 0; $y = 0;
				#$w = null; $h = null;
				# needs to happen for proportion to keep proper.

				#error_log("XYWH=$x, $y, $w, $h");

				# XXX Get compatible imageCrop, if there.

				# calculate default coordinates since images vary in size...
				if(empty($w) || empty($h)) # Calculate default.
				{
					list($imgw,$imgh) = getimagesize(APP."/webroot/$filename");
					$imgw2h = $imgw/$imgh;

					# Get dummy location, to find center point and tolerable size
					if(empty($d['template']))
					{
						# Guess default template from settings.
						if(!empty($product['Product']['fullbleed']))
						{
							$d['template'] = 'fullbleed';
						} else {
							$d['template'] = 'standard';
						}	
					} else if($d['template'] == 'imageonly') { 
						$d['template'] = 'fullbleed';
					}
					list($cx,$cy,$cw,$ch) = $this->get_coords($svg, $d['template']);
					list($fx,$fy,$fw,$fh) = $this->get_coords($svg, 'fullbleed');

					#error_log("FB=$fx,$fy,$fw,$fh");

					if($d['template'] == 'fullbleed')
					{
						/* ALWAYS just go with default fullbleed...
						# See if provided via imageCrop
						if(!empty($s['imageCrop']))
						{
							$crop = split(",", $s['imageCrop']);

							# Scale image as needed....
							# XXX even w/h is a bit off!
							$scalex = $imgw/$crop[2];
							$scaley = $imgh/$crop[3];
							$w = $cw * $scalex;
							$h = $ch * $scaley;

							# For x,y offset, something is a bit wrong...
							$x = $fx - $crop[0];
							$y = $fy - $crop[1];

							error_log("X=$x, FX=$fx, CX={$crop[0]}, scalex=$scalex; Y=$y, FY=$fy, CY={$crop[1]}, scaley=$scaley");

							# XXX figure out HOW To get x/y

							$x = -250;
							$y = -15;

							error_log("NEW $x,$y, $w, $h");

						} else {
						*/
							$w = $cw;
							$h = $w / $imgw2h;
		
							if($h < $ch)
							{
								$h = $ch;
								$w = $imgw2h * $h;
							}

							# Center.
							$x = $cx + ($cw - $w)/2;
							$y = $cy + ($ch - $h)/2;
						##}
					} else { # standard.
						#error_log("Cxywh= $cx, $cy, $cw, $ch");
	
						# Center and fit INSIDE canvas
						$w = $cw;
						$h = $w / $imgw2h;
	
						if($h > $ch)
						{
							$h = $ch;
							$w = $imgw2h * $h;
						}
						# Center.
						$x = $cx + ($cw - $w)/2;
						$y = $cy + ($ch - $h)/2;
					}

				}

				#error_log("IXYWH=$x, $y, $w, $h");



				#$filename = "images/trans.gif";
				$this->set_image($svg, "image", "/$filename", $x, $y, $w, $h, !empty($s['imageCrop']) ? $s['imageCrop'] : null, !empty($s['template']) ? $s['template'] : null);
				# ? parser can't work with dom once large data added?
			} else {  # Clear
				$this->set_image($svg, "image", null);
			}
		}

		$this->design = $design; # Save.

		return $xmldoc;
	}

	function attr($node,$key)
	{
		if(!is_object($node))
		{
			echo "NOB ($key)='".print_r($node,true)."'";
		}
		return $node->getAttribute($key);
	}

	function addChild($parent, $nodename, $value = null, $attrs = array())
	{
		$node = new DOMElement($nodename,$value);
		$parent->appendChild($node);
		if(!empty($attrs))
		{
			foreach($attrs as $k=>$v)
			{
				$node->setAttribute($k,$v);
			}
		}
		return $node;
	}

	function embed_fonts($svg)
	{
		#$defs = $svg->xpath("//svg:defs");
		$defs = $this->xpath($svg, "//svg:defs");
		#error_log("DEFS=".print_r($defs,true));

		$basepath = APP."/webroot/images/designs/fonts";

		foreach($this->fontFiles as $fontfile=>$fontName)
		{
			$absfontfile = "$basepath/$fontfile";
			#error_log("ABSFONTFILE=$absfontfile");
			if(file_exists($absfontfile))
			{
				preg_match("/[.](\w+)$/", $absfontfile,$matches);
				$ext = $matches[1];
				#error_log("EXIST!");
				$fontdata = file_get_contents($absfontfile);
				$base64_data = base64_encode($fontdata);
				#$mt = new MIME_Type();
				#$mime = $mt->autoDetect($absfontfile);
				$mime = $this->mime($absfontfile);
				$cssinfo = "@font-face { font-family: '$fontName'; src: url('data:font/$ext;base64,$base64_data'); font-weight: normal; font-style: normal; }";
			}
			#$style = $defs[0]->addChild("style", $cssinfo);
			#$style->addAttribute("type", "text/css");

			$this->addChild($defs[0], "style", $cssinfo, array('type'=>'text/css'));
		}
	}

	function set_text($svg, $id, $string = null, $font = 'tk-adobe-garamond-pro', $fontsize = 16, $x = null, $y = null, $width = null, $textstyle = null, $color = null)
	{
		#error_log("SHIT_TEXZT - $string, $font, $fontsize, $x, $y, $textstyle, $color");
		$attribution = null;
		if(is_array($string))
		{
			list($attribution,$string) = $string;
		}

		#error_log("FONT=$font");

		$fontName = $this->fontNames[$font];
		$fontFamily = $this->fontFamilies[$font];

		$tweaks = !empty($this->fontTweaks[$font]) ? $this->fontTweaks[$font] : array();
		$textOptions = array_merge($this->textOptions, $tweaks);


		#error_log("FONT=$font, FN=$fontName");
		/*
		$fontName = $font;
		if(!empty($font) && !empty($this->raster))
		{
			$fontfile = $this->fontfile($font);
			$fontAttributes = new FontAttributes($fontfile);
			# Need to give proper name of font installed on system.

			$fontName = $fontAttributes->getFontFamily();
			error_log("FONTNAME=".$fontName);
		}
		*/
		# Font name is not consistent with filename, etc. must scan ttf file.

		#$rect = $svg->xpath("//svg:rect[@id='$id']");
		$rect = $this->xpathOne($svg, "//svg:rect[@id='$id']");
		# For constraints
		if(empty($rect)) { return; } # ie no quote etc on domes, etc.

		# TEST XXX
		#$string = "Is the\n cutest baby on\nearth, maybe the universe.";

		# Fix newlines
		$string = preg_replace("/\r\n/", "\n", $string);

		# Swap special chars. (ellipsis)
		$string = preg_replace("/([.]\s*[.]\s*[.])/", "…", $string);


		#$string = "Lorem ipsum dolor sit amet";#, todor monei faloush doupf.";
		# XXX DUMMY

		$origX = $this->attr($rect,'x');#$rect[0]['x'];
		$origY = $this->attr($rect,'y');#$rect[0]['y'];

		$startX = !empty($x) ? $x : $this->attr($rect,'x');#$rect[0]['x']; 
		$startY = !empty($y) ? $y : $this->attr($rect,'y');#$rect[0]['y']; 
		$origWidth = $maxWidth = (!empty($width) ? $width : $this->attr($rect, 'width')) +($fontsize*$textOptions['rightShaveFudge']);
		$origHeight = $maxHeight = $this->attr($rect,'height'); // Make sure text fits within.

		#error_log("OrigW=$origWidth, Wid=$width, FUDGE={$textOptions['rightShaveFudge']}, OrigH=$origHeight");

		# Remove placeholder
		$placeholder = $this->xpath($svg, "//svg:text[@id='{$id}_text']");
		if(!empty($placeholder)) { 
			$this->deleteNode($placeholder[0]);
		}

		if(empty($string)) { return; }

		# Escape string, ampersands screw up XML...
		$unescaped_string = $string;
		$string = htmlspecialchars($unescaped_string);

		$text = $this->addChild($svg, "text");
		$text->setAttribute("x", $startX);
		$text->setAttribute("y", $startY);
		# Or elsewhere, based on x,y of coords
		#error_log("WIDTH=$width");

		$style = "font-size: {$fontsize}px; ";
		if(!empty($fontName)) { $style .= " font-family: $fontFamily;"; }
		#error_log("SET FONT=$fontName");

		#error_log("COLOR: $color");

		if(!empty($color)) { 
			if(!preg_match("/^#/", $color)) { $color = "#$color"; }
			$style .= " fill: $color;"; 
		}

		#error_log("STLE=$style");

		if($textstyle == 'attribution')
		{
			$string = "— $string";
			$style .= " font-style: italic;"; 
		}

		#if($textstyle == 'center') { $style .= " text-align: center;"; } # This doesn't work, since no width/height assigned...
		$text->setAttribute("style", $style);

		$offsetX = $startX;
		$offsetY = $startY;
		$maxX = $offsetX + $origWidth;#$startX + $maxWidth;
		$maxY = $offsetY + $origHeight;#$startY + $maxHeight;

		#error_log("MAX_X=$maxX");

		#error_log("X,Y=$x,$y; MAXX($id)=$maxX, $origX + W=$origWidth");


		#error_log("WORDS=".print_r($string,true));

		$dropcapY = $offsetY;

		list($normalW,$normalH,$charW,$charH) = $normalMetrics = $this->textMetrics($unescaped_string, $font, $fontsize);
		# Move down a linespace, since start coordinate is at top edge of text.
		$offsetY += $charH*.9; 

		# There is no 'line-height', so we have to adjust the offset to simulate.
		$lineHeightFactor = $textOptions['lineHeight'];
		# (we may need to adjust using a factor of the fontsize)
		$lineHeight = $fontsize*$lineHeightFactor;
		$originalLineHeight = $fontsize*$this->textOptions['lineHeight']; # For newlines.

		#error_log("LINE_HEIGHT=$lineHeight");

		# Replace sets of double quotes with curly quotes.
		# Add margin to make room for quotes.
		if($quoted = preg_match('/"(.+)"/', $string))
		{
			$string = preg_replace('/"(.+)"/', '\\1', $string);
		}


		if($quoted) # Add left quote, but move over
		{
			$tspan = $this->addChild($text, "tspan", '“');
			$tspan->setAttribute("x", $offsetX-($fontsize*$this->textOptions['leftQuoteOffsetX']));
			$tspan->setAttribute("y", $offsetY-($fontsize*$this->textOptions['leftQuoteOffsetY']));
			$lquotefontsize = $fontsize * $this->textOptions['leftQuoteSize'];
			$tspan->setAttribute("style", "font-size: {$lquotefontsize}px;");
		}

		# DROPCAP
		if($textstyle == 'dropcap')
		{
			# Need to support unicode ie special chars.
			#$dropcap = $string[0];
			$dropcap = mb_substr($string, 0, 1);

			$dropfontsize = $fontsize * $textOptions['dropcapFactor']; # ?? maybe ??
			$string = mb_substr($string, 1); // remove.

			list($dropcapW,$dropcapH,$dropcharW,$dropcharH,$box) = $dropMetrics = $this->textMetrics($dropcap, $font, $dropfontsize);
			
			#error_log("DROPH=$dropcapH, NORMH=$normalH, CHARW=$charW, CHARH=$charH");
			#error_log("BOX=".print_r($box,true));

			#$offsetY += $dropcapH/2;

			$dropcapY = $offsetY + $dropcharH*$textOptions['dropcapDrop']*1.05 - $charH; #$startY+$charH*.95; # Lower dropcap. needs a tiny nudge, compared to webpage.
			#error_log("STARTY=$startY + DROPH $dropcapH = DROPZY=$dropcapY");


			$tspan = $this->addChild($text, "tspan", $dropcap);
			$tspan->setAttribute("x", $offsetX);
			$tspan->setAttribute("y", $dropcapY); # Lower
			$tspan->setAttribute("style", "font-size: {$dropfontsize}px;");
			# XXX instead of using padding/margin, we have to adjust x/y

			# OFFSET DEPENDS ON LETER ITSELF, EXACT CHAR METRICS!


			#$dropcapMarginRight = $textOptions['dropcapMarginRight']*$dropcapW;#dropcapW; # $fontsize
			$dropcapMarginRight = $textOptions['dropcapMarginRight']*$dropfontsize*1.75;

			#if(!empty($fontTweaks[$font]['dropcap_margin_right'])) {
			#	$dropcapMarginRight = $dropfontsize*$fontTweaks[$font]['dropcap_margin_right'];
			#}

			$offsetX += $dropcapW + $dropcapMarginRight;

			$dropcapX = $offsetX; # Right edge of dropcap.

			#error_log("DROPCAP X,Y=$dropcapX,$dropcapY");

			# Also include 1st line a tad closer to dropcap.
			$offsetX += $textOptions['dropcapTextIndent']*$dropfontsize;
		}
		#error_log("STR_AFTER=$string, START=$offsetX, $offsetY, MH=$maxHeight");

		$biggestX = 0;

		error_log("STRING=$string");

		while($string)# && $offsetY < $startY+$maxHeight) # Ignore max height, since stuff may go beyond original boxes, will get clipped ok.
		{
			# offsetY miscalculated...?
			#error_log("OFFY < start-y+max-height .... $offsetY <  $startY + $maxHeight");

			# Errors with overlapping dropcap due to explicit newlines are HERE!
			while(!empty($string) && $string[0] == "\n") # Newlines found...
			{
				list($w,$h) = $this->textMetrics("\n", $font, $fontsize);
				error_log("OFF_Y=$offsetY");
				error_log("NEWLINE ($string), LINE_HEIHT=$lineHeight, ADDING $lineHeight (or should be h=$h?), OFFY=$offsetY, DROP UNTIL=$dropcapY");
				if($offsetY > $dropcapY)
				{
					#error_log("DONE DROP ($string) ($offsetY > $dropcapY), Y=$offsetY, X=$offsetX");
					$offsetX = $startX;
				} else {
					#error_log("STILL IN DROP ($offsetY < $dropcapY), X=$offsetX");
					$offsetX = $dropcapX;
				}
				$offsetY += $lineHeight; # May need to adjust
				# PUT AFTER SO PROPER INDENT

				$string = substr($string, 1); # Advance.
			}


			$words = preg_split("/(\s)/", $string, null, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
			#error_log("SPLIT_WORDS=".print_r($words,true));

			$fits = false;
			# Only join up until next newline.
			$testend = count($words)-1;
			if($newlineIndex = array_search("\n", $words))
			{
				#error_log("NEWLINE FOUND AT ($offsetY) $newlineIndex IN '$string'");
				$testend = $newlineIndex-1;
			}
			# XXX TODO single words on a line do not get inserted.
			# If set i >= 0, then recurses forever.

			for($i = $testend; $i >= 0 && !$fits && count($words); $i--) # Check how many words fit on the line.
			{
				# Properly trim entire entity if special....
				$chunk = join("", array_slice($words, 0, $i+1));
				$trimmed_chunk = trim($chunk); # Get rid of spaces before/after.
				$unescaped_trimmed_chunk = htmlspecialchars_decode($trimmed_chunk);

				list($w,$h) = $this->textMetrics($unescaped_trimmed_chunk, $font, $fontsize); # Ignore spaces on right end...
				#error_log("CHECK ($chunk/0-$i) $w + $offsetX <= $maxX");

				# TEST HERE FOR FITTING ON LINE
				#if($w + $offsetX <= $maxX-($fontsize*$textOptions['bufferFactor'])) {

				#error_log("CHECK_FIT '$trimmed_chunk', START=$offsetX,$offsetY, W=$w, TESTED=".($w+$offsetX).", MAX=$maxX");
				if($w + $offsetX <= max($maxX,$biggestX)) { #-($fontsize*$textOptions['bufferFactor'])) {
					//error_log("FITS ($chunk), W=$w + OX=$offsetX < max($maxX, $biggestX)");
					#+ ($fontsize*{$textOptions['bufferFactor']}), Y=$offsetY");

					$biggestX = max($biggestX, $maxX);
					#error_log("BIGGEST_X=$biggestX");

					$fits = true;
					$string = substr($string, strlen($chunk)); # Skip # words matched.

					#error_log("FITS!");

					# Add text.
					$tspan = $this->addChild($text, "tspan", $trimmed_chunk); # Skip spaces at start of line...

					# Factor in centered
					#error_log("TEXZTSTLYE($id)=$textstyle");
					if($textstyle == 'center')
					{
						$offsetX += ($maxWidth - $w)/2;
					} else if ($textstyle == 'attribution') { # Right
						$offsetX += ($maxWidth - $w);
					}

					$tspan->setAttribute("x", $offsetX);
					$tspan->setAttribute("y", $offsetY);
					$offsetX += $w;

				}
			}
			if(!$fits)
			{
				error_log("EXTRA TEXT TO WRAP, DIDNT FIT ($string) AT X=$offsetX < $maxX, ADDING H=$h, OFFSETY=$offsetY, DROPY=$dropcapY");
				# if still in dropcap, just go down, don't go over.
				if($offsetY >= $dropcapY)
				{
					error_log("OUTSIDE OF DROPCAP ($offsetY > $dropcapY), GOING LEFT");
					$offsetX = $startX;
				} else {
					error_log("STILL IN DROPCAP ($offsetY < $dropcapY)");
					$offsetX = $dropcapX; // Go only back to dropcap.
				}
				#error_log("OFFSETY INCREMENT=$offsetY + $lineHeight=".($offsetY+$lineHeight));
				$offsetY += $lineHeight;
				# This kinda only lets for one font size...
			}
			#error_log("STR=$string, OY=$offsetY");
		} 

		if($quoted) # Add right quote
		{
			$rquote = '”';
			# XXX May need to move down to next line if this sticks over...
			# 
			list($w,$h) = $this->textMetrics($rquote, $font, $fontsize);
			#error_log("CHECK ($chunk/0-$i) $w + $offsetX <= $maxX");

			# TEST HERE FOR FITTING ON LINE
			if(!($w + $offsetX <= $maxX-($fontsize*$textOptions['bufferFactor']))) 
			{
				# DOESNT FIT. Advance a line.
				$offsetX = $startX;
				$offsetY += $lineHeight;
			}

			# Now add right quote

			$tspan = $this->addChild($text, "tspan", $rquote);
			$tspan->setAttribute("x", $offsetX);
			$tspan->setAttribute("y", $offsetY);
			$tspan->setAttribute("style", "font-family: '{$this->textOptions['quotedFont']}', Times New Roman, serif;");
		}

		return array($offsetX,$offsetY);
	}

	function setAttribute($node, $key, $value)
	{
		$ns = null;
		if(is_array($key))
		{
			$ns = $key[0];
			$key = $key[1];
			$node->setAttributeNS($this->nsurl[$ns], "$ns:$key", $value);
		} else {
			$node->setAttribute($key,$value);
		}
	}

	function deleteNode($node)
	{
		#error_log("NODE=".print_r($node,true));
		$node->parentNode->removeChild($node);

		#foreach($node as $key)
		#{
		#	unset($key[0]);
		#}
	}

	# Metrics for word-by-word doesnt work (spaces odd), so need to do MANY times.
	# Seeing what fonts/names is available: "identify -list font"
	function textMetrics($string, $font, $fontsize)
	{
		$im = new Imagick();

		$fontfile = $this->fontTTF[$font];#fontfile($font);
		#error_log("FONT FILE=$fontfile");
		$draw = new ImagickDraw();
		$draw->setFont("images/designs/fonts/$fontfile");
		$draw->setFontSize($fontsize); # This needs to be in pixels.
		# TOMAS_MALY XXX not right - too small....
		$metric = $im->queryFontMetrics($draw, $string, false);

		$lastchar = substr($string,-1);
		$lastCharMetric = $im->queryFontMetrics($draw, $lastchar, false);
		$firstchar = substr($string,0,1);
		$firstCharMetric = $im->queryFontMetrics($draw, $firstchar, false);

		$firstedge = $firstCharMetric['originX'];
		$lastedge = $lastCharMetric['maxHorizontalAdvance'] - $lastCharMetric['characterWidth'] - $lastCharMetric['originX'];


		#error_log("FIRST CHAR($firstchar) METRICS=".print_r($firstCharMetric,true));
		#error_log("LAST CHAR($lastchar) METRICS=".print_r($lastCharMetric,true));

		# DISABLED We need to compensate by removing the last char's right edge and first char's left edge
		# To get accurate "width" (175 vs 180) - that the web uses...

		/*
		if(false && $string == 'orem ipsum dolor sit amet, ')
		{
			$draw->setFillColor(new ImagickPixel('blue'));
			$draw->annotation(0,25, $string);
			$im->newImage($metric['textWidth'], $metric['textHeight']*2, new ImagickPixel('white'));
			$im->drawImage($draw);

			$im->setImageFormat("png");
			header("Content-Type: image/png");
			echo $im;
			exit(0);
		}
		*/
		#error_log("FOR ($font/$fontfile) $string, METRICS=".print_r($metric,true));
		return array($metric['textWidth'], $metric['textHeight'], $metric['characterWidth'], $metric['characterHeight'], $metric['boundingBox']);
		#-$firstedge-$lastedge, 
	}

	function fontfile($font)
	{
		$fontFamilies = $this->fontFamilies();
		#error_log("WANT $font IN+".print_r($fontFamilies,true));
		foreach($fontFamilies as $family=>$fontList)
		{
			if(in_array($font, $fontList))
			{
				$css = APP."/webroot/fonts/$family/stylesheet.css";
				$style = file_get_contents($css);
				$pos = strpos($style, $font);
				# Find next instance of '.ttf' after style mentioned.
				preg_match("/url\('([^']+[.]ttf)'\)/", $style, $match, 0, $pos);
				if(!empty($match[1]))
				{
					return APP."/webroot/fonts/$family/$match[1]";
				}
			}
		}
		return false;
	}

	function xpath($svg, $path)
	{
		$xpath = new DOMXPath($svg->ownerDocument);
		$nodelist = $xpath->query($path);
		if(!$nodelist->length)
		{
			return array();
		}
		$nodes = array();
		for($i = 0; $i < $nodelist->length; $i++)
		{
			$nodes[] = $nodelist->item($i);
		}
		return $nodes;
	}

	function xpathOne($svg, $path)
	{
		$nodelist = $this->xpath($svg, $path);
		return !empty($nodelist) ? $nodelist[0] : null;
	}

	function get_coords($svg, $id) # Rect or image
	{
		$objs = $this->xpath($svg, "//svg:image[@id='$id']|//svg:rect[@id='$id']");
		if(empty($objs)) { return array(); }
		$obj = $objs[0];

		#return array($obj['x'], $obj['y'], $obj['width'], $obj['height']);
		return array($obj->getAttribute('x'), $obj->getAttribute('y'), $obj->getAttribute('width'), $obj->getAttribute('height'));
	}

	function mime($url)
	{
		#return mime_content_type($url);

		###################

		$mt = new MIME_Type();
		$mime = $mt->autoDetect($url);
		#
		#$finfo = finfo_open(FILEINFO_MIME_TYPE);
		#$mime = finfo_file($finfo, $url);
		return $mime;
	}

	function set_image($svg, $id, $url, $x=null,$y=null,$w=null,$h=null, $imageCrop = null, $template = 'standard')
	{
		#error_log("ID=$id, X=$x, Y=$y");
		# Make url absolute
		#$absurl = "http://".$_SERVER['HTTP_HOST']."$url";
		$absurl = APP."/webroot$url";

		#error_log("ADDING IMG TO $id, URL=$absurl");
		# Default w/h is whole container.
		#$imgs = $svg->xpath("//svg:image[@id='$id']");
		$imgs = $this->xpath($svg, "//svg:image[@id='$id']");

		if(empty($imgs))
		{
			#error_log("COULD NOT FIND $id");
			return;
		}
		$img = $imgs[0];

		#error_log("IMGNODE=".print_r($img,true));

		#error_log("FOR $id, URL=$url");

		if(empty($url)) # Hide if null passed.
		{
			#$this->deleteNode($imgs);
			#########$this->deleteNode($img);
			#$this->setAttribute($img, array("xlink","href"), null);
			$absurl = APP."/webroot/images/trans.gif"; # Seems the only way for illustrator to not barf and yet libxml to not cut off xml on large pics....
		}
		#} else {
			# Change link.
			# NOW embed.

			#error_log("ABSURL=$absurl");

			$imgfile = file_get_contents($absurl);
			$imgmime = $this->mime($absurl);
			$base64_data = base64_encode($imgfile);
			$href = "data:$imgmime;base64,$base64_data";

			#$img->attributes("xlink",true)->href = $href;
			$this->setAttribute($img, array("xlink","href"), $href);

			#error_log("ABSURL=$absurl, MIME=$imgmime,B64=$base64_data");
	
			# Maybe change x, y, width/height. OR keep as is, if fixed.
			if(!empty($x)) { $this->setAttribute($img,'x', $x); }
			if(!empty($y)) { $this->setAttribute($img,'y', $y); }
			if(!empty($w)) { $this->setAttribute($img,'width', $w); }
			if(!empty($h)) { $this->setAttribute($img,'height', $h); }

			if($this->getAttribute($img,'clip-path') && !empty($this->params['named']['print']))
			{
				$this->setAttribute($img, 'clip-path', "url(#clipFullbleedPrint)");
			}
		#}
	}

	function getAttribute($node, $attr)
	{
		return $this->attr($node,$attr);
	}
}
