<?php
include(dirname(__FILE__)."/../../includes/NSimageClass.inc");
include(dirname(__FILE__)."/../../includes/classDefinitions.inc");


include_once("cart_items_controller.php");
class BuildController extends CartItemsController {

	var $name = 'Build';
	var $helpers = array('Html', 'Form','Ajax');
	var $uses = array("Product", "ProductPart", "GalleryImage", "CustomImage", "CustomizationOption", "ProductRecommendedQuote", "ImageRecommendedQuote",'Quote','Tassel','Charm','Border','Frame','Ribbon','CartItem','StampSurcharge','OrderItem','Part','RecommendedQuote',"GalleryCategory","ProductQuote",'Client');
	var $options = array();
	var $real_only_product = false;
	var $title = 'Build Your Product';
	var $proof_cost = 25;

	var $imgonlys = array('imageonly','imageonly_nopersonalization');

	var $controller_crumbs = false;

	function beforeFilter()
	{
		error_log("BF");
		# XXX TRY HERE
		#error_log("SID0=".session_id());
		#error_log("IMG-2=".print_r($_SESSION,true));
		#error_log("IMG-1=".print_r($_SESSION['Build']['CustomImage'],true));
		#error_log("IMG0=".print_r($this->build['CustomImage'],true));
		switch($this->action)
		{
			case 'admin_add':
			case 'admin_edit':
			case 'add':
			case 'edit':
		}

		parent::beforeFilter(); # Where we define this->build (want above code to go first!)

		$this->styles[] = "/stylesheets/build.css";
		$this->scripts[] = "/javascript/build.js";

		error_log("BUILD=".print_r($this->build,true));


		$this->load_item(); # This needs to be before we set explicit params, so db gets overridden

		error_log("LOADED");


		#error_log("START CROP=".(!empty($this->build['crop']) ? print_r($this->build['crop'],true) : null));

		if (isset($_REQUEST['rotate']))
		{
			$this->build['rotate'] = $_REQUEST['rotate'];
			#error_log("SAVING BUILD ROTATE=".print_r($this->build['crop'],true));
			$this->Session->write("Build", $this->build);
		}


		if (!empty($_REQUEST['reset_coords']))
		{
			$this->build['crop'] = null;
			$this->Session->write("Build", $this->build);

		#error_log("RESET COORDS CROP=".(!empty($this->build['crop']) ? print_r($this->build['crop'],true) : null));
		}


		#error_log("IMG5=".print_r($this->build['CustomImage'],true));

		# Needs to be passed explicitly as a parameter (query string) so saved before template, etc other ops.

		if(!empty($_REQUEST['prod']))
		{
			$prod = $_REQUEST['prod'];
			error_log("SET_BP");
			$this->set_build_product($prod);
		}


		if(!empty($_REQUEST['productCode']))
		{
			$prod = $_REQUEST['productCode'];
			$this->set_build_product($prod);
		}
		if(in_array($this->action, array('create','customize')) && !empty($this->params['pass'][0]))
		{
			$this->set_build_product($this->params['pass'][0]);
		}

		if(empty($this->params['isAjax']) && empty($this->build['Product'])) { $this->redirect("/products/select"); }
		/*
		if(empty($this->build['Product']))
		{
			$this->redirect("/products/select");
		}
		*/
		error_log("OK SO FAR");


		# XXX TODO LETS YOU SPECIFY PRODUCT/IMAGE FROM PARAMETERS...
		#
		#
		#
		#
		if (!empty($_REQUEST['catalogNumber']))
		{
			$catalog_number = $_REQUEST['catalogNumber'];
			$this->set_stamp_image($catalog_number);
		}

		if (!empty($_REQUEST['catalog_number']))
		{
			$catalog_number = $_REQUEST['catalog_number'];
			$this->set_stamp_image($catalog_number);
		}

		#error_log("REQUEST CALLING SET_TEMPLATE=".print_r($_REQUEST,true));

		if(!empty($_REQUEST['fullbleed']))
		{
			error_log("STFB");
			$template = 'fullbleed';
			$this->set_template($template);
		} else if (!empty($_REQUEST['template']))
		{
			$template = $_REQUEST['template'];
			error_log("ST=$template");
			$this->set_template($template);
		} else if(!empty($_REQUEST['layout'])) {
			$template = $_REQUEST['layout'];
			error_log("LAY=$template");
			$this->set_template($template);
		} else if(empty($this->build['template'])) {
			$this->set_template();
			error_log("EBT");
		} else if (!empty($this->build['preview_layout'])) {
			$this->set_template($this->build['preview_layout']);
			error_log("STPL=".$this->build['preview_layout']);
			unset($this->build['preview_layout']);
			$this->Session->write("Build", $this->build);
		}

		if(!empty($_REQUEST['options']))
		{
			foreach($_REQUEST['options'] as $k => $v)
			{
				#error_log("SETTING $k=$v");
				$this->build['options'][$k] = $v;
			}
		}

		# XXX TOMAS_MALY
		if (!empty($_REQUEST['clear']) || !empty($_REQUEST['new']))

		$this->Session->write("Build", $this->build); # SAVE!

		if(!empty($_REQUEST['screenshot']))
		{
			$_REQUEST['image_id'] = 2754;
			# Load fake custom image.
			$this->set("screenshot", true);
			$this->set("step", "all"); # open all steps
		}



		if (!empty($_REQUEST['image_id'])) 
		{
			#error_log("IMG_ID SET");
			$imageID = $_REQUEST['image_id'];
			$custom_image = $this->CustomImage->read(null, $imageID);
			$this->Session->write("Build.imageID", $_REQUEST['image_id']);
			$this->Session->write("Build.CustomImage", $custom_image['CustomImage']);

			$this->Session->delete("Build.catalog_number"); # Don't need to use anymore.
			$this->Session->delete("Build.GalleryImage"); # Don't need to use anymore.
			$this->build = $this->Session->read("Build");
		}

		if (isset($_REQUEST['orient']) && !empty($this->build['CustomImage']))
		{
			$this->build['CustomImage']['orient'] = $_REQUEST['orient'];
			$this->CustomImage->save(array('CustomImage'=>$this->build['CustomImage']));
			$this->Session->write("Build", $this->build);

			$src = $this->build['CustomImage']['Image_Location'];
			$dest = $this->build['CustomImage']['display_location'];
			$width = 350;
			$rc = $this->Image->scaleFile($src, $dest, $width, null, 1, $this->build['CustomImage']['orient']);
		#	#error_log("SAVIN $src TO $dest");

		}

		#error_log("IMG6=".print_r($this->build['CustomImage'],true));

		# Let us pass
		#print_r($this->params);

		#if(!empty($this->params['pass'][0]) && ($this->action == 'customize' || $this->action == 'create'))
		#{
		#	$prod = $this->params['pass'][0]; # Handle odd case where we pass product as param, but need to know it in beforeFilter
		#	$this->set_build_product($prod);
		#}


		if (!empty($_REQUEST['fullbleed']))
		{
			if(empty($this->build['crop']['imageonly']) || empty($this->build['options']['fullbleed']))
			{
				$this->default_imageonly_crop(); # To set coordinates to a default.
			} else if (empty($_REQUEST['fullbleed'])) { 
				# Clear coordinates
				#unset($this->build['crop']);# = null;#array();
			}

			$this->build['options']['fullbleed'] = $_REQUEST['fullbleed'];
		}

		#error_log("IMG7=".print_r($this->build['CustomImage'],true));

   		$layouts = array();                                                     
                if(!empty($this->build['Product']['image_and_text'])) { $layouts[] = 'standard'; }
                if(!empty($this->build['Product']['imageonly'])) { $layouts[] = 'imageonly'; }
                if(!empty($this->build['Product']['fullbleed']) && empty($this->build['Product']['imageonly'])) { $layouts[] = 'imageonly'; }

		if(empty($this->build['options']))
		{
			#if(!empty($this->build['GalleryImage']) || count($layouts) <= 1)
			#{
				$this->build['options'] = array();
			#} else { #Only shut off if can re-enable.
			#	$this->build['options'] = array('personalizationNone'=>1);
			#}
			# DEFAULT to no personalization....
		}

		$is_stamp = !empty($this->build['GalleryImage']);

		$this->real_only_product = false;


		# Load generic stuff here....
		$this->set("counter", 0);

		if(!empty($this->build['GalleryImage']))
		{
			unset($this->build['options']['fullbleed']); # Make full bleed on a stamp impossible.
		}

		$this->Session->write("Build", $this->build); #Save changes.


		 if (!empty($_REQUEST['new']))
		 #This needs to be way down here so we let params be saved first.
		 {
			# Redirect to self w/o params so when we go back from cart, we dont accidentally clear from query string.
			$params = !empty($this->params['pass']) ? join("/", $this->params['pass']) : '';
			$this->redirect("/build/customize/".$params);
		}


		$product_name = "";

		# load image
		if (!empty($this->build['CustomImage']))
		{
			#error_log("IMG11=".print_r($this->build['CustomImage'],true));
			#echo "CI=".print_r($this->build['CustomImage'],true);
			$imageID = $this->build['CustomImage']['Image_ID'];
			$image_object = new CustomImageObject();
	 		if ( strpos($imageID, 't') !== false ) {
	                       	$image_object->initFromArray($imageID);
	                } else {
	                       	$image_object->initFromDB($imageID, $this->database);
	                }
			$this->set("image", $image_object);
			##error_log("IMG1=".print_r($this->viewVars['image'],true));
		}

		if (!empty($this->build['GalleryImage']))
		{
			$catalogNumber = $this->build['GalleryImage']['catalog_number'];
			$stamp_object = new StampObject();
			$stamp_object->initFromDB($this->build['GalleryImage']['catalog_number'], $this->database);

			#$this->set("stamp", (object)$this->build['GalleryImage']);
			$stamp_surcharge = ($catalogNumber) ? $this->StampSurcharge->find("Catalog_number = '$catalogNumber'") : null;
			$this->set("stamp_surcharge", $stamp_surcharge);
			$this->set("image", $stamp_object);
			##error_log("IMG2=".print_r($this->viewVars['image'],true));
		}

		if(empty($this->viewVars['image']) && $this->action == 'customize' && $this->build['template'] != 'textonly')
		{
			$this->redirect("/gallery");
		}

		#$this->set("rightbar_template", "build/rightbar");

	}

	function default_imageonly_crop()
	{
		$productCode = $this->build['Product']['code'];
		if(!empty($this->build['CustomImage']))
		{
			$image_path = APP."/webroot/". $this->build['CustomImage']['display_location'];
		} else if (!empty($this->build['GalleryImage'])) {
			$image_path = APP."/../".$this->build['GalleryImage']['image_location'];
		}
		$orient = $this->get_image_orientation($image_path);
		$product_config = $this->get_product_config($productCode, $orient, true);
		$cropdata = $this->get_build_crop_info('imageonly', $product_config, $this->build, true);
		$x = $cropdata['bestfit']['x'];
		$y = $cropdata['bestfit']['y'];
		$w = $cropdata['bestfit']['w'];
		$h = $cropdata['bestfit']['h'];
		$this->build['crop']['imageonly'] = array($x,$y,$w,$h);
		$this->Session->write("Build", $this->build);
	}

	function product_can_do_image() # Needs to be called in methods, AFTER product is selected!
	{
		# If we can't do custom image on product, redirect to ask about product....
		if (!empty($this->build['CustomImage']) && !empty($this->build['Product']) && !preg_match("/custom/", $this->build['Product']['image_type']))
		{
			$this->Session->delete("Build.Product");
		#	error_log("R222");
			$this->redirect("/products/select");
		}
	}

	function save()
	{
		$this->Session->setFlash("Please login or signup for an account to save your design.");
		$this->Session->write("savegoto", $_SERVER['HTTP_REFERER']);
		$this->redirect("/saved_items/add");
	}

	function save_ajax()
	{
		if(!empty($this->data))
		{
			foreach($this->data['options'] as $k => $v)
			{
				$this->build['options'][$k] = $v;
			}
			$this->Session->write("Build", $this->build);
		}
		echo "OK";
		exit(0);
	}

	function ajax_save_coords() # MUCH simpler, since we have FULL-sized coords.
	{
		#error_log("REQUEST=".print_r($_REQUEST,true));
		#error_log("DATA=".print_r($this->data,true));
		if(!empty($this->data))
		{
			$layout = $this->data['layout'];
			$bestfit = !empty($this->build['options']['fullbleed']);
			# ? scale wrong (not properly loaded on reload page?)
			if(isset($this->data['rotate']))
			{
				$this->build['rotate'] = $this->data['rotate'];
				if($this->build['rotate'] == 90 || $this->build['rotate'] == 270)
				{
					# Switch w,h around.
					$w = $this->data['h'];
					$h = $this->data['w'];
					#$this->data['w'] = $w;
					#$this->data['h'] = $h;
					# May be fixed later...
				}
			}
			#error_log("SAVING_COORDS=".print_r($this->data,true));  # w > h ?
			$cropinfo = array($this->data['x'], $this->data['y'],$this->data['w'], $this->data['h'], $bestfit);
			if($layout == 'imageonly_nopersonalization') { $layout = 'imageonly'; }

			$this->build['crop'][$layout] = $cropinfo;
			$this->Session->write("Build", $this->build);
		}

		echo "OK";
		Configure::write("debug", 0);
		exit(0);
	}

