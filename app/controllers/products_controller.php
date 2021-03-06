<?php
class ProductsController extends AppController {

	var $name = 'Products';
	var $helpers = array('Html', 'Form');
	var $uses = array("Product", "GalleryImage", "CustomImage","Charm","CharmCategory","CharmCategoryCharm","Tassel","Part","ShippingPricePoint","TrackingProductCalculatorRequest","Faq","FaqTopic","ContentSnippet",'Country','Client','ProductCategory','ZipCode',"ProductOption",'CartItem','ProductSampleImage','ProductFeature');
	var $build_page = false;
	var $paginate = array('limit'=>50,'order'=>'name');

	function beforeFilter()
	{
		
		parent::beforeFilter();

		switch($this->action)
		{
			case 'admin_add':
			case 'admin_edit':
			case 'add':
			case 'edit':
				if (!empty($this->data['Product']['image_type'])) { $this->data['Product']['image_type'] = join(",", $this->data['Product']['image_type']); }
				if (!empty($this->data['Product']['product_template'])) { $this->data['Product']['product_template'] = join(",", $this->data['Product']['product_template']); }

				break;
		}

	}

	function beforeRender()
	{
		parent::beforeRender();

		$this->set("product_template_names", $this->Product->get_product_template_names());

		switch($this->action)
		{

			case 'admin_add':
			case 'admin_edit':
			case 'add':
			case 'admin_editold':
			case 'edit':
				$this->set("image_types", $this->Product->getSetValues('image_type'));
				$this->set("stamp_types", $this->Product->getEnumValues('stamp'));



				break;
		}
		if ($this->action != 'index')
		{
			$this->set("current_build_step", 1);
		}
	}

	function how_to_order($prod = '')
	{
		$this->set("product", $this->Product->find(array('code'=>$prod)));
		$this->set("prod", $prod);
	}

	function design($code)
	{
		if(empty($code)) { $this->redirect(array('index')); }

		$product = $this->Product->findByCode($code);
		$parent = !empty($product['Product']['parent_product_type_id']) ?
			$this->Product->read(null, $product['Product']['parent_product_type_id']) : null;
		$parentCode = !empty($parent) ? $parent['Product']['code'] : null;

		$base = APP."/webroot/images/designs/products";
		$qs = $this->params['url']; unset($qs['url']); unset($qs['ext']);
		if(empty($this->params['url']['catalog_number']) && !empty($product['Product']['new_build']))#(file_exists("$base/$code.svg") || (!empty($parentCode) && file_exists("$base/$parentCode.svg"))))
		{
			$this->redirect("/designs/add/$code?".http_build_query($qs));
		} else {
			$this->redirect("/build/customize/$code?".http_build_query($qs));
		}
	}
		

	function template_download()
	{
		if(!empty($_REQUEST['file']))
		{
			$file = $_REQUEST['file'];
			header("Content-Type: application/pdf");
			header("Content-Disposition: attachment; filename=".basename($file));
			echo file_get_contents(APP."/webroot/$file");
			exit(0);
		} else {
			$this->redirect("/");
		}
	}

	function template($prod = '')
	{
		$this->layout = 'ajax';

		$product = $this->Product->find(array('OR'=>array('code'=>$prod,'product_type_id'=>$prod)));
		$pid = $product['Product']['product_type_id'];
		$ppid = $product['Product']['parent_product_type_id'];
		$this->set("product", $product);

		#echo "P=".$product['Product']['pricing_name'];

		$params = array('product_type_id'=>$pid, 'parent_product_type_id'=>$pid);
		$pparams = array('product_type_id'=>$ppid, 'parent_product_type_id'=>$ppid);

		if(!empty($ppid))
		{
			$params = array_merge($params, $pparams);
		}

		#if(!$this->Auth->user())
		#{
		#	$this->set("goto", "/products/template/$prod");
		#	$this->action = 'template_login';
		#} else {
			# Show page, related products.
			$products = $this->Product->findAll(array('OR'=>$params), null, 'Product.choose_index ASC');
			#echo "<pre>";
			#print_r($this->Product->getLog());
			#echo "</pre>";
			$this->set("products", $products);
		#}
	}

	function order_overview($prod = '')
	{
		$this->set("prod", $prod);
		$this->layout = 'default_plain';
		Configure::write("debug",0);
	}

	function madeinusa($prod = '')
	{
		$this->body_title = !empty($this->snippet_titles['made_in_usa']) ? $this->snippet_titles['made_in_usa'] : "Made in USA Products";
		$this->set("products", $this->Product->findAll("available = 'yes' AND parent_product_type_id IS NULL",null,'is_stock_item ASC, sort_index ASC'));
		$this->set("prod", $prod); # Show first if looking at.
	}

	function index() {
		unset($this->build['image_first']);
		$this->Session->delete("Build.image_first");
		#$this->set("stepname", "product"); 

		$this->Product->recursive = -1;
		#$this->body_title = "Design custom gifts created with your image or ours"; 
		#$this->body_title = "Premium quality custom gifts at off-the-shelf prices";
		#$this->body_title = "Unique gifts &bull; Free setup &amp; design with your order &bull; Use your image or ours";
		#$this->body_title = "Build custom gifts online &bull; Put your image (or ours) on products &bull; Free setup";
		$this->body_title = "Discover How Easy it is to Create Custom Gifts Online in Just a Few Clicks";
		#$this->body_title = "Unique personalized gifts &bull; Free setup &amp; design with your order &bull; Use your image or ours";
		$this->bread_title = "Products";
		#$this->set("body_title", "Select a Product:");
		#$this->set('products', $this->paginate());
		$this->breadcrumbs = false;

		$this->rightbar_disabled = true;

		#$this->set("items_per_row", $this->rightbar_disabled ? 6 : 3);
		$this->set("items_per_row", 6);
		#$this->set("rightbar_disabled", true);

		$this->ProductCategory->recursive = -1;

		$product_categories = $this->ProductCategory->findAll();
		$this->set("product_categories", $product_categories);

		$products_by_category = array();
		foreach($product_categories as $cat)
		{
			$pcid = $cat['ProductCategory']['product_category_id'];
			$pc_name = $cat['ProductCategory']['name'];
			$products = $this->Product->findAll("Product.available = 'yes' AND Product.parent_product_type_id IS NULL AND product_category_id = $pcid", array(), "sort_index, name");
			$products_by_category[$pc_name] = $products;
		}

		$this->set("products_by_category", $products_by_category);

		$product_category_map = Set::combine($product_categories, '{n}.ProductCategory.name', '{n}');
		$this->set("product_category_map", $product_category_map);
	}

	function quantityPricing($pricing_level = 'retail')
	{
		$prod = null;

		if($this->wholesale_site)
		{
			$pricing_level = 'wholesale';
		}

		if(!empty($_REQUEST['prod']))
		{
			$prod = $_REQUEST['prod'];
			# Get parent product if any.
			$product = $this->Product->find(" code = '$prod' ");
			if(!empty($product['Product']['parent_product_type_id']))
			{
				$parent = $this->Product->read(null, $product['Product']['parent_product_type_id']);
				$prod = $parent['Product']['code'];
			}
		}

		$this->body_title = "Product Pricing";
		if($pricing_level == 'wholesale') { $this->body_title .= " &mdash; WHOLESALE"; }

		$this->rightbar_disabled = true;
		$this->Product->link_product_details();
		$this->Product->link_related_products();
		$this->Product->recursive = 1;
		$products = $this->Product->findAll("available = 'yes' AND parent_product_type_id IS NULL", array(), "is_stock_item ASC, sort_index ASC"); # Parent products only...
		$product_pricings = $this->Product->get_pricing_chart_pricings($pricing_level == 'wholesale' ? 100 : 1);
		$this->set('product_pricings', $product_pricings);
		$this->set("products", $products);

		$this->set("products_by_code", Set::combine($products, "{n}.Product.code", "{n}"));

		$this->set("prod", $prod);

		# Loop through products, if parent, print (else skip). Print parent and print related/children.

	}

