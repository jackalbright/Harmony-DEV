<?php
class CustomImagesController extends AppController {

	var $name = 'CustomImages';
	#var $title = 'Upload your image to preview on all products';
	var $title = 'Upload your image to select a product';
	var $helpers = array('Html', 'Form');
	#var $build_page = true;
	var $iframe = false;

	var $paginate = array(
		'order'=>'Image_ID DESC'
	);

	function testImage($id)
	{ # Re-gen thumbs + transparency preserve.

		$customImage = $this->CustomImage->read(null, $id);
		$srcfile =  APP."/webroot/".$customImage['CustomImage']['Image_Location'];

		list($srcw,$srch) = getimagesize($srcfile);
		$srcw2h = $srcw/$srch;

		$w = 200;
		$h = $w/$srcw2h;

		$image = new Imagick($srcfile);
		$image->setImageBackgroundColor("none");

		$image = $image->flattenImages();
		#$image->thumbnailImage($w, $h);

		header("Content-Type: image/png");
		echo $image;
		exit(0);

	}

	function beforeFilter()
	{
		if(!empty($_REQUEST['savegoto'])) # MUST CALL BEFORE beforeFilter() so saved before login catches.
		{
			$this->Session->write("savegoto", $_REQUEST['savegoto']);
		}

	#	error_log("SAVEGOTO=".$this->Session->read("savegoto"));

		ini_set("upload_max_filesize", "10M");
		parent::beforeFilter();
		$this->rightbar_disabled = true;
		if (!empty($_REQUEST['prod']))
		{
			$prod = $_REQUEST['prod'];
			$this->Session->write("Build.prod", $prod);
			$product = $this->Product->find("code = '$prod'");
			$this->build['Product'] = $product['Product'];
			$this->Session->write("Build", $this->build);

			if(!preg_match("/custom/", $product['Product']['image_type']))
			{
				$this->redirect("/gallery/browse");
			}
		}
		if (!empty($_REQUEST['new']) || empty($this->build["Product"]))
		{
			#$this->Session->delete("Build.Product");
			#unset($this->build['Product']);
			#$this->build = array();

			#unset($this->build['Product']); # Clear product.
			#
			# Clear EVERYTHING in build, so don't overwrite previous item in cart.
			$this->build = array();
			$this->build['image_first'] = 1;
			$this->Session->write("Build", $this->build);
		}
	}

	function ajax_save($image_id)
	{
		$this->layout = 'ajax';
		Configure::write("debug", 0);
		$session_id = session_id();
		$customer_id = $this->get_customer_id();
		if($customer_id) # Shouldn't call this directly until logged in.
		{
			$image = $this->CustomImage->read(null, $image_id);
			$this->CustomImage->saveImage($image, $session_id, $customer_id);
		}
		$this->redirect("/custom_images/ajax_load");
	}

	function ajax_delete($image_id)
	{
		$this->layout = 'ajax';
		Configure::write("debug", 0);
		$image = $this->CustomImage->del($image_id);

		$this->redirect("/custom_images/ajax_load");
	}

	function ajax_load()
	{
		$this->layout = 'ajax';
		Configure::write("debug", 0);
		$customer_id = !empty($_SESSION['Auth']['Customer']['customer_id']) ? $_SESSION['Auth']['Customer']['customer_id'] : null;
		$session_id = session_id();
		$images = $this->CustomImage->findAll( ($customer_id?" CustomImage.customer_id = '$customer_id' OR " : "") . " CustomImage.session_id = '$session_id' ", null, "Image_ID DESC");
		$this->set("images", $images);
	}

	function beforeRender()
	{
		$this->Auth->allow('*');
		#echo "SID=".session_id()."!";
		#$this->set("rightbar_disabled", true);
		parent::beforeRender();
		$this->set("current_build_step", 2);
		if (!isset($this->build['Product'])) { 
			$this->set("image_select_first", true);
		}
	}