	function crop_ajax($layout = 'standard')
	{
		Configure::write("debug", 0);
		$data = $this->get_build_crop_info($layout);
		if (!empty($this->data))
		{
		#	error_log("CROP=".print_r($this->data,true));
			#$layout = $this->data['layout'];
			if($layout == 'fullbleed')
			{
				$this->build['options']['fullbleed'] = 1;
				$layout = 'imageonly';
			}
			$imgid = $this->build['CustomImage']['Image_ID'];
			$productCode = $this->build['Product']['code'];
			$fullview = ($layout == 'imageonly');
			#error_log("IMG_DL=".$this->build['CustomImage']['display_location']);
			$orient = $this->get_image_orientation(APP."/webroot/".$this->build['CustomImage']['display_location']);
			list($img_w,$img_h) = getimagesize(APP."/webroot/".$this->build['CustomImage']['display_location']);
		##	error_log("LAY=$layout, FV=$fullview, OR=$orient");
		#	error_log("LAY=$layout, FV=$fullview, OR=$orient");
		#	error_log("DATA=".print_r($data,true));

			#error_log("OR2=$orient");
			$product_config = $this->get_product_config($productCode, $orient, $fullview);
			#error_log("CODE=$productCode, OR=$orient (".$this->build['CustomImage']['display_location']."), FV=$fullview (LAY=$layout), PC=".print_r($product_config,true));
			
			# Get this to scale properly to original image size...
			#$scale = $data['upload']['scale_factor']; # thumb/orig
			#$scale_w = $this->data['scale_w'];
			$scale_w = 175;
			$scale = $img_w / $scale_w;
		#	error_log("SCALE=$img_w, SCALED_W=$scale_w");

			#$scale = $data['upload']['scale_factor']; # thumb/orig

			$x = ceil($this->data['x'] * $scale);
			$y = ceil($this->data['y'] * $scale);
			$w = ceil($this->data['w'] * $scale);
			$h = ceil($this->data['h'] * $scale);
			#$bestfit = !empty($this->data['bestfit']) ? $this->data['bestfit'] : null;
			$bestfit = !empty($this->build['options']['fullbleed']);
			$w2h = $w/$h;

			# Now make sure we're not off because of a scaled down version....
			if ($bestfit) # Width AND height must fit 'fullview'/'image'
			{
				# Stretch until at or beyond canvas size...
				$image_data = $product_config['image'];
				if(!empty($product_config['fullbleed']))
				{
					$image_data = $product_config['fullbleed'];
				}
				else if(!empty($product_config['fullview']))
				{
					$image_data = $product_config['fullview'];
				}
				list($image_x,$image_y,$image_w,$image_h) = $image_data;
				$image_w2h = $image_w/$image_h;

				# We need to consider when an image is smaller than the canvas....
				# What we're really looking for is appropriate proportions....

				# fit it by width. If height not enough, fit it by height.
				# if width not big enough, fit it by width.

				# KEEP THE PROPORTIONS of the view area....


				$new_w = $w;
				$new_h = ceil($new_w / $image_w2h);

				#error_log("W2H=$w2h, W=$w, H=$h; IMAGE_W2H=$image_w2h, NEW_W=$new_w,, NEW_H=$new_h");


				if ($new_h > $h)
				{
					$new_h = $h;
					$new_w = ceil($new_h * $image_w2h);
				}

				if ($new_w > $w)
				{
					$new_w = $w;
					$new_h = ceil($new_w / $image_w2h);
				}
				$w = $new_w;
				$h = $new_h;
			} else {
				# Make sure 'fullfit' matches width  height.
				# For fullfit, match width if height at or larger
				# Make sure whole thing fits within, as much height and width permits (while still fitting whole thing)

				# Stretch until at or beyond canvas size...
				#$image_data = (!empty($product_config['fullview'])  && $layout == 'imageonly') ? $product_config['fullview'] : $product_config['image'];
				#list($image_x,$image_y,$image_w,$image_h) = $image_data;
				#$image_w2h = $image_w/$image_h;

				# We need to consider when an image is smaller than the canvas....
				# What we're really looking for is appropriate proportions....

				# If ratio not right, trim the longer side.

				#if ($w > $h)
				#{
				#	$h = floor($w / $image_w2h);
				#} else {
				#	$w = floor($h * $image_w2h);
				#}

			}

			$cropinfo = ($w > 0 && $h > 0) ? array($x,$y,$w,$h,$bestfit) : null;

		#	error_log("CROP_INFO_NOW ($layout)=".print_r($cropinfo,true));

		#	error_log("LAY=($layout)=".print_r($cropinfo,true));
			if($layout == 'imageonly_nopersonalization') { $layout = 'imageonly'; }
			$this->build['crop'][$layout] = $cropinfo;
			$this->Session->write("Build", $this->build);
			#$this->Session->write("Build.crop.$imgid.$productCode.$layout", array($x,$y,$w,$h));
			# someday??

			# May or may not go to here.... (may just be a popup!)
			#$this->redirect("/build/create");
		}
		#$this->set("template", $layout);
		#$this->crop($layout);
		$this->layout = 'ajax';
		#echo "OK";
		#exit(0);
	}

	function crop($layout = 'standard')
	{
		$this->layout = 'default_plain';
		$this->body_title = "";
		if($layout == 'imageonly_nopersonalization') { $layout = 'imageonly'; }
		$crop_info = !empty($this->build['crop'][$layout]) ? $this->build['crop'][$layout] : null;
		$data = array();

		if ($crop_info)
		{
			list($x,$y,$w,$h) = $crop_info;
			$w2h = $w/$h;
			//error_log("CROP_INFO=".print_r($crop_info,true));
			# We need to FORCE proper ratio! in case gets wacky....
			$bestfit = !empty($crop_info[4]) ? 1 : 0;
			if ($bestfit) # Best fit set.... need to force proportions...
			{

				$fullview = ($layout == 'imageonly');
				$prod = $this->build['Product']['code'];
				$image_path = $this->build['CustomImage']['display_location'];
				$orient = $this->get_image_orientation($image_path);
				list($image_w,$image_h) = getimagesize(APP."/webroot/$image_path");
				$src_image_w2h = $image_w/$image_h;
				$product_config = $this->get_product_config($prod, $orient, $fullview);

				#error_log("PRODCONFIG=".print_r($product_config,true));

				$image_area = $product_config['image'];

				if(!empty($product_config['fullbleed']) && !empty($this->build['options']['fullbleed']))
				{
					$image_area = $product_config['fullbleed'];
				}
				else if(!empty($product_config['fullview']))
				{
					$image_area = $product_config['fullview'];
				}

				$image_w2h = $image_area[2] / $image_area[3];

				#error_log("IMAGE_AREA ($image_w2h VS $w2h )=".print_r($image_area,true));
				#error_log("IMAGE IS=$image_w, $image_h ($src_image_w2h)");

				$test_w = $w;
				$test_h = ceil($test_w / $image_w2h);

				if ($test_h+$y > $h)
				{
					$test_h = $h-$y;
					$test_w = ceil($test_h * $image_w2h);
				}

				if ($test_w+$x > $w)
				{
					$test_w = $w-$x;
					$test_h = ceil($test_w / $image_w2h);
				}

				# Disabled for now!

			}
		}

			$data = $this->get_build_crop_info($layout, null, null, $crop_info);

			#echo "D=".print_r($data,true);

			if ($layout == 'imageonly')
			{

				list(
					$data['upload']['scaled_start_x'],
					$data['upload']['scaled_start_y'],
					$data['upload']['scaled_start_width'],
					$data['upload']['scaled_start_height']
				) = $crop_info;
			} else if ($layout == 'standard') {
				list(
					$data['upload']['start_x'],
					$data['upload']['start_y'],
					$data['upload']['start_width'],
					$data['upload']['start_height']
				) = $crop_info;

			}

		#$this->layout = 'default_plain';
		#Configure::write("debug", 0);

		$prod = $this->build['Product']['code'];
		$orient = $this->get_image_orientation($this->build['CustomImage']['thumbnail_location']);

		$product_image_dir = $this->get_product_image_dir($prod, $orient, ($layout && $layout != 'standard'), true);


		$overlay_path = "$product_image_dir/original/$prod-overlay.gif";

		#echo "PID=$overlay_path";

		$this->set("overlay_path", file_exists(dirname(__FILE__)."/../../".$overlay_path) ? $overlay_path : null);

		#print_r($data);
		$this->set("data", $data);

		$this->set("image_w2h", $image_w2h);
		$this->set("template", $layout);
		return $data;
	}



	function preview()
	{
		#error_log("UPDATING FORM PREVIEW OUT TO SAVE");

		#error_log("PREV=".print_r($_REQUEST,true));
		$this->Product->link_product_details();
		Configure::write("debug", 0);
		$this->layout = 'ajax';
		$product = $this->build['Product'];
		$quantity = !empty($this->data['quantity']) ? $this->data['quantity'] : null;
		$proof_only = !empty($this->data['proof_only']) ? $this->data['proof_only'] : null;

		$parts = $this->data['options'];

		if (!empty($this->data['options']))
		{
			# This is erasing fullbleed for other minor options
			foreach($this->data['options'] as $opt => $val)
			{
				$this->build['options'][$opt] = $this->data['options'][$opt];
			}
			##error_log("OPTIONS=".print_r($this->data['options'],true));
			if(isset($this->data['options']['personalization_logo_id']) &&
				empty($this->data['options']['personalization_logo_id']))
			{
				unset($this->build['PersonalizationLogo']);
			}
			unset($this->build['saved']);
			$this->Session->write("Build", $this->build);
		}

		$this->set("build_preview", true);
		if(!empty($this->params['form']['vertical_preview'])) { $this->set("vertical", true); }
		$this->set("build", $this->build);
	}

	function set_template($template = null)
	{
		#error_log("******** SET TEMP=$template **************, currently=".(!empty($this->build['template']) ? $this->build['template'] : null));
		if(empty($template) && !empty($this->build['CustomImage'])) 
		{ 
			$template = $this->config['default_custom_image_layout']; # SANER DEFAULT
		}
		if(empty($template)) { $template =  'standard'; error_log("TEM333=$template"); }
		# full bleed is a separate checkbox, not part of template name. 

		$this->options = $this->load_product_options();

			$cant_do_standard = true;
			foreach($this->options as $opt)
			{
				if($opt['Part']['part_code'] == 'quote')
				{
					$cant_do_standard = false;
					break;
				}
			}
		error_log("PROD={$this->build['Product']['code']}");
		error_log("OPTS=".print_r($this->options,true));
		error_log("CANT DO STD+$cant_do_standard");

		if($template == 'standard' && $cant_do_standard)
		{
			$template = "imageonly_nopersonalization"; # Default to none; #!empty($this->build['options']['personalizationNone']) ? "imageonly_nopersonalization" : "imageonly";
			error_log("TMPL NOW=$template");
		}


		if($template == 'imageonly')
		{
			unset($this->build['options']['personalizationNone']); // clear.
			$this->build['options']['quoteNone'] = 1; 
		} else if($template == 'imageonly_nopersonalization') {
			$this->build['options']['personalizationNone'] = 1; 
			$this->build['options']['quoteNone'] = 1; 
			#$template = 'imageonly';
			# DONT CHECK MARK AND HIDE BOX UNLESS WE EXPLICITLY CLICK AND STORE FLAG.
			#$this->build['options']['personalizationNone'] = 1;
		} else { # STD
			$this->build['options']['personalizationNone'] = 0; 
			$this->build['options']['quoteNone'] = 0; 
		}

		$layout = $template;
		$old_template = !empty($this->build['template']) ? $this->build['template'] : null;
		if(!empty($this->build['options']['fullbleed'])) { $old_template = 'fullbleed'; }

		if($template == 'standard')
		{
			$this->build['options']['fullbleed'] = 0;
		}

		if(in_array($this->build['Product']['code'], array('B','BC','BNT','BB')) && empty($this->build['complete']['border'])) #!isset($this->build['options']['borderID']))
		# Only put in a border if not selected yet.
		{
			#error_log("CHANGING BORDER");
			if($template == 'standard')# && empty($this->build['options']['borderID']))
			{
				#unset($this->build['options']['borderID']);
				$this->build['options']['borderID'] = 2; # Set border when go back to standard....
			} else if (in_array($template, $this->imgonlys) || $template == 'fullbleed') { 
				$this->build['options']['borderID'] = -1;
				# Clear border when switch to imageonly...
				# only called when switching or starting out.
			}
		}

		if ($template == 'fullbleed')
		{
			if($old_template != 'fullbleed') # proportion is wrong.
			# Don't set via imageonly, then go to fb or to standard then fb.
			# will end up wrong.
			{
				unset($this->build['crop']['imageonly']);
			}
			$this->build['options']['fullbleed'] = 1;
			$template = 'imageonly';
		} else if($template == 'imageonly') {
			if(!in_array($old_template, $this->imgonlys))
			{ # proportion is wrong.
				unset($this->build['crop']['imageonly']);
			}
			$this->build['options']['fullbleed'] = 0;
			$template = 'imageonly';
		}

		if(!empty($this->build['options']['fullbleed']) && empty($this->build['Product']['fullbleed']))
		{
			# Can't do fullbleed, do imageonly
			$this->build['options']['fullbleed'] = 0;
			$template = 'imageonly';
		} else if($template == 'imageonly' && empty($this->build['options']['fullbleed']) && empty($this->build['Product']['imageonly'])) {
			if(!empty($this->build['Product']['fullbleed']))
			{
				$template = 'imageonly';
				$this->build['options']['fullbleed'] = 1;
			} else {
				$template = 'standard';
			}
		}
		#if(preg_match("/fullbleed/", $template))
		#{
		#	$this->build['options']['fullbleed'] = 1;
		#	$template = 'imageonly';
		#} else {
		#	$this->build['options']['fullbleed'] = 0;
		#}
		#error_log("SETTING TMPL=$template");
		$this->build['template'] = $template;
		$this->build['preview_layout'] = $layout; # So we stay consistent.
		$this->Session->write("Build", $this->build);
	}