	function select($code = null) 
	{
		#$this->set("stepname", "product");

		if(empty($this->build['preview_layout']) && !empty($this->build['template']))
		{
			$this->build['preview_layout'] = $this->build['template'];
			if(!empty($this->build['options']['fullbleed']))
			{
				$this->build['preview_layout'] = 'fullbleed';
			}
		}
		$this->Session->write("Build", $this->build);

		#error_log("CODE=$code");

		if (isset($_REQUEST['code'])) { $code = $_REQUEST['code']; }
		if (isset($_REQUEST['productCode'])) { $code = $_REQUEST['productCode']; }

		if (isset($_REQUEST['quantity']))
		{
			$this->Session->write("Build.quantity", $_REQUEST['quantity']);
			$this->Session->write("Build.quantity_price", $this->Product->get_effective_base_price($code, $_REQUEST['quantity'], $this->Session->read("Auth.Customer")));
		} else {
			$this->Session->delete("Build.quantity");
			$this->Session->delete("Build.quantity_price");
		}



		#error_log(print_r($this->params,true));

		if (!empty($_REQUEST['catalog_number'])) { $this->Session->write("Build.catalog_number", $_REQUEST['catalog_number']); $this->Session->delete("Build.imageID"); }
		if (!empty($_REQUEST['imageID'])) { $this->Session->write("Build.imageID", $_REQUEST['imageID']);$this->Session->delete("Build.catalog_number");  }

		$catalog_number = $this->Session->read("Build.GalleryImage.catalog_number");
		$image_id = $this->Session->read("Build.CustomImage.Image_ID");
		
		$build = $this->Session->read("Build");

		# NO LONGER ASSUMING PRODUCT.
		#if (!$code) { $code = $this->Session->read("Build.productCode"); }
		#if (!$code) { $code = $this->Session->read("Build.prod"); }
		$product = $code ? $this->Product->find("code = '$code'") : null;
		#Session->read("Build.Product");

		#error_log("CODE2=$code");

		#if (isset($this->params['url']['new']) || empty($product))
		if (isset($this->params['url']['new']))# || empty($product))
		{
			$code = null;
			$this->Session->delete("Build.Product");
			$this->Session->delete("Build.productCode");
			$this->Session->delete("Build.prod");
		}

		if (isset($_REQUEST['start_over'])) { $this->rightbar_disabled = true; }
		$this->rightbar_disabled = true;

		if ($code)
		{
		#	error_log("CODE..........");
			$product = $this->Product->find("code = '$code'");

			if ($product['Product']['is_stock_item']) { $this->redirect("/details/".$product['Product']['prod'].".php"); } # Force to enter in qty from landing page.

			$this->Session->write("Build.productCode", $code);
			$this->Session->write("Build.Product", $product['Product']);
			$this->Session->delete("Build.cart_item_id"); # Don't modify cart!
			#error_log("BUILD=".print_r($_SESSION,true));
			#error_log("CAT=$catalog_number, IM=$image_id");
			$image_types = split(",", $product['Product']['image_type']);

			$cannot_custom_image = true;
			$cannot_gallery_image = true;

			foreach($image_types as $image_type)
			{
				if($image_type == 'real')
				{
					$cannot_gallery_image = false;
				} else if ($image_type == 'repro') {
					$cannot_gallery_image = false;
				} else if ($image_type == 'custom') {
					$cannot_custom_image = false;
				}
			}

			#error_log("PROD_TYPE=".print_r($image_types,true));

			if ($catalog_number || $image_id) # Redirect to build.
			{
				#$this->redirect("/product/build.php?prod=$code&catalogNumber=$catalog_number&image_id=$image_id&clear=1");
				$this->redirect("/build/create/$code?new=1&catalogNumber=$catalog_number&image_id=$image_id&clear=1");
				# ALWAYS ASK FOR THE PRODUCT 2009-08-20
				#$this->redirect("/build?prod=$code&catalogNumber=$catalog_number&image_id=$image_id");
			} else if ($cannot_custom_image) { # Cannot do custom image
				$this->redirect("/gallery/browse");
			} else if ($cannot_gallery_image) { # Cannot do stamp
				$this->redirect("/custom_images");
			#} else if ($product['Product']['is_stock_item']) {
			#	$this->redirect("/custom_images");
#
			} else { # Redirect to /gallery, let them choose custom vs gallery
				$this->redirect("/gallery");
			}
		}

		$this->set("rightbar_template", "build/rightbar");

		$image_name = "";
		if ($catalog_number)
		{
			$this->build['step'] = 2;
			$image = $this->GalleryImage->find("GalleryImage.catalog_number = '$catalog_number'");
			$image_name = '"' . $image['GalleryImage']['stamp_name'] . '"';
			$this->set("products", $this->getImageAvailableProducts($catalog_number));
			$this->set("galleryImage", $image);
			$this->action = "select_image_products";
		} else if ($image_id) { 
			$this->build['step'] = 2;
			$image = $this->CustomImage->read(null, $image_id);
			$image_name = '"' . $image['CustomImage']['Title'] . '"';
			$this->set("products", $this->getCustomImageAvailableProducts());
			$this->set("customImage", $image);

			$this->action = "select_image_products";

		} else { # Haven't chosen one yet.
			$this->redirect("/products");
			# GO to homepage since no image selected...


			$this->build['step'] = 1;
			#$this->set("items_per_row", 6);
			#$this->set("rightbar_disabled", true);
			$this->Product->recursive = 1;
			$this->set("popular_products", $this->Product->findAll("available = 'yes' AND is_popular = 1 AND buildable = 'yes'", array(), 'sort_index, name'));
			$this->set("all_products", $this->Product->findAll("available = 'yes' AND is_stock_item = 0 AND buildable = 'yes'", array(), 'sort_index, name'));
			$this->set("products", $this->Product->findAll("available = 'yes' AND is_stock_item = 0 AND buildable = 'yes'", array(), 'sort_index, name'));
			$this->Product->recursive = 0;
			# So domed shows up as 'Choose' item and bookcharm doesnt (based on buildable only)
			#$this->set("popular_products", $this->Product->findAll("available = 'yes' AND is_popular = 1 AND buildable = 'yes' AND parent_product_type_id IS NULL", array(), 'sort_index, name'));
			#$this->set("all_products", $this->Product->findAll("available = 'yes' AND is_stock_item = 0 AND buildable = 'yes' AND parent_product_type_id IS NULL", array(), 'sort_index, name'));
			#$this->set("products", $this->Product->findAll("available = 'yes' AND is_stock_item = 0 AND buildable = 'yes' AND parent_product_type_id IS NULL", array(), 'sort_index, name'));

			#$this->action = "index";
			$this->action = "select_image_products";
		}
		$this->set("product_build_link", true);

		$this->set("items_per_row", $this->rightbar_disabled ? 5 : 4);

		#$this->set("body_title", "Choose a product for your $image_name gift:");
		#$this->set("body_title", "Choose your $image_name product:");
		#$this->set("body_title", "Click on a(n) $image_name product below to get started:");
		#$this->set("body_title", "Click on a product below to " . (!empty($this->build['CustomImage']) ? "choose a layout:" : "get started:"));
		$this->set("body_title", "Click on a product below to personalize online(select)");

	}

	function admin_select($code = null) 
	{
		#$this->set("stepname", "product");

		#error_log("CODE=$code");

		if (isset($_REQUEST['code'])) { $code = $_REQUEST['code']; }
		if (isset($_REQUEST['productCode'])) { $code = $_REQUEST['productCode']; }
		if (isset($_REQUEST['catalog_number'])) { $this->set_build_gallery_image($_REQUEST['catalog_number']); }
		if (isset($_REQUEST['image_id'])) { $this->set_build_custom_image($_REQUEST['image_id']); }

		if (isset($_REQUEST['quantity']))
		{
			$this->Session->write("Build.quantity", $_REQUEST['quantity']);
			$this->Session->write("Build.quantity_price", $this->Product->get_effective_base_price($code, $_REQUEST['quantity'], $this->Session->read("Auth.Customer")));
		} else {
			$this->Session->delete("Build.quantity");
			$this->Session->delete("Build.quantity_price");
		}



		#error_log(print_r($this->params,true));

		if (!empty($_REQUEST['catalog_number'])) { $this->Session->write("Build.catalog_number", $_REQUEST['catalog_number']); $this->Session->delete("Build.imageID"); }
		if (!empty($_REQUEST['imageID'])) { $this->Session->write("Build.imageID", $_REQUEST['imageID']);$this->Session->delete("Build.catalog_number");  }

		$catalog_number = $this->Session->read("Build.GalleryImage.catalog_number");
		$image_id = $this->Session->read("Build.CustomImage.Image_ID");
		
		$build = $this->Session->read("Build");

		# NO LONGER ASSUMING PRODUCT.
		#if (!$code) { $code = $this->Session->read("Build.productCode"); }
		#if (!$code) { $code = $this->Session->read("Build.prod"); }
		$product = $code ? $this->Product->find("code = '$code'") : null;
		#Session->read("Build.Product");

		#error_log("CODE2=$code");

		#if (isset($this->params['url']['new']) || empty($product))
		if (isset($this->params['url']['new']))# || empty($product))
		{
			$code = null;
			$this->Session->delete("Build.Product");
			$this->Session->delete("Build.productCode");
			$this->Session->delete("Build.prod");
		}

		if (isset($_REQUEST['start_over'])) { $this->rightbar_disabled = true; }
		$this->rightbar_disabled = true;

		if ($code)
		{
		#	error_log("CODE..........");
			$product = $this->Product->find("code = '$code'");

			if ($product['Product']['is_stock_item']) { $this->redirect("/details/".$product['Product']['prod'].".php"); } # Force to enter in qty from landing page.

			$this->Session->write("Build.productCode", $code);
			$this->Session->write("Build.Product", $product['Product']);
			$this->Session->delete("Build.cart_item_id"); # Don't modify cart!
			#error_log("BUILD=".print_r($_SESSION,true));
			#error_log("CAT=$catalog_number, IM=$image_id");
			$image_types = split(",", $product['Product']['image_type']);

			$cannot_custom_image = true;
			$cannot_gallery_image = true;

			foreach($image_types as $image_type)
			{
				if($image_type == 'real')
				{
					$cannot_gallery_image = false;
				} else if ($image_type == 'repro') {
					$cannot_gallery_image = false;
				} else if ($image_type == 'custom') {
					$cannot_custom_image = false;
				}
			}

			#error_log("PROD_TYPE=".print_r($image_types,true));

			if ($catalog_number || $image_id) # Redirect to build.
			{
				#$this->redirect("/product/build.php?prod=$code&catalogNumber=$catalog_number&image_id=$image_id&clear=1");
				$this->redirect("/build/create/$code?catalogNumber=$catalog_number&image_id=$image_id&clear=1");
				# ALWAYS ASK FOR THE PRODUCT 2009-08-20
				#$this->redirect("/build?prod=$code&catalogNumber=$catalog_number&image_id=$image_id");
			} else if ($cannot_custom_image) { # Cannot do custom image
				$this->redirect("/gallery/browse");
			} else if ($cannot_gallery_image) { # Cannot do stamp
				$this->redirect("/custom_images");
			#} else if ($product['Product']['is_stock_item']) {
			#	$this->redirect("/custom_images");
#
			} else { # Redirect to /gallery, let them choose custom vs gallery
				$this->redirect("/gallery");
			}
		}

		$this->set("rightbar_template", "build/rightbar");

		$image_name = "";
		if ($catalog_number)
		{
			$this->build['step'] = 2;
			$image = $this->GalleryImage->find("GalleryImage.catalog_number = '$catalog_number'");
			$image_name = $image['GalleryImage']['stamp_name'];
			$this->set("products", $this->getImageAvailableProducts($catalog_number));

			$this->set("galleryImage", $image);
			#$this->set("rightbar_template", "build/preview/gallery_image");

			$this->action = "admin_select_image_products";
		} else if ($image_id) { 
			$this->build['step'] = 2;
			$image = $this->CustomImage->read(null, $image_id);
			$image_name = $image['CustomImage']['Title'];
			$this->set("products", $this->getCustomImageAvailableProducts());

			$this->set("customImage", $image);
			#$this->set("rightbar_template", "build/preview/custom_image");

			$this->action = "admin_select_image_products";

		} else { # Haven't chosen one yet.
			$this->redirect("/products");
			# GO to homepage since no image selected...


			$this->build['step'] = 1;
			#$this->set("items_per_row", 6);
			#$this->set("rightbar_disabled", true);
			$this->Product->recursive = 1;
			$this->set("popular_products", $this->Product->findAll("available = 'yes' AND is_popular = 1 AND buildable = 'yes'", array(), 'sort_index, name'));
			$this->set("all_products", $this->Product->findAll("available = 'yes' AND is_stock_item = 0 AND buildable = 'yes'", array(), 'sort_index, name'));
			$this->set("products", $this->Product->findAll("available = 'yes' AND is_stock_item = 0 AND buildable = 'yes'", array(), 'sort_index, name'));
			$this->Product->recursive = 0;
			# So domed shows up as 'Choose' item and bookcharm doesnt (based on buildable only)
			#$this->set("popular_products", $this->Product->findAll("available = 'yes' AND is_popular = 1 AND buildable = 'yes' AND parent_product_type_id IS NULL", array(), 'sort_index, name'));
			#$this->set("all_products", $this->Product->findAll("available = 'yes' AND is_stock_item = 0 AND buildable = 'yes' AND parent_product_type_id IS NULL", array(), 'sort_index, name'));
			#$this->set("products", $this->Product->findAll("available = 'yes' AND is_stock_item = 0 AND buildable = 'yes' AND parent_product_type_id IS NULL", array(), 'sort_index, name'));

			#$this->action = "index";
			$this->action = "admin_select_image_products";
		}
		$this->set("product_build_link", true);

		$this->set("image_name", $image_name);

		$this->set("items_per_row", $this->rightbar_disabled ? 4 : 3);

		#$this->set("body_title", "Choose a product for your $image_name gift:");
		#$this->set("body_title", "Choose your $image_name product:");
		#$this->set("body_title", "Click on a(n) $image_name product below to get started:");
		#$this->set("body_title", "Click on a product below to " . (!empty($this->build['CustomImage']) ? "choose a layout:" : "get started:"));
		$this->set("body_title", "Click on a product below to get started:");

	}

