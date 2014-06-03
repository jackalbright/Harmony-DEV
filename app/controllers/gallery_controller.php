<?php
class GalleryController extends AppController {

	var $name = 'Gallery';
	var $title = "Select Your Image";
	var $helpers = array('Html', 'Form');
	var $uses = array("GalleryCategory", "GalleryImage", "GalleryCategoryImageLink","Product","GalleryFilterKeyword");
	var $paginate = array(
		'GalleryCategoryImageLink'=>array(
			'order'=>array(
				'GalleryImage.stamp_name'=>'asc',
			),
			'limit'=>40,
			'fields'=>array('DISTINCT GalleryImage.stampID', 'GalleryImage.*'),
		),
	);
	var $build_page = true;

	function beforeFilter()
	{
		#error_log("S4=".print_r($this->Session->read(),true));
		if (!empty($this->params['url']['new'])) { 
			$this->Session->delete("Build.GalleryImage"); 
			$this->Session->delete("Build.gallery_number"); 
			$this->Session->delete("Build.CustomImage"); 
			$this->Session->delete("Build.imageID"); 
		}
		parent::beforeFilter();

		if (isset($_REQUEST['browse_prod'])) # So can pass prod= to view, index, browse, clipart, etc...
		{
			$prod = $_REQUEST['browse_prod'];
			$this->Session->write("browse_prod", $prod);
		}

		if (isset($_REQUEST['prod'])) # So can pass prod= to view, index, browse, clipart, etc...
		{
			$prod = $_REQUEST['prod'];
			#$this->set_build_product($prod,true);
			$this->set_build_product($prod,false); # Don't clear image...
		}
		if (empty($this->build['Product']))
		{
			$this->build['image_first'] = 1;
			$this->Session->write("Build", $this->build);
		} else {
			unset($this->build['image_first']);
			$this->Session->write("Build", $this->build);
		}

		if(empty($this->build['preview_layout']) && empty($_REQUEST['layout']))
		{
			$this->build['preview_layout'] = 'standard'; # Reset unless passed in url.
			$this->Session->write("Build", $this->build);
		}
	}

	function catch_custom_only_product()
	{
		if (!empty($this->build["Product"]) && !preg_match("/(real|repro)/", $this->build["Product"]['image_type']))
		{
			# clear product.
			unset($this->build['Product']);
			$this->Session->write("Build", $this->build);

			#print_r($this->build['Product']);
			#$this->redirect("/gallery?custom_only=1");
		}
	}

	function beforeRender()
	{
		parent::beforeRender();

		$this->set("current_build_step", 2);
		if (!isset($this->build['Product'])) { 
			$this->set("image_select_first", true);
		}
	}

	function index($prod = null) {
		$this->redirect("/custom_images");
		$this->set("stepname", "image");

		#$this->GalleryCategory->recursive = 0;
		#$this->set('galleryCategories', $this->paginate());
		if (!$prod)
		{
			$prod = !empty($this->params['form']['prod']) ? $this->params['form']['prod'] : $this->Session->read("Build.Product.code");
		}

		$type = "";

		#error_log("GALLERY PROD=$prod");
		$this->set("custom_only", false);

		if (!empty($_REQUEST['custom_only']) && !empty($this->build["Product"]))
		{
			$name = !empty($this->build['Product']['short_name']) ? $this->build['Product']['short_name'] : $this->build['Product']['name'];
			$pluralname = strtolower($this->pluralize($this->build['Product']['short_name']));
			$this->Session->setFlash("Please note: We are not licensed to create $pluralname with stamp images. Please upload <br/>your own image (below) to create $pluralname, or choose a stamp image to create another product.");
			$this->set("custom_only",1);
		}

		if ($prod)
		{
			$this->build['step'] = 2;
			$this->set_build_product($prod);
			$this->Session->delete("browse_prod");

			#$type = $prod_name = $this->Product->get_product_name($prod, true);
			$type = $this->pluralize(!empty($this->build['Product']['short_name']) ? $this->build['Product']['short_name'] : $this->build['Product']['name']);
			#$type = $this->build['Product']['name'];
			$this->set("product", array('Product'=>$this->build['Product']));
			$parent_id = $this->build['Product']['product_type_id'];
			$related_products = $this->Product->findAll("parent_product_type_id = '$parent_id' AND Product.buildable = 'yes'");
			$this->set("related_products", $related_products);
			$this->set("product_name", $type);
		} else {
			$this->build['step'] = 1;
		}
		#$pluraltype = $this->pluralize($type);
		if (!$type) { $type = "Gift"; }
		if (!preg_match("/custom/i", $type)) { $type = "custom $type"; }

		if (!empty($this->build['Product']) && !preg_match("/custom/", $this->build['Product']['image_type']))
		{
			# Skip this step since just a stamp.
			$this->redirect("/gallery/browse");

		}
		$type = strtolower($type);
		#$this->set("body_title", "Personalize your $type: Choose an option below to get started");
		$this->set("body_title", "Choose your image for your $type");
		$this->set("prod", $prod);
		$this->set("rightbar_disabled", true);

		$customer_id = !empty($_SESSION['Auth']['Customer']['customer_id']) ? $_SESSION['Auth']['Customer']['customer_id'] : null;
		$session_id = session_id();
		$images = $this->CustomImage->findAll( ($customer_id?" CustomImage.customer_id = '$customer_id' OR " : "") . " CustomImage.session_id = '$session_id' ", null, "Image_ID desc");
		$this->set("custom_images", $images);
	}