	function index($reset = false) {
		#$this->Session->setFlash("warning goes here", 'warn');

		//$this->set("stepname", "image");
		# ALWAYS GO TO ADD PAGE NOW!
		#$this->redirect(array('action'=>"add")); 

		#return;
		########################################

		$productname = null;#"all products";

		$this->body_title_crumbs = false;

		$customer_id = !empty($_SESSION['Auth']['Customer']['customer_id']) ? $_SESSION['Auth']['Customer']['customer_id'] : null;
		$session_id = session_id();
		$images = $this->CustomImage->findAll( ($customer_id?" CustomImage.customer_id = '$customer_id' OR " : "") . " CustomImage.session_id = '$session_id' ", null, "Image_ID desc");

		$product = null;

		if(!empty($reset))
		{
			$this->set("product", null);
			unset($this->build['Product']);
			$this->Session->write("Build", $this->build);
		} else {
			$p = $this->Session->read("Build.Product");
			if(!empty($p)) { $product = array('Product'=>$p); }
			$this->set("product", $product);
		}
		$parent_product = !empty($product['Product']['parent_product_type_id']) ? $this->Product->read(null, $product['Product']['parent_product_type_id']) : $product;

		if(!empty($parent_product)) { $productname = strtolower($this->pluralize($parent_product['Product']['short_name'])); }
		if(empty($productname)) { $productname = strtolower($this->pluralize($parent_product['Product']['name'])); }

		#$this->body_title = "Upload your image to preview on $productname";
		$this->body_title = " ";#"Select your photo, logo or art to continue";

		$this->set("images", $images);

	}

	function admin_search($email = '')
	{
		$this->layout = 'default_plain';
		$conditions = array();
		if(!empty($email) || !empty($this->data)) {
			$value = $this->data['value'];
			if(!empty($email) && $value == '') {
				$conditions = array('eMail_Address'=>$email); # Exact person.
			} else if ($this->data['field'] == 'firstlast') { 
				$conditions = "CONCAT(First_Name, ' ', Last_Name) LIKE '%$value%'";
			} else if ($this->data['field'] == 'lastfirst') { 
				$conditions = "CONCAT(Last_Name, ', ', First_Name) LIKE '%$value%'";
			} else if ($this->data['field'] == 'email') { 
				$conditions = array('eMail_Address LIKE'=>"%$value%");
			} else if ($this->data['field'] == 'company') { 
				$conditions = array('Company LIKE'=>"%$value%");
			}
			$customer = $this->Customer->findAll($conditions);
			$count = $this->Customer->findCount($conditions);

			$this->set("users", $customer);

			if($count == 1)
			{
				$this->set("user", $customer[0]);
				$customer_id = $customer[0]['Customer']['customer_id'];
				$this->CustomImage->recursive = 0;
				$this->CustomImage->order = "Image_ID desc";
				$custom_images = $this->CustomImage->findAll(" CustomImage.customer_id = '$customer_id' ");

				$this->set("custom_images", $custom_images);
			}
		}
	}

	function save($image_id)
	{
		if(!$this->get_customer_id())
		{
			$this->Session->setFlash("Save your images for later by logging in or signing up for an account");
			$this->redirect("/account/login?goto=/custom_images/save/$image_id");
			#$this->require_login();
		} else { # Do save now.
			$image = $this->CustomImage->read(null, $image_id);
			$session_id = session_id();
			$customer_id = $this->Session->read("Auth.Customer.customer_id");
			$this->CustomImage->saveImage($image, $session_id, $customer_id);
			$this->Session->setFlash("Your image has been saved.","success");
			$savegoto = $this->Session->read("savegoto");
		#	error_log("SAVEGOTO=$savegoto");
			$this->Session->delete("savegoto");
			if(empty($savegoto)) { $savegoto = '/custom_images'; }
			$this->redirect($savegoto);
		}
	}

	function signup()
	{
		$this->Session->setFlash("Save your images for later by logging in or signing up for an account");
		$this->redirect("/account/login?goto=/custom_images");
	}

	function choose_image($id)
	{
		$this->Session->write("Build.imageID", $id);
		$image = $this->CustomImage->read(null, $id);
		$this->build["CustomImage"] = $image['CustomImage'];
		$this->build["GalleryImage"] = null; # Clear!
		$this->build['crop'] = null;
		$this->Session->write("Build", $this->build);
	}
	