	function admin_send_email()
	{
		$catalog_number = !empty($this->build['GalleryImage']) ? $this->build['GalleryImage']['catalog_number'] : null;
		$image_id = !empty($this->build['CustomImage']) ? $this->build['CustomImage']['Image_ID'] : null;
		
		$emails = preg_split("/(\n|\r\n|\r|[ ]+|[ ]*,[ ]*)/", $this->data['emails']);
		$message = $this->data['message'];
		$subject = $this->data['subject'];

		if ($catalog_number)
		{
			$image = $this->GalleryImage->find("GalleryImage.catalog_number = '$catalog_number'");
			$image_name = $image['GalleryImage']['stamp_name'];
			$this->set("products", $this->getImageAvailableProducts($catalog_number));
			$this->set("galleryImage", $image);
		} else if ($image_id) { 
			$image = $this->CustomImage->read(null, $image_id);
			$image_name = $image['CustomImage']['Title'];
			$this->set("products", $this->getCustomImageAvailableProducts());
			$this->set("customImage", $image);
		}

		# Eventually send to entire list quicker.

		foreach($emails as $email)
		{
			if(!preg_match("/.*@.*[.].*/", $email))
			{
				continue; # Bogus.
			}
			$this->sendEmail($email, $subject, "all_products", array('message'=>$message, 'build'=>$this->build,'product_build_link'=>1,'no_view_larger'=>1));
		}
		$this->Session->setFlash("Your email has been sent.");
		$this->redirect($_SERVER['HTTP_REFERER']);

	}

	function pressready()
	{
		$prod = !empty($_REQUEST['prod']) ? $_REQUEST['prod'] : $this->build['Product']['prod'];
		if ($prod)
		{
			$product = $this->Product->find(" code = '$prod' ");
			$this->build['Product'] = $product['Product'];
		}
		$this->Session->write("Build", $this->build);

		$this->redirect("/custom_images/pressready");
	}

	/*
	function template($template = '')
	{
		# ONLY if more than one layout possible, give option. Otherwise, skip and redirect....

		$this->set("body_title", "Select a product layout");
		$prod = !empty($_REQUEST['prod']) ? $_REQUEST['prod'] : $this->build['Product']['prod'];
		$templates = array();
		if ($prod)
		{
			$product = $this->Product->find(" code = '$prod' ");
			$this->build['Product'] = $product['Product'];
			$templates = split(",", $product['Product']['product_template']);
			$this->set("product_templates", $templates);
		}

		# Clear, either way.
		$this->build['template'] = $template;
		$this->Session->write("Build", $this->build);

		if (!empty($template) || empty($templates))
		{
			# We chose it (or none to choose from), now set and redirect appropriate.... ie if no image, skip image chooser...

			if ($template == 'textonly' || !(empty($this->build['GalleryImage']) || empty($this->build['CustomImage'])))
			{
				$this->redirect("/build/create/$prod?new=1");
			} else { # Select image.
				# WHAT IF ALREADY CHOSEN? How do we properly choose a layout? (above may fix)
				$this->redirect("/gallery?prod=$prod");
			}
		}
		$this->set("prod", $prod);

		# Select image...
		#$this->redirect("/gallery?prod=$prod");
	}
	*/

	function preview_all()
	{
		$products = $this->Product->findAll("available = 'yes' AND buildable = 'yes' AND is_stock_item = 0");
		$this->set("products", $products);
	}

	function preview($code = '')
	{
		# XXX EVENTUALLY MOVE TO COMPONENT!!!!!!!!!!!!!
		Configure::write("debug", 0);
		$tmpname = tempnam("/tmp", "hd_product_preview_");
		#HOW HANDLE WARNING???

		$basedir = dirname(__FILE__)."/../../images/products/blanks";
		$vertical_dir = "$basedir/$code/vertical";
		$horiz_dir = "$basedir/$code/horizontal";

		# Determine based off of IMAGE ORIENTATION XXX TODO

		#
		$dir = "";
		#error_log("VD=$vertical_dir");
		#error_log("HD=$horiz_dir");
		if (file_exists($vertical_dir)) { $dir = $vertical_dir; }
		else if (file_exists($horiz_dir)) { $dir = $horiz_dir; }

		$svgfile = "$dir/svg/$code.svg"; 
		if (!file_exists($svgfile))
		{
			$svgfile = "$dir/svg/$code.png";
		}

		#error_log("SVGFILE=$svgfile");

		$svg_raw_content = file_get_contents($svgfile);
		$svg_content = $svg_raw_content;

		#error_log("TMPNAME=$tmpname");

		$svghandle = fopen("$tmpname.svg", "w");
		fwrite($svghandle, $svg_content);
		fclose($svghandle);

		#$raw_image = shell_exec("convert $tmpname.svg png:-");
		$raw_image = shell_exec("convert -resize 100x $tmpname.svg png:-");
		# MAY BE FAULTY, freezing....

		unlink("$tmpname.svg");
	
		header("Content-Type: image/png");
		#header("Content-Type: text/plain");
		$size = count($raw_image);
		header("Length: $size");
		echo $raw_image;
		#echo "CRAP=$size";

		exit(0);
	}

	function stock_calc_process($code, $quantity, $customized = false)
	{
		if(!empty($quantity))
		{
			$product = $this->Product->find(" code = '$code' ");
			$customer = $this->get_customer();
			$this->set("quantity", $quantity);
			$total = $this->Product->get_effective_base_price($code, $quantity, $customer);
			$subtotal = $total['total'] * $quantity;
			$base_price_list = $this->Product->get_effective_base_price($code, $product['Product']['minimum']);
			$base_price = $base_price_list['total'];
			$this->set("base_price", $base_price);

			$setup = !empty($customized) && !empty($product['Product']['setup_charge']) ? $product['Product']['setup_charge'] : null;

			if(empty($customized))
			{
				$this->Session->delete("Preview");
			}

			#error_log("CODE=$code, Q=$quantity, T=$subtotal");
			$this->set("unitPrice", $total['total']);
			$this->set("subtotal", $subtotal+$setup);
			$this->set("original_subtotal", $base_price*$quantity+$setup);
			$this->set("setup", $setup);
			$this->set("customized", $customized);
		}
	}

	function stock_calc($code)
	{
		$this->layout = 'ajax';
		# XXX TODO losing selected one.
		# maybe pass??? via ajax, etc.
		$product = $this->Product->find(" code = '$code' ");
		$this->set("product", $product);
		$quantity = !empty($this->params['form']['quantity']) ? $this->params['form']['quantity'] : $product['Product']['minimum'];
		$this->set("quantity", $quantity);
		if(!empty($quantity))
		{
			$this->stock_calc_process($code, $quantity, !empty($this->params['form']['customized']) );
		}
		$this->set("p", $product['Product']);
		$this->set("prod", $code);
		if($code == 'CH')
		{
			if(!empty($this->params['form']['charm_id']))
			{
				$this->set("charm_id", $this->params['form']['charm_id']);
			}
			$charms = $this->Charm->findAll("Charm.available = 'yes'", array('DISTINCT charm_id','*'), "name ASC");
			$this->set("charms", $charms);
		} else if ($code == 'TA') {
			if(!empty($this->params['form']['tassel_id']))
			{
				$this->set("tassel_id", $this->params['form']['tassel_id']);
			}
			$tassels = $this->Tassel->findAll("Tassel.available = 'yes'", array('DISTINCT tassel_id','*'), "color_name ASC");
			$this->set("tassels", $tassels);
		} else if (in_array($code, array('PWK','DPWK','MPWK','DPWK-FLC'))) {
			$pid = $product['Product']['product_type_id'];
			$ppid = $product['Product']['parent_product_type_id'];
			$related = $this->Product->findAll("(Product.product_type_id IN ('$pid','$ppid') OR Product.parent_product_type_id IN ('$pid','$ppid')) AND Product.available = 'yes'",null, 'choose_index ASC');
			$compare = array();
			$compare[] = $product['Product'];
			foreach($related as $rp)
			{
				$compare_products[] = $rp['Product'];
			}
			usort($compare_products, array($this, "compare_products_sort"));

			$this->set("compare_products", $compare_products);
		}
		$this->render("/elements/products/stock_calc");
	}

	function pricing_calculator($code)
	{
		if(empty($this->params['isAjax'])) { $this->layout = 'default_plain'; if(empty($_REQUEST['debug'])) { Configure::write("debug", 0); } }
		$product = $this->Product->find(" code = '$code' ");
		# Default quantity.
		$quantity = $product['Product']['minimum'];

		$pid = $product['Product']['product_type_id'];
		$ppid = $product['Product']['parent_product_type_id'];

		# Get list or related items for dropdown, if any.

		$related_products = $this->Product->find('all', array('fields'=>array('pricing_name'),'conditions'=>" available = 'yes' AND (parent_product_type_id = '$pid' OR product_type_id = '$pid' OR parent_product_type_id = '$ppid' OR product_type_id = '$ppid') ",'order'=>'choose_index ASC'));
		$this->set("related_products", $related_products);
		
		if(!empty($this->data))
		{
			if(!empty($this->data['Product']['prod']))
			{
				$code = $this->data['Product']['prod'];
			}
			$product = $this->Product->find(" code = '$code' ");
			# Default quantity.
			$quantity = $product['Product']['minimum'];

			if(!empty($this->data['Product']['quantity']) && $this->data['Product']['quantity'] > $quantity) { $quantity = $this->data['Product']['quantity']; }

		}

		# Now get pricing.
		$customer = $this->get_customer();
		$pricing = $this->Product->get_effective_base_price($code, $quantity, $customer);

		$this->set("pricing", $pricing); 

		if(!empty($this->data['Product']['zipCode']))
		{
			# Calculate shipping.
			$zipCode = $this->data['Product']['zipCode'];

			$product_list = array($code=>$quantity);
			$shippingOptions = $this->ShippingPricePoint->calculate_shipping_options_list($zipCode, $product_list, $pricing['total']*$quantity, !empty($customer['is_wholesale']));

			$this->set("shippingOptions", $shippingOptions);
		}

		$this->data['Product']['quantity'] = $quantity;
		$this->data['Product']['prod'] = $code;
		$this->set("prod", $code);


	}
	
	function pricing_chart($code)
	{
		Configure::write("debug", 0);
		$this->Product->recursive = 2;
		$this->Product->link_product_details();
		$this->layout = "default_plain";
		$product = $this->Product->find(" code = '$code' ");
		$this->set("product", $product);
		$pricings = $this->Product->generate_pricing_list($product);
		$this->set('product_pricings', $pricings);
	}