	#function generate_breadcrumbs()
	#{
	#	$this->breadcrumbs["/".$this->params['controller']] = "Select Your Image";
	#}

	function select($id)
	{
		#error_log("SESS=".print_r($this->Session->read(),true));
		$prod = $this->Session->read('Build.prod');
		$this->Session->delete("Build.imageID"); # Don't need to use anymore.
		$this->Session->delete("Build.CustomImage"); # Don't need to use anymore.

		$this->GalleryImage->recursive = -1;
		$image = $this->GalleryImage->find("GalleryImage.catalog_number = '$id'");
		$this->Session->write("Build.catalog_number", $id);
		$this->Session->write("Build.GalleryImage", $image['GalleryImage']);

		#error_log("S=".print_r($this->Session->read("Build"),true));
		#$this->redirect("/gallery/browse");
		#if ($prod != "")
		#{
			#$this->redirect("/product/build.php?productCode=$prod&catalogNumber=$id");
			#$this->redirect("/build");
		#} else {
			$this->redirect("/products/select");
			#$this->redirect("/details");
			# Redirect to /products if none set, or /details/build.php?whatever=here if set.

		#}
	}

	function clipart()
	{
		$this->body_title = "Browse Images on Clipart.com&trade;";
	}

	function image($id)
	{
		preg_match("/^(.*)[.](.*)$/", $id, $matches);
		#$catnum = $matches[1];
		#$ext = $matches[2];
		$catnum = $id;
		$ext = "gif";
		Configure::write('debug', 0);
		$image = $this->GalleryImage->find("GalleryImage.catalog_number = '$catnum' ");
		$path = $image['GalleryImage']['image_location'];
		$full_path = APP."/../".$path;
		#$finfo = finfo_open(FILEINFO_MIME_TYPE);
		#$mime_type = finfo_file($finfo, $full_path);
		$mime_type = 'image/'.$ext;
		header("Content-Type: $mime_type");
		$content = file_get_contents($full_path);
		echo $content;
		exit(0);
	}

	function view($id, $category_id = null)
	{
		$this->catch_custom_only_product();
		$this->set("stepname", "product");

		$image = $this->GalleryImage->find("GalleryImage.catalog_number = '$id' AND GalleryImage.available = 'yes'");
		if (empty($image))
		{
			$this->redirect("/gallery/browse");
		}
		$this->set_build_gallery_image($id);
		$this->set("image", $image);
		#$this->set("body_title", 'Click on a(n) "'.$image['GalleryImage']['stamp_name'].'" product below to personalize');
		$this->set("body_title", 'Select your "'.$image['GalleryImage']['stamp_name'].'" gift below to order');
		$this->pageTitle = $image['GalleryImage']['stamp_name'] . " Gifts by Harmony Designs (Bookmarks, Paperweights, Magnets and more.)";
		$this->meta_keywords =  $image['GalleryImage']['HTML_Keywords'];
		$this->meta_description =  $image['GalleryImage']['stamp_name'] . " gifts -- Shop for " . $image['GalleryImage']['stamp_name'] . " gifts by Harmony Designs.  Custom bookmarks, paperweights, magnets, luggage tags, keychains and more.";

		if ($category_id != null)
		{
			$crumbs = $this->GalleryCategory->generate_category_breadcrumb_trail($this->params['controller'].'/'.$this->params['action'], $category_id);
			$this->breadcrumbs = array_merge($this->breadcrumbs, array_reverse($crumbs));
		}

		$this->set("stamp_surcharge", $this->StampSurcharge->find("catalog_number = '$id' "));

		$this->set("rightbar_disabled", true);
		#$this->set("rightbar_template", "build/rightbar");

		$this->breadcrumbs["/".$this->params['url']['url']] = $image['GalleryImage']['stamp_name'];

		$this->set("products", $this->getImageAvailableProducts($id));
		$this->set("all_products", $this->Product->findAll(" available = 'yes' AND is_stock_item = 0 AND buildable = 'yes' "));
	}