	function select($id)
	{
		
		
		
		$this->TrackingVisit->did_goal("upload");
		# XXX TODO MAKE SURE IMAGE BELONGS TO USER!!!!
		$prod = !empty($_REQUEST['prod']) ? $_REQUEST['prod'] : $this->Session->read('Build.Product.code');
		$this->Session->delete("Build.catalog_number"); # Don't need to use anymore.
		$this->Session->write("Build.GalleryImage",2); # Don't need to use anymore.
		$this->Session->delete("Build.GalleryImage"); # Don't need to use anymore.

		if(!empty($_REQUEST['layout']))
		{
			$this->Session->write("Build.template", $_REQUEST['layout']);
		}
		if(!empty($_REQUEST['template']))
		{
			$this->Session->write("Build.template", $_REQUEST['template']);
		}

		$layout = $this->Session->read("Build.template");
		if(empty($layout)) { $layout = $this->config['default_custom_image_layout']; }

		$this->build['crop'] = null;


		#error_log("IMGA=".print_r($this->build['CustomImage'],true));

		$this->choose_image($id);

		$this->track("custom_images", "existing", array('image_id'=>$id));

		#error_log("IMGB=".print_r($this->build['CustomImage'],true));

		# WTF!
		#$_SESSION['Build']['GalleryImage'] = null;
		#$_SESSION['Build']['catalog_number'] = null;
		#error_log("BUILD_PROD111111111111111111111111111111111111111=".print_r($this->build['CustomImage'],true));
			# OK
		#error_log("IMGC=".print_r($this->build['CustomImage'],true));
		
		// test variables set by JA to test the product_grid page
		
		$myTemp = json_encode($_SESSION);
		$this->Session->write("myTemp",$myTemp);
		
		if ($prod != "" && empty($_REQUEST['clear']))
		{##
			#$this->redirect("/product/build.php?productCode=$prod&imageID=$id");
		#error_log("IMGD=".print_r($_SESSION['Build']['CustomImage'],true));
		#error_log("SIDx=".session_id());
			$this->redirect("/build/customize?new=1&layout=$layout");#?prod=$prod");
			# DO NOT PASS prod, erases rest of stuff!
		} else {
			$default_layout = !empty($this->config['default_custom_image_layout']) ? $this->config['default_custom_image_layout'] : 'standard';
			$layout = !empty($_REQUEST['layout']) ? $_REQUEST['layout'] : $default_layout;
			$this->redirect("/products/select?layout=$layout");
		}
	}

	function add_build_logo()
	{
		$this->Image->model = 'PersonalizationLogo';
		$this->add_or_edit_process(); # Will redirect to build accordingly...
	}