	function wholesale_pricing()
	{
		$this->body_title = "Wholesale Pricing";
		$this->layout = 'default_plain';
		Configure::write('debug',0);
		$this->Product->recursive = 1;
		if (!empty($_REQUEST['prod']))
		{
			$prod = $_REQUEST['prod'];
			$product = $this->Product->find(" code = '$prod' ");
			$pid = $product['Product']['product_type_id'];

			$products = $this->Product->findAll("available = 'yes' AND (parent_product_type_id = '$pid' OR product_type_id = '$pid')", array(), 'is_stock_item ASC, name, short_name');
		} else {
			$products = $this->Product->findAll("available = 'yes'", array(), 'is_stock_item ASC, name, short_name');
		}
		$pricing = array();
		$quantity_breaks = array(12, 250, 500,1001);
		foreach($products as &$product)
		{
			$prod = $product['Product']['code'];
			$pricing[$prod] = array();
			foreach($quantity_breaks as $qty)
			{
				$effective_quantity = $qty < 100 ? 100 : $qty;
				foreach($product['ProductPricing'] as $pricing_level)
				{
					if ($pricing_level['quantity'] <= $effective_quantity && $pricing_level['price'] > 0) 
					{
						$pricing[$prod][$qty] = $pricing_level['price'];
					}

				}
			}
			if (empty($product['Product']['is_stock_item']) && !preg_match("/Custom/i", $product['Product']['name']))
			{
				$product['Product']['name'] = "Custom ".$product['Product']['name'];
			}
			
		}
		usort($products, array($this, "products_by_name"));

		$all_products = $this->Product->findAll("available = 'yes' AND parent_product_type_id IS NULL", array(), 'is_stock_item ASC, short_name, name');
		$this->set("all_products", $all_products);
		$this->set("quantity_breaks", $quantity_breaks);
		$this->set("products", $products);
		$this->set("pricing", $pricing);



		$pros = $this->Product->findAll();

		$products_by_id = Set::combine($pros, '{n}.Product.product_type_id', '{n}');
		$products_by_code = Set::combine($pros, '{n}.Product.code', '{n}');
		$parent_code_by_code = array();
		foreach($products_by_code as $code => $p)
		{
			if(!empty($p['Product']['parent_product_type_id']))
			{
				$parent_id = $p['Product']['parent_product_type_id'];
				$parent_code_by_code[$code] = $products_by_id[$parent_id]['Product']['code'];
			}
		}

		$product_pricings = array();

		foreach($pricing as $code => $prices)
		{
			$parent_code = !empty($parent_code_by_code[$code]) ? $parent_code_by_code[$code] : $code;

			$pricing_data = array();
			$i = 0;
			foreach($prices as $qty => $price)
			{
				$pricing_data[$i] = array(
					'price'=>$price,
					'min_quantity' => $qty
				);
				if($i > 0) # Set top of previous tier.
				{
					$pricing_data[$i-1]['max_quantity'] = $qty-1;
				}
				
				$i++;
			}
			$product_pricings[$parent_code][] = array(
				'name'=>$products_by_code[$code]['Product']['pricing_name'],
				'desc'=>$products_by_code[$code]['Product']['pricing_description'],
				'pricing_data'=>$pricing_data,

			);
			
		}

		#echo "**********************************************";

		#print_r($product_pricings);


		$this->set("product_pricings", $product_pricings);
	}

	function products_by_name($a,$b)
	{
		if ($a['Product']['is_stock_item'] == $b['Product']['is_stock_item'])
		{
			return strcmp($a['Product']['name'], $b['Product']['name']);
		} else {
			if (!$a['Product']['is_stock_item']) { return -1; }
			return 1;
		}
	}

	function test_ajax()
	{
		Configure::write("debug", 0);
		$this->layout = 'ajax';
	}

	function ajax_image_preview($prod = '')
	{
		ini_set("display_errors", 0);
		Configure::write("debug", 0);
		$this->layout = 'ajax';
		$this->set("prod", $prod);

		$this->Product->link_product_details();
		$product = $this->Product->find(" code = '$prod' ");
		$this->build['Product'] = $product['Product'];
		$this->set("product", $product['Product']);
		$this->set("build", $this->build); 
		$this->set("build_preview", true);
		# JUST DONT SET SESSION->build!
	}

	function view($id = null) 
	{

		$session_id = session_id();
		$customer_id = $this->get_customer_id();
		$this->set("custom_images", $this->CustomImage->find(" CustomImage.session_id = '$session_id' ". (!empty($customer_id) ? " OR CustomImage.customer_id = '$customer_id' " : "")));

		if(!empty($_REQUEST['catalog_number']))
		{
			$gallery_image = $this->GalleryImage->find(" GalleryImage.catalog_number = '". $_REQUEST['catalog_number']. "'");
			$this->build['GalleryImage'] = $gallery_image['GalleryImage'];
			unset($this->build['CustomImage']);
			$this->Session->write("Build", $this->build);
		}
		else if(!empty($_REQUEST['image_id']))
		{
			$custom_image = $this->CustomImage->read(null, $_REQUEST['image_id']);
			$this->build['CustomImage'] = $custom_image['CustomImage'];
			unset($this->build['GalleryImage']);
			$this->Session->write("Build", $this->build);
		}
		#print_r($this->build);

		$this->body_title_crumbs = false;
		if (!$id) {
			$this->Session->setFlash(__('Invalid Product.', true));
			$this->redirect(array('action'=>'index'));
		}
		$id = preg_replace("/[.]php$/", "", $id); # If routed.

		$this->Product->recursive = 1;
		$this->Product->link_product_details();
		##error_log("NUM($id)=".is_numeric($id));
		if (!is_numeric($id))
		{
			$product = $this->Product->findByProd($id);
		} else {
			$product = $this->Product->read(null, $id);
		}
		$this->Product->recursive = 1;
		if (!$product)
		{
			$this->redirect("/products");
			exit(0);
		}
		if(strtolower($product['Product']['available']) != 'yes')
		{
			$this->redirect("/"); 
		}

		if(empty($product['Product']['is_stock_item']))
		{
			#$this->set("stepname", "product"); 
		}

		#print_r($product['RelatedProducts']);
		$parent_id = $product['Product']['parent_product_type_id'];
		$prod = $product['Product']['prod'];
		$code = $product['Product']['code'];
		$parent_product = $parent = null;
		$this->track("products", "view", array('productCode'=>$code));

		#if ($parent_id)
		#{
		#	$parent_product = $parent = $this->Product->read(null, $parent_id);
		#}

		# If we asked for a child, go to parent page!
		if (!empty($parent_id))
		{
			$this->redirect(array('action'=>'view',$parent_id));
		}

		#$this->set("parent_product", $parent);
		$code = $product['Product']['code'];
		$productCode = $product['Product']['prod'];
		$this->set("prod", $code);

		$pid = $product_type_id = $product['Product']['product_type_id'];
		$this->Product->recursive = 1;
		$this->Product->link_product_details();
		$related = $this->Product->findAll("(Product.product_type_id = '$pid' OR Product.parent_product_type_id = '$pid') AND Product.available = 'yes'",null,'choose_index ASC',null, 'choose_index ASC');
		# TOMAS XXX

		$price_lists[$code] = $this->get_effective_base_price_list($product, false);

		#$all_products = $this->Product->findAll("(Product.parent_product_type_id = '$pid' OR Product.product_type_id = '$pid') AND Product.available = 'yes'");

		#foreach($all_products as $ap)
		foreach($related as $ap)
		{
			$rpcode = $ap['Product']['code'];
			$price_lists[$rpcode] = $this->get_effective_base_price_list($ap, false);
		}

		$this->set("price_lists", $price_lists);

		$related_by_id = Set::combine($related, "{n}.Product.product_type_id", "{n}");
		#print_r($related_by_id);

		$this->set("related_products_by_id", $related_by_id); # We need to bind separately so we can get THEIR pricing and albums....
		$this->set("related_products", $related); # We need to bind separately so we can get THEIR pricing and albums....
		$this->set("related", $related);
		#print_r($related);

		$this->breadcrumbs["/products/view/".$product['Product']['prod']] = ($product['Product']['short_name'] ?  $this->pluralize($product['Product']['short_name']) : $this->pluralize($product['Product']['name']));

		# Now load list of product options

		$product_option_field = "";
		$product_options = array();
		$default_product_option_value = "";

		if ($prod == 'charm')
		{
			$product_options[""] = "None Selected";
			$charms = $this->Charm->findAll("Charm.available = 'yes'", array('DISTINCT charm_id','*'), "name ASC");
			foreach($charms as $charm)
			{
				$product_options[$charm['Charm']['charm_id']] = ucwords($charm['Charm']['name']);
			}
			$product_option_field = "charmID";
		} else if ($prod == 'tassel') { 
			$product_options[""] = "None Selected";
			$tassels = $this->Tassel->findAll("Tassel.available = 'yes'", array('DISTINCT tassel_id','*'), "color_name ASC");
			#print_r($tassels);
			foreach($tassels as $tassel)
			{
				$product_options[$tassel['Tassel']['tassel_id']] = ucwords($tassel['Tassel']['color_name']);
			}
			$product_option_field = "tasselID";

		} else {
			if (count($related) > 0)
			{
				if (!empty($parent_product))
				{
					$product_options[$parent_product['Product']['code']] = $parent_product['Product']['name'];
				}
				foreach($related as $related_product)
				{
					$product_options[$related_product['Product']['code']] = $related_product['Product']['name'];
				}
				$product_option_field = "productCode";
				$default_product_option_value = $code;
			}
		}

		$this->set("product_options", $product_options);
		$this->set("product_option_field", $product_option_field);
		$this->set("default_product_option_value", $default_product_option_value);

		$this->set('product', $product);
		#$pricings = $this->Product->generate_pricing_list($product);
		#$this->set('product_pricings', $pricings);
		#$quantity = $product_minimum = count($pricings) && count($pricings[0]['pricing_data']) ? $pricings[0]['pricing_data'][0]['min_quantity'] : $product['Product']['minimum'];
		$quantity = $product_minimum = $this->Product->get_minimum($product, $this->get_customer());
		#$product['Product']['minimum'];

		# Load item in cart if asking....
		if(!empty($_REQUEST['cart_item_id']))
		{
			$cartItem = $this->CartItem->read(null, $_REQUEST['cart_item_id']);
			if(!empty($cartItem))
			{
				$quantity = $cartItem['CartItem']['quantity'];
				$preview = $cartItem['CartItem'];
				$preview['options'] = unserialize($preview['parts']);
				if(!empty($preview['options']['personalization_logo_id']))
				{
					$customImage = $this->CustomImage->read(null, $preview['options']['personalization_logo_id']);
					$preview['PersonalizationLogo'] = $customImage['CustomImage'];
				}
				$this->Session->write("Preview", $preview);
			}
		}
		$this->set("preview", $this->Session->read("Preview"));





		$this->set('product_minimum', $product_minimum);
		$this->set('quantity', $quantity);
		#$qty_price = $this->Product->get_effective_base_price($code, $quantity, $this->Session->read("Auth.Customer"));
		#$this->set("quantity_price", $qty_price['total']);

		$this->set("product_plural_name", $this->Product->plural_name($product));
		$this->body_title = $product['Product']['body_title'];
		if (!$this->body_title) { $this->body_title = $product['Product']['name']; }
		#$this->set("body_title", $body_title);
		if ($product['Product']['page_title']) { $this->pageTitle = $product['Product']['page_title']; }

		# NOW SET META STUFF...
		if (!empty($product['Product']['meta_keywords'])) { $this->meta_keywords = $product['Product']['meta_keywords']; }
		if (!empty($product['Product']['meta_desc'])) { $this->meta_description = $product['Product']['meta_desc']; }

		#$minimum_price = $this->Product->get_minimum_price($code);
		#list($minimum_price,$minprice_qty) = $this->Product->get_minimum_price_qty($code);

		#$this->set("minimum_price", $minimum_price);
		#$this->set("minprice_qty", $minprice_qty);

		#echo $product['Product']['meta_desc'].", ".$product['Product']['meta_keywords'];

		# Stock items have a DIFFERENT sidebar...
		# XXX TODO

		$this->set("rightbar_disabled", true);
		if (isset($_REQUEST['new'])) { 
			$this->action = 'viewnew';
			#$this->set("rightbar_disabled", false);
			#$this->set("rightbar_template", "products/rightbar_new");
		}

		#if(!empty($product['AllRelatedProducts']) && ($this->malysoft || $this->hdtest))
		#{
			#$this->action = 'view_related';
		#}
		#else 
		$this->action = 'view_tabbed'; # Default now.

		#if($product['Product']['is_stock_item'] && count($related) <= 1)#product['AllRelatedProducts']))
		if(in_array($code, array('CH','TA','PB'))) 
		{
			$this->action = 'view_stock';
		}

		#if ($code == 'RL' || $code == 'PR')
		# We want to use upload version for rulers now...
		#if ($code == 'PR')
		#{
		#	$this->action = 'view_vertical';
		#}
		#echo "VV($code)";

		# NEW CALCULATOR ENABLED
		$this->set("rightbar_disabled", true);
		#$this->set("rightbar_disabled", false);
		#$this->set("rightbar_template", "products/rightbar_new");

		#if ($product['Product']['is_stock_item'])
		#{
		#	$this->build_page = false;
		#	$this->set("rightbar_template", "products/rightbar_stockitem");
		#} else {
		#	$this->set("rightbar_template", "products/rightbar");
		#}

		#if (preg_match("/malysoft/", $_SERVER['HTTP_HOST']))
		#{
		#} else {
		#	$this->set("rightbar_template", null);
		#}


		$this->product_set_variables($product['Product']['prod']);

		if (isset($this->params['url']['tab']))
		{
			$this->set("active_tab", $this->params['url']['tab']);
		}

		# Load faq stuff.....

		$this->FaqTopic->recursive = 2;
		$faq_topics = $this->FaqTopic->findAll("product_enabled = 1");
		$wholesale_topic = $this->FaqTopic->find("topic_name = 'Wholesale'");

		$faq_topics_list = Set::combine($faq_topics, '{n}.FaqTopic.topic_name', '{n}');

		$this->set("faqTopics", $faq_topics_list);
		$this->set("productFaq", $this->Faq->findAll("Faq.product_type_id = '$product_type_id' AND answer != '' AND answer IS NOT NULL"));
		$this->set("wholesaleFaq", $wholesale_topic['Faq']);
		$this->set("wholesaleContent", $this->ContentSnippet->find("snippet_code = 'wholesale'"));

		$this->Client->recursive = -1;
		$this->set("client_list", $this->Client->findAll());
		#if(!empty($_REQUEST['new'])) { $this->action = 'viewnew'; }

		#$compare_products = array($product['Product']);
		$compare_products = array();#$product['Product']);
		$compare_pricings = array();#$product['Product']);

		#if (!empty($product['AllRelatedProducts']))

		if (!empty($related))
		{
			#$compare_products[] = $product['Product'];
			#foreach($product['AllRelatedProducts'] as $rp)
			foreach($related as $rp)
			{
				$rpid = $rp['Product']['product_type_id'];
				# Now add features to list.
				$pricing = $this->Product->generate_pricing_list($rp,false);
				$compare_pricings[$rp['Product']['code']] = $pricing;
				$this->ProductFeature->recursive = 1;

				$compare_products[] = $rp['Product'];

			}

			usort($compare_products, array($this, "compare_products_sort"));
		}

		$this->set("compare_pricings", $compare_pricings);
		$this->set("compare_products", $compare_products);

		$this->ProductOption->recursive = 1;
		$product_options = $this->ProductOption->findAll(" ProductOption.product_type_id = '$pid' ", null, "ProductOption.sort_index ASC, ProductOption.product_option_id ASC");
		$this->set("product_options", $product_options);

		$prod = $product['Product']['code'];

		# ALL PRODUCTS NOW

		if(empty($product['Product']['is_stock_item']))
		{
			$this->action = 'view_compare';
		} else if(in_array($prod, array('B','BNT','BC','BB','DPW','DPW-FLC','PW','KC','SMKC'))) { 
			$this->action = 'view_compare';
		} else if (in_array($prod, array('PWK','DPWK','DPWK-FLC'))) { 
			$this->action = 'view_compare';

		} else if(in_array($prod, array('B','BNT','BC','KC','SMKC','DPW','PW','DPW-FLC'))) {
			#if(!empty($this->malysoft) || !empty($this->hdtest))
			#{
				$this->action = 'view_tabbed';
			#} else {
			#	$this->action = 'view_tabbed_orig';
			#}
		}

		#$this->action = "view.20100526";

		#$this->set("onLoad", "enableLinkTracking('{$this->params['url']['url']}');");

		if($product['Product']['is_stock_item'])
		{
			#$this->stock_calc_process($prod, $quantity, $this->Session->read("Preview.options.customized") );
			# Dont auto process on first call.
		}

		if(!empty($product['Product']['semi_customizable_quotes']))
		{
			$quoteIDs = preg_split("/\s+/", $product['Product']['semi_customizable_quotes']);
			$quotes = array();
			foreach($quoteIDs as $qid)
			{
				$quotes[] = $this->Quote->read(null, $qid);
			}
			$this->set("semi_customizable_quotes", $quotes);
		}

		$first_prod = !empty($compare_products) ? $compare_products[0]['code'] : $product['Product']['code'];

		$this->mini_calc($first_prod, $product['Product']['minimum']);
		$this->layout = 'default'; # Since calc switches.
	}