	function browse_filter($filter = null, $id = null)
	{
		# Get info of filter.
		$this->body_title_crumbs = false;

		$this->GalleryFilterKeyword->recursive = 2;
		if (is_numeric($filter))
		{
			$gallery_filter = $this->GalleryFilterKeyword->find("GalleryFilterKeyword.filter_id = '$filter'");
		} else {
			$gallery_filter = $this->GalleryFilterKeyword->find("GalleryFilterKeyword.name = '$filter' OR GalleryFilterKeyword.path = '$filter'");
		}
		if (!$gallery_filter)
		{
			$this->redirect("/gallery/browse");
		}
		$subcategories = $gallery_filter['GalleryCategory'];

		if (!count($subcategories))
		{
			#$this->redirect("/gallery/browse");
			$this->GalleryCategory->recursive = 2;
			$category = $this->GalleryCategory->read(null, 1);
			$subcategories = $category['Subcategories']; # Show all...
		}


		$filter_name = $gallery_filter['GalleryFilterKeyword']['name'] . " Products";
		$path = "/gallery/browse_filter/".$gallery_filter['GalleryFilterKeyword']['path'];
		#echo "P=$path";
		$this->set("browseurl", $path);

		# Do our own breadcrumbs...
		$this->breadcrumbs = array();
		$this->breadcrumbs["/"] = "Home";
		
		# FOR NOW, ASSUME IT'S A SPECIALTY PAGE.... (maybe add flag eventually)
		$this->breadcrumbs["/specialty_pages/view/".$gallery_filter['GalleryFilterKeyword']['path']] = $gallery_filter['GalleryFilterKeyword']['name'];
		$this->breadcrumbs[$path] = "Products";#$filter_name;

		if ($id != "")
		{
			$crumbs = $this->GalleryCategory->generate_category_breadcrumb_trail($path, $id);
			$this->breadcrumbs = array_merge($this->breadcrumbs, array_reverse($crumbs));
		}

		if ($id != "" && $id != 1) # Show just that category.
		{
			$this->_display_category($id, $filter_name);
			$this->action = "browse";
		} else { # Show top level categories for filter.

			$this->_display_category_list($subcategories, $filter_name);
		}
	}