	function add_or_edit_process($id = null)
	{
		$this->TrackingVisit->did_goal("upload");

		$this->set("stepname", "image");

		if (empty($this->build['Product']))
		{
			$this->build['image_first'] = 1;
			$this->Session->write("Build", $this->build);
		}
		if (!empty($_REQUEST['clear']) || (isset($_REQUEST['prod']) && !$_REQUEST['prod']))
		{
			$this->clear_product();
		}
		$session_id = session_id();
		$customer_id = $this->Session->read("Auth.Customer.customer_id");
		$this->set("customer_id", $customer_id);

		if (!$id && !empty($this->data['CustomImage']['Image_ID'])) { $id = $this->data['CustomImage']['Image_ID']; }
		$mode = "";

		$path = "";
		$prefix = "";

		if (!$id)
		{
			#$this->body_title = "Upload your image to see it on " . (!empty($this->build["Product"]) ? strtolower($this->pluralize($this->build['Product']['name'])) : "available items");
			$this->body_title = "Upload your image to continue";#preview it on " . (!empty($this->build["Product"]) ? strtolower($this->pluralize($this->build['Product']['name'])) : "all available products");
			$mode = 'add';
			$this->CustomImage->create();
			$path = $this->getImagePath();
			$prefix = $this->_getImageFilenamePrefix();

		} else {
			$this->body_title = "Manage your image";
			$mode = 'edit';
			# Look up record, make sure id matches session_id.
			$image = $this->CustomImage->read(null, $id);
			$customer_id = $this->Session->read("Auth.Customer.customer_id");
			if ($image['CustomImage']['session_id'] != $session_id && $image['CustomImage']['Customer_ID'] != $customer_id)
			# XXX TODO OR customer_id mismatch.
			{
				$this->Session->setFlash("Invalid image");
				$this->redirect(array('action'=>'index'));
				return;
			}

			# Get from existing...

			$path = dirname($image['CustomImage']['Image_Location']);
			$prefix = preg_replace("/[.]\w+$/", "", basename($image['CustomImage']['Image_Location']));
		}
		$this->set("mode", $mode);
		# Set up path.
		$path = $this->getImagePath();
		$prefix = $this->_getImageFilenamePrefix(); # Generates.

		if (!empty($this->data))
		{
			$this->Image->allowed = $this->Image->all_types;
			if (!$this->Image->didSupplyUpload('file'))
			{
				$size_limit = ini_get("upload_max_filesize");
				if (!$size_limit) { $size_limit = "5M"; }
				$this->Session->setFlash("We are unable to receive your image. Please make sure that the size of your image is 2 MB or less",'warn');
				return;
			}
			#
			$return = $this->Image->saveUpload('file', $path, $prefix); # Done separately from actual db
			if ($return && is_array($return))
			{
				$this->Session->setFlash("Sorry, we are unable to process your image: " .  join("<br/>\n", $return), 'warn' );
				return;
			}
			error_log("RETURN=".print_r($return,true));
			# SOMETIMES WWe accidentally get an Array back.....

			if ($filename = $return) # Now save db portion. Create thumbnails.
			{
				error_log("GOT FILENAME=$filename");

				# Before we save to db, scale down files and convert to viewable format.
				$viewable_filename = $this->Image->viewable_filename($filename);

				####################
				# XXX TODO
				# We MAY change our mind  to make 'display' file full-sized....
				# Since we'd use that image for previews....

				# Now save smaller images.
				$display_width = 350;
				$thumb_height = 80;

				# Make a PNG version if not.
				$master_filename = preg_replace("/[.](\w+)$/", '.png', $filename);
				$rc = $this->Image->scaleFile("$path/$filename", "$path/$master_filename", null, null, 1);
                                if (is_array($rc))
                                {
                                	$this->Session->setFlash(join("<br/>", $rc));
                                        return;
                                }

				# FORCE PNG, so no odd black lines from jpeg scaling.
				$viewable_filename = preg_replace("/[.](\w+)$/", '.png', $viewable_filename);
				error_log("VP=$viewable_filename");

				$rc = $this->Image->scaleFile("$path/$master_filename", "$path/display/$viewable_filename", $display_width, null, 1);
                                if (is_array($rc))
                                {
                                	$this->Session->setFlash(join("<br/>", $rc));
                                        return;
                                }
                                $rc = $this->Image->scaleFile("$path/$master_filename", "$path/thumbs/$viewable_filename", null, $thumb_height, 1);
                                if (is_array($rc))
                                {
                                                $this->Session->setFlash(join("<br/>", $rc));
                                                return;
                                }



				# Now save to database.
				$this->data['CustomImage']['session_id'] = $this->Session->id();
				$this->data['CustomImage']['Customer_ID'] = $this->Session->read("Auth.Customer.customer_id");
				$this->data['CustomImage']['Image_Path'] = $path; 
				$this->data['CustomImage']['Submission_Date'] = $this->unix_date();

				if(empty($this->data['CustomImage']['Title'])) { 
					list($fileprefix, $ext) = preg_split("/[.]/", $this->data['CustomImage']['file']['name']);
					$this->data['CustomImage']['Title'] = Inflector::humanize(Inflector::underscore(preg_replace("/[-]/", '_', $fileprefix)));
				}

				$this->data['CustomImage']['Image_Location'] = "$path/$filename"; # Could be gigantic here

				$this->data['CustomImage']['display_location'] = "$path/display/$viewable_filename"; # What we'll bother showing on browser for sanity.
				$this->data['CustomImage']['thumbnail_location'] = "$path/thumbs/$viewable_filename";

				# Now save record.
					if ($this->CustomImage->save($this->data)) {
						if($this->iframe)
						{
							#$msg = "Please wait while your image preview loads below...";
						} else {
							$msg = "Your image has been uploaded.";
						$customer = $this->get_customer();
						if (empty($customer)) {
							#$url = $_SERVER['REQUEST_URI'];
							$goto = !empty($this->build['Product']) ? "/build/customize?new=1" : "/products/select";
							$msg .= " <a href='/account/login/custom_image?goto=$goto'>Signup or Login</a> to save your image for later.";
						}
							$this->Session->setFlash(__($msg, true),'success');
						}

						$customer_id = !empty($customer['Customer_ID']) ? $customer['Customer_ID'] : null;

						$this->track("custom_images", "add", array('customer_id'=>$customer_id, 'image_id'=>$this->CustomImage->id));

						#if (!$customer_id)
						#{
						#	$msg .= " We recommend you <a href='/account/login'>signup or login</a> to save your image for later.";
						#}

						#error_log("SAVIN $mode");


						if ($mode == 'add')
						{
							# Now send confirmation email to site admin.
							$this->sendAdminEmail("Image Uploaded", "admin_image_uploaded", array('custom_image'=>$this->data['CustomImage']));

							#$this->redirect(array('action'=>'index'));
						}
						$imgid = $this->CustomImage->id;
						#if (!empty($_REQUEST['prod']))
						#{
						#	$prod = $_REQUEST['prod'];
						#	$product = $this->Product->find(" code = '$prod' ");
						#	$this->Session->write("Build.Product", $product['Product']);
						#}

						if ($this->action == 'add_build_logo') {
							$image = $this->CustomImage->read(null, $imgid);
							$this->build['PersonalizationLogo'] = $image['CustomImage'];
							$this->Session->write("Build", $this->build);
							$this->redirect("/build/customize?step=personalization");
						}



						if(!empty($_REQUEST['prod']))
						{
							$this->set_build_product($_REQUEST['prod'],true); # clear rest of build...
						}
						if (!empty($this->data['prod']))
						{
							$this->set_build_product($this->data['prod'],true);
						}

						if (!empty($this->data['template']))
						{
							$this->build['template'] = $this->data['template'];
							$this->Session->write("Build", $this->build);
						}

						$this->choose_image($imgid);

						if (!empty($this->data['CustomImage']['save']))
						{
							$url = "/custom_images/select/$imgid";
							if (!empty($_REQUEST['prod']))
							{
								$url = "/build/step?prod=".$_REQUEST['prod'];
							}
							$this->Session->setFlash("Your image has been uploaded. Please login or signup to continue. <a href='$url'>Continue without signing up</a>");
							$this->redirect("/account/login?goto=$url");

						}
						else if (!empty($_REQUEST['prod']))
						{
							# XXX TODO
							# if we haven't chosen a layout, choose here... (what if only one, though???)
							if (!empty($product['AllRelatedProducts']))
							{
								$this->redirect("/build/choose_product_type/".$_REQUEST['prod']); # Skip step if we specified product.
							} else {
								$this->redirect("/build/create?new=1&prod=".$_REQUEST['prod']); # Skip step if we specified product.
							}
						} else {
							return true;
						}
					} else {
						if (empty($this->data['CustomImage']['title'])) {
							$this->Session->setFlash(__('Your image could not be saved. Please give your image a title.', true));
						} else {
							$this->Session->setFlash(__('Your image could not be saved. Please, try again.', true));
						}
					}

			}

			return true;
		} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$size_limit = ini_get("post_max_size");
			if (!$size_limit) { $size_limit = "5M"; }
			$this->Session->setFlash("We are unable to save your image. Please make sure you have provided your image and that it is $size_limit or less");
			# We have NO way of knowing whether they either FORGOT the image
			# or it was too big (either way it's blank)

		}