	function admin_shipping()
	{
		$this->Product->link_product_details();
		
		$this->ShippingPricePoint->free_shipping = false;

		$subtotal = 0;

		if (!empty($this->data['Product']['zipCode']))
		{
			$product_list = array();
			$quantities = array();
			$shippingWeight = 0;
			foreach($this->data['Products'] as $i => $p)
			{
				$code = $p['code'];
				$quantity = $p['quantity'];
				if (empty($product_list[$code])) { $product_list[$code] = 0; }
				$product_list[$code] += $quantity;
				$product = $this->Product->find(" code = '$code' ");
				$quantities[$i] = $quantity;
				#$products[$code] = $product;
				$products[$i] = $product['Product'];
				$shippingWeight += ($quantity * $product['Product']['weight']) * 0.00220462262; # To pounds.
				$pricing = $this->Product->get_effective_base_price($code, $quantity);
				$subtotal += $pricing['total']*$quantity;
			}
			$this->set("quantities", $quantities);
			$this->set("products", $products);
			$this->set("shippingWeight", $shippingWeight);

			$ships_by_time = $this->Product->get_shipment_time($product_list);
			$this->set("ships_by_time", $ships_by_time);

			
			$zipCode = $this->data['Product']['zipCode'];
			$country = $this->data['Product']['isoCode'];
			# calculate shipping
			$shippingOptions = $this->ShippingPricePoint->calculate_shipping_options_list(array($zipCode,$country), $product_list, $subtotal);
			$this->set("shippingOptions", $shippingOptions);
			$shippingOptionsByID = Set::combine($shippingOptions, '{n}.shippingMethod.shippingMethodID', '{n}');
			$this->set("shippingOptionsByID", $shippingOptionsByID);

			list($rush_dates, $fastestShippingMethodID) = $this->Product->get_rush_dates($shippingOptions, $product_list);
			$this->set("rush_dates", $rush_dates);
			$this->set("rush_shipping_method_id", $fastestShippingMethodID);


			$this->set("location", $this->ZipCode->find(" zip = '$zipCode' "));

			#echo "SW=$shippingWeight";

			$handlingCharge = $this->ShippingPricePoint->calculateHandlingCharge($shippingWeight);
			$this->set("handlingCharge", $handlingCharge);
		}

		$all_products = $this->Product->findAll(null, null, 'pricing_name');
		$all_products_map = Set::combine($all_products, '{n}.Product.code', '{n}.Product.pricing_name');
		$this->set("all_products_map", $all_products_map);
		$this->set("all_products", $all_products);
		$country = $this->Country->findAll();
		$this->set("countries", Set::combine($country, '{n}.Country.iso_code', '{n}.Country.name'));

		$this->set("subtotal", $subtotal);
	}

	function shipping_calculator_item($i = 1)
	{
		Configure::write("debug", 0);
		$this->layout = 'ajax';
		$this->set("i", $i);
		#$custom_products = $this->Product->findAll(" available = 'yes' AND is_stock_item = 0", null, 'pricing_name');
		#$stock_products = $this->Product->findAll(" available = 'yes' AND is_stock_item = 1", null, 'pricing_name');
		#$stock_products_map = $custom_products_map = array();
		/*
		foreach($custom_products as $custom)
		{
			$code = $custom['Product']['code'];
			#$name = $this->pluralize($custom['Product']['pricing_name']);
			$name = $custom['Product']['pricing_name'];
			$custom_products_map[$code] = $name;
		}

		foreach($stock_products as $stock)
		{
			$code = $stock['Product']['code'];
			#$name = $this->pluralize($stock['Product']['pricing_name']);
			$name = $stock['Product']['pricing_name'];
			$stock_products_map[$code] = $name;
		}
		*/

		#$all_products_map = array_merge($custom_products_map, $stock_products_map);
		$all_products_map = $this->Product->allProductMap();
		$this->set("all_products_map", $all_products_map);
		
	}

	function shipping()
	{
		if($this->Auth->user("is_admin"))
		{
			Configure::write("debug", 2);
		}
		$this->body_title = "Pricing &amp; Shipping Calculator";
		$this->Product->link_product_details();

		$subtotal = 0;

		if (!empty($this->data['Product']['zipCode']))
		{
			$customer = $this->get_customer();

			$product_list = array();
			$quantities = array();
			$shippingWeight = 0;

			foreach($this->data['Products'] as $i => $p)
			{
				$code = $p['code'];
				if(!$code) { continue; }
				$quantity = $p['quantity'];
				if(!$quantity) { continue; }
				if (empty($product_list[$code])) { $product_list[$code] = 0; }
				$product_list[$code] += $quantity;
				$product = $this->Product->find(" code = '$code' ");
				if($quantity < $product['Product']['minimum'])
				{
					$this->Session->setFlash("<img src='/images/warning.png' align='middle'/> Minimum is {$product['Product']['minimum']}");
					$quantity = $product['Product']['minimum'];
				}
				$pricing = $this->Product->get_effective_base_price($code, $quantity, $customer);
				$subtotal += $pricing['total']*$quantity;
				$quantities[$i] = $quantity;
				$products[$i] = $p;
				$w = ($quantity * $product['Product']['weight']) * 0.00220462262; # To pounds.
				$shippingWeight += $w;
			}


			if (!empty($product_list))
			{
				$this->set("quantities", $quantities);
				$this->set("products", $products);
				$this->set("shippingWeight", $shippingWeight);
				
				$zipCode = $this->data['Product']['zipCode'];
				$country = $this->data['Product']['isoCode'];
				#print_r($product_list);
				# calculate shipping
				$this->set("location", $this->ZipCode->find(" zip = '$zipCode' "));

				$shippingOptions = $this->ShippingPricePoint->calculate_shipping_options_list(array($zipCode,$country), $product_list, $subtotal, $customer['is_wholesale']);
				$this->set("shippingOptions", $shippingOptions);
				$shippingOptionsByID = Set::combine($shippingOptions, '{n}.shippingMethod.shippingMethodID', '{n}');
				$this->set("shippingOptionsByID", $shippingOptionsByID);
	
				#echo "SW=$shippingWeight";
				$ships_by_time = $this->Product->get_shipment_time($product_list);
				$this->set("ships_by_time", $ships_by_time);
	
				$handlingCharge = $this->ShippingPricePoint->calculateHandlingCharge($shippingWeight);
				$this->set("handlingCharge", $handlingCharge);

				list($rush_dates, $fastestShippingMethodID) = $this->Product->get_rush_dates($shippingOptions, $product_list);
				$this->set("rush_dates", $rush_dates);
				$this->set("rush_shipping_method_id", $fastestShippingMethodID);
			} else {
				$this->Session->setFlash("Specify a product and quantity");
			}
		} else if (!empty($this->data)) {
			$this->Session->setFlash("Please specify a zip code and item quantity");
		}

		$this->set("subtotal", $subtotal);
		/*
		$custom_products = $this->Product->findAll(" available = 'yes' AND is_stock_item = 0", null, 'pricing_name');
		$stock_products = $this->Product->findAll(" available = 'yes' AND is_stock_item = 1", null, 'pricing_name');
		$stock_products_map = $custom_products_map = array();
		foreach($custom_products as $custom)
		{
			$code = $custom['Product']['code'];
			#$name = (!preg_match("/Custom/i", $custom['Product']['pricing_name']) ? "Custom " : "") .$this->pluralize($custom['Product']['pricing_name']);
			$name = $custom['Product']['pricing_name'];
			$custom_products_map[$code] = $name;
		}

		foreach($stock_products as $stock)
		{
			$code = $stock['Product']['code'];
			#$name = $this->pluralize($stock['Product']['pricing_name']);
			$name = $stock['Product']['pricing_name'];
			$stock_products_map[$code] = $name;
		}

		$all_products_map = array_merge($custom_products_map, $stock_products_map);
		*/

		#$this->Product->bindModel(array('belongsTo'=>array("ParentProduct"=>array('className'=>'Product','foreignKey'=>'parent_product_type_id'))));

		$all_products_map = $this->Product->allProductMap();

		$this->set("all_products_map", $all_products_map);
		#$this->set("all_products", $all_products);
		$country = $this->Country->findAll(" can_order = 'Yes' ");
		$this->set("countries", Set::combine($country, '{n}.Country.iso_code', '{n}.Country.name'));

	}