	function browse($id = null) {
		if(!empty($_REQUEST['browse_node_id'])) { $id = $_REQUEST['browse_node_id']; }

		if (!empty($_REQUEST['clear_product'])) { $this->Session->delete("Build.Product"); $this->Session->delete("Build.prod"); unset($this->build["Product"]); }
		$this->set("stepname", "image");

		$this->body_title_crumbs = false;
		
		$this->catch_custom_only_product();

		$product = null;

		$session = $this->Session->read();
		$product_code = null;
		if (isset($session['browse_prod']))
		{
			if ($session['browse_prod'])
			{
				$product_code = $session['browse_prod'];
				$p = $this->Product->find(" code = '$product_code' ");
				$product = $p['Product'];
			}
		}
		else 
		{
			$product_code = $this->Session->read('Build.prod');
			$product = $this->Session->read("Build.Product");
		}

		$this->Product->recursive = 1;
		$code = $product['code'];
		$full_product = $this->Product->find(" code = '$code' ");

		$this->set("product", $full_product);

		$this->set("browse_prod", $product_code);

		$type = !empty($product) ? (!empty($product['short_name']) ? $product['short_name'] : $product['name']) : null;
		#if (!$type || $type == "") { $type = "Product"; }
		#$pluraltype = $this->pluralize($type);

		$this->action = "browse"; # Default.


		if ($product_code)
		{
			$this->filterImagesForProduct($product_code);
		}

		#$this->set("rightbar_template", "build/rightbar");

		# WE NEED TO SOMEHOW GRAB ALL CATEGORIES, no matter how deep, with a specific filter set...
		# WE SHOULD PROBABLY JUST SHOW A FLAT VIEW OF ALL CATEGORIES WHO USE THIS....
		# AND ONCE THEY CLICK ON A CATEGORY, IT"LL drill down and let one go back via the breadcrumbs....

		if (!$id || $id === 1 || $id === '1' || (!is_numeric($id) && preg_replace("/[+_]/", " ", $id) == "All Subjects")) {
		#echo "I=$id";
			$this->GalleryCategory->recursive = 2;
			$category = $this->GalleryCategory->read(null, 1);

			#$type = "Product";
			#$pluraltype = $this->pluralize($type);
			#if (!$type || $type == "") { $type = "Gift"; }
			#$pluraltype = $this->pluralize($type);

			$this->_display_category_list($category['Subcategories'], $type);
		} else {
			#if (!$type || $type == "") { $type = "Gift"; }
			#$pluraltype = $this->pluralize($type);

			$this->_display_category($id, $type, $product);
		}
		$this->set("products", $this->Product->findAll("available = 'yes' AND buildable = 'yes' AND is_stock_item = 0 AND (image_type LIKE '%repro%' OR image_type LIKE '%real%')",null,"name"));
		$this->set("path", $id);
	}

	function _display_category_list($categories, $name = null)
	{
		$this->set("categories", $categories);
		$this->set("product_name", $name);
		#if ($name)
		#{
		#	$this->set("body_title", "Select an image for your ".strtolower($name).": Select an image category");
		#}
		$this->set("body_title", (!empty($name) ?  "Select an image for your ".$this->pluralize(ucwords($name)) : "Select an image for your gifts"));

		if (!isset( $this->breadcrumbs["/".$this->params['url']['url']]))
		{
			$this->breadcrumbs["/".$this->params['url']['url']] = "Select an image category";
		}

		$this->set("rightbar_disabled", true);
		$this->set("cols_per_row", 4);


		$this->action = "browse_root";
	}