	function set_stamp_image($catalogNumber)
	{
		#error_log("SET_STAMP_IMG!!!!!!!!!!!!!!!!!");
			$this->GalleryImage->recursive = 2;
			#$this->GalleryImage->unbindModel(array('hasOne'=>array('StampSurcharge')));
			#$this->GalleryImage->bindModel(array('hasOne'=>array('StampSurcharge'=>array('foreignKey'=>false,'conditions'=>'GalleryImage.catalog_number = StampSurcharge.catalog_number'))));

			#$stamp = $this->GalleryImage->find('first', array(
			#	'joins'=>array(
			#		array(
			#			'table'=>'stamp_surcharge',
			#			'alias'=>'StampSurcharge',
			#			'type'=>'inner',
			#			'foriegnKey'=>false,
			#			'conditions'=>'GalleryImage.catalog_number = StampSurcharge.catalog_number'
			#	)))
			#);
			#echo "FOO";
			$stamp = $this->GalleryImage->find("GalleryImage.catalog_number = '".$catalogNumber."'");
			$this->Session->delete("Build.imageID");
			$this->Session->delete("Build.CustomImage");

			$this->Session->write("Build.GalleryImage", $stamp['GalleryImage']);
			$this->Session->write("Build.catalog_number", $catalogNumber);
			$this->build = $this->Session->read("Build");
	}

	function initialize_product($prod = '')
	{
		$old_prod = !empty($this->build['Product']['code']) ? $this->build['Product']['code'] : null;
		#error_log("IP=$prod");
	#	#error_log("OLD=$old_prod, NEW=$prod");

		if (!empty($prod))
		{
			$this->set_build_product($prod);
			#error_log("SET_P=$prod");
		}

		if (!empty($this->build['Product']))
		{
			if($old_prod != $prod)
			{
				unset($this->build['complete']);
			}
		#	error_log("EMPTYING...................");
			#error_log("P=".print_r($this->build['Product'],true));
			$product_type_id = $this->build['Product']['product_type_id'];
			$prod = $this->build['Product']['prod'];
			$minimum = $this->build['Product']['minimum'];

			$quantity = !empty($this->build['quantity']) ? $this->build['quantity'] : $minimum;

			$sess_quantity = $this->Session->read('quantity');
			if(!empty($sess_quantity) && $sess_quantity > $quantity) # Load from form set on order.
			{
				$this->build['quantity'] = $sess_quantity;
				$this->Session->delete('quantity');
			}

			$image_type = $this->build['Product']['image_type'];
			$this->real_only_product = (preg_match("/real/", $image_type) && !preg_match("/repro/", $image_type));

			$this->options = $this->load_product_options();
			$this->all_options = $this->load_product_options(false, true);
			$this->set('options', $this->options);

			$real_only_stamp = (!empty($this->build['GalleryImage']) && $this->build["GalleryImage"]['reproducible'] == 'No');

			$real_stamp = $this->real_only_product || $real_only_stamp || (!empty($this->build['options']['reproductionStamp']) && strtolower($this->build['options']['reproductionStamp']) == 'no');

			if (empty($this->build['quantity']) || $this->build['quantity'] < $this->build['Product']['minimum'])
			{
				$this->build['quantity'] =  $this->build['Product']['minimum'];
			}
			$catalog_number = $this->Session->read("Build.GalleryImage.catalog_number");
			$this->GalleryImage->recursive = 2;
			$stamp_surcharge = $catalog_number ? $this->GalleryImage->find("GalleryImage.catalog_number = '$catalog_number'") : null;
			$parts = $this->load_build_parts();
			#echo "SS ($real_stamp) 9=".print_r($stamp_surcharge,true);
			#$this->build['quantity_price'] =  $this->Product->get_effective_base_price($this->build['Product']['code'], $this->build['quantity'], $this->Session->read("Auth.Customer"), $this->real_only_product?$stamp_surcharge:null, $parts);
			$price_list = $this->Product->get_effective_base_price($this->build['Product']['code'], $this->build['quantity'], $this->Session->read("Auth.Customer"), $real_stamp?$stamp_surcharge:null, $parts, $catalog_number);
			$this->build['quantity_price_list'] = $price_list;
			$retail_price_list = $this->Product->get_effective_base_price($this->build['Product']['code'], $minimum, null, $real_stamp?$stamp_surcharge:null, $parts, $catalog_number);
			$this->build['retail_price_list'] = $retail_price_list;
			$price = $price_list['total'];
			$this->build['quantity_price'] = $price;
			$this->Session->write("Build.quantity", $this->build['quantity']);
			$this->Session->write("Build.quantity_price", $this->build['quantity_price']);
			$this->Session->write("Build.quantity_price_list", $this->build['quantity_price_list']);
			$this->Session->write("Build.retail_price_list", $this->build['retail_price_list']);
			
			#############
			$this->load_build_options(); # Loads option_list, etc...
			$this->set("option_list", $this->option_list);

			#############
			$root_product = $this->build;
			if(!empty($this->build['Product']['parent_product_type_id']))
			{
				$root_product = $this->Product->read(null, $this->build['Product']['parent_product_type_id']);
			}
			$this->set("this_product", (object)$this->build['Product']);
			$this->set("rightbar_disabled", true);
			$product_name =  $root_product['Product']['short_name'];
			$this->set("product_name", $product_name);

			###########

			$image_name = "";
			if (isset($this->build['CustomImage']['Title']))
			{
				$image_name = $this->build['CustomImage']['Title'];
			} else if (isset($this->build['GalleryImage']['stamp_name'])) { 
				$image_name = $this->build['GalleryImage']['stamp_name'];
			}
			$this->set("image_name", $image_name);
	
			#$title = ($image_name ? "&quot;$image_name&quot; " : "").
			$title = $this->pluralize(ucwords($product_name));# . " &bull; Free personalization";

			$this->body_title = "Choose Options for Your " .ucwords($title);

	
			$this->Session->write("Build", $this->build);

			#$parent_product_id = $this->build['Product']['parent_product_type_id'];
			#$parent_product = !empty($parent_product_id) ? $this->Product->read(null, $parent_product_id) : null;
			$this->set("product", $this->build['Product']);
			#$this->set("parent_product", $parent_product);
		}

		$this->product_can_do_image();

		return !empty($this->build['Product']) ? $this->build['Product'] : null;
	}

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

		$this->set("current_build_step", 3);
		#$this->set("status_bar_template", "build/progress");
		# NO MORE WITH ONE-PAGER

		# ALWAYS RETRIEVE DATA AVAILABLE FOR CUSTOMIZATION.....

		# Quote
		#print_r($this->build['options']['quote']);
		if(isset($this->build['options']['quote']['quoteID']))
		{
			$this->build['options']['quote']['quoteID_data'] = 
				$this->Quote->read(null, $this->build['options']['quote']['quoteID']);
		}

		#echo "QIDD=".print_r($this->build['options']['quote']['quoteID_data'],true);

		# Ribbon

		if(isset($this->build['options']['ribbon']['ribbonID']))
		{
			$this->build['options']['ribbon']['ribbonID_data'] = 
				$this->Ribbon->read(null, $this->build['options']['ribbon']['ribbonID']);
		}

		# Border
		if(isset($this->build['options']['border']['customBorder'])) {
			#error_log("BORDER+DATA...");
			$this->build['options']['border']['borderID_data'] = 
				$this->Border->read(null, $this->build['options']['border']['customBorder']);
		} else if(!empty($this->build['options']['borderID'])) {
			$this->build['options']['border']['borderID_data'] = 
				$this->Border->read(null, $this->build['options']['borderID']);
		}

		# Frame
		if(!empty($this->build['options']['frame']['frameID'])) {
			$this->build['options']['frame']['frameID_data'] = 
				$this->Frame->read(null, $this->build['options']['frame']['frameID']);
		}
		
		# Handles
		if(!empty($this->build['options']['frame']['frameID'])) {
			$this->build['options']['frame']['frameID_data'] = 
				$this->Frame->read(null, $this->build['options']['frame']['frameID']);
		}
		
		# Tassel
		if(!empty($this->build['options']['tassel']['customTassel'])) {
			$this->build['options']['tassel']['tasselID_data'] = 
				$this->Tassel->read(null, $this->build['options']['tassel']['customTassel']);
		} else if(!empty($this->build['options']['tasselID'])) {
			$this->build['options']['tasselID_data'] = 
				$this->Tassel->read(null, $this->build['options']['tasselID']);
		} else {
			unset($this->build['options']['tassel']['tasselID_data']);
		}
		
		# Charm
		if(!empty($this->build['options']['charm']['customCharm'])) {
			$this->build['options']['charm']['charmID_data'] = 
				$this->Charm->read(null, $this->build['options']['charm']['customCharm']);
		} else if(!empty($this->build['options']['charmID'])) {
			$this->build['options']['charm']['charmID_data'] = 
				$this->Charm->read(null, $this->build['options']['charmID']);
		} else {
			unset($this->build['options']['charm']['charmID_data']);
		}

		$this->Session->write("Build", $this->build);