	function get_started($path)
	{
		# Clear stuff.... so not tangled up...

		$this->clear_build_options();
		$this->initialize_new_build();

		if (!empty($_REQUEST['prod']))
		{
			$this->set_build_product($_REQUEST['prod']);
		}
		$prod = !empty($this->build["Product"]) ? $this->build['Product']['code'] : null;

		if (!empty($_REQUEST['clear_product']))
		{
			$this->set_build_product();
			$catalog_number = $this->build['GalleryImage']['catalog_number'];
			$this->redirect("/gallery/view/$catalog_number");
		}
		if (!empty($_REQUEST['catalog_number']))
		{
			$this->set_build_gallery_image($_REQUEST['catalog_number']);
		}
		if (!empty($_REQUEST['image_id']))
		{
			$this->set_build_custom_image($_REQUEST['image_id']);
		}

		$this->assert_valid_image_type_for_product();

		if ($path != 'build') # Clear image type if not going to reuse existing one...
		{
			$this->set_build_gallery_image(null);
			$this->set_build_custom_image(null);
		}

		if ($path == 'build')
		{
			#$this->redirect("/build/create");
			$this->redirect("/build/customize?new=1");
		} 
		else if ($path == 'gallery')
		{
			$this->redirect("/gallery/browse");
		} 
		else if ($path == 'custom_add')
		{
			$this->redirect("/custom_images?prod=$prod");
		} 
		else if ($path == 'custom' || $path = 'custom_images')
		{
			$this->redirect("/custom_images?prod=$prod");
		} 
		else if ($path == 'clipart')
		{
			$this->redirect("/gallery/clipart");
		} else {
			$this->redirect("/products");
		}
	}

	function calculator($code, $quantity = null)
	{
		error_log("PARAM=".print_r($this->params,true));
		#$this->layout = $this->RequestHandler->isAjax() ? "ajax" : "default_plain";
		if(empty($_REQUEST['debug'])) { Configure::write("debug", 0); }
		#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());

		$customer = $this->Session->read("Auth.Customer");

		$this->Product->link_product_details();
		$this->Product->link_product_customization();

		if (!empty($this->params['form']['productCode']))
		{
			$code = $this->params['form']['productCode'];
		}
		if ($code == 'B' && !empty($this->data['Product']['options']['charm']))
		{
			$code = 'BC';
		} else if ($code == 'CH') {
			$charms = $this->Charm->findAll("Charm.available = 'yes'", array('DISTINCT charm_id','*'), "name ASC");
			$this->set("charms", $charms);
		} else if ($code == 'TA') { 
			$tassels = $this->Tassel->findAll("Tassel.available = 'yes'", array('DISTINCT tassel_id','*'), "color_name ASC");
			$this->set("tassels", $tassels);

		}
		#if ($code == 'B' && empty($this->data['Product']['options']['tassel']))
		#{
		#	$code = 'BNT';
		##}
		#if (true || !empty($this->params['isAjax'])) { Configure::write('debug', 0); }
		$this->Product->recursive = 2;
		$product = $this->Product->find("code = '$code'");

		$pid = $product['Product']['product_type_id'];

		# If we're a child product, find the parent product and all children from there....
		$ppid = $parent_id = $product['Product']['parent_product_type_id'];
		if ($parent_id)
		{
			$parent_product = $this->Product->find("product_type_id = '$parent_id'");
		} else {
			$parent_id = $pid;
			$parent_product = $product;
		}
		$this->Product->recursive = 1;
		$related = $this->Product->findAll("(parent_product_type_id IN ('$pid','$ppid') OR product_type_id IN ('$pid','$ppid')) AND Product.available = 'yes'",null, 'choose_index ASC');
		$this->set("related_products", $related);
		$this->set("products", $related);
		$this->set("parent_product", $parent_product);
		$this->set("prod", $code);

		#print_r($this->params);

		$prod = $product['Product']['prod'];

		if(!empty($this->params['form']['charmID']))
		{
			$this->set("charmID", $this->params['form']['charmID']);
		}
		if(!empty($this->params['url']['charmID']))
		{
			$this->set("charmID", $this->params['url']['charmID']);
		}
		if(!empty($this->params['form']['tasselID']))
		{
			$this->set("tasselID", $this->params['form']['tasselID']);
		}
		if(!empty($this->params['url']['tasselID']))
		{
			$this->set("tasselID", $this->params['url']['tasselID']);
		}

		$options = !empty($this->data['Product']['options']) ? $this->data['Product']['options'] : array();


		$parts = array();

		#echo "P=".print_r($product['ProductPart'],true);

		foreach($product['ProductPart'] as $part)
		{
			$part_name = $part['Part']['part_name'];
			$parts[$part_name] = $part;
		}

		$this->set("parts", $parts);


		$submitted = !empty($this->data);
		$discount = 100;

		$minimum = $this->Product->get_minimum($product, $this->get_customer());

		if(!empty($this->data['Product']['quantity'])) { $quantity = $this->data['Product']['quantity']; }
		else { $quantity = $minimum; }

		#$product['ProductPricing'][0]['quantity'];
		#print_r($product);

		if(!empty($_REQUEST['quantity'])) { $quantity = $_REQUEST['quantity']; }

		#$minimum = $product['Product']['minimum'];


		#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());

		if (!empty($quantity))#!empty($this->data) && $_SERVER['REMOTE_ADDR'] != "71.224.1.11" && !empty($quantity))
		{
			$zipCode = $this->data['Product']['zipCode'];
			$options_url = "";
			if (!empty($this->data['Product']['options']))
			{
				foreach($this->data['Product']['options'] as $part => $value)
				{
					$options_url .= "$part=$value&";
				}
			}
			
			# TRACK REQUESTS....
			$now = date("Y-m-d H:i:s");
			$session_id = session_id();
			$this->TrackingProductCalculatorRequest->create();
			$this->TrackingProductCalculatorRequest->save(array(
				'session_id'=>$session_id,
				'productCode'=>$code,
				'quantity'=>$quantity,
				'minimum'=>$minimum,
				'date'=>$now,
				'options'=>$options_url,
				'zipCode'=>$zipCode
			));


			if ($quantity < $minimum)
			{
				$this->Session->setFlash("Minimum quantity is $minimum");
				$quantity = $minimum;
			}


				$setup = (!empty($_REQUEST['customized']) && !empty($product['Product']['customizable'])) ? $product['Product']['setup_charge'] : null;
				$this->set("customized", !empty($_REQUEST['customized']));
		
				#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
		
				# Need to add parts to and combine???
				$discounted_base_prices = $this->Product->get_effective_base_price($code, $quantity, $this->Session->read("Auth.Customer"),null,$options);
				#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
				$discounted_base_price = $discounted_base_prices['total'];
				#$discounted_base_price = $discounted_base_prices;
				#$part_costs = $individual_part_costs = $this->Product->get_part_costs($code, $this->data); # Dependso n what was set in form...
		
				$part_list = array();
		
				# We need to get costs for EVERYTHING possible, since we need to show individual costs of each....
				foreach($product['ProductPart'] as $part)
				{
					#error_log(print_r($part,true));
					$partname = $part['Part']['part_code'];
					#if(!empty($this->data['Product']['options'][$partname]))
					#{
					$part_list[$partname] = 1;#$this->data['Product']['options'][$partname];
					#}
				}
		
		
				# Get each separately so we can figure pricing for each....
				$part_price = $this->Product->get_options_cost($code, $quantity, $part_list);
				$part_costs = $part_price['total'];
		
				#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
		
				$individual_part_costs = $part_costs;
		
				$this->set("part_price", $part_price);
		
				# Get base pricing for quantity....
				#$original_subtotal = ($product['Product']['base_price']+$individual_part_costs) * $quantity;
				$original_subtotals = $this->Product->get_effective_base_price($code, $minimum, $this->Session->read("Auth.Customer"),null,$options); # BASED OFF MINIMUM
				$original_subtotal = $original_subtotals['total'] * $quantity + $setup;
		
		
				$discounted_individual = $discounted_base_price;# + $individual_part_costs;
				#print_r($discounted_individual);
				$discounted_subtotal = $discounted_individual * $quantity + $setup;
		
				#error_log("DISCOUNTED_EACH=$discounted_individual");
				#error_log("TOTAL=$discounted_subtotal");
		
				$savings_total = $original_subtotal - $discounted_subtotal;
		
				#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
		
				$percent_savings = $original_subtotal > 0 ? $savings_total / $original_subtotal * 100 : 0;
				# ???
		
		
				$this->set("base_discount_percent", 100-$discount);
				$this->set("discount_percent", $percent_savings);
				$this->set("quantity", $quantity);
				$this->set("base_pricing", $discounted_base_prices['base']);
				$this->set("setup", $setup);
		
		
				$this->set("subtotal", $discounted_subtotal);
				$this->set("original_subtotal", $original_subtotal);
				$this->set("each_total", $discounted_individual);
				$this->set("savings_total", $savings_total);
		
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
		
				#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
		
				$this->set("next_tier", $next_tier);
		
				$grand_total = $discounted_subtotal;
		
				if (!empty($this->data['Product']['zipCode']))
				{
					$zipCode = $this->data['Product']['zipCode'];
					# calculate shipping
					$shippingOptions = $this->ShippingPricePoint->calculate_shipping_options_list($zipCode, array($code=>$quantity), $grand_total, !empty($customer['is_wholesale']));
					#print_r($shippingOptions);
					$this->set("shippingOptions", $shippingOptions);
		
					foreach($shippingOptions as $option)
					{
						$method_id = $option['shippingPricePoint']['shippingMethod'];
						$grand_totals[$method_id] = $grand_total + $option[0]['cost'];
					}
					$this->set("grand_totals", $grand_totals);
				}
	
			}
	
			# Now load list of product options
	
			$product_options = array();
			$default_product_option_value = "";
	
			$product_option_field = "";
	
			if ($prod == 'charm')
			{
				$product_options[""] = "None Selected";
				$charms = $this->Charm->findAll("Charm.available = 'yes'", array('DISTINCT charm_id','*'), "name ASC");
				foreach($charms as $charm)
				{
					$product_options[$charm['Charm']['charm_id']] = ucwords($charm['Charm']['name']);
				}
				$product_option_field = "charmID";
			} else if ($prod == 'tassel') { 
				$product_options[""] = "None Selected";
				$tassels = $this->Tassel->findAll("Tassel.available = 'yes'", array('DISTINCT tassel_id','*'), "color_name ASC");
				#print_r($tassels);
				foreach($tassels as $tassel)
				{
					$product_options[$tassel['Tassel']['tassel_id']] = ucwords($tassel['Tassel']['color_name']);
				}
				$product_option_field = "tasselID";
	
			} else {
				if (count($related) > 0)
				{
					$product_options[$parent_product['Product']['code']] = !empty($parent_product['Product']['pricing_name']) ? $parent_product['Product']['pricing_name'] : $parent_product['Product']['name'];
					if(!empty($parent_product['Product']['pricing_description'])) { $product_options[$parent_product['Product']['code']] .= " &mdash; ".$parent_product['Product']['pricing_description']; }
	
					foreach($related as $related_product)
					{
						$product_options[$related_product['Product']['code']] = !empty($related_product['Product']['pricing_name']) ? $related_product['Product']['pricing_name'] : $related_product['Product']['name'];
						if(!empty($related_product['Product']['pricing_description'])) { $product_options[$related_product['Product']['code']] .= " &mdash; ".$related_product['Product']['pricing_description']; }
					}
					$product_option_field = "productCode";
					$default_product_option_value = $code;
				}
			}
	
			#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
	
			$product_list = array();
			$product_list[$code] = $quantity;
	
			$ships_by_time = $this->Product->get_shipment_time(array($code=>$quantity));
			$ships_by = date("D M j", $ships_by_time);
	
			# Do multiplication, figure 
	
			$this->set("ships_by_time", $ships_by_time);
			$this->set("ships_by", $ships_by);
	
			$parent_product = !empty($product['Product']['parent_product_type_id']) ? $this->Product->read(null, $product['Product']['parent_product_type_id']) : $product;
	
			$this->set("product_options", $product_options);
			$this->set("product_option_field", $product_option_field);
			$this->set("default_product_option_value", $default_product_option_value);
			$this->set("parent_product", $parent_product);
			$this->set("product", $product);
			$this->set("parent_product", $parent_product);
	
			#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
	
			#if ($this->malysoft || $this->hdtest)
			#{
			#	$this->action = "calculator_new";
			#}
		}
	