	function _display_category($id, $name = null, $product = null)
	{
		$this->GalleryCategory->recursive = 2;
		if (!is_numeric($id)) # By name, Air+Space, Air Space, Air_Space, etc...
		{
			# Split at ';', loop from start to finish to find children who match next part....
			$catnames = split(";", $id);
			$parent_catid = 1;
			foreach($catnames as $catname)
			{
				if ($catname === '1' || $catname === 1) { continue; }
				$catname = preg_replace("/'/", "\\'", preg_replace("/[+_]/", " ", $catname));
				#Escape apostrophes!
				$category = $this->GalleryCategory->find("(GalleryCategory.browse_node_id = '$catname' OR GalleryCategory.browse_name = '$catname') AND ParentCategory.browse_node_id = '$parent_catid'");
				$parent_catid = $category['GalleryCategory']['browse_node_id'];
			}

			$id = $category['GalleryCategory']['browse_node_id'];
		} else {
			$category = $this->GalleryCategory->read(null, $id);
		}
		$this->set('galleryCategory', $category);
		$this->set("body_title", (!empty($name) ?  "Select a ".strtolower($name).": " : "Select an image for your gifts: ") .
			$category['GalleryCategory']['browse_name']);# . " &bull; Free personalization");
		$path = "/".$this->params['controller']."/".$this->params['action'];
		$crumbs = $this->GalleryCategory->generate_category_breadcrumb_trail($path, $id);
		$this->breadcrumbs = array_merge($this->breadcrumbs, array_reverse($crumbs));

		$this->set("rightbar_disabled", true);
		#$this->set("cols_per_row", 3);

		$product_stamp_conditions = array();

		if ($product)
		{

			# Product filter.
			$product_image_type_list = split(",", $product['image_type']);
			$product_filter = array();
	
			$product_stamp_image_types = array();
	
			foreach($product_image_type_list as $product_image_type)
			{
				$product_stamp_image_types[$product_image_type] = true;
			}
	
		# stamp can be:
	
		# Only = reproduced but NOT the real stamp
		# yes = reproduced AND real
		# no = real, but NOT reproduced
	
	
			if (isset($product_stamp_image_types['repro']) && !isset($product_stamp_image_types['real'])) 
			# repro
			{
				$product_stamp_conditions[] = "Only";
				$product_stamp_conditions[] = "Yes";
			}
			else if (!isset($product_stamp_image_types['repro']) && isset($product_stamp_image_types['real']))
			# real
			{
				$product_stamp_conditions[] = "No";
				$product_stamp_conditions[] = "Yes";
			}
			else if (isset($product_stamp_image_types['repro']) && isset($product_stamp_image_types['real']))
			# either real or repro
			{
				$product_stamp_conditions[] = "Yes";
				$product_stamp_conditions[] = "No";
				$product_stamp_conditions[] = "Only";
			}
			else 
			# Default. All.
			{
				$product_stamp_conditions[] = "Yes";
				$product_stamp_conditions[] = "No";
				$product_stamp_conditions[] = "Only";
			}
		}

		if (!count($product_stamp_conditions))
		{
			$product_stamp_conditions[] = "Yes";
			$product_stamp_conditions[] = "No";
			$product_stamp_conditions[] = "Only";
		}


		
		


		$idlist = $this->GalleryCategory->get_self_and_ancestor_ids($id);
		$images = $this->paginate("GalleryCategoryImageLink", array('GalleryCategoryImageLink.browse_node_id'=>$idlist,'GalleryImage.stampID IS NOT NULL','GalleryImage.reproducible'=>$product_stamp_conditions,'GalleryImage.available'=>'Yes'));
		$this->set("galleryImages", $images);

		$limit = null;
		if (!empty($this->params['url']['limit'])) { $limit = $this->params['url']['limit']; }
		if (!$limit && !empty($this->passedArgs['limit']))
		{
			$limit = $this->passedArgs['limit'];
		}
		#if (!$limit) { $limit = 40; }
		#$this->javascript_sets['limit'] = $limit; # dropdown for template to set.

		if (isset($category['GalleryCategory']['meta_desc'])) { $this->meta_description = $category['GalleryCategory']['meta_desc']; }
		if (isset($category['GalleryCategory']['meta_keywords'])) { $this->meta_description = $category['GalleryCategory']['meta_keywords']; }
		if (isset($category['GalleryCategory']['browse_name'])) { $this->pageTitle = $category['GalleryCategory']['browse_name'] . " gifts by Harmony Designs Inc. - Bookmarks, Paperweights, Magnets and more."; }
	}

	function add() {
		if (!empty($this->data)) {
			$this->GalleryCategory->create();
			if ($this->GalleryCategory->save($this->data)) {
				$this->Session->setFlash(__('The GalleryCategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The GalleryCategory could not be saved. Please, try again.', true));
			}
		}
		$images = $this->GalleryCategory->Image->find('list');
		$parentCategories = $this->GalleryCategory->ParentCategory->find('list');
		$this->set(compact('images', 'parentCategories'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid GalleryCategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->GalleryCategory->save($this->data)) {
				$this->Session->setFlash(__('The GalleryCategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The GalleryCategory could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->GalleryCategory->read(null, $id);
		}
		$images = $this->GalleryCategory->Image->find('list');
		$parentCategories = $this->GalleryCategory->ParentCategory->find('list');
		$this->set(compact('images','parentCategories'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for GalleryCategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->GalleryCategory->del($id)) {
			$this->Session->setFlash(__('GalleryCategory deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->GalleryCategory->recursive = 0;
		$this->set('galleryCategories', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid GalleryCategory.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('galleryCategory', $this->GalleryCategory->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->GalleryCategory->create();
			if ($this->GalleryCategory->save($this->data)) {
				$this->Session->setFlash(__('The GalleryCategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The GalleryCategory could not be saved. Please, try again.', true));
			}
		}
		$images = $this->GalleryCategory->Image->find('list');
		$parentCategories = $this->GalleryCategory->ParentCategory->find('list');
		$this->set(compact('images', 'parentCategories'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid GalleryCategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->GalleryCategory->save($this->data)) {
				$this->Session->setFlash(__('The GalleryCategory has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The GalleryCategory could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->GalleryCategory->read(null, $id);
		}
		$images = $this->GalleryCategory->Image->find('list');
		$parentCategories = $this->GalleryCategory->ParentCategory->find('list');
		$this->set(compact('images','parentCategories'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for GalleryCategory', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->GalleryCategory->del($id)) {
			$this->Session->setFlash(__('GalleryCategory deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