		# get list of images....

		$criteria = array();
		$criteria['CustomImage.session_id'] = $this->Session->id();
		if ($customer_id = $this->get_customer_id()) { $criteria['CustomImage.customer_id'] = $customer_id; }
		$this->set('customImages', $this->paginate("CustomImage", array('or'=>$criteria)));

		return false;
	}

	function pressready() # Redirect to 
	{
		$this->Session->write("Build.pressready", 1);
		$this->redirect("/custom_images"); # Select image.
	}

		
	function pressready_upload() # Show preview, add to cart....
	{

	}

	function pressready_preview()
	{
		# Show preview w/ add-to-cart button, etc...
	}

	function emailart()
	{
		$this->body_title = 'Email Your Completed Art (REDO AS EMAIL)';
		if (!empty($this->data))
		{
			$info = $this->data['CustomImage'];
			if(empty($info['email']) || empty($info['name']) || empty($info['phone']))
			{
				$this->Session->setFlash("Your contact information is required");
				return;
			}
			$time = time();
			$url = "/images/custom/emailart";
			$path = APP."/webroot/$url";
			$prefix = $time;

			#$this->Image->allowed = array('jpeg','jpg','gif','png','psd','tif','pdf','zip');
			$this->Image->allowed = array('jpeg','jpg','gif','png','tif','pdf','zip');

			if (!$this->Image->didSupplyUpload('file'))
			{
				$this->Session->setFlash("Please provide a file");
			} else {
				$return = $this->Image->saveUpload('file', $url, $prefix); # Done separately from actual db
				if ($return && is_array($return))
				{
					$this->Session->setFlash("Sorry, we are unable to save your image: " .  join("<br/>\n", $return) );
					#$this->render();
				} else if ($filename = $return) {
					$url .= "/$filename";
					#$this->sendAdminEmail("Completed Art Uploaded", "admin_art_uploaded", array('url'=>$url, 'info'=>$info,'path'=>$url), $info['email']);
					$this->sendEmail("t_maly@comcast.net", "Completed Art Uploaded", "admin_art_uploaded", array('path'=>$url, 'info'=>$info), $info['email']);
					$this->set("path", $url);
					$this->action = 'emailart_thanks';
					$this->body_title = 'Your Completed Art Has Been Received';
				}
			}
		}
	}

	function add() {

		if (empty($this->data)) { $this->track("custom_images", "view"); }
		if($this->add_or_edit_process())
		{
			$imgid = $this->CustomImage->id;
			$default_layout = !empty($this->config['default_custom_image_layout']) ? $this->config['default_custom_image_layout'] : 'standard';
			$this->redirect("/custom_images/select/$imgid?layout=$default_layout");
		} else {
			$this->redirect("/custom_images"); # List.
		}

		$this->action = 'add_or_edit';

	}

	function ajax_add()
	{
		$this->layout = 'ajax';
		$this->add_or_edit_process();
	}

	function iframe_add()
	{
		Configure::write("debug", 0);
		$this->layout = 'iframe';
		$this->iframe = true;
		$this->add_or_edit_process();
	}

	function _assignToCustomer($image, $customer_id)
	{
		# Add customer id.
		# Change paths.
	}


	function _getImageFilenamePrefix()
	{
		return $prefix = time() . rand(0, 10000);
	}

	function edit($id = null) {

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Image', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->add_or_edit_process($id);

		# Since we don't load all fields, load again!
		$this->data = $this->CustomImage->read(null, $id);

		$this->action = 'add_or_edit';
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Image', true));
		}
		if ($this->CustomImage->del($id)) {
			$this->Session->setFlash(__('Image deleted', true));
		}
		$this->redirect(array('action'=>'index'));
	}

        function view($id = null) {
                if (!$id) {
                        $this->Session->setFlash(__('Invalid CustomImages.', true));
                        $this->redirect(array('action'=>'index'));
                }
                $this->set('customImage', $this->CustomImage->read(null, $id));
        }

	function display($imgid) 
	{
		$img = $this->CustomImage->read(null, $imgid);
		$this->redirect($img['CustomImage']['display_location']);
	}

	function thumb($imgid)
	{
		$img = $this->CustomImage->read(null, $imgid);
		$this->redirect($img['CustomImage']['thumbnail_location']);
	}
	function img($imgid) # FUll
	{
		$img = $this->CustomImage->read(null, $imgid);
		$this->redirect($img['CustomImage']['Image_Location']);
	}



	function admin_index($all = false) {
		$this->paginate['limit'] = 50;


	

		$this->CustomImage->recursive = 0;

		if (isset($this->data) && $this->data['searchImage_ID'] !='')
		{
			$custom_images = $this->paginate('CustomImage',array('Image_ID'=>$this->data['searchImage_ID']) );
		}else if ($all)
		{
			$custom_images = $this->paginate();
		} else 
		{
			$custom_images = $this->paginate('CustomImage', array('Approved'=>'Pending'));
		}
		
		
		$this->set("all", $all);


		$this->set('customImages', $custom_images);
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CustomImages.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('customImage', $this->CustomImage->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->CustomImage->create();
			if ($this->CustomImage->save($this->data)) {
				$this->Session->setFlash(__('The CustomImages has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CustomImages could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CustomImages', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CustomImage->save($this->data)) {
				$this->Session->setFlash(__('The CustomImages has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CustomImages could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CustomImage->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CustomImages', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CustomImage->del($id)) {
			$this->Session->setFlash(__('CustomImages deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>