		function mini_calc($baseCode = null, $quantity = null)
		{
			$this->layout = $this->RequestHandler->isAjax() ? "ajax" : "default_plain";
			if($this->layout == 'ajax') { Configure::write("debug", 0); }
			#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
	
			$customer = $this->Session->read("Auth.Customer");
	
			$this->Product->link_product_details();
			$this->Product->link_product_customization();

			$this->Product->recursive = 1;
			$product = $this->Product->find("code = '$baseCode'");
			$this->set("baseCode", $baseCode);
			$pid = $product['Product']['product_type_id'];
			$prod = $product['Product']['prod'];
			$ppid = $product['Product']['parent_product_type_id'];

			$compare_products = array();
			$related_products = $this->Product->findAll("(Product.product_type_id = '$pid' OR Product.parent_product_type_id = '$pid' OR Product.product_type_id = '$ppid' OR Product.parent_product_type_id = '$ppid') AND Product.available = 'yes'",null,'choose_index ASC',null, 'choose_index ASC');


			if (!empty($related_products))
			{
				#$compare_products[] = $product['Product'];
				#foreach($product['AllRelatedProducts'] as $rp)
				foreach($related_products as $rp)
				{
					$compare_products[] = $rp['Product'];
				}
	
				usort($compare_products, array($this, "compare_products_sort"));
			}

			$code = $baseCode;
	
			if (!empty($_REQUEST['productCode']))
			{
				$code = $_REQUEST['productCode'];
			} else {
				# Default to 1st in order...
				$code = $compare_products[0]['code'];
			}

			# Get real product.
			$product = $this->Product->find("code = '$code'");
			$pid = $product['Product']['product_type_id'];
			$prod = $product['Product']['prod'];
			$ppid = $product['Product']['parent_product_type_id'];
	
			$this->set("prod", $code);
	
			$submitted = !empty($this->data);
			$discount = 100;

			$this->set("compare_products", $compare_products);

			if(!empty($_REQUEST['quantity'])) { $quantity = $_REQUEST['quantity']; }

			$minimum = $this->Product->get_minimum($product, $this->get_customer());
			$this->set("minimum", $minimum);
	
			#error_log("P=$code, Q=$quantity");
	
	
			if ($quantity < $minimum)
			{
				#$this->Session->setFlash("Minimum quantity is $minimum");
				$quantity = $minimum;
			}

			if(!empty($quantity))
			{
	
			$this->Session->write("quantity", $quantity); # So we can populate the build.

			$options = array();
	
			$discounted_base_prices = $this->Product->get_effective_base_price($code, $quantity, $this->Session->read("Auth.Customer"),null,$options);
			$discounted_base_price = $discounted_base_prices['total'];
			$original_subtotals = $this->Product->get_effective_base_price($code, $minimum, $this->Session->read("Auth.Customer"),null,$options); # BASED OFF MINIMUM
			$original_subtotal = $original_subtotals['total'] * $quantity;
	
			$discounted_individual = $discounted_base_price;# + $individual_part_costs;
			$discounted_subtotal = $discounted_individual * $quantity;
	
			$savings_total = $original_subtotal - $discounted_subtotal;
	
			$percent_savings = $original_subtotal > 0 ? $savings_total / $original_subtotal * 100 : 0;
			# ???
	
			$this->set("base_discount_percent", 100-$discount);
			$this->set("discount_percent", $percent_savings);
			$this->set("quantity", $quantity);
			$this->set("price_each", $discounted_base_prices['total']);
			$this->set("base_pricing", $discounted_base_prices['base']);
			$this->set("original_subtotal", $original_subtotal);
			$this->set("subtotal", $discounted_subtotal);
			$this->set("unitPrice", $discounted_individual);
			$this->set("each_total", $discounted_individual);
			$this->set("savings_total", $savings_total);

			$next_tier = "";
			$next_tier_cost = 0;
	
			$i = 0;
			foreach($product['ProductPricing'] as $pricing)
			{
				if ($pricing['quantity'] > $quantity && $i+1 < count($product['ProductPricing']))
				{
					$next_tier = $pricing['quantity'];
					$next_tier_cost = $pricing['price'];
					break;
				}
				$i++;
			}
	
			$next_tier_percent = intval(($discounted_base_prices['total']-$next_tier_cost)/($discounted_base_prices['total'])*100); 
			$list_cost = $product['ProductPricing'][0]['price'];
			$list_percent = intval(($list_cost-$next_tier_cost)/($list_cost)*100); 
	
			#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());
	
			$this->set("next_tier", $next_tier);
	
			$this->set("next_tier_percent", $next_tier_percent);
			$this->set("list_percent", $list_percent);
	
			$grand_total = $discounted_subtotal;
	
	
			if (!empty($this->data['Product']['zipCode']))
			{
				$zipCode = $this->data['Product']['zipCode'];
				# calculate shipping
				$shippingOptions = $this->ShippingPricePoint->calculate_shipping_options_list($zipCode, array($code=>$quantity), $grand_total, !empty($customer['is_wholesale']));
				#print_r($shippingOptions);
				$this->set("shippingOptions", $shippingOptions);
	
				foreach($shippingOptions as $option)
				{
					$method_id = $option['shippingPricePoint']['shippingMethod'];
					$grand_totals[$method_id] = $grand_total + $option[0]['cost'];
				}
				$this->set("grand_totals", $grand_totals);
			}

		}

		# Now load list of product options

		$product_options = array();
		$default_product_option_value = "";

		$product_option_field = "";

		if ($prod == 'charm')
		{
			$product_options[""] = "None Selected";
			$charms = $this->Charm->findAll("Charm.available = 'yes'", array('DISTINCT charm_id','*'), "name ASC");
			foreach($charms as $charm)
			{
				$product_options[$charm['Charm']['charm_id']] = ucwords($charm['Charm']['name']);
			}
			$product_option_field = "charmID";
		} else if ($prod == 'tassel') { 
			$product_options[""] = "None Selected";
			$tassels = $this->Tassel->findAll("Tassel.available = 'yes'", array('DISTINCT tassel_id','*'), "color_name ASC");
			#print_r($tassels);
			foreach($tassels as $tassel)
			{
				$product_options[$tassel['Tassel']['tassel_id']] = ucwords($tassel['Tassel']['color_name']);
			}
			$product_option_field = "tasselID";

		} else {
			if (!empty($related) && count($related) > 0)
			{
				$product_options[$parent_product['Product']['code']] = !empty($parent_product['Product']['pricing_name']) ? $parent_product['Product']['pricing_name'] : $parent_product['Product']['name'];
				if(!empty($parent_product['Product']['pricing_description'])) { $product_options[$parent_product['Product']['code']] .= " &mdash; ".$parent_product['Product']['pricing_description']; }

				foreach($related as $related_product)
				{
					$product_options[$related_product['Product']['code']] = !empty($related_product['Product']['pricing_name']) ? $related_product['Product']['pricing_name'] : $related_product['Product']['name'];
					if(!empty($related_product['Product']['pricing_description'])) { $product_options[$related_product['Product']['code']] .= " &mdash; ".$related_product['Product']['pricing_description']; }
				}
				$product_option_field = "productCode";
				$default_product_option_value = $code;
			}
		}

		#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());

		$product_list = array();
		$product_list[$code] = $quantity;

		$ships_by_time = $this->Product->get_shipment_time(array($code=>$quantity));
		$ships_by = date("D M j", $ships_by_time);

		# Do multiplication, figure 

		$this->set("ships_by_time", $ships_by_time);
		$this->set("ships_by", $ships_by);

		$parent_product = !empty($product['Product']['parent_product_type_id']) ? $this->Product->read(null, $product['Product']['parent_product_type_id']) : $product;

		##########$this->set("product_options", $product_options);
		$this->set("product_option_field", $product_option_field);
		$this->set("default_product_option_value", $default_product_option_value);
		$this->set("parent_product", $parent_product);

		if(empty($this->viewVars['product']))
		{
			$this->set("product", $product); # NEEDS to be set, so hidden prod set on 2nd+ calls.
		}

		#$this->set("parent_product", $parent_product);
		$this->set("calc_prod", $code);

		#error_log(__FILE__.":".__FUNCTION__.".".__LINE__.": ".time());

		#if ($this->malysoft || $this->hdtest)
		#{
		#	$this->action = "calculator_new";
		#}
	}