		$this->set("build", $this->build);
		$this->set("in_build", true);
		$this->set("template", $this->build['template']);
	}

	function cart()
	{
		$this->redirect("/build/customize"); # Only place we go now...
	}

	function update_quantity_old($step = '')
	{
		if (!$step) { $step = !empty($this->params['form']['step']) ? $this->params['form']['step'] : null; }
		if (!empty($this->params['form']['quantity']))
		{
			$quantity = $this->params['form']['quantity'];
			if ($quantity < $this->build["Product"]['minimum'])
			{
			 	$quantity = $this->build["Product"]['minimum'];
				$this->Session->write("Minimum quantity is " . $quantity);
			}
			$this->build['quantity'] = $quantity;

			$parts = $this->load_build_parts();
			$catalogNumber = $this->Session->read("Build.GalleryImage.catalog_number");
			$stamp_surcharge = !empty($catalogNumber) ? $this->GalleryImage->find("Catalog_number = '$catalogNumber'") : null;
			$unit_price_list = $this->Product->get_effective_base_price($this->build['Product']['code'], $this->build['quantity'], $this->get_customer(), $stamp_surcharge, $parts, $catalogNumber);
			$unit_price = $unit_price_list['total'];
			$this->Session->write("Build.quantity", $quantity);
			$this->Session->write("Build.quantity_price", $unit_price);
			$this->Session->write("Build.quantity_price_list", $unit_price_list);
		}
		$this->redirect($step != 'cart' ? "/build/step/$step" : "/build/cart");
	}

	function update_review() # Stuff at bottom of build
	{
		Configure::write("debug", 0);
		$this->ajax_update();
		$this->all_options = $this->load_product_options(false, true);
		$this->options = $this->load_product_options();
		$this->set("all_options_by_code", Set::combine($this->all_options, '{n}.Part.part_code','{n}'));
		$this->set("all_options", $this->all_options);
		$this->set("options", $this->options);
		#error_log("REVIEW=".print_r($this->build['options'],true));

		
		$prod = $this->build['Product']['prod'];
		$minimum = $this->build['Product']['minimum'];
		$parts = $this->build['options'];

		$real_only_stamp = (!empty($this->build['GalleryImage']) && $this->build["GalleryImage"]['reproducible'] == 'No');
		$real_stamp = $this->real_only_product || $real_only_stamp || (!empty($this->build['options']['reproductionStamp']) && strtolower($this->build['options']['reproductionStamp']) == 'no');

		$catalog_number = $this->Session->read("Build.GalleryImage.catalog_number");
		$this->GalleryImage->recursive = 2;
		$stamp_surcharge = $catalog_number ? $this->GalleryImage->find("GalleryImage.catalog_number = '$catalog_number'") : null;

		$price_list = $this->Product->get_effective_base_price($this->build['Product']['code'], $this->build['quantity'], $this->Session->read("Auth.Customer"), $real_stamp?$stamp_surcharge:null, $parts, $catalog_number);
		$this->build['quantity_price_list'] = $price_list;
		$retail_price_list = $this->Product->get_effective_base_price($this->build['Product']['code'], $minimum, null, $real_stamp?$stamp_surcharge:null, $parts, $catalog_number);
		$this->build['retail_price_list'] = $retail_price_list;


		$this->update_quantity(); # Change quantity, etc.

		$quantity = $this->build['quantity'];

		$this->Product->recursive = 2;
		$product = $this->Product->read(null, $this->build['Product']['product_type_id']);

		$next_tier = "";

		$i = 0;
		foreach($product['ProductPricing'] as $pricing)
		{
			if ($pricing['quantity'] > $quantity && $i+1 < count($product['ProductPricing']))
			{
				$next_tier = $pricing['quantity'];
				break;
			}
			$i++;
		}
		$this->set("next_tier", $next_tier);

		$this->set("build", $this->build);

	#	error_log("LOADING REVIEW, PROOF=".$this->build['proof']);
		$this->render("/elements/build/cart");
	}

	function ajax_update()
	{
		if(!empty($this->data))
		{
			#error_log("RECEIVED=".print_r($this->data,true));
			foreach($this->data as $k => $v)
			{
				if(is_array($v))
				{
					foreach($v as $ik => $iv)
					{
						$this->build[$k][$ik] = $iv;

					}
				} else {
				#	error_log("SETTING $k = $v");
					$this->build[$k] = $v;
				}
			}

			if(isset($this->data['options']['personalization_logo_id']) &&
				empty($this->data['options']['personalization_logo_id']))
			{
				unset($this->build['PersonalizationLogo']);
			}
		}
		$this->set("build", $this->build);

		#error_log("BUILD=".print_r($this->build['options'],true));

		# MISSINZG BORDER INFO....

		$this->Session->write("Build", $this->build);
	}

	function update_quantity() #$quantity = '') # Little ajax thingy....
	{
		$this->Product->link_product_details();
		#error_log("DATA=".print_r($this->data,true));
		#print_r($this->data);
		#exit(0);
		Configure::write("debug", 0);
		$this->layout = 'ajax';
		$product = $this->build['Product'];
		$quantity = !empty($this->data['quantity']) ? $this->data['quantity'] : null;
		$proof_only = !empty($this->data['proof_only']) ? $this->data['proof_only'] : null;

		$parts = $this->data['options'];
		#print_r($this->data);

		$this->set("proof_cost", $this->proof_cost);

		$proof = !empty($this->data['proof']) ? $this->data['proof'] : null;
		$this->build['proof'] = $proof;
	#	error_log("SETTING PROOF TO $proof");

		$setup_charge = null;

		if (!empty($quantity))
		{
			if (!empty($this->data['options']['quantity_size']))
			{
				$this->build['options']['quantity_size'] = $this->data['options']['quantity_size'];
				$quantity = 0;
				$this->build['size'] = array();

				foreach($this->data['options']['quantity_size'] as $size => $qty)
				{
					$this->build['options']['size'][$size] = $qty;

					$quantity += $qty;
					if($productCode == 'TS' && !empty($this->build['Product']["surcharge_$size"]))
					{
						if(empty($setup_charge)) { $setup_charge = 0; }
						$setup_charge += $product['Product']["surcharge_$size"] * $qty;
					}
				}
				$this->Session->write("Build", $this->build);
			}

			if ($quantity < $product['minimum']) { $quantity = $product['minimum']; }
			$this->build['quantity'] = $quantity;
			$this->build['proof_only'] = $proof_only;
			$this->build['proof'] = $proof;
			#$this->Session->write("Build.quantity", $quantity);
			#$this->Session->write("Build.proof_only", $proof_only);
			#$this->Session->write("Build.proof", $proof);


			
			#$parts = $this->load_build_parts();
			$catalogNumber = $this->Session->read("Build.GalleryImage.catalog_number");
			#$stamp_surcharge = !empty($catalogNumber) ? $this->StampSurcharge->find("Catalog_number = '$catalogNumber'") : null;
			$this->GalleryImage->recursive = 2;
			$stamp = !empty($catalogNumber) ? $this->GalleryImage->find("GalleryImage.catalog_number = '$catalogNumber'") : null;
			#echo "SUR=".$stamp['StampSurcharge'];
			#$quantity_price_list =  $this->Product->get_effective_base_price($this->build['Product']['code'], $quantity, $this->Session->read("Auth.Customer"), $stamp_surcharge, $parts);
			#error_log("WOOT=".print_r($parts,true));

			$quantity_price_list =  $this->Product->get_effective_base_price($this->build['Product']['code'], $quantity, $this->Session->read("Auth.Customer"), $stamp, $parts, $catalogNumber);
			$quantity_price = !empty($proof_only) ? 25: $quantity_price_list['total'];
			$this->build['quantity_price'] = $quantity_price;
			$this->build['quantity_price_list'] = $quantity_price_list;
			if(!empty($setup_charge)) { $this->build['quantity_price_list']['surcharge'] = $setup_charge; }

			$this->Session->write("Build", $this->build);
		}

		$this->set("build", $this->build);
	}

	function update_pricing_chart() #$quantity = '') # Little ajax thingy....
	{
		$this->Product->link_product_details();
		#error_log("DATA=".print_r($this->data,true));
		#print_r($this->data);
		#exit(0);
		Configure::write("debug", 0);
		$this->layout = 'ajax';
		$product = $this->build['Product'];
		$quantity = !empty($this->data['quantity']) ? $this->data['quantity'] : null;
		$proof_only = !empty($this->data['proof_only']) ? $this->data['proof_only'] : null;

		$parts = $this->data['options'];
		#print_r($this->data);

		# Clear logo if pers text.
		if(isset($this->data['options']['personalization_logo_id']) &&
			empty($this->data['options']['personalization_logo_id']))
		{
			unset($this->build['PersonalizationLogo']);
			$this->Session->delete("Build.PersonalizationLogo");
		}

		# Save parts!
		$this->Session->write("Build.options", $parts);

		$this->set("proof_cost", $this->proof_cost);

		if (!empty($quantity))
		{
			if ($quantity < $product['minimum']) { $quantity = $product['minimum']; }
			$this->Session->write("Build.quantity", $quantity);
			$this->Session->write("Build.proof_only", $proof_only);
			#$parts = $this->load_build_parts();
			$catalogNumber = $this->Session->read("Build.GalleryImage.catalog_number");
			#$stamp_surcharge = !empty($catalogNumber) ? $this->StampSurcharge->find("Catalog_number = '$catalogNumber'") : null;
			$this->GalleryImage->recursive = 2;
			$stamp = !empty($catalogNumber) ? $this->GalleryImage->find("GalleryImage.catalog_number = '$catalogNumber'") : null;
			#echo "SUR9=".print_r($stamp['StampSurcharge'],true);
			#$quantity_price_list =  $this->Product->get_effective_base_price($this->build['Product']['code'], $quantity, $this->Session->read("Auth.Customer"), $stamp_surcharge, $parts);
			$quantity_price_list =  $this->Product->get_effective_base_price($this->build['Product']['code'], $quantity, $this->Session->read("Auth.Customer"), $stamp, $parts, $catalogNumber);
			#print_r($quantity_price);
			$quantity_price = !empty($proof_only) ? 25: $quantity_price_list['total'];
			$this->Session->write("Build.quantity_price", $quantity_price);
			$this->Session->write("Build.quantity_price_list", $quantity_price_list);
	
			$this->build = $this->Session->read("Build");
		}

		$this->set("build", $this->build);

		$price_list = $this->get_effective_base_price_list();
		$this->set("price_list", $price_list);

	}

	function ajax_notice()
	{
		$this->layout = 'ajax';
	}

	function ajax_complete_step($step)
	{
		Configure::write("debug", 0);
		$this->layout = 'ajax';

		$step = preg_replace("/^step_/", "", $step);
		$this->build['complete'][$step] = true;
		if(!empty($this->build['saved']))
		{
			unset($this->build['saved']);
		}
		$this->Session->write("Build", $this->build);

		echo "OK";
		exit(0); # We don't need to show a template!
	}

	function ajax_set_step($step)
	{
		Configure::write("debug", 0);
		$this->layout = 'ajax';

		$this->build['step'] = $step;
		$this->Session->write("Build", $this->build);

		echo "OK";
		exit(0); # We don't need to show a template!
	}

	function create_ajax($prod = '')
	{
		#Configure::write("debug", 0);
		$this->layout = 'ajax';

		if (!empty($this->data['template']))
		{
			$this->build['template'] = $this->data['template'];

			# This should affect what options are shown....
			# UPDATE! $this->options !
			#$this->options = $this->load_product_options();
		}

		if (!empty($this->data['options']))
		{
			$this->build['options'] = $this->data['options'];
			$this->Session->write("Build", $this->build);
		}

		$this->set("build", $this->build);

		#$this->action = 'create';
		$this->action = 'customize';

		$this->_create($prod);
	}

	function create($prod = '')
	{
		$this->set("stepname", "layout");
		# Here, now we ask for the template/layout.
		#error_log("SID00=".session_id());
		#error_log("IMG=".print_r($this->build['CustomImage'],true));
		#error_log("ME=".print_r($_SESSION['Build'],true));
		$this->initialize_product($prod);
		#$this->redirect("/build/customize/$prod");
		#$this->_create($prod);
		$type = !empty($this->build['Product']) ? strtolower($this->build["Product"]['name']) : "product";
		$this->Product->recursive = 1;
		$this->Product->link_related_products();
		$product = $this->Product->find(" code = '$prod' ");



		$this->body_title = "Choose a $type layout:";

		$this->build['options'] = array(); # Clear stuff from before, since we could be making a new product.
		# MEsses up fullbleed....

		if (!empty($this->build['GalleryImage'])) #
		{
			# Clear layout and choices...
			#if(empty($_REQUEST['template']))
			#{
			#	$this->build['template'] = 'standard';
			#}
			#$this->build['options'] = null;
			# DONT ERASE OPTIONS IN CASE WE'RE DOING BNT
			$this->Session->write("Build", $this->build);
			#if (!empty($product['AllRelatedProducts']) && empty($_REQUEST['customize'])) { # We need to allow them to choose which variety...
				#$this->redirect("/build/choose_product_type/$prod"); # Skip template choosing if stamp.
			#} else {
				$this->redirect("/build/customize/$prod"); # Skip template choosing if stamp.
			#}
		}

		# Forget all this....

		#if(empty($this->build['template'])) { $this->build['template'] = 'standard'; }
		$this->Session->write("Build", $this->build);

		if (empty($this->build['CustomImage']) && empty($this->build['GalleryImage']))
		{
			$this->redirect("/gallery?prod=$prod"); # Skip template choosing if stamp.
		}

		$this->redirect("/build/customize/$prod"); # Skip template choosing if stamp.
	}

	function choose_product_type($code)
	{
		$this->Product->recursive = 1;
		$this->Product->link_related_products();
		$product = $this->Product->find(" code = '$code' ");
		$pid = $product_type_id = $product['Product']['product_type_id'];
		$compare_products = array();

		if (!empty($product['AllRelatedProducts']))
		{
			$compare_products[] = $product['Product'];
			foreach($product['AllRelatedProducts'] as $rp)
			{
				$compare_products[] = $rp;
			}

			usort($compare_products, array($this, "compare_products_sort"));
		}

		$price_lists[$code] = $this->get_effective_base_price_list($code);

		$all_products = $this->Product->findAll("Product.parent_product_type_id = '$pid' ");

		foreach($all_products as $ap)
		{
			$rpcode = $ap['Product']['code'];
			$price_lists[$rpcode] = $this->get_effective_base_price_list($rpcode);
		}

		$this->set("price_lists", $price_lists);
		$this->set("compare_products", $compare_products);
		$this->set("product", $product);
	}

	function setup_adjust($prod = '')
	{
		#error_log("LOADING CROP=".(!empty($this->build['crop']) ? print_r($this->build['crop'],true):null));

		if($this->build['template'] == 'textonly') { return; }

		if(!empty($prod))
		{
			$this->set_build_product($prod);
		}
		$product = $this->build;
		$prod = $product['Product']['code'];

		$template = $layout = $this->build['template'];
		$fullview = (in_array($layout, array('imageonly_nopersonalization','imageonly')));


		$this->set("template", $template);
		$this->set("imageonly", $fullview);

		$time = time();


		$image_path = !empty($this->build['CustomImage']) ? $this->build['CustomImage']['display_location'] : "/../../".$this->build['GalleryImage']['image_location'];
		$original_image_path = !empty($this->build['CustomImage']) ? $this->build['CustomImage']['display_location'] : "/../../".$this->build['GalleryImage']['image_location'];
		$orient = $this->get_image_orientation(APP."/webroot/$image_path");
		$this->set("orient", $orient);
		$product_config = $this->get_product_config($prod, $orient, $fullview);
		$product_config_fullview = $this->get_product_config($prod, $orient, true); # Always need this to see if 2-sided or not.

		$this->set("product_config", $product_config);
		$this->set("product_config_fullview", $product_config_fullview);

		$this->set("product", $product);

		$product_image_dir = $this->get_product_image_dir($prod, $orient, $fullview,true);
		$this->set("product_image_dir", $product_image_dir);

		$overlayimg = null;
		$overlayimg_gif = null;

		if(file_exists(APP."/../$product_image_dir/medium/$prod-overlay.png"))
		{
			$overlayimg = "$product_image_dir/medium/$prod-overlay.png";
		}
		if(file_exists(APP."/../$product_image_dir/medium/$prod-overlay.gif"))
		{
			$overlayimg_gif = "$product_image_dir/medium/$prod-overlay.gif";
			if(empty($overlayimg)) { $overlayimg = $overlayimg_gif; }
		}

		$this->set("overlayimg", $overlayimg);
		$this->set("overlayimg_gif", $overlayimg_gif);

		#error_log("OVERLA=$overlayimg");

		$width = (in_array($prod,array('PR','RL','PB')) ? 500 : 300);# 300/270

		#error_log("WID=$width, P=$prod");

		$fileprod = $prod;
		if(in_array($prod, array('BB','BC'))) { $fileprod = 'B'; }
		else if(in_array($prod, array('MG-USA'))) { $fileprod = 'MG'; }

		#$transimg = !empty($product_config['background']) ? "/product_image/build_view/$width.png/$time?noimage=1&background=1" : "";
		#$transimg = !empty($product_config['background']) ? "$product_image_dir/medium/$fileprod-trans.png" : "";
		$transimg = "$product_image_dir/medium/$fileprod-trans.png";
		$transimg_white = "$product_image_dir/medium/$fileprod-trans-white.png";
		#$transimg_gif = !empty($product_config['background']) ? "/product_image/build_view/$width.gif/$time?noimage=1&background=1" : "";
		#if(empty($transimg) && file_exists(APP."/../$overlayimg")) { $transimg = $overlayimg; } # But it's not scaled.... =(
		#$blankimg = "/product_image/build_view/$width.png/$time?noimage=1";
		$blankimg = "$product_image_dir/medium/$fileprod.png";

		if(file_exists(APP."/../$transimg"))
		{
			$this->set("transimg", $transimg);
		}
		if(file_exists(APP."/../$transimg_white"))
		{
			$this->set("transimg_white", $transimg_white);
		}
		#$this->set("transimg_gif", $transimg_gif);
		$this->set("blankimg", $blankimg);

		$prodscale = $scale = $width / $product_config['file'][2];

		$box = 'image';

		$fullbleed = !empty($fullview);# && $no_crop_coords #!empty($this->build['options']['fullbleed']) ? 1 : 0;
		$fullbleed = true;
		$this->set("fullbleed", $fullbleed);

		$default_fullbleed = !empty($this->build['Product']['fullbleed']);

		$pers = !empty($this->build['options']['personalizationInput']) ? $this->build['options']['personalizationInput'] : null;

		if(!isset($this->build['options']['personalizationNone']))
		{
			$this->build['options']['personalizationNone'] = empty($pers);
			# Default to not set unless explicit otherwise.
		}

		# 
		$no_pers = false;
		$donePersStep = !empty($this->build['complete']['personalization']);
		$two_sided = (in_array($template, $this->imgonlys) && !empty($product_config['image.2']));
		if ($template == 'imageonly_nopersonalization' || !empty($this->build['options']['personalizationNone']) || (empty($pers) && ($two_sided || $donePersStep))) { $no_pers = true; }
		# Picture should be bigger if dont want pers OR is empty (and either two sided or finished step)

		error_log("NOP=$no_pers,, PER=$pers PN=".!empty($this->build['options']['personalizationNone']));

		$stamp = !empty($this->build['GalleryImage']);

		if($stamp && !$no_pers) { $box = 'image'; } # Use smaller box if stamp and has pers.
		else if(!$stamp && in_array($template, $this->imgonlys) && !empty($product_config['fullbleed'])) { $box = 'fullbleed'; }
		# if they dont want anything cut off, they will simply zoom out.
		else if(in_array($template, $this->imgonlys) && !empty($product_config['image.nopersonalization']) && $no_pers) { $box = 'image.nopersonalization'; }
		else if(!empty($product_config['fullview']) && in_array($template, $this->imgonlys)) { $box = 'fullview'; }

		error_log("BOXING AS =$box");

		$canvas = $product_config[$box];
		#error_log("BIG CANVAS=".print_r($canvas,true));

		list($cx,$cy,$cw,$ch) = $scale_canvas = array(ceil($canvas[0]*$scale), ceil($canvas[1]*$scale), ceil($canvas[2]*$scale), ceil($canvas[3]*$scale));



		$this->set("canvas", $scale_canvas);

		if(!empty($product_config["$box.2"]) && in_array($template, $this->imgonlys))
		{
			$canvas2 = $product_config["$box.2"];
			$scale_canvas2 = array(ceil($canvas2[0]*$scale), ceil($canvas2[1]*$scale), ceil($canvas2[2]*$scale), ceil($canvas2[3]*$scale));
			$this->set("canvas2", $scale_canvas2);
		}

		# ...
		if(!empty($this->build['GalleryImage']))
		{
			# Calculate proper imgwidth, imgheight and pass image_path
			list($full_imgwidth, $full_imgheight) = getimagesize(APP."/webroot/$original_image_path"); # Default.
			$full_imgw2h = $full_imgwidth/$full_imgheight;

			$border_width = 5; # 

			$imgwidth = floor($scale_canvas[2]-$border_width*2);
			$imgheight = floor($imgwidth / $full_imgw2h);

			if($imgheight > $scale_canvas[3]-$border_width*2)
			{
				$imgheight = floor($scale_canvas[3]-$border_width*2);
				$imgwidth = floor($imgheight * $full_imgw2h);
			}



			$imgx = floor(($scale_canvas[2] - $border_width - $imgwidth)/2);
			$imgy = floor(($scale_canvas[3] - $border_width - $imgheight)/2);



			$this->set("imgheight", $imgheight);
			$this->set("imgwidth", $imgwidth);
			$this->set("imgx", $imgx);
			$this->set("imgy", $imgy);


			$this->set("image_path", $this->build['GalleryImage']['image_location']);

			return; # Can't adjust stamp images.
		}

		$imgx = $imgy = 0;
		list($full_imgwidth, $full_imgheight) = getimagesize(APP."/webroot/$original_image_path"); # Default.
		list($imgwidth, $imgheight) = getimagesize(APP."/webroot/$image_path"); # Default.

		$rotate = !empty($this->build['rotate']) ? $this->build['rotate'] : 0;
		if($rotate == 90 || $rotate == 270) 
		{ 
			$imgheight2 = $imgwidth; $imgwidth = $imgheight; $imgheight = $imgheight2; 
			$full_imgheight2 = $full_imgwidth; $full_imgwidth = $full_imgheight; $full_imgheight = $full_imgheight2; 
		} # Fix zoom setting?

		$imgw2h = $imgwidth/$imgheight;
		$origwidth = $imgwidth;
		$origheight = $imgheight;

		$scale = $imgwidth / $full_imgwidth;

		$this->set("imgw2h", $imgw2h);

		$fitwidth = $cw;
		$fitheight = ceil($fitwidth / $imgw2h);

		$this->set("minwidth", $fitwidth*0.5); # Allow some whitespace
		$this->set("minheight", $fitheight*0.5); # Allow some whitespace
		$this->set("fitwidth", $fitwidth); # Allow some whitespace
		$this->set("fitheight", $fitheight); # Allow some whitespace


		$imgwidth = $cw;
		$imgheight = floor($imgwidth / $imgw2h);

		# 
		#error_log("STARTING WITH $imgwidth, $imgheight");

		# XXX TODO TOMAS_MALY maybe here to get to NOT FB.

		if($imgheight > $ch)
		{
			$imgheight = $ch;
			$imgwidth = floor($imgheight * $imgw2h);
			#error_log("ADJUSTING $imgheight > $ch");
		}

		# ADDED TO TEST
		$imgwidth = $cw;
		$imgheight = $imgwidth / $imgw2h;
		# XXX TODO
		#error_log("ENDING WITH $imgwidth, $imgheight");

		# Now center. (XXX may need to chance to 2/5 down)
		$imgx = -($imgwidth - $cw)/2;
		$imgy = -($imgheight - $ch)/2;

		#error_log("IH=$imgheight, CAN_H=$ch, IMGY=$imgy");

		$cropdata = $this->get_build_crop_coords($this->build['template'], $product_config, $this->build, false, $no_pers);

		#error_log("CROPDATA (is this resetting?)=".print_r($cropdata,true));

		#$cropdata = null;
		if(!empty($cropdata['w']) && !empty($cropdata['h']))
		{
			$cropx = $cropdata['x'];
			$cropy = $cropdata['y'];
			$cropw = $cropdata['w'];
			$croph = $cropdata['h'];
			#error_log("CROPDATA1=$cropx,$cropy,$cropw,$croph");
		} else if (count($cropdata) >= 4) {
			$cropx = $cropdata[0];
			$cropy = $cropdata[1];
			$cropw = $cropdata[2];
			$croph = $cropdata[3];
			#error_log("CROPDATA2=$cropx,$cropy,$cropw,$croph");
		}

		if($template == 'imageonly_nopersonalization') { $template = 'imageonly'; }

		$prod = $this->build['Product']['code'];

		# so whatever default coordinates get applied to image?
		#
		#$this->Session->write("Build", $this->build);

		#error_log("CANVAS=".print_r($scale_canvas,true));

		error_log("TEMPALTE=$template");

		# Default without crop.
		if($default_fullbleed && $template != 'standard') # Catches I/O also
		{ # Never fullbleed on standard layout.
			error_log("DEFAULT FULLBLEED");

			# Try fitting by width, see if height is more than canvas.
			$imgwidth = $scale_canvas[2];
			$imgheight = $imgwidth / $imgw2h;

			# Height too short.
			if($imgheight < $scale_canvas[3])
			{
				$imgheight = $scale_canvas[3];
				$imgwidth = $imgheight * $imgw2h;
			}
		} else { # Image only fit.

			error_log("IMGONLY FIT");

			# Try fitting by width, see if height is less than canvas.
			$imgwidth = $scale_canvas[2];#*.8; // pad a bit.
			$imgheight = $imgwidth / $imgw2h;

			# Height too tall, shrink to fit.
			if($imgheight > $scale_canvas[3])
			{
				$imgheight = $scale_canvas[3];
				$imgwidth = $imgheight * $imgw2h;
			}


			# NOT fitting by 'image' coords, since on magnets, etc it's off to the side too much.
		}
		# Center image.
		$imgx = ($scale_canvas[2]-$imgwidth)/2;
		$imgy = ($scale_canvas[3]-$imgheight)/(in_array($prod, array('B','BNT','BC','BB')) ? 4 : 2);

		$cropdata = !empty($this->build['crop'][$template]) ? $this->build['crop'][$template] : null;
		#array($cropx,$cropy,$cropw,$croph);

		# Re-load crop coordinates....
		if(!empty($cropdata))
		{
			# XXX THIS HERE IS MESSING W/H BASED ON PROPORTION OF CANVAS
			$imgwidth = ceil($scale_canvas[2] * $full_imgwidth/$cropw);
			$imgheight = ceil($scale_canvas[3] *$full_imgheight/$croph);
			# big_h * can_h / crop_h * scale (when no crop, becomes 1 * can_h / 1 * scale = can_h*scale (scaled can_h)

			$imgx = -ceil($cropx * $imgwidth / $full_imgwidth);
			$imgy = -ceil($cropy * $imgheight / $full_imgheight );
		}

		# THOUGH COORDINATES FROM DEFAULT CROP SHOULD DO SAME...

		# TODO Since we get full-size coords for crop, we need to just use them as coords for img and then scale that down and recenter.
		#$imgwidth = $cropw * $prodscale;
		#$imgheight = $croph * $prodscale;

		#$imgx = $cropx*$prodscale;
		#$imgy = $cropy*$prodscale;

		# ORIGINAL:

		# XXX THIS HERE IS MESSING W/H BASED ON PROPORTION OF CANVAS
		# WE already got all this info above. wtf.
		/*
		$imgwidth = ceil($full_imgwidth * $canvas[2] / $cropw * $prodscale);
		$imgheight = ceil($full_imgheight * $canvas[3] / $croph * $prodscale);
			# big_h * can_h / crop_h * scale (when no crop, becomes 1 * can_h / 1 * scale = can_h*scale (scaled can_h)

		$imgx = -ceil($cropx * $imgwidth / $full_imgwidth);
		$imgy = -ceil($cropy * $imgheight / $full_imgheight );
		*/

		#error_log("CANVAS $box, SCALE=$scale, PRODSCALE=$prodscale, CROP=$cropx,$cropy,$cropw,$croph, IMGCOORDS=$imgx,$imgy,$imgwidth,$imgheight, CANVAS=".print_r($scale_canvas,true));

		#error_log("IMGX=$imgx, $imgy; $imgwidth, $imgheight (FULLIMG=$full_imgwidth, $full_imgheight; CANVAS={$canvas[2]}, {$canvas[3]})");

		$this->set("imgx", $imgx);
		$this->set("imgy", $imgy);
		$this->set("imgwidth", $imgwidth);
		$this->set("imgheight", $imgheight);
		$this->set("imgw2h", $imgwidth/$imgheight);

		error_log("IMGX=$imgx, IMGY=$imgy, IMGH=$imgheight");

		$this->set("origwidth", $origwidth);
		$this->set("origheight", $origheight);
		$this->set("full_imgwidth", $full_imgwidth);
		$this->set("full_imgheight", $full_imgheight);
		$this->set("imgid", $this->build['CustomImage']['Image_ID']);

		$this->set("coordx", $cropx);
		$this->set("coordy", $cropy);
		$this->set("coordw", $cropw);
		$this->set("coordh", $croph);

		$this->set("prod", $this->build["Product"]['code']);

		# Also do start coordinates.
		$image_path = "/product_image/image_rotate/".$this->build['CustomImage']['Image_ID']."/".(!empty($this->build['rotate'])?$this->build['rotate']:'');

		$this->set("image_path", $image_path);

	}

	function step($step = '') # ie layout
	# So when we update rotation, we get accurate layout previews.
	{
		$this->_create(); # rotate will be read from 
		$this->set("option_code", $step);
		$this->render("/elements/build/step");
	}

	function add_logo()
	{
		# Copy of custom_images::add_or_edit_process...
		# (or maybe we just redirect to there! saying what we are!)
	}

	function charms()
	{
		$this->layout = 'default_plain'; // JS and css.
		Configure::write("debug", 0);
		$this->load_variables_charm();
		if(!empty($_REQUEST['charm_id']))
		{
			$this->data['charm_id'] = $_REQUEST['charm_id'];
		}
		if(!empty($this->data['charm_id']))
		{
			$this->layout = 'ajax';  // no js/css

			$this->build['options']['charmID'] = $this->data['charm_id'];
			$this->build['options']['charm']['charmID_data'] = 
				$this->Charm->read(null, $this->build['options']['charmID']);
			#error_log("CHARM=".print_r($this->build['options']['charm'],true));
			$this->Session->write("Build", $this->build);
			$this->set("option_code", "charm");
			$this->set("top_next", false);
			$this->set("reload", true);
			return $this->render("/elements/build/step");
		}
	}

	function customize($prod = '')
	{

		error_log("IN CUSTOMIZE");
		$this->TrackingVisit->did_goal("build");
		#error_log("CUSTOMIZE/$prod");
		if(!empty($prod))
		{
			$this->set_build_product($prod);
		}
		if(empty($this->build['Product'])) { $this->redirect("/products/select"); }
		if (!$prod) { $prod = $this->build['Product']['code']; }

		if ($prod == 'RL' || $prod == 'PR' || $prod == 'PB')
		{
			$this->action = "customize_vertical";
		}

		if(!empty($this->params['url']['options']))
		{
			#print_r($this->params['url']['options']);
			foreach($this->params['url']['options'] as $k => $v)
			{
				$this->build['options'][$k] = $v;
			}
			$this->Session->write("Build", $this->build);
		}

		$build_notes = $this->ContentSnippet->find("snippet_code = 'build_notes'");
		$this->set("build_notes", !empty($build_notes) ? $build_notes['ContentSnippet']['content'] : null);

		$this->set("stepname", "options");
		$this->set("prod", $prod);
		$parent_id = $this->build['Product']['parent_product_type_id'];
		$pid = $this->build['Product']['product_type_id'];

		$type = null;
		if(!empty($this->build['CustomImage']))
		{
			$type = 'custom';
		} else if (!empty($this->build['GalleryImage'])) {
			// check to see what stamp allows
			$repro = strtolower($this->build['GalleryImage']['reproducible']); // Yes, No, Only
			if($repro == 'yes')
			{
				$type = 'real|repro';
			} else if ($repro == 'no') { 
				$type = 'real';

			} else if ($repro == 'only') {
				$type = 'repro';

			}
		}

		$related_products = $this->Product->findAll("(Product.product_type_id = '$pid' OR Product.parent_product_type_id = '$pid' OR Product.product_type_id = '$parent_id' OR Product.parent_product_type_id = '$parent_id') AND Product.available = 'yes' AND Product.image_type REGEXP '($type)'", null, "Product.choose_index ASC");

		$this->set("related_products", $related_products);

		$this->set("clients", $this->Client->findAll());
		error_log("BEFORE _CREATE=".print_r($this->build['options'],true));
		

		$this->_create($prod);
	}

	function _create($prod = '')
	{
		if(empty($this->build['template']) && !empty($this->build['GalleryImage']))
		{
			# Only reset to standard if no template set yet.
			$this->build['template'] = 'standard';
			#error_log("STND");
		}
		#if(empty($this->build['template']) && !empty($this->build['CustomImage']))
		#{
		#	$this->build['template'] = 'standard';
		#}
		#error_log("SID1=".session_id());
		#error_log("CRE=$prod");
		#error_log("IMG=".print_r($this->build['CustomImage'],true));

		#error_log("BUILD_PROD=".$this->build['CustomImage']);
		if (empty($prod) && empty($this->build['Product']))
		{
			$this->redirect("/products/select");
		}
		$this->initialize_product($prod); #Gets options, data, etc.

		#error_log("IMG2=".print_r($this->build['CustomImage'],true));

		$this->set("all_options_by_code", Set::combine($this->all_options, '{n}.Part.part_code','{n}'));

		$this->set("standard_options", $this->load_product_options(false, true, null, 'standard'));
		$this->set("imageonly_options", $this->load_product_options(false, true, null, 'imageonly'));

		$this->set("all_options", $this->all_options);
		$this->set("options", $this->options);
		foreach($this->options as $option)
		{
			$step = $option['Part']['part_code'];
			$this->load_variables_step($step); # data files...
		}

		$this->Product->recursive = 2;
		$this->Product->link_related_products();
		$this->Product->link_product_details();
		$product = $this->Product->read(null, $this->build['Product']['product_type_id']);
		$this->set("product", $product);

		#$pricings = $this->Product->generate_pricing_list($product);
		#$this->set('product_pricings', $pricings);

		#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());

		#$price_list = $this->get_effective_base_price_list();
		#$this->set("price_list", $price_list);
#
#		$this->set("proof_cost", $this->proof_cost);

		$product_template_names = $this->Product->get_product_template_names();
		$template = !empty($this->build['template']) ? $this->build['template'] : null;
		if($template == 'imageonly_nopersonalization')
		{
			$template = 'imageonly'; # For finding template...
		}

		if ($template && empty($product_template_names[$template]))
		{
			$this->build['template'] = 'standard'; # Can't do what we're asking for, ie switched products.
			#error_log("CANT DO LAYOUT=$template, DEFAULTING TO STD");
			$this->Session->write("Build", $this->build);
		}
		$this->set("product_template_names", $product_template_names);

		#error_log("BUILD=".print_r($this->build,true));

		#error_log("IMG3=".print_r($this->build['CustomImage'],true));

		$prod = $this->build['Product']['code'];
		$layout = $this->build['template'];
		
		$orient = null;
		$fullview = 1;

		if($layout != 'textonly')
		{
			$image_path = !empty($this->build['CustomImage']) ? $this->build['CustomImage']['display_location'] : $this->build['GalleryImage']['image_location'];
			#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
			$fullview = ($layout == 'imageonly');
			$orient = $this->get_image_orientation($image_path);
		}

		$product_config = $this->get_product_config($prod, $orient, $fullview);
		$this->set("product_config", $product_config);

		$price_list = $this->get_effective_base_price_list();
		$this->set("price_list", $price_list);

		$next_tier = "";

		$quantity = !empty($this->build['quantity']) ? $this->build['quantity'] : $product['Product']['minimum'];

		$i = 0;
		foreach($product['ProductPricing'] as $pricing)
		{
			if ($pricing['quantity'] > $quantity && $i+1 < count($product['ProductPricing']))
			{
				$next_tier = $pricing['quantity'];
				break;
			}
			$i++;
		}
		$this->set("next_tier", $next_tier);


		$this->load_variables_layout();

		$this->setup_adjust();
	}

	function preview_adjust($template = null) # Can call via ajax to change template.
	{
		#error_log("PREVIEW_ADJUST (t=$template)");
		#error_log("REQ+".print_r($_REQUEST,true));
		if(!empty($template)) # Do first since maybe affected by data
		{
			#error_log("PRETEM=$template");
			$this->set_template($template);
			#$this->build['template']  = $template;
			#$this->Session->write("Build", $this->build);
		}
		if(!empty($this->data)) # Updating, ie text, etc.
		{
			#error_log("DATA=".print_r($this->data,true));
			foreach($this->data as $k=>$v)
			{
				if($k == 'options')
				{
					foreach($v as $ok=>$ov)
					{
						#error_log("SETTING $k/$ok = $ov");
						$this->build['options'][$ok] = $ov;
					}
				} else {
					$this->build[$k] = $v;
					#error_log("SETTING $k=$v");
				}
			}
			$this->Session->write("Build", $this->build);
		}
		# Setting manually from parameter must be LAST after all calls to load from submitted data... (out of sync may be a problem)
		$this->setup_adjust();
	}

	function OLDquote_select($code = '', $catalogNumber = '')
	{
		Configure::write("debug", 0);
		$this->layout = "default_plain";

		#print_r($this->params);

		$product = $this->Product->find(" code = '$code' ");
		$product_id = $product['Product']['product_type_id'];

		$maxLength = $product['Product']['quote_limit'];

		$keywords = null;

		if(!empty($this->data['keywords']))
		{
			$keywords = $this->data['keywords'];
		} else if (!empty($this->passedArgs['keywords'])) { 
			$keywords = $this->passedArgs['keywords'];
		}

		if (!empty($keywords))
		{
			# Do search.
			$keyword_list = split(" ", $keywords);

			$keyword_where_list = array();
			foreach($keyword_list as $kw)
			{
				$keyword_where_list[] = "CONCAT(text,attribution,subjects)  LIKE '%$kw%'";
			}
			$keyword_where = join(" AND ", $keyword_where_list);

			$kw = mysql_escape_string($keywords);
			#$quotes = $this->Quote->find('all', array('conditions'=>" (text LIKE '%$kw%' OR attribution LIKE '%$kw%' OR subjects LIKE '%$kw%') " . ($maxLength > 0 ? " AND (LENGTH(text)+LENGTH(attribution)) <= '$maxLength' " : "")) );
			#$quotes = $this->paginate('Quote', array( " (text LIKE '%$kw%' OR attribution LIKE '%$kw%' OR subjects LIKE '%$kw%') " . ($maxLength > 0 ? " AND (LENGTH(text)+LENGTH(attribution)) <= '$maxLength' " : "")) );
			# Look for words in any order, with text in between keywords, etc....

			# How do we find whether text, attribution OR subjects has all keywords, when could be mixed????
			$quotes = $this->paginate('Quote', array( " ($keyword_where) " . ($maxLength > 0 ? " AND (LENGTH(text)+LENGTH(attribution)) <= '$maxLength' " : "")) );
			$this->set("quotes", $quotes);
		}

		$category_stack = array();
		$this->set("category_stack", $category_stack);

		$parent_node_id = 1; # Default..

		#print_r($this->data);

		if (!empty($this->params['url']['browse_node_id']))
		{
			$browse_node_id = $this->params['url']['browse_node_id'];
			$parent_node_id = $browse_node_id;
		}

		if (!empty($this->data['browse_node_id']))
		{
			$browse_node_id = $this->data['browse_node_id'];
			$parent_node_id = $browse_node_id;
		}

		if (!empty($this->passedArgs['browse_node_id']))
		{
			$browse_node_id = $this->passedArgs['browse_node_id'];
			$parent_node_id = $browse_node_id;
		}

		$all_categories = $this->GalleryCategory->findAll("",array(),"GalleryCategory.browse_name");
		$categories_by_parent_id = array();
		foreach($all_categories as $ac)
		{
			$pid = $ac['GalleryCategory']['parent_node'];
			if (empty($categories_by_parent_id[$pid])) { $categories_by_parent_id[$pid] = array(); }
			$categories_by_parent_id[$pid][] = $ac;
		}
		$categories_by_node_id = Set::combine($all_categories, '{n}.GalleryCategory.browse_node_id', '{n}');

		$this->set("all_categories", $all_categories);
		$this->set("categories_by_parent_id", $categories_by_parent_id);
		$this->set("categories_by_node_id", $categories_by_node_id);

		if (!empty($browse_node_id) && $browse_node_id > 1)
		{
			#$browse_node_id = $this->params['url']['browse_node_id'];
			$parent_node_id = $browse_node_id;

			$kw = $categories_by_node_id[$browse_node_id]['GalleryCategory']['browse_name'];

			#$browse_quotes = $this->Quote->findAll(" (subjects LIKE '%$kw%') " . ($maxLength > 0 ? " AND (LENGTH(text)+LENGTH(attribution)) <= '$maxLength' " : ""));
			$browse_quotes = $this->paginate('Quote', array(" (subjects LIKE '%$kw%') " . ($maxLength > 0 ? " AND (LENGTH(text)+LENGTH(attribution)) <= '$maxLength' " : "")));
			$this->set("browse_quotes", $browse_quotes);
			#print_r($browse_quotes);
		}

		# Now do product quotes....
		$this->ProductQuote->recursive = 1;
		$product_quotes = $this->ProductQuote->findAll(" ProductQuote.product_type_id = '$product_id' ");
		$this->set("productQuotes", $product_quotes);

		$category_stack = array();

		$cid = $parent_node_id;
		do
		{
			array_unshift($category_stack, $cid);
			$cat = $categories_by_node_id[$cid];
			$cid = $cat['GalleryCategory']['parent_node'];
		} while($cid >= 1);
		#print_r($category_stack);

		$this->set("category_stack", $category_stack);

		$this->set("parent_node_id", $parent_node_id);

		$this->load_recommended_quotes($catalogNumber);

		$this->set("code", $code);
		$this->set("keywords", $keywords);
		$this->set("prod", $code);
		$this->set("catalogNumber", $catalogNumber);
	}


	function option_select($code, $option)
	{
		Configure::write("debug", 0);
		$this->layout = "iframe";
		$this->load_variables_step($option); # data files...
		foreach($this->options as $opt)
		{
			if ($opt['Part']['part_code'] == $option)
			{
				# Don't think we need to do anything....
			}
		}
		$this->set("option", $option);
		$this->set("code", $code);
	}

	function view_part($partcode)
	{
		Configure::write("debug", 0);
		$this->layout = "default_plain";
		$this->load_variables_step($partcode);
		$this->set("part", $this->Part->find("Part.part_code = '$partcode'"));
		$this->set("partcode", $partcode);
	}

	function get_crop_data()
	{
		$productCode = $this->build['Product']['code'];
		$image_path = null;

		if(!empty($this->build['CustomImage']))
		{
			$image_path = APP."/webroot/". $this->build['CustomImage']['display_location'];
		} else if (!empty($this->build['GalleryImage'])) {
			$image_path = APP."/../".$this->build['GalleryImage']['image_location'];
		}
		if(empty($image_path)) { return array(); }
		$orient = $this->get_image_orientation($image_path);
		$product_config = $this->get_product_config($productCode, $orient, true);
		$cropdata = $this->get_build_crop_info($this->build['template'], $product_config, $this->build);
		return $cropdata;
	}


	function load_item()
	{

		if (isset($_REQUEST['new'])) # Clears cart item from loading and clears options, too.
		{
			unset($this->build['cart_item_id']);
			unset($this->build['options']);
			$this->Session->write("Build", $this->build);
		}

		$this->build['isNewItem'] = (empty($this->build['cart_item_id']) && empty($this->build['cartID']));

		if (isset($_REQUEST['cart_item_id'])) 
		{ 
			$cart_item_id = $_REQUEST['cart_item_id'];
			$cart_item = $this->CartItem->read(null, $cart_item_id);
			$code = $cart_item['CartItem']['productCode'];

			$this->build = $this->cart_item_to_build($cart_item, $cart_item_id);

			$this->Session->write("Build", $this->build);
			$this->redirect("/build/customize");
		}
		else if (!empty($this->build['cart_item_id']) && empty($this->build['cart_item_loaded'])) # this broke build updating by loading a bogus item.
		{ 
			# How do we know when an item is already loaded and we've changed the form?
			$cart_item_id = $this->build['cart_item_id'];
			$cart_item = $this->CartItem->read(null, $cart_item_id);
			$code = $cart_item['CartItem']['productCode'];

			$this->build = $this->cart_item_to_build($cart_item, $cart_item_id);

			$this->Session->write("Build", $this->build);
			# 
			# DONT redirect since we're already there!
		}
		elseif (isset($_REQUEST['reorder']))
		{
			#$this->build = $this->load_reorder($_REQUEST['itemID']);
			$order_item = $this->OrderItem->read(null, $_REQUEST['itemID']);
			$this->build = $this->cart_item_to_build($order_item, null);
			$this->Session->write("Build", $this->build);
			$this->redirect("/build/step");
		} 

		$this->set("isNewItem", !empty($this->build['isNewItem']) ? true : false);
		$this->set("productCode", !empty($this->build['Product']) ? $this->build['Product']['code'] : null);

		$hasSurcharge = false;
		$surchargePossible = false;
		$surcharge = 0;

		$stamp_reproduction = !empty($this->build['options']['reproductionStamp']) ? strtolower($this->build['options']['reproductionStamp']) : null;

		if (!empty($this->build['catalog_number']) && !empty($this->build['Product']))
		{
			$catalogNumber = $this->build['catalog_number'];
			$surcharge = $this->GalleryImage->get_surcharge($catalogNumber);
			if(!empty($surcharge)) { $hasSurcharge = true; $surchargePossible = true; }
			if (!preg_match("/real/", $this->build['Product']['image_type']) || $stamp_reproduction =="yes") { $surcharge = 0; }
		}

		#if(!empty($this->build['GalleryImage']))
		#{
		#	$this->build['template'] = 'standard'; # Always do standard layout.
		#	#error_log("STAMPSTD");
		#}
		# This messes up switching to imageonly stamp.

		$this->set("surchargePossible", $surchargePossible);
		$this->set("hasSurcharge", $hasSurcharge);
		#echo "SUR_SET=$surcharge";
		$this->set("surcharge", $surcharge);

		if(!empty($this->build['options']))
		{
			$parts_info = $this->load_parts_info($this->build['options']);
			foreach($parts_info as $k=>$v) { 
				#error_log("LOAD_PART $k = $v"); 
				$this->build[$k] = $v; 
			}
		}

	}

	function cart_item_to_build($currentItem, $cartID)
	{
		$build = array('options'=>array());
		#error_log("CART_ID=$cartID");
		#echo "CI=".print_r($currentItem,true);

		$item = array();

		if (is_object($currentItem)) # From old version....
		{
			$parts = get_object_vars($currentItem->parts);
			$item = get_object_vars($currentItem);
			$item['parts'] = $parts;
			$build['cartID'] = $cartID;
		} else if (!empty($currentItem['CartItem'])) { # From cart db record.
			$item = $currentItem['CartItem'];
			$item['parts'] = unserialize($currentItem['CartItem']['parts']);
			$build['cart_item_id'] = $cartID;

			if(!empty($item['parts']['size']) && is_array($item['parts']['size']))
			{
				# Fix quantity for tshirt.
				$item['quantity'] = 0;
				$item['options']['quantity_size'] = $item['parts']['size'];

				$item['quantity_size'] = $item['parts']['size'];

				foreach($item['parts']['size'] as $s => $q)
				{
					$item['quantity'] += $q;
				}
			}

		} else if (!empty($currentItem['OrderItem'])) { # Reorder...
			$item = $currentItem['OrderItem'];

			if(!empty($currentItem['ItemPart']['Size']) && preg_match("/(\d+) (\w+),/", $currentItem['ItemPart']['Size']))
			{
				$sizes = split(",", $currentItem['ItemPart']['Size']);
				$qtys = array();
				foreach($sizes as $size)
				{
					if(preg_match("/(\d+) (\w+)/", $size))
					{
						$qtys[$matches[2]] = $matches[1];
					}
				}
				$item['options']['quantity_size'] = $qtys;
				# TOMAS_MALY
			} else {
				$item['quantity'] = $currentItem['OrderItem']['Quantity'];
			}
			$item['unitPrice'] = $currentItem['OrderItem']['Price'];
			$product_type_id = $item['product_type_id'];
			$product = $this->Product->read(null, $product_type_id);
			$item['productCode'] = $product['Product']['code'];
			$item['parts'] = array(); #$currentItem['ItemPart'];
			foreach($currentItem['ItemPart'] as $part_id => $value)
			{
				$part_id = preg_replace("/_(\w)/e", "strtoupper('\\1')", $part_id);
				if ($part_id == 'personalization') { 
					$part_id = 'personalizationInput';
				}
				$item['parts'][$part_id] = $value;
			}
			#error_log("OLD PARTS=".print_r($currentItem['ItemPart'],true));

			$item['parts']['customImageID'] = $currentItem['ItemPart']['imageID'];
			$item['parts']['catalogNumber'] = $currentItem['ItemPart']['catalogNumber'];
			#$build['cart_item_id'] = $cartID;

		}

		$build['options'] = $item['parts']; # Keep the same...
		# This too far down messes up effortst o adjust options for quantities in tshirts

		$code = $item['productCode'];
		# This here is causing us to show a tassel when BNT...
		#if ($code == 'BC') { $code = 'B'; }
		#if ($code == 'BNT') { $code = 'B'; }
		if ($code == 'PSF') { $code = 'PS'; }
		$product = $this->Product->find("code = '$code'");

		$build['Product'] = $product['Product'];
		#error_log( "IQ={$item['quantity']}");
		$build['quantity'] = $item['quantity'];
		if(!empty($item['options']['quantity_size']))
		{
			$build['options']['quantity_size'] = $item['options']['quantity_size'];
			#error_log("COPTING QUANT_SIZE OVER=".print_r($item['options']['quantity_size'],true));
		}
		$build['quantity_price'] = $item['unitPrice'];
		$build['template'] = $item['template'];
		$build['rotate'] = !empty($item['rotate']) ? $item['rotate'] : 0;
		$build['isNewItem'] = false;
		$build['proof'] = !empty($item['proof']) ? $item['proof'] : null;
		$build['options']["comments"] = array('itemComments'=>$item['comments']);
		if(!empty($item['parts']['imageCrop']))
		{
			if(is_array($item['parts']['imageCrop']))
			{
				$build['crop'] = $item['parts']['imageCrop'];
			} else {
				$build['crop'][$item['template']] = split(",", $item['parts']['imageCrop']); # Reload coordinates!
			}
		}

		#error_log("LOADING=".print_r($item,true));

		# Load stamp.
		if(!empty($item['parts']['stampNumber'])) {
			$catalogNumber = $item['parts']['stampNumber'];
			$gallery_image = $this->GalleryImage->find("GalleryImage.catalog_number = '$catalogNumber'");
			$build['GalleryImage'] = $gallery_image['GalleryImage'];
		} else if(!empty($item['parts']['catalogNumber'])) {
			$catalogNumber = $item['parts']['catalogNumber'];
			$gallery_image = $this->GalleryImage->find("GalleryImage.catalog_number = '$catalogNumber'");
			$build['GalleryImage'] = $gallery_image['GalleryImage'];
		} else if (!empty($item['parts']['customImageID'])) {
		# Load custom image.
			$ImageID = $item['parts']['customImageID'];
			$custom_image = $this->CustomImage->find("CustomImage.Image_ID = '$ImageID'");
			$build['CustomImage'] = $custom_image['CustomImage'];
		}

		if (!empty($item['parts']['personalization_logo_id'])) {
		# Load logo
			$ImageID = $item['parts']['personalization_logo_id'];
			$logo = $this->CustomImage->find("CustomImage.Image_ID = '$ImageID'");
			$build['PersonalizationLogo'] = $logo['CustomImage'];
		}

		$build['complete'] = array();

		# Now mark all steps as complete.
		foreach($this->options as $option)
		{
			$part_code = $option['Part']['part_code'];
			$build['complete'][$part_code] = true;
		}

		$build['cart_item_loaded'] = true; # So we dont overwrite form changes.

		#error_log("BO=".print_r($build['options'],true));

		return $build;
	}

	function load_reorder($orderID)
	{
		$this->OrderItem->recursive = 2;
		$order_item = $this->OrderItem->read(null, $orderID);

		#print_r($order_item);
	}

	
	function product_view_large_png($prod = null)
	{
		Configure::write("debug", 0);
		$this->view = 'Media';
		if (!empty($prod))
		{
			$this->Session->write("Build.productCode", $prod);
			$product = $this->Product->find("code = '$prod'");
			$this->Session->write("Build.Product", $product['Product']);
			$this->build = $this->Session->read("Build");
		}

		$catalogNumber = !empty($this->params['form']['catalogNumber']) ? $this->params['form']['catalogNumber'] : null;
		$imageID = !empty($this->params['form']['imageID']) ? $this->params['form']['imageID'] : null;

		if ($catalogNumber)
		{
			$galleryImage = $this->GalleryImage->find("GalleryImage.catalog_number = '$catalogNumber'");
			$this->build['GalleryImage'] = $galleryImage['GalleryImage'];
		}

		if ($imageID)
		{
			$customImage = $this->CustomImage->read(null, $imageID);
			$this->build['CustomImage'] = $customImage['CustomImage'];
		}

		/*

		$large = true;
		if (isset($_REQUEST['small'])) { $large = false; }
		Configure::write('debug',0);
		#$this->layout = 'default_plain_html';
		include_once(dirname(__FILE__)."/../../includes/build/preview/product_preview.php");
		?><html><body><div style="text-align: center; margin-left: auto; margin-right: auto; background-color: white; text-align: center;"><?
		#product_view_large($this->build);
		product_preview($this->build, $large);
		?></div></body></html><?
		exit(0);
		*/
	}

	function product_view_large($prod = null)
	{
		Configure::write("debug", 0);
		$this->layout = 'default_plain';
		if (!empty($prod))
		{
			$this->Session->write("Build.productCode", $prod);
			$product = $this->Product->find("code = '$prod'");
			$this->Session->write("Build.Product", $product['Product']);
			$this->build = $this->Session->read("Build");
		}

		$catalogNumber = !empty($this->params['form']['catalogNumber']) ? $this->params['form']['catalogNumber'] : null;
		$imageID = !empty($this->params['form']['imageID']) ? $this->params['form']['imageID'] : null;

		if ($catalogNumber)
		{
			$galleryImage = $this->GalleryImage->find("GalleryImage.catalog_number = '$catalogNumber'");
			$this->build['GalleryImage'] = $galleryImage['GalleryImage'];
		}

		if ($imageID)
		{
			$customImage = $this->CustomImage->read(null, $imageID);
			$this->build['CustomImage'] = $customImage['CustomImage'];
		}

		/*

		$large = true;
		if (isset($_REQUEST['small'])) { $large = false; }
		Configure::write('debug',0);
		#$this->layout = 'default_plain_html';
		include_once(dirname(__FILE__)."/../../includes/build/preview/product_preview.php");
		?><html><body><div style="text-align: center; margin-left: auto; margin-right: auto; background-color: white; text-align: center;"><?
		#product_view_large($this->build);
		product_preview($this->build, $large);
		?></div></body></html><?
		exit(0);
		*/
	}

	function index() {
		# Make sure they have both a product and image selected.

		$this->redirect(array('action'=>'customize'));
		# NO MORE BELOW...

		if (!empty($this->build['Product']['is_stock_item']))
		{
			# Show add-to-cart page.
			$this->redirect(array('action'=>'cart'));
		}

		if (!isset($this->build['Product']))
		{
		#	error_log("R209");
			$this->redirect("/products/select"); 
		}

		if (!isset($this->build['GalleryImage']) && !isset($this->build['CustomImage']))
		{
			$this->redirect("/gallery");
		}

		if (!empty($this->params['form']))#!empty($this->data))
		{
			$this->redirect(array('action'=>'step',$this->option_list[0]));
			#$this->redirect(array('action'=>'quantity'));
			#$this->redirect(array('action'=>'quantity'));
		}

		#foreach($this->options as $option)
		#{
		#	$part_code = $option['Part']['part_code'];
		#	if (!isset($this->build['Build'][$part_code]))
		#	{
		#		$this->redirect(array('action'=>'step',$part_code));
		#	}
		#}
		$code = $this->build['Product']['code'];
		$this->Product->recursive = 2;
		$product = $this->Product->find("code = '$code'");
		$this->set("product", $product);
		if ($parent_id = $product['Product']['parent_product_type_id'])
		{
			$parent_product = $this->Product->find("product_type_id = '$parent_id'");
			$this->set("parent_product", $parent_product);
		}

		$this->set("body_title", "Custom ".($this->viewVars['image_name'] ? "&quot;".ucwords($this->viewVars['image_name'])."&quot; " : "").$this->pluralize($this->viewVars['product_name']));

		$minimum_price = $this->Product->get_minimum_price($this->build['Product']['code']);

		$this->set("minimum_price", $minimum_price);

	}

	function quantity()
	{
		$this->Product->link_product_details();
		#print_r($this->option_list);
			$next = $this->option_list[0];
			#echo "N=$next";
		$catalog_number = $this->Session->read("Build.GalleryImage.catalog_number");
		$this->GalleryImage->recursive = 2;
		$stamp_surcharge = ($catalog_number && $this->real_only_product) ? $this->GalleryImage->find("GalleryImage.catalog_number = '$catalog_number'") : null;

		if (!empty($this->params['form']))#!empty($this->data))
		{
			$quantity =  $this->params['form']['quantity'];
			if ($quantity < $this->build['Product']['minimum'])
			{
				$this->Session->setFlash("Minimum quantity is ". $this->build['Product']['minimum']);
				$quantity =  $this->build['Product']['minimum'];
			}
			$this->Session->write("Build.quantity", $quantity);
			$parts = $this->load_build_parts();
			$quantity_price_list =  $this->Product->get_effective_base_price($this->build['Product']['code'], $this->params['form']['quantity'], $this->Session->read("Auth.Customer"), $stamp_surcharge, $parts, $catalog_number);
			$quantity_price = $quantity_price_list['total'];
			$this->Session->write("Build.quantity_price", $quantity_price);
			$this->Session->write("Build.quantity_price_list", $quantity_price_list);

			 $this->params['form'] = null;

			$this->redirect(array('action'=>'step',$next));
			#$this->redirect(array('action'=>'quantity'));
		}
		$minimum = $this->build['Product']['minimum'];
		$quantity = $this->Session->read("Build.quantity");
		if (!$quantity || $quantity < $minimum)
		{
			$quantity = $minimum;
		}
		$this->set("quantity", $quantity);
		$this->set("minimum", $minimum);
		$this->set("current_step", "quantity");
		$this->set("product_pricings", $this->Product->generate_pricing_list($this->build['Product']['code'],false, $stamp_surcharge));
	}

	function quote()
	{
		if (!empty($this->data['quote']))
		{
			$this->Session->write("Build.quote", $this->data['quote']);

			$this->goto_next_step('quote'); # May want to implement 'save' vs 'save and next'
		}
		# Get quote info...
		$product_id = $this->build['Product']['product_type_id'];
		$quote_limit = $this->build['Product']['quote_limit'];
		$this->set("quote_limit", $quote_limit);
		$productQuotes = $this->ProductRecommendedQuote->findAll("ProductRecommendedQuote.productTypeID = '$product_id'");

		$quotes = array();

		foreach($productQuotes as $productQuote)
		{
			$length = $productQuote['Quote']['attrib_length'] + $productQuote['Quote']['text_length'];
			if ($length <= $quote_limit)
			{
				$quotes[] = $productQuote;
			}
		}

		if (isset($this->build['GalleryImage']['catalog_number']))
		{
			$catalog_number = $this->build['GalleryImage']['catalog_number'];
			$imageQuotes = $this->ImageRecommendedQuote->findAll("ImageRecommendedQuote.Catalog_Number = '$catalog_number'");
			foreach($imageQuotes as $imageQuote)
			{
				$length = $imageQuote['Quote']['attrib_length'] + $imageQuote['Quote']['text_length'];
				if ($length <= $quote_limit)
				{
					$quotes[] = $imageQuote;
				}
			}
		}

		$this->set("quotes", $quotes);

		# Get current quote 
		# TODO
		$quoteLength = 0;
		$this->set("quoteLength", $quoteLength);
	}

	function border()
	{
	}

	# Need a way to just load the default, what's in the system, without passing.
	function save_text()
	{
		$this->layout = 'ajax';
		if(!empty($this->data['options']))
		{
			foreach($this->data['options'] as $k=>$v)
			{
				$this->build['options'][$k] = $v;
			}
			$this->Session->write("Build", $this->build);
		}

		echo "OK";
		exit(0);
	}


	###############################

	function customize_old($customization_step = '')
	{
		if (isset($this->data['Build']['customization_step']))
		{
			$this->build['customization_step'] = $this->data['Build']['customization_step'];
		}
		else if (!empty($customization_step))
		{
			$this->build['customization_step'] = $customization_step;
		}

		$this->build['step'] = 3;

		if (!isset($this->build['customization_step']))
		{
			$this->build['customization_step'] = 'intro';
		}

		$page = $this->build['customization_step'];

		$prod = $this->build['prod'];

		$this->CustomizationOption->recursive = 2;
		$product = $this->Product->find("code = '$prod'");
		$options = $product['CustomizationOptions'];
		#$options = $this->CustomizationOption->Products->findAll("Products.code = '$prod'");

		#print_r($options);

		# Maybe just get a list of sub-pages? and ignore url....
		$next_page = $page;

		if (!empty($this->data))
		{
			$ix = 0;
			for($ix = 0; $ix < count($options); $ix++)
			{
				$option = $options[$ix];
				if ($page == 'intro')
				{
					$next_page = $option['part_code'];
					break;
				}
				else if ($option['part_code'] == $page && $ix < count($options)-1)
				{
					$next_page = $option[$ix+1]['part_code'];
					break;
				}
			}

			# Set next page.
			$page = $next_page;
		}

		if (method_exists($this, "customize_$page"))
		{
			$customize_method = "customize_$page";
			$this->$customize_method();
		}


		$this->set("next_page", $next_page);

		$this->set("action_page", $page);
	}

	function customize_quote()
	{
		$this->body_title = "Customization: Select Your Quote/Text";

		# XXX ADD IN JS TO SELECT CORRECT QUOTE IF RELOADING FROM DB....

		$quotes = array();
		$product_id = $this->build['Product']['product_type_id'];
		$catalog_number = $this->build['catalog_number'];
		$this->ProductRecommendedQuote->contain('Quote');
		$this->ImageRecommendedQuote->contain('Quote');
		$product_quotes = $this->ProductRecommendedQuote->findAll("ProductRecommendedQuote.productTypeID = '$product_id'");
		#echo "PQ=".print_r($product_quotes,true);
		foreach($product_quotes as $quote)
		{
			$quotes[] = $quote['Quote'];
		}

		# IMAGE BASED QUOTES.....
		# XXX TOMAS_MALY
		$image_quotes = $this->ImageRecommendedQuote->findAll("ImageRecommendedQuote.catalog_number = '$catalog_number'");
		#echo "IM_QUOTE=".print_r($image_quotes,true);
		foreach($image_quotes as $quote)
		{
			$quotes[] = $quote['Quote'];
		}
		#print_r($quotes);
		$this->set("quotes", $quotes);
	}

	function select_product_quantity($code, $quantity = 0)
	{
		$this->Product->recursive = 1;
		$product = $this->Product->find(" code = '$code' ");

		if(empty($quantity)) { $quantity = $product['Product']['minimum']; }

		$real_only_stamp = (!empty($this->build['GalleryImage']) && $this->build["GalleryImage"]['reproducible'] == 'No');

		$real_stamp = $this->real_only_product || $real_only_stamp || (!empty($this->build['options']['reproductionStamp']) && strtolower($this->build['options']['reproductionStamp']) == 'no');

		$catalog_number = $this->Session->read("Build.GalleryImage.catalog_number");
		$stamp_surcharge = $catalog_number ? $this->GalleryImage->find("GalleryImage.catalog_number = '$catalog_number'") : null;

		$base_price_list = $this->Product->get_effective_base_price($code, $quantity, $this->Session->read("Auth.Customer"), $real_stamp?$stamp_surcharge:null, null, $catalog_number);
		$base_price = $base_price_list['total'];

		$pid = $product['Product']['product_type_id'];
		$parent_id = $product['Product']['parent_product_type_id'];

		$related_products = $this->Product->findAll("(Product.product_type_id = '$pid' OR Product.parent_product_type_id = '$pid' OR Product.product_type_id = '$parent_id' OR Product.parent_product_type_id = '$parent_id') AND Product.available = 'yes'", null, "Product.choose_index ASC");
		$this->set("related_products", $related_products);


		$this->set("product", $product);
		$this->set("base_price", $base_price);
		$this->set("quantity", $quantity);
	}

	function personalize()
	{
		$this->build['step'] = 4;
	}

	function cart_old()
	{
		$this->body_title = "Add to Cart";
		# Display page to add to cart.
		$this->set("min_quantity", $min_quantity);

		# XXXX TODO once we add to cart, we need to save info into STACK, so we can reference back again!
		# MAYBE just a matter of reading 'cart' entry in db....
		# XXX cart entry should encompass EVERYTHING HERE we need.
		# MAYBE just be an XML dump? for expandability? AND EASY SESSION RESTORATION!!!!!
		# XXX 
	}

	#
	#
	#
	#
	#
	#
	#
	####################################################################################
	# Stuff below for managing building....


	function admin_index() {
		$this->Product->recursive = 0;
		$this->set('products', $this->paginate());
		#$this->set('products', $this->Product->findAll());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Product.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('product', $this->Product->read(null, $id));
	}

	function admin_add() {
		$this->action = 'admin_edit';
		if (!empty($this->data)) {
			$this->Product->create();
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(__('The Product has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Product could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Product', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set("product_id", $id);
		if (!empty($this->data)) {
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(__('The Product has been saved', true));
				#$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Product could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Product->read(null, $id);
			#$this->data['product_pricing_matrix'] = $this->Product->create_pricing_matrix($this->data);
			#print_r($this->data['product_pricing_matrix']);
		}

		$this->breadcrumbs["/".$this->params['url']['url']] = $this->data['Product']['name'];

		$product_count = $this->Product->find('count', array('conditions'=>array('buildable' => 'yes')));
		$popularity_options = array(''=>'N/A');
		for($i = 0; $i <$product_count; $i++)
		{
			$popularity_options[$i] = $i;
		}
		$this->set("popularity_ranking_options", $popularity_options);
		$this->set("parent_product_types", $this->Product->get_product_option_list($id));

		include_once("includes/image_gallery.php");
		$count = get_gallery_file_count("details/".$this->data['Product']['name'], 'jpg');
		#echo "C=$count, P=".$this->data['Product']['name'];
		$this->set("gallery_image_count", $count);
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Product', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Product->del($id)) {
			$this->Session->setFlash(__('Product deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