	function admin_product_grid($imgtype, $imgid)
	{
		# This takes $this->data and passes along appropriate build info for accurate view.

		$image_type = '';
		if(!empty($this->data['EmailMessage']['template']))
		{
			$this->build['template'] = $this->data['EmailMessage']['template'];
		}
		if($imgtype == 'Custom')
		{
			$image = $this->CustomImage->read(null, $imgid);
			$this->build['CustomImage'] = $image['CustomImage'];
			$image_type = 'custom';
		} else if ($imgtype == 'Gallery') { 
			$image = $this->GalleryImage->find(" GalleryImage.catalog_number = '$imgid' ");
			$this->build['GalleryImage'] = $image['GalleryImage'];
			if($image['GalleryImage']['reproducible'] == 'Only')
			{
				$image_type = "repro";
			}
			else if($image['GalleryImage']['reproducible'] == 'No')
			{
				$image_type = "real";
			}
			else 
			{
				$image_type = "real|repro";
			}
		}

		#error_log( "URL=".print_r($this->data,true));
		$options_string = "";

		if(!empty($this->data['Customer']['session_id']))
		# If Customer.session_id is available, we get them logged in automatically.
		{
			$options_string .= "&session_id=".$this->data['Customer']['session_id'];
		}

		$allow_fields = array('prod','catalog_number','image_id','template','fullbleed','customQuote','personalizationInput','ribbon_id','charm_id','tassel_id','border_id','personalizationStyle');

		if(!empty($this->data['EmailMessage']))
		{
			foreach($this->data['EmailMessage'] as $k => $v)
			{
				if(in_array($k, $allow_fields))
				{
					$options_string .= "&options[$k]=$v";
					$options_string .= "&$k=$v";
				}
			}
		}

		if(!empty($this->data['Customer']))
		{
			$this->set("effective_customer", $this->data['Customer']);
		}

		$this->set("options_string", $options_string);

		#$this->Session->write("Build", $this->build);

		# DONT save to Session!
		# Only get what products this image can go on....
		$products = $this->Product->findAll("available = 'yes' AND is_stock_item = 0 AND image_type REGEXP '($image_type)'", array(), "is_stock_item ASC, sort_index ASC"); # Parent products only...
		$this->set("products", $products);
		$this->set("live", true);
	}

	function admin_testimonials()
	{
	}

	function admin_images($id = null)
	{
		$product = $this->Product->read(null, $id);
	}

	function product_set_variables($prod)
	{
		# Other data per product...
		if ($prod == 'charm') # Charms...
		{
			#$this->CharmCategory->recursive = 1;
			#$this->set("charm_categories", $this->CharmCategory->findAll(null, array(), "category_name ASC"));
			$this->Charm->recursive = 0;
			#$this->set("other_charms", $this->Charm->findAll("Charm.available = 'yes' AND CharmCategories.charm_id IS NULL"));
			$this->set("charms", $this->Charm->findAll("Charm.available = 'yes'", array('DISTINCT charm_id','*'), "name ASC"));
		} else if ($prod == 'tassel') {
			$this->set("tassels", $this->Tassel->findAll("available = 'yes'"));
		}
	}

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

	function admin_description($id, $i = 0)
	{
		$this->data = $this->Product->read(null, $id);
		$this->set("i", $i);
	}
	function admin_delete_description($id)
	{
		error_log("DELETING $id");
		$this->Product->ProductDescription->delete($id);
		echo "OK";
		exit(0);
	}

	function admin_edit($id = null)
	{
		if(!empty($this->data))
		{
			if(empty($id) && empty($this->data['Product']['product_type_id']))
			{
				$this->Product->create();
			}

			$ppa = array();

			if(!empty($this->data['ProductPart']))
			{
				$parts = array();
				$this->ProductPart->deleteAll(array('ProductPart.product_type_id'=>$id));

				foreach($this->data['ProductPart'] as $part)
				{
					if(empty($part['optional']) || $part['optional'] == 'None')
					{
						if(!empty($part['product_part_id'])) {
							$this->ProductPart->delete($part['product_part_id']);
						}
					} else {
						$parts[] = $part;
					}
				}

				$this->data['ProductPart'] = $parts;
			}


			foreach($this->data['ProductPricing'] as $pp)
			{
				if(!empty($pp['quantity']) && !empty($pp['price']))
				{
					$ppa[] = $pp;
				}
			}
			$this->data['ProductPricing'] = $ppa;

			if($this->Product->saveAll($this->data))
			{
				if (!empty($this->data['thumbnail']['file']['size']))
				{
					$this->Image->force_type = "png";
					$this->Image->saveUpload(array('thumbnail','file'), "/images/products/thumbnail", $this->data['Product']['code'], null, 94);
				}

				$this->Session->setFlash("Product saved");
				$this->redirect("/admin/products/edit/{$this->Product->id}");
			} else {
				$this->Session->setFlash("Product could not be saved");
			}
		}

		$this->set("maxSortIndex", $this->Product->field('MAX(sort_index) AS sort_index',array(1=>1)));

		if(!empty($id))
		{
			$this->Product->recursive = 2;
			$this->data = $this->Product->read(null, $id);
			$this->set("product", $this->data);
			$this->data['Product']['image_type'] = split(",", $this->data['Product']['image_type']);
			$this->set('productSampleImages', $this->ProductSampleImage->findAll("ProductSampleImage.product_type_id = '$id'"));

			# Get related products. for sample images.
			$this->set("relatedProducts", $this->Product->find('all', array('conditions'=>array('parent_product_type_id'=>$id))));
		}
		$this->set("image_types", $this->Product->getSetValues('image_type'));
		$this->set("productCount", $this->Product->find('count'));
		$this->set("parent_product_types", $this->Product->get_product_option_list());
		$this->set("parts", $this->Part->find('all',array('conditions'=>array(''))));
		$this->set("stamp_types", $this->Product->getEnumValues('stamp'));

		$product_categories = $this->ProductCategory->find('list');
		$this->set("product_categories", $product_categories);
	}

	function admin_add() {
		$this->redirect(array('action'=>'admin_edit'));

		####################################################

		$this->set("parent_product_types", $this->Product->get_product_option_list());
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
		if (empty($this->data))
		{
			$this->data = $this->Product->getDefaultValues();
			#echo "DATA=".print_r($this->data,true);
		}

	}

	function strip_format(&$product, $key)
	{
		# Get rid of everything! 
		# (MAYBE turn newlines intor <br/> ???)
		$content = $product[$key];
		$lines = split("\n", $content);
		foreach($lines as &$line)
		{
			$line = preg_replace("/<p[^>]*>/", "", $line);
			$line = preg_replace("/<\/p>/", "", $line);
			$line = preg_replace('/<span class="attribute-value">(.*)<\/span>/', "\$1", $line);
		}

		$product[$key] = join("\n", $lines);
	}

	function admin_edit_customization($id = null)
	{
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Product', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set("product_id", $id);

		$this->set("parts", $this->ProductPart->findAll());

		if (!empty($this->data)) {
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(__('The Product has been saved', true));
				#$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Product could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_editold($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Product', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Product->link_related_products();
		$this->set("product_id", $id);
		if (!empty($this->data)) {
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(__('The Product has been saved', true));
				#$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Product could not be saved. Please, try again.', true));
			}
		}
		#if (empty($this->data)) {
		# ALWAYS GET, CUZ OF RELATED PRODUCTS, etc.
			$this->data = $this->Product->read(null, $id);
			$this->data['Product']['image_type'] = split(",", $this->data['Product']['image_type']);
			$this->data['Product']['product_template'] = split(",", $this->data['Product']['product_template']);
			#$this->data['product_pricing_matrix'] = $this->Product->create_pricing_matrix($this->data);
			#print_r($this->data['product_pricing_matrix']);

			#if (empty($this->data['Product']['base_price']))
			#{
			#	$this->data['Product']['base_price'] = $this->data['ProductPricing'][0]['price'];
			#	$this->data['Product']['minimum'] = $this->data['ProductPricing'][0]['quantity'];
			#}

			$this->strip_format($this->data['Product'], 'main_desc');
			$this->strip_format($this->data['Product'], 'secondary_desc');
			$this->strip_format($this->data['Product'], 'meta_desc');
			$this->strip_format($this->data['Product'], 'meta_keywords');
		#}

		$this->breadcrumbs["/".$this->params['url']['url']] = $this->data['Product']['short_name'] ?  $this->data['Product']['short_name'] : $this->data['Product']['name'];


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

		$categories = $this->ProductCategory->findAll();
		$category_list = Set::combine($categories, '{n}.ProductCategory.product_category_id', '{n}.ProductCategory.name');
		$this->set("product_categories", $category_list);

		$this->set("product_parts", $this->Part->create_dropdown_list('part_name'));
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

	function admin_image_upload($id = null)
	{
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Product', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Product->recursive = -2;
		$product = $this->Product->read(null, $id);
		$prefix = $product['Product']['code'];
		$this->set("product", $product);
		#$imgheight = 94; # Scale down to....
		#error_log("DATA=".print_r($this->data,true));
		if (!empty($this->data))
		{
			foreach($this->data as $key => $info)
			{
				$imgwidth = isset($info['scalewidth']) ? $info['scalewidth'] : null;
				$imgheight = isset($info['scaleheight']) ? $info['scaleheight'] : null;
				$basepath = "/images/products/$key";
				#error_log("INFO ($key, W=$imgwidth, H=$imgheight)=".print_r($info,true));
				$this->Image->force_type = "jpg";
				#if ($key == 'thumbnail')
				#{
				#	$return = $this->Image->saveUpload(array($key, "file"), "$basepath/large", $prefix, $imgwidth, $imgheight);
				#	if (!$return)
				#	{
				#		$largefile = APP."/webroot/$basepath/large/$prefix.jpg";
				#		$thumbfile = APP."/webroot/$basepath/$prefix.jpg";
				#		error_log("LF=$largefile, TF=$thumbfile");
				#		list($w,$h) = getimagesize($largefile);
				#		$thumb_imgheight = 94;
				#		$thumb_imgwidth = ceil($thumb_imgheight * ($w/$h));
				#		$return = $this->Image->scaleFile($largefile, $thumbfile, $thumb_imgwidth, $thumb_imgheight);
				#	}
				#} else {
					$return = $this->Image->saveUpload(array($key, "file"), $basepath, $prefix, $imgwidth, $imgheight);
				#}
				if (is_array($return))
				{
					$this->Session->setFlash("Could not save image: ".join("<br/>", $return[0]));
					#$this->redirect(array('action'=>"edit", $id));
				}
			}
		}
		$this->data['Product'] = $product['Product'];
		$this->Session->setFlash("Image saved.");

		# Go back to product
		$this->redirect(array('action'=>"edit", $id));
	}

	function test($file)
	{
		if(!empty($_REQUEST))
		{
			print_r($_REQUEST);
		}
		$this->action = "test/$file";
	}

	function promo_details()
	{
		$this->layout = 'ajax';
	}

}
