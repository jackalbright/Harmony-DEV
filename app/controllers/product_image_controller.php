<?php
class ProductImageController extends AppController {

	var $imgonlys = array('imageonly','imageonly_nopersonalization');

	var $debug = false;
	var $name = 'ProductImage';
	var $helpers = array('Html', 'Form');
	var $uses = array("Product", "GalleryImage", "CustomImage","Charm","CharmCategory","CharmCategoryCharm","Tassel","Part","ShippingPricePoint","TrackingProductCalculatorRequest","Faq","FaqTopic","ContentSnippet","Border","CartItem","Ribbon","Frame","OrderItem",'SavedItem','BuildEmail');
	var $black;
	var $white;
	var $grey;
	var $template;
	var $fullview = false;
	var $textonly = false;
	var $noimage = false;
	var $transbg = false;
	var $gif = false;
	var $filetype = false;
	var $orient = "horizontal"; # Default
	var $transindex = null;
	var $transcol = null;
	var $transparency = true;
	var $default_text = false;
	var $no_quote = false;
	var $no_pers = null;
	var $no_crop = false;
	var $no_default_pers = false;
	var $double_sided = false;
	var $defaultColor = 0x888888;
	var $textColor = 0x0;
	var $min_font_size = 6;
	var $max_font_size = 56;
	var $dark = false;
	var $picture_only = false;

	function testTrans()
	{
		# THIS HERE MAKES LAYERED TRANSPARENT GIFS  HAPPY (no degraded colors)
		if(!empty($_REQUEST['debug']))
		{
			header("Content-Type: text/plain");
		}
		else {
			header("Content-Type: image/gif");
		}

		# lower layer doesnt have all the colors of the upper layer, so degrades.
		$prodImg = APP."/../images/products/blanks/ORN-CER/horizontal/original/ORN-CER-trans.gif";
		$ribbonImg = APP."/../ribbons/blanks/ORN-CER/cranberry.gif";

		$img1 = imagecreatefromgif($prodImg);
		list($img1w,$img1h) = getimagesize($prodImg);


		$img2 = imagecreatefromgif($ribbonImg);
		list($img2w,$img2h) = getimagesize($ribbonImg);

		$truecanvas = imagecreatetruecolor($img1w,$img1h);
		# CONVERT BLACK TO ALPHA (BEFORE ANYTHING PUT ON TOP)
		$black = imagecolorallocate($truecanvas, 0,0,0);
		imagecolortransparent($truecanvas, $black);


		imagecopy($truecanvas, $img1, 0,0, 0,0, $img1w, $img1h);
		# Imagecopy plays nicer with transparency than resampled

		imagecopy($truecanvas, $img2, 0,0, 0,0, $img1w, $img1h);

		#imagecopyresampled($truecanvas, $img1, 0,0, 0,0, $img1w,$img1h, $img1w, $img1h);

		#imagecopyresampled($truecanvas, $img2, 0,0, 0,0, $img1w,$img1h, $img1w, $img1h);



		imagegif($truecanvas);
		exit(0);

	}

	function beforeFilter()
	{

		if (!empty($_REQUEST['noimage']))
		{
			$this->noimage = true;
		}

		
		parent::beforeFilter();

		switch($this->action)
		{
			case 'admin_add':
			case 'admin_edit':
			case 'add':
			case 'edit':
		}
	}

	function beforeRender()
	{
		parent::beforeRender();

		switch($this->action)
		{
			case 'admin_add':
			case 'admin_edit':
			case 'add':
			case 'edit':
		}
	}
	function testTrans11()
	{
		$img1file = "http://www.harmonydesigns.com/images/products/blanks/B/horizontal/original/B-trans.png";
		$img2file = "http://www.harmonydesigns.com/tassels/blanks/black.png";
		$img1 = imagecreatefrompng($img1file);
		list($img1w,$img1h) = getimagesize($img1file);
		imagealphablending( $img1, false );
		imagesavealpha( $img1, true );

		$img2a = imagecreatefrompng($img2file);
		list($img2w,$img2h) = getimagesize($img2file);
		imagealphablending($img2a, false);
		imagesavealpha($img2a, true);

		# Maybe get transparent from master image???

		$img2b = imagecreatetruecolor($img2w,$img2h);

		# XXX TOMAS_MALY THIS SEEMS TO WORK...

		# This made things transparent so far.  maybe we should fill as well?
		# so stuff outside of pasted area works too.
		#
		$transparent = imagecolorallocatealpha($img2b, 0,0,0,127);
		imagefill($img2b, 0,0, $transparent); # This fills entire area, even spots not pasted upon.
		imagecolortransparent($img2b, $transparent); # This designates what the transparent color IS.

		imagealphablending($img2b, false);
		imagesavealpha($img2b, true);

		imagecopyresampled($img2b, $img2a, 0,0, 0,0, $img2w/2,$img2h/2,$img2w,$img2h);

		imagecopyresampled($img1, $img2b, 0,0, 0,0, $img1w,$img1h, $img2w,$img2h); # This erases the layer below.
		if(!empty($_REQUEST['debug'])) { exit(0); }
		header("Content-Type: image/png"); imagepng($img1); exit(0);
	}




	function _out($img) { header("Content-Type: image/png"); imagepng($img); exit(0); }

	function tassel($tasselID)
	{
		$tassel = $this->Tassel->read(null, $tasselID);
		$color = preg_replace("/ /", "-", $tassel['Tassel']['color_name']);
		$path = "/tassels/medium-fullview/$color.png";
		$this->redirect($path);
	}

	function charm($charmID)
	{
		$charm = $this->Charm->read(null, $charmID);
		$color = preg_replace("/ /", "-", $charm['Charm']['name']);
		$path = $charm['Charm']['graphic_location'];
		$this->redirect($path);
	}

	function image_rotate($image_id, $angle = 0)
	{
		$image = $this->CustomImage->read(null, $image_id);

		$display_location = $image['CustomImage']['display_location'];
		$image_location = $image['CustomImage']['Image_Location'];

		#$imgpath = APP."/webroot/".$image_location;
		$imgpath = APP."/webroot/".$display_location;

		$rotimg = $this->_gd_load_image($imgpath, null, $angle);

		$this->_output_image($rotimg);
	}

	function imagickRotate($imgpath, $angle = 0)
	{
		#$angle = 360-$angle; # Since reversed..
		$cmd = "convert -rotate $angle $imgpath PNG32:-";
		#error_log("CMD=$cmd");
		$output = popen($cmd, "r");
		$rotimg_string = null;
		while(!feof($output)) { $rotimg_string .= fread($output, 1024); }

		$rotimg = imagecreatefromstring($rotimg_string);
		imagealphablending( $rotimg, false );
		imagesavealpha( $rotimg, true );

		return $rotimg;
	}

	function image($image_id, $coords = null)
	{
		$image = $this->CustomImage->read(null, $image_id);

		$display_location = $image['CustomImage']['display_location'];
		$image_location = $image['CustomImage']['Image_Location'];

		list($x,$y,$w,$h) = split(",", $coords);

		list($dlw,$dlh) = getimagesize(APP."/webroot/".$display_location);
		list($ilw,$ilh) = getimagesize(APP."/webroot/".$image_location);

		$i2d = $ilw / $dlw;

		$ix = $x * $i2d;
		$iy = $y * $i2d;
		$iw = $w * $i2d;
		$ih = $h * $i2d;


		$img = $this->_gd_load_image(APP."/webroot/".$image_location, array($ix,$iy,$iw,$ih));
		$this->_output_image($img);
	}


	function _gd_load_image($path, $crop_data = false, $rotate = 0)
	{
		#error_log("LOADING=$path");
		ini_set("memory_limit","200M");
		if (!file_exists($path)) { return null; }
		list($w,$h) = getimagesize($path);
		$img_w2h = $w/$h;
		$t = exif_imagetype($path);
		$img = null;
		if ($t == IMAGETYPE_GIF)
		{
			$img_src = imagecreatefromgif($path);
			#$this->save_transparency($img_src);

			# Convert from indexed to truecolor for better colors.

			$img = imagecreatetruecolor($w,$h);
			# Convert black to alpha (before anything put on top)

			# Get original image's transparent color (may not be black!)
			$trans_index = imagecolortransparent($img_src);
			if($trans_index >= 0)
			{
				$trans_rgb = imagecolorsforindex($img_src, $trans_index);
				# Since color may not be black, we have to consider alpha too.
				$trans_color = imagecolorallocate($img, $trans_rgb['red'], $trans_rgb['green'], $trans_rgb['blue']);
				$trans_color_a = imagecolorallocatealpha($img, $trans_rgb['red'], $trans_rgb['green'], $trans_rgb['blue'], $trans_rgb['alpha']);
				imagefill($img, 0,0, $trans_color_a);
				# This seems to be the right way to make transparency preserved.
			} else { # Default to black w/half alpha (so normal black ok).
				#$trans_color_a = imagecolorallocate($img, 255,255,255, 127);
				#$trans_color = imagecolorallocate($img, 255,255,255);
				#imagefill($img, 0,0, $trans_color_a);
			}

			$transparent = imagecolorallocatealpha($img, 0,0,0,127);
			imagefill($img, 0,0, $transparent); # This fills entire area, even spots not pasted upon.
			imagecolortransparent($img, $transparent); # This designates what the transparent color IS.

			#imagecolortransparent($img, $trans_color);
			# This above doesnt work, messes up colors (makes black transparent, etc).
			imagecopy($img, $img_src, 0,0, 0,0, $w,$h);
			# What IF a different color is transparent?
			# esp if black is a 'used' color?

			#header("Content-Type: image/png");
			#imagepng($img);
			#exit(0);

			#exit(0); # Doesnt work for PZ!
			##$img = $img_src;

			# Now should be happy since always true color.
			
		} else if ($t == IMAGETYPE_JPEG) { 
			$img = imagecreatefromjpeg($path);

		} else if ($t == IMAGETYPE_PNG) {
			$img = imagecreatefrompng($path);
			#$this->save_transparency($img);
		}

		#header("Content-Type: image/png"); imagepng($img); exit(0);

		if($rotate != 0)
		{
			$img = $this->imagickRotate($path, $rotate, 0);
			#$img = imagerotate($img, $rotate, 0);
		}

		$w = imagesx($img);
		$h = imagesy($img);
		$img_w2h = $w/$h;


		if (!empty($crop_data))
		{
			# SOMETIMES we might be a little off, so make sure neither width nor height are too small given other dimension.
			# (allow for slight clipping)
			list($crop_x,$crop_y,$crop_w,$crop_h) = $crop_data;
			#error_log("CROP=$crop_x,$crop_y,$crop_w,$crop_h");

			# Due to ceil(), we may be off by a pixel or two too much.

			if(!$crop_w || !$crop_h) { return $img; }
			$crop_w2h = $crop_w/$crop_h;

			/*

			if($crop_x < 0) { $crop_x = 0; } # Panned around.
			if($crop_y < 0) { $crop_y = 0; }


			# Let them zoom out and deal with crop coordinates bigger than image.
			# Scaling down is handled later.
			if($crop_w > $w)
			{
				$canvas_w = $w;
			}
			if($crop_h > $h)
			{
				$canvas_h = $h;
				#$canvas_h = intval($w / $img_w2h);
			}

			# Canvas needs to be in proportion to image.

			if ($crop_x + $crop_w > $w)
			{
				$crop_w = $w - $crop_x;
			} 
			else if ($crop_y + $crop_h > $h)
			{
				$crop_h = $h - $crop_y;
			}
			if($crop_w > $w) { $crop_w = $w; $crop_h = $crop_w/$img_w2h; }
			if($crop_h > $h) { $crop_h = $h; $crop_w = $crop_h*$img_w2h; }
			# scaling will be done by imagescale

			*/

			# New approach.
			$dx = $dy = $sx = $sy = 0;
			# dx,dy gets adjusted elsewhere...
			$neww = $newh = 0;
			if($crop_x >= 0)
			{
				$sx = $crop_x;
				$neww = $w - $crop_x;
			} else {
				$sx = 0;
				$neww = $crop_w - abs($crop_x);
			}
			if($crop_y >= 0)
			{
				$sy = $crop_y;
				$newh = $h - $crop_y;
			} else {
				$sy = 0;
				$newh = $crop_h - abs($crop_y);
			}
			if($newh > $h) { $newh = $h; }
			if($neww > $w) { $neww = $w; }

			$sh = $dh = $newh;
			$sw = $dw = $neww;

			$canvas_w = $crop_w;
			$canvas_h = $crop_h;

			$crop_img = imagecreatetruecolor($canvas_w,$canvas_h);
			
						#imagealphablending($this->canvas, false);
						#$color = imagecolortransparent($this->canvas, imagecolorallocatealpha($this->canvas, 0,0,0,127));
						#imagefill($this->canvas, 0,0, $color);
						#imagesavealpha($this->canvas, true);

			imagealphablending( $crop_img, false );
			imagesavealpha( $crop_img, true );

			# Fill bg with trans color.
			$transparent = imagecolorallocatealpha($crop_img, 0,0,0,127);
			imagefill($crop_img, 0,0, $transparent); # This fills entire area, even spots not pasted upon.
			imagecolortransparent($crop_img, $transparent); # This designates what the transparent color IS.


			# d, s, dx, dy, sx, sy, dw, dh, dw, sh
			/*
			$dx = 0;
			$dy = 0;
			$sx = $crop_x;
			$sy = $crop_y;
			$sw = $crop_w;
			$sh = $crop_h;
			$dw = $canvas_w;
			$dh = $canvas_h;
			*/


			# Should the rotate be done AFTER resample?
			#error_log("IMG=$w,$h; SRC=$sx,$sy,$sw,$sh; DST=$dx,$dy,$dw,$dh");
			# fix where the whole picture gets placed on canvas, too (elsewhere)

			imagecopyresampled($crop_img, $img, $dx,$dy, $sx, $sy, $dw, $dh, $sw, $sh);

			#$this->_output_image($crop_img);

			return $crop_img;
		} else {
			if($rotate != 0)
			{
				#$img = imagerotate($img, $rotate, 0);
			}
						#imagealphablending($img, false);
						#$color = imagecolortransparent($img, imagecolorallocatealpha($img, 0,0,0,127));
						#imagefill($img, 0,0, $color);
						#imagesavealpha($img, true);
			return $img;
		}
	}

	function colorcreate($r, $g, $b) {
	  return hexdec(str_pad(dechex($r), 2, 0, STR_PAD_LEFT).str_pad(dechex($g), 2, 0, STR_PAD_LEFT).str_pad(dechex($b), 2, 0, STR_PAD_LEFT));
	}

	function _gd_getimagesize($src)
	{
		$w = imagesx($src);
		$h = imagesy($src);
		return array($w, $h);
	}

	function preview()
	{
		$testPreviewItem = json_encode($this->params['form']); // Jack Albright test data
		$this->Session->write("testPreviewItem",$testPreviewItem);// Jack Albright test data
		
		$this->layout = 'ajax';
		Configure::write('debug',0);
		# Process form, generate image, create page with it.... (how do we pass ??? put in session ?)
		
		// G E T     P R O D U C T I O N     C O D E
		if(!empty($this->params['form']['productCode']))
		{
			$product = $this->Product->find(" code = '{$this->params['form']['productCode']}' ");

			if(empty($product['Product']['blank_product_type_id']))
			{
				$this->data['Product'] = $product['Product'];
			} else { # Borrow blank from something existing...
				$blank_product = $this->Product->read(null, $product['Product']['blank_product_type_id']);
				$this->data['Product'] = $blank_product['Product'];
			}
		}
		
		// G E T     Q U O T E   -   I F     A N Y
		if(!empty($this->params['form']['quoteID']))
		{
			$this->data['options']['quoteID'] = $this->params['form']['quoteID'];
		}
		
		// G E T     C A T A L O G     N U M B E R     - I F     A N Y
		if(!empty($this->params['form']['catalogNumber']))
		{
			$imgid = $this->data['options']['catalogNumber'] = $this->params['form']['catalogNumber'];
			$image = $this->GalleryImage->find("GalleryImage.catalog_number ='$imgid'");
			$this->data['GalleryImage'] = $image['GalleryImage'];
		}

		$customized = !empty($this->params['form']['customized']) ? $this->params['form']['customized'] : null;
		
		$testCondition = 0;
		if($customized == 'logo')
		{
			
			if($this->Image->didSupplyUpload(array('PersonalizationLogo','file')))
			{
				$testCondition = 1;
				$id = $this->process_image_upload('PersonalizationLogo');
				if(empty($id))
				{
					return;
				}
	
				#error_log("ID=$id");
				$this->data['options']['personalization_logo_id'] = $id;
				$image = $this->CustomImage->read(null, $id);
				$this->data["PersonalizationLogo"] = $image['CustomImage'];
			} else if ($this->Image->failedUpload(array('PersonalizationLogo','file'))) {
				$testCondition = 2;
				$this->Session->setFlash("We are unable to receive your image. Please make sure that the size of your image is 2 MB or less",'warn');
				return;
			} else if(!empty($this->data['options']['personalization_logo_id'])) {
				$testCondition = 3;
				$logo_id = $this->data['options']['personalization_logo_id'];
				$image = $this->CustomImage->read(null, $logo_id);
				$this->data["PersonalizationLogo"] = $image['CustomImage'];
			} else {
				$testCondition = 4;
				unset($this->data['PersonalizationLogo']);
			}
		}else if($customized == 'personalization'){
				$testCondition = 5;
				unset($this->data['PersonalizationLogo']);
		}
		$this->Session->write("testCondition",$testCondition);// Jack Albright test data
		$this->data['options']['customized'] = !empty($customized);


		if($customized && !empty($this->data))
		{
			# Process upload, if any....
			$this->Session->write("Preview", $this->data);
		} else {
			$this->Session->delete("Preview");
		}
	}

	function process_image_upload($model = 'PersonalizationLogo')
	{
			$path = $this->getImagePath();
			$filename = $this->Image->saveUpload(array($model,'file'), $path, time().rand(0,10000));
			if(is_array($filename)) # Failed
			{
				# PROPERLY HANDLE!
				$this->Session->setFlash("Could not upload photo: ". join(". ", $filename));
				return false;
			} 
			#error_log("PROCCESSING = ".print_r($filename,true));
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

	function stock_preview($scale = '')
	{
		# Actual image.
		$build = $this->Session->read("Preview");
		$prod = $build['Product']['code'];

		$imgtype = $imgid = null; # Can pass an optional stamp, if semi-customizable, etc.

		if(!empty($build['GalleryImage']))
		{
			$imgtype = 'Gallery';
			$imgid = $build["GalleryImage"]['catalog_number'];
		}
		else if(!empty($build['CustomImage']))
		{
			$imgtype = 'Custom';
			$imgid = $build["CustomImage"]['Image_ID'];
		}


		# print out.
		$this->_display_image($prod, $imgtype, $imgid, $scale, $build, false);


	}

	function order_view($scale = '')
	{
		$order_item_id = !empty($_REQUEST['order_item_id']) ? $_REQUEST['order_item_id'] : null;
		if (!$order_item_id) { return; }
		$scale = preg_replace("/[.]\w+$/", "", $scale); # Get rid of file extension, if any...

		$orderItem = $this->OrderItem->read(null, $order_item_id);

		if (empty($orderItem)) { return; }


		
		$build = $orderItem['OrderItem'];
		$prod = $orderItem['Product']['code'];
		$is_stock_item = $orderItem['Product']['is_stock_item'];

		$parts = $orderItem['ItemPart'][0]; # Since hasMany now
		#array_change_key_case($parts,CASE_LOWER);

		$this->picture_only = isset($parts['picture_only']) ? $parts['picture_only'] : null;

		$customized = !empty($parts['customized']) ? $parts['customized'] : null;

		# Fix stuff...
		foreach($parts as $partkey => $partvalue)
		{
			$newpartkey = preg_replace("/_/", "", $partkey);
			$parts[$newpartkey] = $partvalue;
		}
		$parts['customQuote'] = !empty($parts['custom_quote']) ? $parts['custom_quote'] : null;
		$parts['personalizationInput'] = !empty($parts['personalization']) ? $parts['personalization'] : null;

		$build['options'] = $parts;

		#$layout = !empty($build['options']['template']) ? $build['options']['template'] : 'standard';
		$layout = $build['template'];

		#$build['template'] = $layout;
		$build['crop'][$layout] = !empty($build['options']['imageCrop']) ? split(",", $build['options']['imageCrop']) : null;
		$imgtype = null;
		$imgid = null;
		if (!empty($build['template']) && in_array($build['template'], $this->imgonlys))
		{
			$this->fullview = true;
		}
		if (!empty($build['options']['imageID'])) { 
			#error_log("CI!");
			$imgtype = 'Custom';
			$imgid = $build['options']['imageID'];
			$image = $this->CustomImage->find("Image_ID ='$imgid'");
			$build['CustomImage'] = $image['CustomImage'];
		} else if (!empty($build['options']['catalogNumber'])) { 
			$imgtype = 'Gallery';
			$imgid = $build['options']['catalogNumber'];
			$image = $this->GalleryImage->find("GalleryImage.catalog_number ='$imgid'");
			$build['GalleryImage'] = $image['GalleryImage'];
		}

		if (!empty($build['options']['personalization_logo_id'])) { 
			$logo_id = $build['options']['personalization_logo_id'];
			$image = $this->CustomImage->read(null, $logo_id);
			$build["PersonalizationLogo"] = $image['CustomImage'];
		}

		if ($customized || !empty($build['GalleryImage']) || !empty($build['CustomImage'])) # Stock item ok if customizable/setup charge
		{
			$this->default_text = false;
			#error_log("C=$cache, CNT=$cant_do_personalization, FV={$this->fullview}");
			$this->_display_image($prod, $imgtype, $imgid, $scale, $build, false);
		} else {
			if ($prod == 'TA')
			{
				$tassel_id = $build['options']['tassel_ID'];
				$tassel = $this->Tassel->find("tassel_id = '$tassel_id'");
				$tasselname = preg_replace("/ /", "-", $tassel['Tassel']['color_name']);
				$filename = APP."/../tassels/$tasselname.png";
				# Get filename for specific tassel
				$this->transparency = false;
			} else if ($prod == 'CH') { 
				$charm_id = $build['options']['charm_ID'];
				$charm = $this->Charm->find("charm_id = '$charm_id'");
				$charmname = preg_replace("/ /", "-", $charm['Charm']['charm_code']);
				# Get filename for specific charm
				$filename = APP."/../charms/large/$charmname.jpg";
			} else { 
				$filename = APP."/webroot/images/products/thumbnail/$prod.png";
			}
			$this->canvas = $this->_gd_load_image($filename);
			$this->save_transparency($this->canvas);
			$final_img = $this->_scale_image($scale);
			$this->_output_image($final_img);
		}
	}


	function cart_view($scale = '')
	{
		$scale = preg_replace("/[.]\w+$/", "", $scale); # Get rid of file extension, if any...
		$cart_item_id = !empty($_REQUEST['cart_item_id']) ? $_REQUEST['cart_item_id'] : null;
		if (!$cart_item_id) { return; }

		$cartItem = $this->CartItem->read(null, $cart_item_id);

		if (empty($cartItem)) { return; }

		$this->picture_only = $cartItem['CartItem']['picture_only'];
		
		$build = $cartItem['CartItem'];
		$prod = $build['productCode'];
		$build['options'] = unserialize($cartItem['CartItem']['parts']);
		$layout = !empty($build['template']) ? $build['template'] : 'standard';


		$build['template'] = $layout;
		if(!empty($build['options']['imageCrop']) && is_array($build['options']['imageCrop']))
		{
			$build['crop'][$layout] = $build['options']['imageCrop'];
			#echo "IC=".print_r($build['crop'][$layout],true);
			#exit(0);
		} else {
			$build['crop'][$layout] = !empty($build['options']['imageCrop']) ? split(",", $build['options']['imageCrop']) : null;
		}
		$imgtype = null;
		$imgid = null;
		if (!empty($build['template']) && in_array($build['template'], $this->imgonlys))
		{
			$this->fullview = true;
		}
		if($build['template'] == 'textonly')
		{
			$this->fullview = true;
			$this->textonly = true;
		}
		if (!empty($build['options']['customImageID'])) { 
			$imgtype = 'Custom';
			$imgid = $build['options']['customImageID'];
			$image = $this->CustomImage->find("Image_ID ='$imgid'");
			$build['CustomImage'] = $image['CustomImage'];
		} else if (!empty($build['options']['catalogNumber'])) { 
			$imgtype = 'Gallery';
			$imgid = $build['options']['catalogNumber'];
			$image = $this->GalleryImage->find("GalleryImage.catalog_number ='$imgid'");
			$build['GalleryImage'] = $image['GalleryImage'];
		}
		if (!empty($build['options']['personalization_logo_id'])) { 
			$logo_id = $build['options']['personalization_logo_id'];
			$image = $this->CustomImage->read(null, $logo_id);
			$build["PersonalizationLogo"] = $image['CustomImage'];
		}

		# XXX TODO

		$this->_display_image($prod, $imgtype, $imgid, $scale, $build, false);
	}

	function email_view($scale = '')
	{
		$build = array();
		$build['template'] = 'standard';

		if (!empty($_REQUEST['template'])) { 
			$this->template = $build['template'] = $_REQUEST['template']; 
		}
		if (!empty($_REQUEST['fullbleed']) || $build['template'] == 'fullbleed') { 
			$build['options']['fullbleed'] = 1;
			$this->template = $build['template'] = 'imageonly';
		}
		if (!empty($_REQUEST['transbg'])) { 
			$this->transbg = $_REQUEST['transbg'];
		}

		if(!empty($_REQUEST['catalog_number']))
		{
			$catnum = $_REQUEST['catalog_number'];
			$galleryImage = $this->GalleryImage->find(" GalleryImage.catalog_number='$catnum' ");
			$build['GalleryImage'] = $galleryImage['GalleryImage'];
		}
		else if (!empty($_REQUEST['image_id'])) 
		{
			$customImage = $this->CustomImage->read(null, $_REQUEST['image_id']);
			$build['CustomImage'] = $customImage['CustomImage'];
		}

		if(!empty($_REQUEST['options']))
		{
			foreach($_REQUEST['options'] as $k => $v)
			{
				$build['options'][$k] = $v;
			}
		}

		if (!empty($build['template']))
		{
			$template = $build['template'];
			if (in_array($template, $this->imgonlys) || $template == 'textonly')
			{
				$this->fullview = true;
			}
			if($template == 'textonly')
			{
				$this->noimage = 1;
				$this->textonly = 1;
			}
		}

		if (!empty($_REQUEST['prod'])) { 
			$prod = $_REQUEST['prod'];
			$product = $this->Product->find(" Product.code = '$prod' ");
			$build['Product'] = $product["Product"];
		}

		#$this->Session->write("Build", $this->build);
		# DONT SAVE!

		$prod = $build['Product']['code'];
		$imgtype = "";
		$imgid = "";

		if (!empty($build['GalleryImage']))
		{
			$imgtype = 'Gallery';
			$imgid = $build['GalleryImage']['catalog_number'];
		} else if (!empty($build['CustomImage'])) {
			$imgtype = 'Custom';
			$imgid = $build['CustomImage']['Image_ID'];
		}



		$this->_display_image($prod, $imgtype, $imgid, $scale, $build, false);
	}

	function blank($prod, $template = 'standard', $scale = '')
	{
		$build = array('template'=>$template);
		$imgtype = 'Static'; # static.
		$imgid = null;
		if(!empty($_REQUEST['template']))
		{
			$build['template'] = $_REQUEST['template'];
		}
		if(in_array($prod, array('B','BNT','BC','BB')) && !empty($build['template']) && in_array($build['template'], $this->imgonlys))
		{
			$build['CustomImage']['display_location'] = "../../images/Your-Image-Will-Appear-Here-B.png";
		} else if($prod == 'RL' && !empty($build['template']) && in_array($build['template'], $this->imgonlys)) {
			$build['CustomImage']['display_location'] = "../../images/Your-Image-Will-Appear-Here-RL.png";
		} else {
			$build['CustomImage']['display_location'] = "../../images/Your-Image-Will-Appear-Here.png";
		}
		$this->noimage = true; # NOPE!
		$this->no_pers = true;
		$this->no_quote = true;
		$this->no_crop = true;
		$this->default_text = true;
		$this->_display_image($prod, $imgtype, $imgid, $scale, $build, true);
	}

	function blank2($prod, $scale = '')
	{
		$build = array();
		$imgtype = 'Static'; # static.
		$imgid = null;
		if(!empty($_REQUEST['template']))
		{
			$build['template'] = $_REQUEST['template'];
		}

		$this->noimage = true;
		$this->no_pers = true;
		$this->no_quote = true;
		$this->no_crop = true;
		$this->_display_image($prod, null, null, $scale, $build, true);
	}

	function load_stamp_previews($force = false) # Wrapper around build_view that loads pics for all stamps for all products.
	{ # Call from cake shell script.
		set_time_limit(0); # Never abort.

		$stamps = $this->GalleryImage->find('all', array('conditions'=>array('available'=>'Yes'),'order'=>'catalog_number','recursive'=>-1));
		$products = $this->Product->find('all', array('conditions'=>array('is_stock_item'=>0,'available'=>'yes'),'recursive'=>-1));

		#header("Content-Type: text/plain");

		$this->build = array();

		$this->silent = true; // Don't output pics.

		# Loop through stamps
		foreach($products as $product)
		{
			$this->build['Product'] = $product['Product'];
			$code = $product['Product']['code'];

			echo "$code: \n";

			# Loop through products
			foreach($stamps as $stamp)
			{
				$this->build['GalleryImage'] = $stamp['GalleryImage'];
				$catnum = $stamp['GalleryImage']['catalog_number'];

				echo "\t$code-$catnum";
				# If file exists, skip if not forced.
				$url = "images/preview/$code/Gallery/$catnum.png";
				$filename = APP."/webroot/$url";

				if(file_exists($filename) && empty($force))
				{
					echo " - SKIP\n";
					continue;
				} else {
					$this->params['url']['url'] = $url;
					$this->_display_image($code, 'Gallery', $catnum, null, $this->build, $filename);
					echo " - OK\n";
				}
				flush();
			}
		}
		echo "DONE!";
		exit(0);
	}

	function build_view($scale = '')
	{
		if(!empty($_REQUEST['build_email_id'])) {
			# Set but dont save...
			$buildEmail = $this->BuildEmail->read(null, $_REQUEST['build_email_id']);
			$this->build = unserialize($buildEmail['BuildEmail']['build_data']);

		}
		# NEVER SAVE build to Session! we can still show an accurate preview
		# even without affecting future pages/calls.
		#
		if (!empty($_REQUEST['template'])) { 
			$this->template = $this->build['template'] = $_REQUEST['template']; 
		}
		if (!empty($_REQUEST['fullbleed'])) { 
			$this->build['options']['fullbleed'] = $_REQUEST['fullbleed'];
		}
		if (!empty($_REQUEST['transbg'])) { 
			$this->transbg = $_REQUEST['transbg'];
		}


		if (!empty($this->build['template']))
		{
			$template = $this->build['template'];
			if (in_array($template, $this->imgonlys) || $template == 'textonly')
			{
				$this->fullview = true;
			}
			if($template == 'textonly')
			{
				$this->textonly = true;
			}
		}


		if (!empty($_REQUEST['noimage']))
		{
			$this->noimage = true;
		}

		if (!empty($_REQUEST['prod'])) { 
			$prod = $_REQUEST['prod'];
			$product = $this->Product->find(" Product.code = '$prod' ");
			$this->build['Product'] = $product["Product"];
		}

		if(!empty($this->build['Product']['blank_product_type_id']))
		{
			#echo "BPTGID=".$this->build['Product']['blank_product_type_id'];
			# Borrow blank from something existing...
			$blank_product = $this->Product->read(null, $this->build['Product']['blank_product_type_id']);
			$this->build['Product'] = $blank_product['Product'];
		}

		$prod = $this->build['Product']['code'];
		$imgtype = "";
		$imgid = "";

		if (!empty($this->build['GalleryImage']))
		{
			$imgtype = 'Gallery';
			$imgid = $this->build['GalleryImage']['catalog_number'];
		} else if (!empty($this->build['CustomImage'])) {
			$imgtype = 'Custom';
			$imgid = $this->build['CustomImage']['Image_ID'];
		}

		if(!empty($_REQUEST['rotate']))
		{
			$this->build['rotate'] = $_REQUEST['rotate'];
		}

		# Reinstating no-fake-text if build step complete.
		# Don't show dummy text anymore (sept 19 2012) since default is no text.
		#if(empty($this->build['complete']['text']))
		#{
		#	$this->default_text = true;
		#}
		$this->no_pers = false; // better than null, allow for generic ghost

		$this->_display_image($prod, $imgtype, $imgid, $scale, $this->build, false);
	}


	function saved_view($saved_item_id, $scale = '')
	{
		$saved_item = $this->SavedItem->read(null, $saved_item_id);

		$build = unserialize($saved_item['SavedItem']['build_data']);

		$prod = $build['code'];

		$imgtype = null;
		$imgid = null;

		if(!empty($build['catalog_number']))
		{
			$imgtype = "Gallery";
			$imgid = $build['catalog_number'];
			$gallery_image = $this->GalleryImage->find("GalleryImage.catalog_number = '$imgid'");
			$build['GalleryImage'] = $gallery_image['GalleryImage'];
		}
		if(!empty($build['image_id']))
		{
			$imgtype = "Custom";
			$imgid = $build['image_id'];
			$custom_image = $this->CustomImage->find("Image_ID = '$imgid'");
			$build['CustomImage'] = $custom_image['CustomImage'];
		}

		if (!empty($build['template']) && in_array($build['template'],$this->imgonlys))
		{
			$this->fullview = true;
		}

		######
		$this->_display_image($prod, $imgtype, $imgid, $scale, $build, false);
	}

	function view_gallery($type, $name, $id, $scale = '')
	{
		list($path, $ext) = preg_split("/[.]/", $this->params['url']['url']);
		$scale = preg_replace("/[.]\w+$/", "", $scale); # Get rid of file extension, if any...
		$id = preg_replace("/[.]\w+$/", "", $id); # Get rid of file extension, if any...
		#$ext = 'png';
		if($ext == 'gif') { $this->transbg = true; }
		$filename = "/images/galleries/$type/$name/$id.$ext";
		$cache_filename = "/images/galleries/cached/$type/$name/$id/$scale.$ext";
		$abs_filename = APP."/webroot/$filename";
		$abs_cache_filename = APP."/webroot/$cache_filename";


		$this->canvas = $this->_gd_load_image($abs_filename);
		if ($scale)
		{
			$final_img = $this->_scale_image($scale, $this->transbg);
		} else {
			$final_img = $this->canvas;
		}

		$this->_output_image($final_img, $abs_cache_filename);
	}

	function view($prod = '', $imgtype = '', $imgid = '', $scale = '')
	{
		$this->default_text = true; // Default.
		# 
		$build = array();
		$template = null;
		if (preg_match("/^(.+)-(standard|imageonly|imageonly_nopersonalization|fullview|fullbleed)$/", $prod, $matches))# && $prod != 'ORN-CER')
		{
			$prod = $matches[1];
			$template = $matches[2];
			#error_log("TEMPLATE=$template");
			$this->no_default_pers = true;
			if($template == 'imageonly_nopersonalization')
			{
				#error_log("NOP TEP");
				$this->no_pers = true;
				$template = 'imageonly';
				$this->default_text = false;
			} else if ($template == 'imageonly') {
				#error_log("DEF TRUE, I/O");
				$this->default_text = true;
				$this->no_pers = false;
				$this->defaultColor = $this->textColor;
				# Make more visible via thumbs.
			} else {
				#error_log("DEF TRUE, ELSE");
				$this->default_text = true;
				$this->no_pers = false;
				$this->defaultColor = $this->textColor;
				# Make more visible via thumbs.
			}
			if ($template == 'fullbleed')
			{
				$build['options']['fullbleed'] = true;
				$template = 'imageonly';
			}
			$build['template'] = $template;
		}

		if(!empty($_REQUEST['fullbleed']))
		{
			$build['options']['fullbleed'] = true;
			$build['template'] = 'imageonly';
		}

		if(!empty($_REQUEST['rotate']))
		{
			$build['rotate'] = $_REQUEST['rotate'];
			# Crop doesn't get reasonable centered coordinates ( need to pass to get_crop_coords)
		}


		# Get correct master image! (base off template!)
		$this->_display_image($prod, $imgtype, $imgid, $scale, $build);
	}

	function _save_image($canvas, $file)
	{
			$dir = dirname($file);
			if (!file_exists($dir))
			{
				mkdir($dir, 0755, true);
			}

			$w = imagesx($canvas);
			$h = imagesy($canvas);
			
			$png_img = imagecreatetruecolor($w,$h);

			imagealphablending($png_img, false);
			$trans = imagecolorallocatealpha($png_img, 0,0,0,127);
			imagefill($png_img, 0,0,$trans);
			imagesavealpha($png_img, true);

			imagecopyresampled($png_img,$canvas, 0,0,0,0,$w,$h,$w,$h);
			$rc = imagepng($png_img, $file); #Save for cache, so dont need to reload every time...
			imagedestroy($canvas);
			return $rc;
	}

	function _load_product_image($generic, $product, $orient, $template = '', $build = array())
	{
		$prod = !empty($product['Product']) ? $product['Product']['code'] : $product['code'];
		$product_image_path = $this->get_product_image_path($prod, $orient, null, $template, !empty($_REQUEST['background']), $build); 
		$product_config_path = $this->get_product_config_path($prod, $orient, $this->fullview, $build);

		#error_log("PIP=$product_image_path");
		# This here, loading the transparent version messes up the rest of the image
		# (somehow affects color palette?)
		#

		#error_log("PIP=$product_image_path");
		# Need to cache stock text file....


		if ($generic) # Stock text, etc...
		{
			$build = array();
			$generic_product_image_path = $this->get_product_image_path($prod, $orient, $generic, $template, null, $build); 
			# We need to get a generic file...
			$build['template'] = $template;

			if (!file_exists($generic_product_image_path) || filemtime($generic_product_image_path) < filemtime($product_config_path))
			{
				$product_config = $this->get_product_config($prod, $orient, $this->fullview, $build);
				# Generate!
				#error_log("------------------ GENERATE GENERIC ---------------- ");
				$generic_canvas = $this->_gd_load_image($product_image_path);
				#if (!$this->fullview)
				#{
					$generic_build = $build;
					$generic_build['default_text'] = true;
					$generic_build['no_pers'] = false;
					#error_log("FBT3");
					$this->_fill_build_text($generic_canvas, $product, $product_config, $generic_build, true);
				#}
				$rc = $this->_save_image($generic_canvas, $generic_product_image_path);
				#error_log("------------------ DONE GENERATE GENERIC ---------------- ");
			}
			
			return $this->_gd_load_image($generic_product_image_path);
		} else {
			return $this->_gd_load_image($product_image_path);
		}
	}


	# TODO properly pass what is necessary....
	function print_text($template = '')
	{
		$build = $this->build; # Not sure if this is complete, if need
		# parts to update. ?? TODO XXX
		$this->default_text = empty($build['complete']['text']) || (!empty($build['step']) && $build['step'] == 'text') ;#false;

		if(!empty($build['options']['quoteNone']))
		{
			$this->no_quote = true;
			#error_log("NOQ!");
		}

		if(!empty($build['options']['backgroundColor']))
		{
			# This should be properly set via bg color change....
			if(isset($build['options']['personalizationColor']))
			{
				$this->textColor = ($build['options']['personalizationColor'] == 'white' ? 0xFFFFFF : 0x000000);
				#error_log("PERS_COLOR={$this->textColor}");
			} else { # Guess from bg.
				$hexColor = preg_replace("/^#/", "", $build['options']['backgroundColor']);

				$darkThreshold = 130;
				#error_log("HEX=$hexColor, BRIGHT=".$this->brightness($hexColor)." < $darkThreshold = white : black");
				$this->textColor = $this->brightness($hexColor) < $darkThreshold ? 0xFFFFFF : 0x0;
			}
		}

		$prod = $build['Product']['code'];
		if(in_array($prod, array('BC','BB'))) { $prod = 'B'; }
		if(in_array($prod, array('MG-USA'))) { $prod = 'MG'; }

		if(empty($template) && !empty($build['template']))
		{
			$template = $build['template'];
		}
		if(empty($template))
		{
			$template = 'standard';
			#error_log("STD222");
		}
		$build['template'] = $template;

		if(empty($build['CustomImage']) && empty($build['GalleryImage']))
		{
			# Show dummy pic.
			header("Content-Type: image/png");
			$img = imagecreatetruecolor(1,1);
			$white = imagecolorallocate($img, 255,255,255);
			imagefill($img, 0,0, $white);
			imagepng($img);
			exit(0);
		}

		# Image no-personalization?
		#error_log("PERNONE=".!empty($build['options']['personalizationNone']));
		$this->no_pers = !empty($build['options']['personalizationNone']);

		$img_path = !empty($build['GalleryImage']) ? 
			$build['GalleryImage']['image_location'] : 
			$build['CustomImage']['display_location'] ; 

		# Get orientation from file.
		$crop = !empty($build['crop'][$template]) ? $build['crop'][$template] : null;
		$orient = $this->get_image_orientation($img_path, null, $crop);
		#error_log("ORIENT-$orient".print_r($crop,true));

		$product_config = $this->get_product_config($prod, $orient, (in_array($template, $this->imgonlys)));
		$file = $product_config['file'];


		$canvasw = in_array($prod, array('PR','RL','PB')) ? 500 : 300;
		$scale = $canvasw / $product_config['file'][2];
		$canvash = $product_config['file'][3]*$scale;


		$scale = 1;

		$scaled_config = array();
		foreach($product_config as $k=>$coords)
		{
			$scaled_config[$k] = array(ceil($coords[0]*$scale),ceil($coords[1]*$scale),ceil($coords[2]*$scale),ceil($coords[3]*$scale));
		}
		# Clear offset for text.
		/*
		list ($x,$y) = $scaled_config['text'];
		$scaled_config['text'][0] = 0;
		$scaled_config['text'][1] = 0;
		# offset personalization.
		$scaled_config['personalization'][0] -= $x;
		$scaled_config['personalization'][1] -= $y;
		*/

		$dir = $this->get_product_image_dir($prod, $orient, (in_array($template, $this->imgonlys)));
		$product_image_path = "$dir/original/$prod.png";

		list($w,$h) = getimagesize($product_image_path);
		$scaledw = in_array($prod, array('PR','RL','PB')) ? 500 : 300;
		$scaledh = floor($scaledw * $h/$w);

		#$canvas = imagecreatefrompng($product_image_path);

		# Load text from own or quotation library.
		$canvas = imagecreatetruecolor($file[2],$file[3]);
		/*
		$canvas = imagecreatetruecolor(
			max($scaled_config['text'][2],
				$scaled_config['personalization'][0]+ $scaled_config['personalization'][2]),
			max($scaled_config['text'][3],
				$scaled_config['personalization'][1]+ $scaled_config['personalization'][3])
			);
		*/

		//imagefill($canvas, 0,0, imagecolorallocate($canvas, 255,255,255));
		# White fill.

		$transparent = imagecolorallocatealpha($canvas, 0,0,0,127);
		imagefill($canvas, 0,0, $transparent); # This fills entire area, even spots not pasted upon.
		imagecolortransparent($canvas, $transparent); # This designates what the transparent color IS.
		# GRAINY pic, put white bg behind!


		#imagealphablending( $canvas, false );
		#imagesavealpha( $canvas, true );
		# XXX ensure transparency!
		#
		# XXX TODO tell text to scale properly, remove offsets.
		$this->_fill_build_text($canvas, $build, $scaled_config, $build, true);

		#error_log("LAY={$build['template']}");

		# Scale down.
		$scaled_canvas = imagecreatetruecolor($scaledw,$scaledh);
		$transparent = imagecolorallocatealpha($scaled_canvas, 0,0,0,127);
		imagefill($scaled_canvas, 0,0, $transparent); # This fills entire area, even spots not pasted upon.
		imagecolortransparent($scaled_canvas, $transparent); # This designates what the transparent color IS.
		#$transparent = imagecolorallocatealpha($scaled_canvas, 0,0,0,127);
		#imagefill($scaled_canvas, 0,0, $transparent); # This fills entire area, even spots not pasted upon.
		#imagecolortransparent($scaled_canvas, $transparent); # This designates what the transparent color IS.

		imagecopyresampled($scaled_canvas, $canvas, 0,0,0,0, $scaledw,$scaledh,$w,$h);

		imagealphablending($scaled_canvas,false);
		imagesavealpha($scaled_canvas,true);

		# print out canvas.
		header("Content-Type: image/png");
		imagepng($scaled_canvas);
		#imagepng($canvas);
		exit(0);
		#return $this->_output_image($canvas,false);
	}

	function _display_image($prod = '', $imgtype = '', $imgid = '', $scale = '', $build = array(), $cache = true)
	{
		# Get image orientation, if applicable.
		# Get product folder, appropriate for orientation needed
		# load product config file
		# load product image
		#  load image 
		# past image on top of product.
		# print modified image.


		$prod = preg_replace("/[.]\w+$/", "", $prod); # Get rid of file extension, if any...
		$imgtype = preg_replace("/[.]\w+$/", "", $imgtype); # Get rid of file extension, if any...
		$imgid = preg_replace("/[.]\w+$/", "", $imgid); # Get rid of file extension, if any...

		$imgid = preg_replace("/^_/", "", $imgid); # Get rid of initial underscore, since rewritecond caching wont match if there's a filename the same as the dir.

		$scale = preg_replace("/[.]\w+$/", "", $scale); # Get rid of file extension, if any...

		$filename = $this->params['url']['url'];
		$filename_parts = split("[.]", $filename);

		$ext = $filename_parts[count($filename_parts)-1];

		$orig_prod = $prod;

		if ($ext == 'gif') { $this->gif = true; } # else, png

		#if ($prod == 'BC') { $prod = 'B'; }
		if ($prod == 'PSF') { $prod = 'PS'; $build['options']['poster_frame'] = 'yes'; }
		#if ($prod == 'BNT') { $prod = 'B'; }



		$urlparts = array("images", "preview");
		if ($prod) { $urlparts[] = $prod; }
		if ($imgtype) { $urlparts[] = $imgtype; }
		if ($imgid) { $urlparts[] = $imgid; }
		if ($scale) { $urlparts[] = $scale; }

		if (preg_match("/(horizontal|vertical)-(.*)$/", $imgtype, $matches))
		{
			$imgtype = $matches[1];
			$template = $matches[2];
			$build['template'] = $matches[2];
		}


		$template = !empty($_REQUEST['template']) ? $_REQUEST['template'] : null;
		
		#error_log("TEMPLATE=$template");

		if($template == 'imageonly_nopersonalization') 
		{
			#error_log("NOPERS");
			$this->no_pers = true;
			$template = 'imageonly';
			# DOn't show personalization

		}

		if (!$template) { $template = (!empty($build['template']) && $build['template'] != 'standard') ? $build['template'] : 'standard'; }


		$ext = "png";
		#$cache_file = APP."/webroot/".$_SERVER['REQUEST_URI']; # Whatever uri we asked for... #join("/", $urlparts).".$ext";
		$url = !empty($_SERVER['REQUEST_URI']) ? preg_replace("/\?.*/", "", $_SERVER['REQUEST_URI']) : null; # Remove query string from filename.
		$cache_file = is_string($cache) ? $cache : APP."/webroot/".$url;
		# Can give file also.

		if(!empty($_SERVER['PATH_INFO']))
		{
			$cache_file .= $_SERVER['PATH_INFO'];
		}

		#error_log("CACHING=$cache_file"); # Should go off of REQUEST_URI, etc...
		#error_log("REQURI={$_SERVER['REQUEST_URI']}");


 
		$product = $this->Product->find(" code = '$prod' ");

		$build['Product'] = $product['Product'];

		$image_path = "";

		$is_custom = ($imgtype == 'Custom');
		#error_log("IT=$imgtype, $imgid");

		if($imgtype == 'Static')
		{
			$is_custom = true;
			$thumb_image_path = $build['CustomImage']['display_location'];
			$image_path = $build['CustomImage']['display_location'];
		}
		else if($imgtype == 'Custom')
		{
			$real_imgid = preg_replace("/^_/", "", $imgid);
			$image = $this->CustomImage->read(null, $real_imgid);
			#if (!empty($image['CustomImage']['Image_Location']))
			# Using display_location now so it's in a readable format, might be psd, etc in other field.
			if (!empty($image['CustomImage']['display_location']))
			{
				#$image_path = APP ."/webroot/".$image['CustomImage']['Image_Location'];
				$image_path = APP ."/webroot/".$image['CustomImage']['display_location'];
				$thumb_image_path = APP ."/webroot/".$image['CustomImage']['thumbnail_location'];
			}
			$build['CustomImage'] = $image['CustomImage'];
			# Custom image.
		} else if ($imgtype == 'Gallery') { # Catalog image...
			$real_imgid = preg_replace("/^_/", "", $imgid);
			$image = $this->GalleryImage->find(" GalleryImage.catalog_number = '$real_imgid' ");
			if (!empty($image['GalleryImage']['image_location']))
			{
				$image_path = APP ."/../".$image['GalleryImage']['image_location'];
				$thumb_image_path = APP ."/../".$image['GalleryImage']['image_location'];
			}
			$build['GalleryImage'] = $image['GalleryImage'];
		}
		#error_log("TIP=$thumb_image_path");
		if(empty($this->noimage) && empty($build['options']['customized']) && $template != 'textonly' && (empty($thumb_image_path) || !file_exists($thumb_image_path))) { # Just show generic image.
			#if(!empty($product['Product']['parent_product_type_id']))
			#{
			#	$parent = $this->Product->read(null, $product['Product']['parent_product_type_id']);
			#	$prod = $parent['Product']['code'];
			#}
			# XXX HERE
			#error_log("P=$prod");
			if($prod == 'TA' && !empty($build['options']['tasselID'])) {
				return $this->tassel($build['options']['tasselID']);
			} else if($prod == 'CH' && !empty($build['options']['charmID'])) {
				return $this->charm($build['options']['charmID']);
			} else {
				#error_log("CANNOT FIND $prod thumb");
				$this->redirect("/images/products/thumbnail/$prod.png");
			}
		}


		################################################################
		# We may get the literal image on the product...
		#
		if($this->picture_only)
		{
			$this->canvas = $this->_gd_load_image(APP."/webroot/".$build['CustomImage']['Image_Location']);
			$final_img = $this->_scale_image($scale);
			#error_log("CACHE_FILE=$cache_file");
			$this->_output_image($final_img);
		}

		################################################################
		

		$crop = !empty($build['crop'][$template]) ? $build['crop'][$template] : null;

		$this->orient = $orient = ($template != 'textonly' && empty($build['options']['customized'])) ? $this->get_image_orientation($thumb_image_path, null, $crop) : null;
		# STILL need to use image to figure proper orient, in case layering below image.
		#

		# Base product orientation off of ORIGINAL image's orientation, not rotated one...

		# Now get appropriate image.....
		$product = $this->Product->findByCode($prod);
		if(!empty($product['Product']['blank_product_type_id']))
		{
			#echo "BPTGID=".$this->build['Product']['blank_product_type_id'];
			# Borrow blank from something existing...
			$product = $this->Product->read(null, $product['Product']['blank_product_type_id']);
			$build['Product'] = $product['Product'];
			$prod = $build['Product']['code'];
		}

		
		$product_image_path = $this->get_product_image_path($prod, $orient, null, $template, null, $build); # Need to pass info about custom image, orientation etc.
		$overlay_path = null;

		if(!empty($_REQUEST['background'])) { $this->transbg = true; }

		if (empty($this->transbg))
		{
			$overlay_path = dirname($product_image_path)."/$prod-overlay.png";
			if (!is_file($overlay_path))
			{
				$overlay_path = dirname($product_image_path)."/$prod-overlay.gif";
			}
		}

		if(!empty($build['Product']['is_stock_item']) && !empty($build['Product']['customizable']))
		{
			$this->noimage = 1; # any picture gets loaded in personalization.
		}

		# Add generic text if cached, can do personalization, not image only
		$quoteID = !empty($build['options']['quoteID']) ? $build['options']['quoteID'] : null;
		$quote = !empty($build['options']['customQuote']) ? $build['options']['customQuote'] : null;


		$this->no_quote = ($quoteID == -1) || (empty($quote) && !empty($build['complete']['quote'])) || ($this->fullview && !$this->textonly);

		#error_log("NQ={$this->no_quote}, Q=$quote, QID=$quoteID, FV={$this->fullview}");

		$product_config = $this->get_product_config($prod, $orient, $this->fullview, $build);

		$personalization = !empty($build["options"]["personalizationInput"]) ? $build['options']['personalizationInput'] : '';

		#error_log("PERS=$personalization");

		$dont_want_pers = !empty($build['options']['personalizationNone']) || (empty($personalization) && !empty($build['complete']['personalization']));
		$this->double_sided = (in_array($template, $this->imgonlys) && (!empty($product_config['image.nopersonalization.2']) || !empty($product_config['image.2'])));
		# Either they say they dont want, or they've completed the step and it's blank.
		#$this->no_pers = ($cant_do_personalization || $dont_want_pers) && (!$double_sided || empty($personalization));

		$options = Set::extract($this->load_product_options($build['Product']['code'], false, $build), '{n}.Part.part_code');
		$cant_do_personalization = !(in_array('personalization', $options) && !empty($product_config['personalization']));

		#error_log("C=$cache, FV={$this->fullview}"); # generic should omit personalization.
		####$this->no_pers = ($cant_do_personalization || $dont_want_pers || ($this->fullview && empty($personalization)) || ($this->double_sided && empty($personalization)));

		######################$this->no_pers = ($cant_do_personalization || $dont_want_pers || ($this->fullview && empty($personalization)) || ($this->double_sided && empty($personalization)));
		# Allow for larger img if imageonly.
		####$this->no_pers = ($template == 'imageonly_nopersonalization'); # Already done earlier...

		#error_log("NO_PERS={$this->no_pers}, DONT=$dont_want_pers, (FV={$this->fullview} && emppers=$personalization) || (dbl={$this->double_sided} && emptper=$personalization");
		if(!empty($cache) && $template == 'imageonly_nopersonalization') { error_log("CACHE INOP"); $this->no_pers = true; $this->default_text = false; }

		# Show (generic) personalization if complete step not done.
		if($this->no_pers === null && (!empty($build['options']['personalizationNone']) || (isset($build['options']['personalizationInput']) && empty($build['options']['personalizationInput']))))# || !empty($build['complete']['text']))
		{
			$this->no_pers = true;
		}
		# XXX alter default_text for generic pic????

		# TOMAS this above may disable pers. If done with text step
		#error_log("NOP={$this->no_pers}");

		#$src = imagecreatetruecolor(80, 40);
		$this->canvas = $this->_load_product_image($cache, $product, $orient, $template, $build);
		$proof_w = $proof_x = imagesx($this->canvas);
		$proof_h = $proof_y = imagesy($this->canvas);
		$proof_w2h = $proof_w/$proof_h;

		if(!empty($build['options']['fullbleed']) && !empty($build['GalleryImage']))
		{
			unset($build['options']['fullbleed']);
		}

		# Get coordinates of where image should go....
		$product_config = $this->get_product_config($prod, $orient, $this->fullview, $build);
		#error_log("PRODUCT_CONFIG VIA $prod, $orient, FV={$this->fullview}=".print_r($product_config,true));

		if (!$this->noimage && $template != 'textonly')
		{
			$topalign = in_array($prod, array('B','BC','BNT'));
			if($topalign && $this->fullview && empty($build['options']['fullbleed']))
			{
				$topalign = 'topoffset'; # Only offset on fit/image-only
			}
			#error_log("LOADING IMAGE=$image_path");
			$this->_load_image($image_path, $is_custom, $product_config, $cache, $build, $topalign);


		}


		# XXX fit another copy of image on, with background cropped out.
		# TODO
		$trans_bg_img_path = $this->get_product_image_path($prod, $orient, false, null, true, $build); # Need to pass info about custom image, orientation etc.
		#error_log("TRANS_BG_IMG_PATH=$trans_bg_img_path");
		if (file_exists($trans_bg_img_path))
		{
			$this->_insert_graphic($trans_bg_img_path, array(0,0,$proof_w,$proof_h));
		}



		# Rotating image for bookmark?
		# Maybe if proper orientation image isn't available, we should rotate WHOLE canvas (config would be adjusted, tho)
		# maybe just rotate image and then in the end rotate product so image looks upright, etc.


		# This here isn't working for cart_view STD

		#error_log("FBT=$cache, $template");
		#if ($cache && (empty($_REQUEST['background']) || $template == 'imageonly')) { 
		if (empty($_REQUEST['background'])) { 
			#error_log("FBT2");
			$this->_fill_build_text($this->canvas, $product, $product_config, $build); 
		}
		# Let them put in personalization if full bleed.

		# Personalization on image only okay.

		if ($prod == 'B' || $prod == 'BC') # NOT BNT THO!
		{
			if ($cache && !empty($build['options']['tasselID']) && $build['options']['tasselID'] != -1)
			{
				$build['options']['tasselID'] = 41; # Black default.
			}

			if (!isset($build['options']['tasselID']) || (!empty($build['options']['tasselID']) && $build['options']['tasselID'] != -1)) # Not none.
			{
				$this->_fill_build_tassel($this->canvas, $product, $product_config, $build);
			}

		}
		# REDO SO CHECKS PROD FOR FIELDS IN CONFIG...
		#$this->_out($this->canvas);

		#$final_img = $this->_scale_image($scale, $this->transbg);
		#$this->_output_image($final_img, $cache ? $cache_file : null);
		#exit(0);


		if (!$cache && (!empty($build['options']['charmID']) && $build['options']['charmID'] > 0) && (!isset($build['options']['tasselID']) || $build['options']['tasselID'] != -1)) { 
			if ($prod != 'BNT' && ($prod == 'B' || $prod == 'BC' || !(in_array($template, $this->imgonlys) || $prod == 'ORN')))
			{
				$this->_fill_build_charm($this->canvas, $product, $product_config, $build); 
			}
		}


		#if ($cache)# || !isset($build['options']['charmID']) ) # Put in generic charm...
		if ($prod == 'B' || $prod == 'BC' || $prod == 'ORN') # NOT BNT THO!
		{
			$default_charms = array(
				#'PW'=>157, # shooting star
				'B'=>17, # Book
				'BC'=>17, # Book
				'ORN'=>17
			);
			if($cache && !empty($default_charms[$prod]))
			{
				$build['options']['charmID'] = $default_charms[$prod];
				#if ($prod == 'B' || $template != 'imageonly' || $prod == 'ORN')
				# Don't show charm on cached bookmark w/tassel (just w/tass+charm)
				if ($orig_prod == 'BC' || ($prod == 'PW' && !in_array($template, $this->imgonlys) || $prod == 'ORN'))
				{
					$this->_fill_build_charm($this->canvas, $product, $product_config, $build);
				}
			}
		}


		$fullview = $imageonly = $this->fullview;
		$fullbleed = !empty($build['options']['fullbleed']) || $template == 'fullbleed';
		if($template == 'textonly') { $imageonly = false; }

		#if (!$fullview && ((!$cache && !empty($build['options']['borderID'])) || $prod == 'B' || $prod == 'BC')) { $this->_fill_build_border($this->canvas, $product, $product_config, $build); }
		if (!$cache && !empty($build['options']['borderID']))  { $this->_fill_build_border($this->canvas, $product, $product_config, $build); }
		# ALLOW border on image only, but have none by default.
		# DEFAULT
		if (!$imageonly && ($prod == 'B' || $prod == 'BNT' || $prod == 'BC' || $prod == 'BB') && empty($build['options']['borderID'])) { $this->_fill_build_border($this->canvas, $product, $product_config, $build); }
		# Don't do a default border if imageonly

		if (!empty($build['options']['ribbonID']) || $prod == 'ORN' || $prod == 'ORN-CER') { $this->_fill_build_ribbon($this->canvas, $product, $product_config, $build); }
		if ($prod == 'ORN') { $this->_fill_build_charm($this->canvas, $product, $product_config, $build); }

		if (!$cache && $prod == 'TB') 
		{
			$this->_fill_build_handles($this->canvas, $product, $product_config, $build);
		}

		if (!$cache && $prod == 'FS') 
		{
			$this->_fill_build_frame($this->canvas, $product, $product_config, $build);
		}


		if ((($prod == 'PS' && !empty($build['options']['poster_frame']) && strtolower($build['options']['poster_frame']) == 'yes') || $prod == 'PSF')) 
		{
			$this->_fill_build_poster_frame($this->canvas, $product, $product_config, $build);
		}

		if(!in_array($prod, array('DPW','DPW-FLC')))
		{
			$this->_load_overlay($overlay_path);
		}


		if (!empty($_REQUEST['watermark']))
		{
			$watermark_path = APP."/../images/watermark.png";
			$this->_load_overlay($watermark_path, true);
		}

		#if(!empty($build['rotate'])) 
		#{
		#	$this->canvas = imagerotate($this->canvas, 360-$build['rotate'], 0xFFFFFF);
		#}


		$final_img = $this->_scale_image($scale, $this->transbg);
		#error_log("CACHE_FILE=$cache_file");
		$this->_output_image($final_img, $cache ? $cache_file : null);
	}

	function paste_trans_png($src, $dest, $src_x, $src_y, $dest_x, $dest_y)
	{
	}

	function _fill_build_handles($canvas, $product, $product_config, $build = array())
	{
		$handle = !empty($build['options']['handles']) ? strtolower($build['options']['handles']) : 'black'; # default

		$handles_path = APP ."/../images/products/blanks/handles/$handle.gif";

		if (empty($product_config['handles'])) { return; }

		$coords = $product_config['handles'];

		$this->_insert_graphic($handles_path, $coords);
	}

	function _fill_build_frame($canvas, $product, $product_config, $build = array())
	{
		$frameID = !empty($build['options']['frameID']) ? $build['options']['frameID'] : 2; # 
		$frame = $this->Frame->read(null, $frameID);

		if (empty($product_config['frame'])) { return; }

		$coords = $product_config['frame'];

		$frame_name = basename($frame['Frame']['name']);

		$orient = $this->orient;

		$frame_path = APP ."/../images/products/blanks/frames/$orient/$frame_name.gif";

		if (!file_exists($frame_path)) { return; } # Skip default, no need for file.



		$this->_insert_graphic($frame_path, $coords);
	}

	function _fill_build_poster_frame($canvas, $product, $product_config, $build = array())
	{
		if (empty($product_config['poster_frame'])) { return; }

		$coords = $product_config['poster_frame'];

		$orient = $this->orient;
		$fullview = $this->fullview ? "-fullview" : "";

		$frame_path = APP ."/../images/products/blanks/PS/frame/$orient$fullview/frame.gif";
		if (!file_exists($frame_path))
		{
			$frame_path = APP ."/../images/products/blanks/PS/frame/$orient/frame.gif";
		}


		if (!file_exists($frame_path)) { return; } # Skip default, no need for file.

		$this->_insert_graphic($frame_path, $coords);
	}


	function _fill_build_border($canvas, $product, $product_config, $build = array())
	{
		$borderID = !empty($build['options']['borderID']) ? $build['options']['borderID'] : 2; # double line defualt.
		if($borderID <= 0)
		{
			return; # ie none.
		}
		$border = $this->Border->read(null, $borderID);

		$border_name = basename($border['Border']['location']);

		$border_path = APP ."/../borders/blanks/$border_name";


		foreach($product_config as $key => $coords)
		{
			if (preg_match("/^border/", $key) && file_exists($border_path))
			{
				$this->_insert_graphic($border_path, array($coords[0],$coords[1],$coords[2],$coords[3]));
				#imagerectangle($this->canvas, $coords[0],$coords[1],$coords[2]+$coords[0],$coords[3]+$coords[1],0xFF0000);
			}
		}
	}

	function _fill_build_tassel($canvas, $product, $product_config, $build = array())
	{
		$tasselID = !empty($build['options']['tasselID']) ? $build['options']['tasselID'] : 41; # black defualt.
		$tassel = $this->Tassel->read(null, $tasselID);

		if($tasselID <= 0) { return; }


		$tassel_name = preg_replace("/ /", "-", $tassel['Tassel']['color_name']);

		$tassel_path = APP ."/../tassels/blanks/$tassel_name.gif";


		$img_w = imagesx($this->canvas); 
		$img_h = imagesy($this->canvas); 

		$this->_insert_graphic($tassel_path, array(0,0, $img_w, $img_h));


	}

	function _fill_build_ribbon($canvas, $product, $product_config, $build = array())
	{
		if (empty($product_config['ribbon'])) { return; }
		$ribbonID = !empty($build['options']['ribbonID']) ? $build['options']['ribbonID'] : 16; # red defualt.
		#$this->build['options']['ribbonID'] = $ribbonID;
		#$this->Session->write("Build", $this->build);
		$ribbon = $this->Ribbon->read(null, $ribbonID);


		$ribbon_name = preg_replace("/ /", "-", $ribbon['Ribbon']['color_name']);

		$ribbon_path = "";

		if ($product['Product']['code'] == 'ORN-CER')
		{
			$ribbon_path = APP ."/../ribbons/blanks/ORN-CER/$ribbon_name.gif";
		} else if ($product['Product']['code'] == 'ORN') {
			$ribbon_path = APP ."/../ribbons/blanks/ORN/$ribbon_name.gif";
		}

		$coords = $product_config['ribbon'];

		$img_w = imagesx($this->canvas); 
		$img_h = imagesy($this->canvas); 

		$this->_insert_graphic($ribbon_path, $coords, null, null, true);
	}

	function _fill_build_charm($canvas, $product, $product_config, $build = array())
	{
		#error_log("FILL_BUILD_CHARM, PC=".print_r($product_config['text'],true).print_r($product_config['charm'],true));
		$charmID = !empty($build['options']['charmID']) ? $build['options']['charmID'] : null;
		if ($product['Product']['code'] == 'ORN' && !$charmID) { $charmID = 161; } # snowflake Default.

		if($charmID == -1) { return; }

		$charm_pos = !empty($product_config['charm']) ? $product_config['charm'] : null;
		if (!$charm_pos) { return; }
		list($charm_x, $charm_y, $charm_w, $charm_h) = $charm_pos;
		#
		#
		$charm = $this->Charm->read(null, $charmID);

		$charm_path = $charm['Charm']['graphic_location'];
		$charm_name = basename($charm_path);
		list($charm_prefix,$charm_ext) = preg_split("/[.]/", $charm_name);

		# XXX TODO place black background (pw)

		# XXX TODO bookmark should have odd-shaped charms positioned at a certain spot/orientation

		# load image from location and scale it down to fit in location
		# (same code as image load....
		$prod = $product['Product']['code'];

		#if ($prod == 'B' || $prod == 'BC')
		if ($prod != 'PW') # Everything else uses a loop.
		{
			$charm_location = APP."/../charms/blanks-B/$charm_prefix.gif";
			$this->_insert_graphic($charm_location, array($charm_x, $charm_y, $charm_w, $charm_h), 'none');
			#imagerectangle($this->canvas, $charm_x, $charm_y, $charm_x+$charm_w, $charm_y+$charm_h, 0xFF);
		} else {
			$charm_location = APP."/../charms/blanks/$charm_prefix.gif";
			$this->_insert_graphic($charm_location, array($charm_x, $charm_y, $charm_w, $charm_h), 'frame');
			#$this->add_border($charm_x,$charm_y,$charm_w,$charm_h, array(0,0xFF,0));
		}
	}

	function _insert_graphic($image_path, $box, $border_style = null, $image_crop = array(), $clip = false, $main_img = false, $topalign = false, $rotate = 0)
	# Scales down... or clips
	{
		list ($box_x,$box_y,$box_w,$box_h) = $box;
		#error_log("INSERT $image_path, BOX=($box_x,$box_y,$box_w,$box_h), ICROP=".print_r($image_crop,true).", CLIP+$clip, MAIN=$main_img");

			#error_log("IMAGE=$image_path");

		$prod = !empty($this->build['Product']) ? $this->build['Product']['code'] : null; 

		if ($image_path && file_exists($image_path))
		{
			#error_log("IMAGE_EXISTS=$image_path");
			# Load size of image.

			# place black background of 10 pixels etc more.
			# Adjust size and coordinate for image....




			# place image above....
			$image_crop_list = !empty($image_crop['w']) ? array($image_crop['x'], $image_crop['y'], $image_crop['w'], $image_crop['h']) : $image_crop;
			# Might be x,y,w,h OR 0,1,2,3

			#error_log("ICROP ($image_path)=".print_r($image_crop_list,true));

			/*if($main_img)
			{
			#$image_crop_list[3] += 90;
			$image_crop_list[1] += 200;
			$image_crop_list[3] += 200;
			}
			*/

			if(!empty($image_crop_list[0]))
			{
				#$image_crop_list = array(0,-200,400,300);
			}


			# What stretches this is the CROP! (bogus crop coords)

			# We need to figure out how small we're scaling the image since coordinates are relative to FULL image...
			$cropx = !empty($image_crop_list[0]) ? $image_crop_list[0] : null;
			$cropy = !empty($image_crop_list[1]) ? $image_crop_list[1] : null;
			$cropw = !empty($image_crop_list[2]) ? $image_crop_list[2] : null;
			$croph = !empty($image_crop_list[3]) ? $image_crop_list[3] : null;

			# Allow for offset of image lower/higher/etc.
			# These coordinates need to be adjusted, as 0,0 means top left; we REALLY 

			$img = $this->_gd_load_image($image_path, $image_crop_list, $rotate); 
			$img_w = imagesx($img);
			$img_h = imagesy($img);

			#imagecopyresampled($this->canvas,$img,0,0,0,0,$img_w,$img_h,$img_w,$img_h);
			#return;
			# WORKS HERE.
			# but below is broken.

			# Second half (later) needs to 
			# Shrink LATER since we need to shrink relative to canvas size...

			$is_gif = preg_match("/[.]gif$/", $image_path);
			$is_png = preg_match("/[.]png$/", $image_path);


			#if(empty($this->img)) { $this->img = $img; 
			
				#header("Content-Type: image/png");
				#imagepng($img);
				#exit(0);
				#$this->_output_image($img);
				# _OI($i) works since it does png magic, but what happens between here and there?
			#}


			if ($img)
			{
				list ($img_w, $img_h) = $this->_gd_getimagesize($img);
				$img_w2h = $img_w/$img_h;


				if ($clip === 'stretch')
				{
					# Try image by fitting height. If width too long, fit by width.
					$new_img_h = $box_h;
					$new_img_w = ceil($new_img_h * $img_w2h);
					$new_img_h2w = $new_img_h / $new_img_w;
		
					if ($new_img_w < $box_w) # Stretch so we have no whitespace left!
					{
						$new_img_w = $box_w;
						$new_img_h = ceil($new_img_w / $img_w2h);
					}

					$scaled_img_w = $new_img_w;
					$scaled_img_h = $new_img_h;
					$scaled_w2h = $scaled_img_w / $scaled_img_h;

					$scaled_img_x = 0;
					$scaled_img_y = 0;

					# Center.
					#$scaled_img_x = ($scaled_img_w-$box_w)/2;
					#$scaled_img_y = ($scaled_img_h-$box_h)/2;


					$scaled_img = $this->_gd_scale_image($img, $scaled_img_w, $scaled_img_h, empty($main_img));
					$image_scale = $new_img_w/$img_w;
					# offsets should be absolute...
					if(!empty($image_crop_list))
					{
						if($cropx <= 0) { $offset_x = -$cropx*$image_scale; }
						if($cropy <= 0) { $offset_y = -$cropy*$image_scale; }
					}


					if ($box_w < $scaled_img_w) { $scaled_img_w = $box_w; }
					if ($box_h < $scaled_img_h) { $scaled_img_h = $box_h; }


					# If we match by height, and width is too far, then clip at box_w (scaled_img_w = $box_w)
	
					#imagecopy($this->canvas, $scaled_img, $box_x, $box_y, $scaled_img_x, $scaled_img_y, $box_w, $box_h);
					imagecopyresampled($this->canvas, $scaled_img, $box_x, $box_y, $scaled_img_x, $scaled_img_y, $box_w, $box_h, $scaled_img_w, $scaled_img_h);
					# dst, src, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
				} 
				else if ($clip)
				{
					#imagecopy($this->canvas, $img, $box_x, $box_y, 0, 0, $box_w, $box_h);
					# Using box_w,box_h will clip this...

					$new_img_h = $box_h;
					$new_img_w = ceil($new_img_h * $img_w2h);
					$new_img_h2w = $new_img_h / $new_img_w;
		
					if ($new_img_w > $box_w) # Fit whole image.
					{
						$new_img_w = $box_w;
						$new_img_h = ceil($new_img_w / $img_w2h);
					}

					$scaled_img_w = $new_img_w;
					$scaled_img_h = $new_img_h;
					$scaled_w2h = $scaled_img_w / $scaled_img_h;

					$scaled_img = $this->_gd_scale_image($img, $scaled_img_w, $scaled_img_h, empty($main_img));

					$image_scale = $new_img_w/$img_w;
					# offsets should be absolute...
					if(!empty($image_crop_list))
					{
						if($cropx <= 0) { $offset_x = -$cropx*$image_scale; }
						if($cropy <= 0) { $offset_y = -$cropy*$image_scale; }
					}

					if ($box_w > $scaled_img_w) { $box_w = $scaled_img_w; }
					if ($box_h > $scaled_img_h) { $box_h = $scaled_img_h; }

					# If we match by height, and width is too far, then clip at box_w (scaled_img_w = $box_w)

					#imagecopy($this->canvas, $scaled_img, $box_x, $box_y, 0, 0, $box_w, $box_h);
					imagecopyresampled($this->canvas, $scaled_img, $box_x, $box_y, 0, 0, $box_w, $box_h, $scaled_img_w, $scaled_img_h);
					# dst, src, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h


				} else { # Default scale.
	
					# Try image by fitting height. If width too long, fit by width.
					$new_img_h = $box_h;
					$new_img_w = ceil($new_img_h * $img_w2h);
					$new_img_h2w = $new_img_h / $new_img_w;

					$imagescale = 1;
					if($cropw > $img_w || $croph > $img_h) # Wanting to zoom out / shrink.
					{
						$imagescale = $img_w/$cropw;
						$new_img_w = intval($imagescale*$box_w);
						$new_img_h = intval($new_img_w / $img_w2h);
						#error_log("HERE IS BAD... $imagescale = $img_w/$cropw ; $imagescale * $box_w = new_img_w = $new_img_w, NEW_IMG_H (wrong) = $new_img_w / $img_w2h = $new_img_h");
					}
		
					if ($new_img_w > $box_w)
					{
						$new_img_w = $box_w;
						$new_img_h = ceil($new_img_w / $img_w2h);
					}

					$border_w = 0;
					if ($border_style == 'frame')
					{
						$border_w = ceil($box_w*.02); # Adjust according to stuff....
					}
	
		
					# Got an appropraite image size.... Now scale the image.
		
					$scaled_img_w = $new_img_w-$border_w*2; 
					$scaled_img_h = $new_img_h-$border_w*2;

					$align_factor = in_array($prod, array('B','BNT','BB','BC')) ? 3/4 : 2/2; # ratio of top padding to bottom padding.
		
					$offset_x = ($box_w - $new_img_w) / 2;
					$offset_y = ($box_h - $new_img_h) / 2;
					if(!empty($topalign))
					{
						if($topalign === 'topoffset')
						{
							$offset_y = ($box_h - $new_img_h) / (2/$align_factor);
						} else { # Fully at top.
							$offset_y = 0;
						}
					}

					$image_scale = $new_img_w/$img_w;
					# offsets should be absolute...
					if(!empty($image_crop_list))
					{
						if($cropx <= 0) { $offset_x = ceil(-$cropx*$image_scale); }
						if($cropy <= 0) { $offset_y = ceil(-$cropy*$image_scale); }
					}
		
					# Place background there.... 
					$color = 0x060606;
	
					$bx1 = $box_x+$offset_x;
					$by1 = $box_y+$offset_y; 
					$bx2 = $bx1 + $new_img_w;
					$by2 = $by1 + $new_img_h;
	
	
					if ($border_style == 'frame')
					{
						imagefilledrectangle($this->canvas, $bx1, $by1, $bx2, $by2, $color);
					}
					else if ($border_style == 'fill') 
					{
						imagefilledrectangle($this->canvas, $box_x, $box_y, $box_x+$box_w, $box_y+$box_h, $color);
					}

					#$this->_output_image($img);
					# broken in there!
					#imagecopy($this->canvas, $img, 0,0, 0,0, $img_w, $img_h);
					#imagecopyresampled($this->canvas, $img, 0,0, 0,0, $img_w, $img_h, $img_w, $img_h);
					#return; 
					# This above is fine, but below is broken.

	
					$scaled_img = $this->_gd_scale_image($img, $scaled_img_w, $scaled_img_h, empty($main_img));
					#imagecopyresampled($this->canvas, $scaled_img, 0,0, 0,0, $img_w, $img_h, $img_w, $img_h);
					#return;
					# WORKS HERE...
					# but broken below.

					# SOMETHING HERE BREAKS transparency.
					# Place user's img there....
					$scaled_img_x = $bx1 + $border_w;
					$scaled_img_y = $by1 + $border_w;

					#TOMAS_MALY
					#$this->_output_image($scaled_img);
	
					#if($png)
					#{
					#if(false && empty($this->foo))
					#{
					if($main_img)
					{
						#$this->foo = true;
					}
					#}

					# scaled_img_h is wrong.... off by 8 pixels (LOT)

					#imagecopy($this->canvas, $scaled_img, $scaled_img_x, $scaled_img_y, 0, 0, $scaled_img_w, $scaled_img_h);
					# imagecopy() plays nicer than imagecopyresampled() with transparent gifs (trans layer)
					imagecopyresampled($this->canvas, $scaled_img, $scaled_img_x, $scaled_img_y, 0, 0, $scaled_img_w, $scaled_img_h, $scaled_img_w, $scaled_img_h);
					# SCALING the thing messes up transparency...
					# imagecopyresampled is making things blank underneath.
				}
			}
		}
	}

	function _load_image($image_path, $is_custom, $product_config, $cache = false, $build = array(), $top = false)
	{
		$template = !empty($build['template']) ? $build['template'] : null;

		$rotate = ($is_custom && !empty($build['rotate'])) ? $build['rotate'] : null;


		list($prod) = preg_split("/[.]/", basename($image_path));

		$proof_image_x = $proof_image_y = $proof_image_w = $proof_image_h = 0;

		# If we have no personalization and the image can stretch, let it.
		# Only do overlap when fullbleed. But stretch image when no personalization otherwise.
		#
		# dont stretch image if personalization and not fullbleed.)
		$box = 'image';

		$pn = !empty($build['options']['personalizationNone']);

		$layout_crop = null;
		if($is_custom && empty($this->no_crop))
		{
			$layout_crop = $this->get_build_crop_coords($template, $product_config, $build, $cache, $this->no_pers);

			#error_log("LAYOUT CROP ($template) = ".print_r($layout_crop,true));
			# Fix crop coordinates by +5 w,h since may be off from small crop surface.
			#if(!empty($layout_crop['w'])) { $layout_crop['w'] -= 5; $layout_crop['h'] -= 5; }
			#else if(count($layout_crop) >= 4) {  $layout_crop[2] -= 5; $layout_crop[3] -= 5; }

			# XXX
			# if we see a white lien at the bottom of the products, we likely have an outdated (smaller?) generic.png from coordinates - though we should auto regenerate from now on.

		}

		#error_log("PREVIEW_LAYOUT_CROP=".print_r($layout_crop,true));

		# XXX TODO
		#$bestfit = !empty($layout_crop[4]);
		#
		#$bestfit = !empty($build['options']['fullbleed']);
		#$bestfit = $template == 'imageonly'; # NOW, since no fullbleed option separate.
		# Could let product gid default to best fit, but seems buggy.... TODO

		$stretch = false;

		#Wrong box, but maybe because no more 'fullbleed' option on hdtest.
		#error_log("PC ($template)={$product_config['fullbleed']}");


		$two_sided_enabled = !empty($product_config['image.2']) && in_array($template, $this->imgonlys);

		$pers = !empty($build['options']['personalizationInput']) ? $build['options']['personalizationInput'] : (!empty($this->default_text) && empty($this->no_default_pers) ? "Personalization" : null);

		if(!isset($build['options']['personalizationNone']) && empty($pers)) # Default to not set.
		{
			# For both stamp and custom image.
			$build['options']['personalizationNone'] = true;
		} else {
			$build['options']['personalizationNone'] = false;
		}
		$no_pers = false;
		$donePersStep = !empty($build['complete']['personalization']);
		$two_sided = (in_array($template, $this->imgonlys) && !empty($product_config['image.2']));
		if (!empty($this->no_pers) || !empty($build['options']['personalizationNone']) || (empty($pers) && ($two_sided || $donePersStep || $this->no_default_pers))) { $no_pers = true; }

		#error_log("NO_PERS?=$no_pers, PERS=$pers, TMP=$template, PN=".$build['options']['personalizationNone']);

		$stamp = !empty($build['GalleryImage']);

		if($stamp && !$no_pers) { $box = 'image'; } # Use smaller box if stamp and has pers.
		else if (!$stamp && in_array($template, $this->imgonlys) && !empty($product_config['fullbleed']))# && !empty($build['Product']['fullbleed'])) # && (!empty($build['fullbleed']) || !empty($build['CustomImage']))) # Only full bleed on custom images, not stamps.
		{
			$box = 'fullbleed';
		}
		else if(!empty($product_config['image.nopersonalization']) && (!empty($two_sided_enabled) || $no_pers))# || !empty($bestfit)))
		{
			$box = 'image.nopersonalization';
		} else if (in_array($template, $this->imgonlys) && !empty($product_config['fullview']) && empty($product_config['image.nopersonalization']))# && (!empty($build['fullbleed']) || !empty($build['CustomImage']))) # Only full bleed on custom images, not stamps.
		{
			$box = 'fullview';
		} else if ($template == 'textonly') { 
			return;
		}

		#error_log("BOXY=$box");

		list($proof_image_x, $proof_image_y, $proof_image_w, $proof_image_h) = $product_config[$box];
		#$stretch = $bestfit ? 'stretch' : null; # Make bigger if ratio off, so we don't get whitespace.
		$stretch = null; # NO more forced fullbleed.
		$border_style = $is_custom ? null : "frame";

		$options = Set::extract($this->load_product_options($build['Product']['code'], false, $build), '{n}.Part.part_code');
		#error_log("BOX2=$box (NOP={$this->no_pers})");

		#$options = array();


		# Put bg color below picture, full bleed...
		$defaultBackground = in_array('background', $options) ?#&& empty($build['default_text']) && empty($this->default_text) ? 
			(in_array($build["Product"]['code'], array('PZ','MP')) ? "#000000" : "#FFFFFF") : null;

		if(empty($build['options']['backgroundColor']))
		{
			$build['options']['backgroundColor'] = $defaultBackground;
		}

		#error_log("DEFBG=$defaultBackground, DT={$this->default_text}");

		$backgroundColor = !empty($build['options']['backgroundColor']) ? $build['options']['backgroundColor'] : $defaultBackground;

		if(!empty($backgroundColor))
		{
			$hexColor = preg_replace("/^#/", "", $backgroundColor);
			$bgcolor = "0x$hexColor";

			$darkThreshold = 130;
			$this->dark = $this->brightness($hexColor) < $darkThreshold;
			#error_log("DARK={$this->dark}");

			if(isset($build['options']['personalizationColor']))
			{
				$this->textColor = ($build['options']['personalizationColor'] == 'white' ? 0xFFFFFF : 0x000000);
			} else { # Guess from bg.
				$this->textColor = $this->dark ? 0xFFFFFF : 0x0;
			}

			$bgbox = 'image';
			if(!empty($product_config['background'])) { $bgbox = 'background'; }
			else if(!empty($product_config['fullbleed'])) { $bgbox = 'fullbleed'; }
			else if(!empty($product_config['fullview'])) { $bgbox = 'fullview'; }
			else if(!empty($product_config['image.nopersonalization'])) { $bgbox = 'image.nopersonalization'; }

			#error_log("BGBOX=$bgbox");
	
			list($bgx, $bgy, $bgw, $bgh) = $product_config[$bgbox];
			imagefilledrectangle($this->canvas, $bgx, $bgy, $bgx+$bgw, $bgy+$bgh, $bgcolor);
	
			#error_log("FILLING $bgbox");
		}


		$this->_insert_graphic($image_path, array($proof_image_x, $proof_image_y, $proof_image_w, $proof_image_h), $border_style, $layout_crop, $stretch, true, $top, $rotate);

		if(in_array($template, $this->imgonlys) && $this->double_sided)
		{
			$nopers_stretch = !empty($product_config['image.nopersonalization.2']);
			$box = 'image.2'; # Default.

			# If can stretch w/o pers, 
			# If image is stretchable (when no pers), and there's a pers, default to default box.

			if($nopers_stretch && ($two_sided_enabled || $this->no_pers))
			{
				$box = 'image.nopersonalization.2';
			} else if ($nopers_stretch) { # Is a pers, always default
				$box = 'image.2';
			} else if (!empty($product_config['fullview.2'])) {
				$box = 'fullview.2';
			} else {
				$box = 'image.2';
			}

			if(!empty($product_config[$box]))
			{
				$this->_insert_graphic($image_path, $product_config[$box], $border_style, $layout_crop, $stretch, true, $top, $rotate);
			}
		}
	}

	function _load_overlay($overlay_path, $center = false)
	{
				# Now do overlay (puzzle grid, ornament bow, etc)
				$overlay = $this->_gd_load_image($overlay_path);

				# Place overlay, if it exists....
				if (!empty($overlay))
				{
					$ow = imagesx($overlay);
					$oh = imagesy($overlay);

					$w = imagesx($this->canvas);
					$h = imagesy($this->canvas);
					#imagecopy($this->canvas, $overlay, 0,0,0,0, $w, $h);
					$dx = 0;
					$dy = 0;
					$dw = $ow;
					$dh = $oh;

					if ($center)
					{
						$dx = abs($w-$ow)/2;
						$dy = abs($h-$oh)/2;
					}

					imagecopy($this->canvas, $overlay, $dx, $dy, 0,0, $ow, $oh);
					# Imagecopy plays nicer with transparency.
				}
	}

	function _output_image($final_img, $cache_file = null)
	{
		#$this->proctime();

		// Output and free from memory
		if(!empty($this->silent)) { 
			# Do nothing, not even header.

		} else if (!empty($_REQUEST['plain']) || !empty($_REQUEST['debug']))
		{
			header("Content-Type: text/html");
		} else {
			if ($this->gif || preg_match("/[.]gif$/", $cache_file)) {
				header('Content-Type: image/gif');
				$this->filetype = 'gif';
			} else if (preg_match("/[.](jpeg|jpg)$/", $cache_file)) {
				$this->filetype = 'jpeg';
				header('Content-Type: image/jpeg');
			} else {
				$this->filetype = 'png';
				header('Content-Type: image/png');
			}
		}

		if(empty($this->silent))
		{
			header('Pragma: public');
			header('Cache-Control: max-age=0');
		}


		# Should show w/trans here, then means stuff below drops trans.
		#imagepng($final_img);
		#exit(0);

		$w = imagesx($final_img);
		$h = imagesy($final_img);

		if(!empty($_REQUEST['debug']))
		{
			exit(0);
		}

		#echo "SIL={$this->silent}, CF=$cache_file";

		if ($cache_file)
		{
			$rc = $this->_save_image($final_img, $cache_file);

			if(!empty($this->silent)) { return; }

			#imagepng($final_img); #Save for cache, so dont need to reload every time...
	
			if (!$rc) { error_log("Failed to save cached image $cache_file"); }

			if(!$rc)
			{
				#error_log("FOO");
				imagepng($final_img);
			} else {
				$img_content = file_get_contents($cache_file);
				echo $img_content;
			}
		} else if ($this->gif) { 
			#$gif_img = imagecreatetruecolor($w,$h);

			#imagealphablending($gif_img, false);
			#imagesavealpha($gif_img, true);
			#$trans = imagecolorallocatealpha($gif_img, 255,255,255,127);
			#imagefilledrectangle($gif_img, 0, 0, $w, $h, $trans);
			##imagecolortransparent($gif_img, $trans);
			#imagecopyresampled($gif_img, $final_img, 0,0,0,0, $w,$h,$w,$h);

			
			#$red = imagecolorallocate($final_img, 255,0,0);
#
#			$gif_img = imagecreatetruecolor($w,$h);
#			$trans = imagecolortransparent($gif_img, $red);


			#if ($trans >= 0)
			#{
			#	$color = imagecolorsforindex($final_img, $trans);
			#	$index = imagecolorallocate($gif_img, $color['red'],$color['green'],$color['blue']);
			#	imagefill($gif_img, 0,0,$index);
			#	imagecolortransparent($gif_img, $index);
			#}
			#imagecopyresampled($gif_img, $final_img, 0,0,0,0,$w,$h,$w,$h);

			# THIS INSTEAD!
			$gif_img = $this->preserve_transparency($final_img);

			imagegif($gif_img);
		} else {
			#imagealphablending($final_img, false);
			#$trans = imagecolorallocatealpha($final_img, 0,0,0,127);

			$png_img = imagecreatetruecolor($w,$h);

			#imagealphablending($png_img, false);
			#$trans = imagecolorallocatealpha($png_img, 0,0,0,127);
			#imagefill($png_img, 0,0,$trans);
			#imagesavealpha($png_img, true);

			imagealphablending( $png_img, false );
			imagesavealpha( $png_img, true );


			imagecopyresampled($png_img,$final_img, 0,0,0,0,$w,$h,$w,$h);

			if($this->filetype == 'jpeg')
			{
				imagejpeg($png_img);
			} else {
				imagepng($png_img);
			}
		}
		
		if (!empty($src))
		{
			imagedestroy($src);
		}
		exit(0);
	}

	function _scale_image($scale, $trans = false)
	{
		$proof_w = $proof_x = imagesx($this->canvas);
		$proof_h = $proof_y = imagesy($this->canvas);
		$proof_w2h = $proof_w/$proof_h;

		# Scale image down to what we specify.
		if ($scale) # W,H; W; ,H; W,
		# OR -WxH (UNDER width or height)
		{
			if (preg_match("/^-(.*)/", $scale, $matches))
			{
				$scale = $matches[1];
				$scalewh = preg_split("/[,x]/", $scale);
				$orig_scale_w = $scale_w = $scalewh[0];
				$orig_scale_h = $scale_h = count($scalewh) >= 2 ? $scalewh[1] : null;

				$available_w = $desired_w = $orig_scale_w;
				$available_h = $desired_h = $orig_scale_h;
				$available_w2h = $available_w/$available_h;

				$desired_h = $proof_h > $available_h ? $available_h : $proof_h;
				$desired_w = ceil($desired_h * $proof_w2h);

				if ($desired_w > $available_w) # Just in case bumping width messed up...
				{
					$desired_w = $available_w;
					$desired_h = ceil($desired_w / $proof_w2h);
				}

				$scale_h = $desired_h;
				$scale_w = $desired_w;
				# XXX TODO....
			} else {
				$scalewh = preg_split("/[,x]/", $scale);
				$scale_w = $scalewh[0];
				$scale_h = count($scalewh) >= 2 ? $scalewh[1] : null;
			}
			$final_img = $this->_gd_scale_image($this->canvas, $scale_w, $scale_h, $trans);
		} else {
			$final_img = $this->canvas;
		}

		return $final_img;
	}

	function _fill_build_text($canvas, $product, $product_config, $build = array(), $cache = false)
	{
		#error_log("FILL_BUILD_TEXT, PC=".print_r($product_config['text'],true).print_r($product_config['charm'],true));
		$template = !empty($build['template']) ? $build['template'] : null;
		if($template == 'imageonly' && $this->no_pers)
		#!empty($build['options']['fullbleed']))
		{
			$template = 'imageonly_nopersonalization';
		}
		$prod = $product['Product']['code'];
		$quote_limit = $product['Product']['quote_limit'];
		$text_x = $text_y = $text_w = $text_h = null;
		$pers_x = $pers_y = $pers_w = $pers_h = null;

		$text_size = 40;

		$this->line_spacing = 1.2; # buffer...
		$this->drop_factor = 1.60;
		$this->quote_drop_factor = 1.10;

		$default_text = isset($build['default_text']) ? $build['default_text'] : $this->default_text;
		if(!empty($build['options']['personalizationNone'])) { $this->no_pers = $build['options']['personalizationNone']; }
		$no_pers = isset($build['no_pers']) ? $build['no_pers'] : $this->no_pers;

		$cwd = dirname(__FILE__);
		$this->script_fontfile = "$cwd/lte50517.ttf";
		$this->block_fontfile = "$cwd/lte50070.ttf"; 
		$this->italic_fontfile = "$cwd/TimesItalic.ttf"; 
		$text_fontfile = $this->block_fontfile;
		$pers_fontfile = (empty($build['options']['personalizationStyle']) || $build['options']['personalizationStyle'] == 'block') ? $this->block_fontfile : $this->script_fontfile;
		$text_size = null;
		$boxname = $no_pers && !empty($product_config['text.nopersonalization']) ? 'text.nopersonalization' : 'text';
		if ($template == 'textonly' && !empty($product_config['textonly'])) { $boxname = 'textonly'; }
		if ($template == 'textonly' && !empty($product_config['fullview'])) { $boxname = 'fullview'; }
		else if ($template == 'textonly' && !empty($product_config['image.nopersonalization'])) { $boxname = 'image.nopersonalization'; }
		else if ($template == 'textonly' && !empty($product_config['fullbleed'])) { $boxname = 'fullbleed'; }
		else if ($template == 'textonly' && !empty($product_config['background'])) { $boxname = 'background'; }

		#error_log("BOXNAME=$boxname, NOP=$no_pers, PC=".print_r($product_config,true));


		if((empty($build['options']['charmID']) || $build['options']['charmID'] <= 0) && !empty($product_config['text.nocharm'])) # ie for PW, use more room for text if no charm in way.
		{
			$boxname .= '.nocharm';
		}
		#error_log("BOXNAME FOR TEXT=$boxname");

		#error_log("BIX ($boxname)=".print_r($product_config[$boxname],true));

		if (!empty($product_config[$boxname]))
		{
			list($text_x, $text_y, $text_w, $text_h) = $product_config[$boxname];

			#$this->add_border($text_x,$text_y,$text_w,$text_h, array(0xFF,0,0));

			# Create some padding for textonly...
			/*
			$padding = 10; # Pixels.
			if($template == 'textonly')
			{
				$text_x += $padding;
				$text_y += $padding;
				$text_w -= 2*$padding;
				$text_h -= 2*$padding;
			}
			*/

			# Place quotation there....

			#error_log("DEF={$this->default_text}, NOQT={$this->no_quote}");
	
			$full_text = (!$this->no_quote && $default_text ? "Your wording, quotation or other text here" : "");
			$text_color = $this->defaultColor;
			if (empty($this->no_quote) && !empty($build['options']['customQuote'])) { $full_text = $build['options']['customQuote']; $text_color = $this->textColor; }
			#$full_text = '“'.$full_text.'”';

			if (!empty($build['options']['quoteID']) && empty($this->no_quote)) { 
				if($build['options']['quoteID'] == -1) 
				# If we asked for no quote.
				{
					# No quote.
					$full_text = '';
				} else {
					$quote = $this->Quote->find(array('Quote.quote_id'=>$build['options']['quoteID']));
					if (!empty($quote))
					{
						$full_text = $quote['Quote']['text'];
						if (!empty($quote['Quote']['attribution'])) { 
							#$full_text = '"'.$full_text.'"'; # Dont put in quotes!
							$full_text .= "\n- ".$quote['Quote']['attribution']; 
						}
						$text_color = $this->textColor;
					}
				}
			}
			#error_log("QUOTE_TEXT=$full_text");

			#$full_text = '&#x201d;'.$full_text.'&#x201d;';
			$lq = '&#x201c;';
			$rq = '&#x201d;';
			$i = 0;
			while(preg_match('/"/', $full_text))
			{
				#error_log("FTA=$full_text");
				$full_text = preg_replace('/"/', ($i++%2==0?$lq:$rq), $full_text, 1);
			}


			$full_text = html_entity_decode($full_text, ENT_NOQUOTES, "UTF-8");

			if(!empty($_REQUEST['order_item_id']) && $_REQUEST['order_item_id'] == 8556)
			{
				$full_text = preg_replace("/\r/", " ", $full_text);#substr($full_text, 0, 15);
			}

			#error_log("FT=$full_text");
	
			# ALWAYS CLIP PER PRODUCT LENGTH....
			if($quote_limit > strlen($full_text)) { $full_text = substr($full_text, 0, $quote_limit); }
			$dropcap = true;
			$center = false;

			#error_log("FT=$full_text TO $boxname");

			if(!empty($_REQUEST['centerquote']) || !empty($build['options']['centerQuote']))
			{
				$dropcap = false;
				$center = true;
			}

			if (!in_array($template, $this->imgonlys) || $this->textonly)
			{
				$vert_align = 'top';#$this->textonly ? 'middle' : 'top'; # Default.
				if(!empty($build['options']['alignQuote']))
				{
					$vert_align = $build['options']['alignQuote'];
				}
				#$text_size = $this->_put_multiline_text($canvas, $text_fontfile, null, $text_x, $text_y, $text_w, $text_h, $text_color, $full_text, $dropcap, $center, $vert_align, null, null, !empty($build['options']['fontSize']) ? $build['options']['fontSize'] : 0);

				$customFontSizeName = !empty($build['options']['textSize']) ? $build['options']['textSize'] : 'Large';
				$fontSizes = array('Small'=>0.65, 'Medium'=>0.8, 'Large'=>1);
				$customFontSize = $fontSizes[$customFontSizeName];
				if(empty($customFontSize)) { $customFontSize = 1; }

				$text_size = $this->_put_multiline_text($canvas, $text_fontfile, null, $text_x, $text_y, $text_w, $text_h, $text_color, $full_text, $dropcap, $center, $vert_align, false, true, $customFontSize);
			}
		} else {
			#error_log("BROKEN BOX");

		}

		#$pers_size = intval($text_size*0.9);
		$shrinkFactor = ($pers_fontfile == $this->script_fontfile) ? 0.9 : 0.65;
		#error_log("SCRINK FACT=$shrinkFactor, TE=$pers_fontfile, SCR={$this->script_fontfile}");
		$pers_size = empty($product_config['text']) ? $this->max_font_size : intval($this->max_font_size*$shrinkFactor);

		$options = Set::extract($this->load_product_options($product['Product']['code'], false, $build), '{n}.Part.part_code');
		$cant_do_personalization = !in_array('personalization', $options);

		#error_log("OPTS=".print_r($options,true));

		$personalization = null;
		#error_log("NO_PERS={$no_pers},DEF={$default_text}");

		$two_sided_enabled = !empty($product_config['image.2']) && in_array($template, $this->imgonlys);

		if(empty($no_pers))
		{
			if(empty($this->no_default_pers) && $default_text && empty($build['options']['personalizationNone']) && empty($build['options']['personalizationInput']))# && (!$two_sided_enabled))
			{
				$build['options']['personalizationInput'] = "Personalization";
			}
			if(!empty($build['options']['personalizationInput']))
			{
				$personalization = $build['options']['personalizationInput'];
			}
		}
		#error_log("PERS (NOP={$this->no_pers}) =$personalization");
		#$personalization = preg_replace("/\n/", " ", $personalization); # Convert newlines to spaces
		$customPersSizeName = !empty($build['options']['personalizationSize']) ? $build['options']['personalizationSize'] : 'Large';
		$persSizes = array('Small'=>0.75, 'Medium'=>0.85, 'Large'=>1);
		$customPersSize = $persSizes[$customPersSizeName];
		if(empty($customPersSize)) { $customPersSize = 1; }

		#error_log("P=$personalization");

		#error_log("CUSTOM_PERS=$customPersSize");

		#error_log("CANT_DO_PERS=$cant_do_personalization");
		
		# NOW DO PERSONALIZATION....... (Always even on fullview)
		if (!empty($product_config['personalization']) && !$cant_do_personalization)
		{
			if(!empty($build['PersonalizationLogo']))
			{
				#$logo_path = APP."/webroot/".$build['PersonalizationLogo']['Image_Location'];
				$logo_path = APP."/webroot/".$build['PersonalizationLogo']['display_location'];
				#error_log("PERS=$logo_path");
				$this->_insert_graphic($logo_path, $product_config['personalization']);
			} else {
				list($pers_x, $pers_y, $pers_w, $pers_h) = $product_config['personalization'];
				#error_log("PERS={$this->default_text}");
	
				#$personalization = !empty($build["options"]["personalizationInput"]) ? $build['options']['personalizationInput'] : ($this->no_pers ? "" : "Personalization");
				#error_log("P=$personalization");
				# Don't show dummy personalization on fullview.
	
				# Can't show dummy personalization since shows on top of 
				#"Happy Anniversary, October 12th 2009";
	
				#$personalization = preg_replace("/\n/", " ", $personalization); # Convert newlines to spaces
				# No longer remove newlines. Let them do linebreaks as chosen to look better (ie dates, etc)
	
				$persColorName = !empty($build['options']['personalizationColor']) ? $build['options']['personalizationColor'] : null;#"black";
				$persColor = $this->textColor;
				#error_log("PERSCOLOR=$persColor, PCN=$persColorName, def={$this->defaultColor}");
				if($persColorName == 'white') { $persColor = 0xFFFFFF; }
				else if($persColorName == 'black') { $persColor = 0x000000; }
	
				#imagerectangle($canvas, $pers_x,$pers_y,$pers_x+$pers_w,$pers_y+$pers_h,0xFF0000);

				#$pers_color = $prod == 'RL' ? 0xFFFFFF : (!empty($build["options"]["personalizationInput"]) ? $persColor : $this->defaultColor); #$this->white : $this->black;
				$pers_color = (!empty($build["options"]["personalizationInput"]) ? $persColor : $this->defaultColor); #$this->white : $this->black;

				$this->_put_multiline_text($canvas, $pers_fontfile, $pers_size, $pers_x, $pers_y, $pers_w, $pers_h, $pers_color, $personalization, false, true, 'middle', in_array($template, $this->imgonlys), false, $customPersSize);
			}
		}

		#error_log("TEMPL (should get to @ line)=$template, PC=".print_r($product_config,true));

		if (!empty($product_config['personalization.2']) && in_array($template, $this->imgonlys))
		{
			#error_log("IMGONLY PERS @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@");
			if(!empty($build["PersonalizationLogo"]))
			{
				$logo_path = APP."/webroot/".$build['PersonalizationLogo']['Image_Location'];
				$this->_insert_graphic($logo_path, $product_config['personalization.2']);
			} else { 
				list($pers_x, $pers_y, $pers_w, $pers_h) = $product_config['personalization.2'];
	
	
				$this->_put_multiline_text($canvas, $pers_fontfile, $pers_size, $pers_x, $pers_y, $pers_w, $pers_h, $pers_color, $personalization, false, true, 'middle', in_array($template, $this->imgonlys), false, $customPersSize);
			}
		}

		if (!empty($product_config['personalization.right']))
		# RIGHT JUSTIFIED VERSION INSTEAD...
		{
			list($pers_x, $pers_y, $pers_w, $pers_h) = $product_config['personalization.right'];

			$pers_color = $prod == 'RL' ? 0xFFFFFF : 0x000000; #$this->white : $this->black;
			#$this->_put_multiline_text($canvas, $pers_fontfile, intval($text_size*.80), $pers_x, $pers_y, $pers_w, $pers_h, $pers_color, $personalization, false, true, 'bottom');
			#$this->_put_multiline_text($canvas, $pers_fontfile, null, $pers_x, $pers_y, $pers_w, $pers_h, $pers_color, $personalization, false, true, 'bottom');
			$this->_put_multiline_text($canvas, $pers_fontfile, $pers_size, $pers_x, $pers_y, $pers_w, $pers_h, $pers_color, $personalization, false, 'right', 'middle', false, true, $customPersSize);
		}
	}

        function _put_text($canvas, $size, $x, $y, $color, $font, $text) # Internal?
        {
                #$color = imagecolorallocate($canvas, 100,200,200);
                # Size is in points?
                $wh = $this->_get_text_pos($size, $font, $text);
                #$text = "COOOO";
                #imagettftext($canvas, $size, 0, $x, $y, $color, $font, $text);
		#$color = 0x000000;
		$color2 = 0xFFFFFF;
	
                $this->imagettfstroketext($canvas, $size, 0, $x, $y, $color, $color2, $font, $text, 1);
                return $wh;
                # Lower right position of box,
                # So we know if too far off to right or below bounding box.
        }

	function add_border($x,$y,$w,$h, $color = null)
	{
		if(empty($color))
		{
			$color = array(0xFF, 0, 0);
		}
		$colordef = imagecolorallocate($this->canvas, $color[0], $color[1], $color[2]);
		imagerectangle($this->canvas, $x,$y,$x+$w,$y+$h, $colordef);
	}

function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {

    for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
        for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
            $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);

   return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
}


	function _put_multiline_text($canvas, $fontfile, $font_size, $text_x, $text_y, $text_w, $text_h, $text_color, $full_text, $do_dropcap = false, $do_center = false, $vert_align = 'top', $do_stroke = false, $autobreak = true, $customFontSize = 1)
	{
		#error_log("CFS=$customFontSize");
		#error_log("PUT_MULT_TEXT HEIGHT=$text_h");
		$full_text = trim($full_text);
		#$vert_align = 'bottom';
		$text_size = $font_size;
		#$do_center = true;
		###########imagerectangle($this->canvas, $text_x, $text_y, $text_x+$text_w, $text_y+$text_h, $this->grey);

		$min_font_size = $this->min_font_size;
		$max_font_size = $font_size > 0 ? ($font_size >= $min_font_size ? $font_size : $min_font_size) : $this->max_font_size;

		if ($fontfile == $this->script_fontfile) # Since it's smaller...
		{
			#$min_font_size *= 1.5; # Don't screw up if only smaller font works.
			#$max_font_size *= 2;
			#$max_font_size *= 1.25;
		}


		$canvas_w = imagesx($canvas);
		$canvas_h = imagesy($canvas);

		$no_more_text = false;

		$font_interval = 2;

		# Will need to cycle through from largest to smallest until content fits within bounding container....
		for($test_font_size = $max_font_size; $test_font_size >= $min_font_size; $test_font_size -= $font_interval)
		{
			# Create a fake layer to test on.
			$testlayer = imagecreatetruecolor($canvas_w, $canvas_h);

			list($layer, $layer_content_w, $layer_content_h, $dropcap_filled, $lines, $whitespace_percentage, $dropcap_h) = $this->_generate_multiline_text($testlayer, $fontfile, $test_font_size, $text_x, $text_y, $text_w, $text_h, $text_color, $full_text, $do_dropcap, $do_center, $do_stroke, $autobreak);

			#error_log("GEN_MULT ($full_text) ($test_font_size), LAYER_CONT_H=$layer_content_h");

			# IT THINKS IT TOOK AN EXTRA LINE...


			# This returns height we used so we can properly align vertical middle or bottom align....

			#$fits = ($layer_content_w <= $text_w && $layer_content_h <= $text_h && (!$do_dropcap || $dropcap_filled || $text_done));
			$fits = ($layer_content_w <= $text_w && $layer_content_h <= $text_h);# && (!$do_dropcap || $dropcap_filled || $text_done));
			$font_too_small = ($test_font_size <= $min_font_size); # Just go with.
			$droptest = true;
			#$textLines = preg_split("/[\n\r]/", $full_text); # Should be forced split...
			$textLines = $lines;

			#error_log("GEN LINES=".print_r($lines,true));
			#error_log("TEXT_LINES (2nd shouldnt be empty)=".print_r($textLines,true));
			$droptest = ($dropcap_filled || count($lines) <= 1 || !$do_dropcap || count($textLines) <= 1);

			#error_log("TEST=$test_font_size, FITS=$fits ($layer_content_w <= $text_w and $layer_content_h < $text_h) , W $layer_content_w <= $text_w & H $layer_content_h <= $text_h, DROPTEST=$droptest (filled=$dropcap_filled || lines ".count($lines)." <= 1 || notdodrop !$do_dropcap");

			# ALWAYS try to fill dropcap, so it's not just one word on that line.
			# BUT, if the text is all used up, don't keep on going. Stop.

			$whitespace_limit = 50;

			#error_log("DROPTEST=$droptest (**$dropcap_filled** || $lines <= 1 || !$do_dropcap), TESTING $test_font_size, FITS?= $fits ($layer_content_w <= $text_w && $layer_content_h <= $text_h)");


			# If we allow way too much whitespace, then it looks choppy, unprofessional, etc. Try to shrink font until there's a reasonable fill each line.

			if (($fits && $droptest)) # && ($whitespace_percentage < $whitespace_limit || $test_font_size-$font_interval <= $min_font_size)))
			{
				#error_log("FITS AND DROPTESTS ($test_font_size)");
				# Middle alignment, vertically...
				$x_offset = 0;
				$y_offset = 0;
				if ($vert_align == 'middle')
				{
					$y_offset = ($text_h - $layer_content_h)/2;
				} else if ($vert_align == 'bottom') {
					$y_offset = ($text_h - max($dropcap_h, $layer_content_h)); # Consider dropcap, could be one line.
				}
				#error_log("VALIGN=$vert_align, TH=$text_h, LCH=$layer_content_h, YOFF=$y_offset");
				# Gets wrong text_h, for supposed one extra line since old font size doesnt fit.



				#list($layer, $layer_content_w, $layer_content_h, $dropcap_filled, $lines, $whitespace_percentage) = 
				#$this->_generate_multiline_text($testlayer, $fontfile, $test_font_size, $text_x, $text_y, $text_w, $text_h, $text_color, $full_text, $do_dropcap, $do_center, $do_stroke, $autobreak);

				#error_log("XOFF=$x_offset, YOFF=$y_offset");

				# See if what 'fits' looks good.
				#return $this->_output_image($testlayer);
				# TOMAS

				#error_log("CUSTOM_FONT_SIZE=$customFontSize * $test_font_size");

				$this->_generate_multiline_text($canvas, $fontfile, $test_font_size*$customFontSize, $text_x+$x_offset, $text_y+$y_offset, $text_w, $text_h, $text_color, $full_text, $do_dropcap, $do_center, $do_stroke, $autobreak);
				#$canvas_w = imagesx($this->canvas);
				#$canvas_h = imagesy($this->canvas);
				#imagecopymerge($this->canvas, $layer, 0, 0, 0, 0, $canvas_w, $canvas_h, 100);
				#$text_w, $text_h, 100);
				#$this->canvas = $layer;
				#$
				# Merge, since fits.

				$text_size = $test_font_size;

				break;
			}
		}

		#error_log("TEXT_SIZE=$text_size");

		if($font_too_small && !$fits)
		{
			# Start clipping off lines until it fits.
			$old_text = null;
			while(!$fits && !empty($full_text) && $old_text != $full_text)
			{
				$full_text = preg_replace("/(\w+\W+)$/", "", $full_text);
				list($layer, $layer_content_w, $layer_content_h, $dropcap_filled, $lines) = $this->_generate_multiline_text($testlayer, $fontfile, $test_font_size, $text_x, $text_y, $text_w, $text_h, $text_color, $full_text, $do_dropcap, $do_center, $do_stroke, $autobreak);
				$fits = ($layer_content_w <= $text_w && $layer_content_h <= $text_h);# && (!$do_dropcap || $dropcap_filled || $text_done));
				$old_text = $full_text;
			}

			$y_offset = 0;
			if ($vert_align == 'middle')
			{
				$y_offset = ($text_h - $layer_content_h)/2;
			} else if ($vert_align == 'bottom') {
				$y_offset = ($text_h - $layer_content_h);
			}

			$x_offset = 0;
			$this->_generate_multiline_text($canvas, $fontfile, $test_font_size, $text_x+$x_offset, $text_y+$y_offset, $text_w, $text_h, $text_color, $full_text, $do_dropcap, $do_center, $do_stroke, $autobreak);
		}
		return $text_size;
	}

	function _generate_multiline_text($layer, $fontfile, $font_size, $text_x, $text_y, $text_w, $text_h, $text_color, $full_text, $do_dropcap = false, $do_center = false, $do_stroke = false, $autobreak = true)
	{
		#error_log("GEN_MULT=$layer, $fontfile, $font_size, $text_x, $text_y, $text_w, $text_h, $text_color, $full_text, $do_dropcap, $do_center, $do_stroke, $autobreak");
		$lines = array();
		$left_quote = '"'; $right_quote = '"';

		$fulltext_w = 0;


		$original_font_size = $font_size;
		
		$offset_x = $offset_y = 0;

		$line_height = $this->_get_line_height($fontfile, $font_size); # Get max height for ALL letters.... so all lines even spaced.... 

		$dropcap = null;
		$dropcap_width = $dropcap_height = 0;
		$dropcap_filled = false;
		$text = null;

		# Get any punctuation, to shift entire box over (except punctuation)
		$pretext = "";
		while(!empty($full_text) && preg_match("/^\W/", $full_text[0], $match))
		{
			$pretext .= $full_text[0];
			$full_text = substr($full_text, 1);
		}
		if(!empty($pretext))
		{
			# Generate block, subtract width from text_w and offset larger block.
			$preoffset = $line_height;
			if(preg_match("/[.,]/", $pretext)) # Some text should be bottom aligned.
			{
				$preoffset *= $this->drop_factor;
			} else {
				$preoffset /= 2; # Top-align- ish
			}
			list($pretext_width, $pretext_height) = 
				$this->_put_text($layer, $font_size, $text_x, $text_y+$preoffset, $text_color, $fontfile, $pretext);
			$text_x += $pretext_width+$pretext_width/strlen($pretext);
			$text_w -= ($pretext_width+$pretext_width/strlen($pretext));
		}

		if($do_dropcap)
		{
			$dropcap = "";
			for($i = 0; $i < strlen($full_text);$i++) # Extract first letter for dropcap.
			{
				if(preg_match("/\w/", $full_text[$i]))
				{
					$dropcap = substr($full_text, 0, $i+1);
					$text = substr($full_text, $i+1);
					break;
				} 
			}
			# Print dropcap.
			# Force capital (looks odd if lowercase)
			$dropcap = strtoupper($dropcap);
			if(false && strlen($dropcap) > 1) # Quotes included.
			{
				$dropcap1 = substr($dropcap,0,-1);
				$dropcap2 = substr($dropcap,-1,1);
				#error_log("D1=$dropcap1, D2=$dropcap2");
				#$drop2_width = $drop2_height = 0;
				list ($drop1_width, $drop1_height) = $this->_put_text($layer, $line_height*$this->quote_drop_factor, $text_x, $text_y+$line_height*$this->quote_drop_factor, $text_color, $fontfile, $dropcap1);
				list ($drop2_width, $drop2_height) = $this->_put_text($layer, $line_height*$this->drop_factor, $text_x+$drop1_width, $text_y+$line_height*$this->drop_factor, $text_color, $fontfile, $dropcap2);
				$dropcap_width = $drop1_width + $drop2_width;
				$dropcap_height = max($drop1_height,$drop2_height);
			} else {
				list ($dropcap_width, $dropcap_height) = $this->_put_text($layer, $line_height*$this->drop_factor, $text_x, $text_y+$line_height*$this->drop_factor, $text_color, $fontfile, $dropcap);
			}
		} else {
			$text = $full_text;
		}

		#error_log("TEXT=".print_r($text,true));

		$text = preg_replace("/<br([^>]*)>/", "\n", $text);

		$lines = $this->_format_words($fontfile, $font_size, $text, $text_w, $autobreak);
		# Split text into lines and words (arrays of arrays)
		#error_log("LINES=".print_r($lines,true));

		$default_offset_dropcap_x = $offset_dropcap_x = $dropcap_width*1.1;

		$offset_x = $offset_h = 0;
		$pos_x = $pos_y = 0;
		$largest_layer_x = 0;

		$linecount = count($lines);

		$oldfont = $fontfile;

		$outLines = array();


		#foreach($lines as $words)
		#error_log("LINES=".print_r($lines,true));
		for($l = 0; $l < count($lines); $l++)
		{
			#error_log("OFY($l)=$offset_y");
			$words = $lines[$l];

			$is_attrib = false;
			if (preg_match("/^-/", join(" ", $words))) # is an attribution, should right align, etc.
			{
				$font_size = $original_font_size *0.70;
				$is_attrib = true;
				$words[0] = preg_replace("/^-/", "—", $words[0]);
			}
			if(true) { 
				$dropcap_line_has_multiple_words = empty($dropcap); # true if no dropcap.

				while(!empty($words)) # On the given line.
				{
					$line = "";
					$words_w = 0;
					
					if ($offset_y < $dropcap_height)
					{
						if ($offset_y > 0)
						{
							$offset_dropcap_x = $dropcap_width*1.1;
						} else {
							$offset_dropcap_x = $dropcap_width*1.1;
						}
					} else {
						$offset_dropcap_x = 0;
					}
	
					$testwords_w = 0;

					$line_w = 0;

					if(empty($autobreak)) # Fit all words on the same line.
					{
						$testline = $line = join(" ", $words);
						list($words_w, $words_h) = $this->_get_text_pos($font_size,$fontfile,$testline);

						if ($words_w+$offset_dropcap_x > $largest_layer_x)
						{
							$largest_layer_x = $words_w+$offset_dropcap_x;
						}
						$words = array();
						$fulltext_w += $words_w+$offset_dropcap_x;


					} else { # Wrap as necessary.
						while (count($words) && $words_w+$offset_dropcap_x <= $text_w)
						# Words left on line and words still fit.
						{
							$word = $words[0];
							$testline = $line . (($line||($offset_dropcap_x && $offset_y)) ? " ":"") . $word;
							list($words_w, $words_h) = $this->_get_text_pos($font_size,$fontfile,$testline);
							if ($words_w+$offset_dropcap_x <= $text_w) # While words fit on line.
							{
								$line = $testline;
								array_shift($words);
								if ($words_w+$offset_dropcap_x > $largest_layer_x)
								{
									$largest_layer_x = $words_w+$offset_dropcap_x;
								}
								$line_w = $words_w + $offset_dropcap_x;
							}
						}
						$fulltext_w += $line_w;
					}
					$words_on_line = split(" ", $line);


	
					$pos_x = $text_x+$offset_dropcap_x;
					$pos_y = $text_y+$font_size+$offset_y;
	
					if ($do_center === 'right' || $is_attrib)
					{
						list($testwords_w, $testwords_h) = $this->_get_text_pos($font_size,$fontfile,$line);
						$pos_x += ($text_w - $testwords_w - $offset_dropcap_x); # move on right side!
					} 
					else if ($do_center)
					{
						list($testwords_w, $testwords_h) = $this->_get_text_pos($font_size,$fontfile,$line);
						$pos_x += ($text_w - $testwords_w - $offset_dropcap_x)/2; # add half of extra space on both sides.
					}
					if(!empty($is_attrib))
					{
						$fontfile = $this->italic_fontfile;
					} else {
						$fontfile = $oldfont;
					}
					#if(empty($do_stroke))
					#{
						imagettftext($layer, $font_size, 0, $pos_x, $pos_y, $text_color, $fontfile, $line);
					#} else {
					#	$color2 = 0xFFFFFF;
					#	$this->imagettfstroketext($layer, $font_size, 0, $pos_x, $pos_y, $text_color, $color2, $fontfile, $line, 2);
					#}
					$line_count = count(preg_split("/\n/", $line)); # Check for newlines!
	
					# Now offset to next line.
					if (($offset_dropcap_x + $words_w >= $text_w) || preg_match("/^\n/", $line))
					{
						# TODO DROPMULT
						#error_log("@@@@ DROPFILL MULT_WORDS=$offset_y == 0 && $do_dropcap && 1 < ".count($words_on_line));
						# OFF_Y is always > 0
						if($offset_y == 0 && $do_dropcap && count($words_on_line) > 1)
						{
							$dropcap_line_has_multiple_words = true;
						}
						$offset_y += $line_count*$line_height;
						#error_log("OFFY=$offset_y + $line_count*$line_height, DROP!!!");
						$linecount++;
					}
	
					# If no room left, abort.
					if ($offset_y >= $text_h) # Can't fit any more lines.
					{
						break;
					}

					# Tweak so at least one word AFTER dropcap on line, if any
					#error_log("*** DROP_FILLED? $offset_y > 0 && $offset_y <= $dropcap_height && $line != '' && $dropcap_line_has_multiple_words <= MULT_WORD_FAIL");


					if($offset_y == 0 && $do_dropcap && count($words_on_line) > 1)
					{
						$dropcap_line_has_multiple_words = true;
					}

					if ($offset_y >= 0 && $offset_y <= $dropcap_height && $line != "" && $dropcap_line_has_multiple_words)
					{
						$dropcap_filled = true;
					}

					$outLines[] = $line;
				}
			}

			# SOMETHING HERE OVERSIZING TEXT...
			if(true || $l+1 < count($lines))
			{
				$offset_y += $line_count*$line_height; # Advance to next line, if needed.
			}

			if ($offset_x > $largest_layer_x) { $largest_layer_x = $offset_x; }
		}
		#error_log("OFFSET_Y=$offset_y, LINES=".count($lines).", LCNT=$line_count, LHEIGHT=$line_height");
		$layer_x = $offset_x;
		$layer_y = $offset_y;

		#error_log("LINECOUNT ($full_text)=$linecount");

		$total_size = ($linecount) * $largest_layer_x;
		$whitespace_percentage = $total_size > 0 ? intval( ($total_size - $fulltext_w) / $total_size * 100) : 0;

		#return array($layer, $largest_layer_x, $layer_y, $dropcap_filled, $linecount, $whitespace_percentage);
		return array($layer, $largest_layer_x, $layer_y, $dropcap_filled, $outLines, $whitespace_percentage, $dropcap_height);
	}

	function _format_words($fontfile, $font_size, $text, $text_w, $autobreak = true)
	{
		$text = preg_replace("/<br>/", "\n", $text);
		$lines = preg_split("/\n/", $text);

		$text_words = array();
		$l = 0; foreach($lines as $ln)
		{
				$raw_text_words = split(" ", $ln);
				$angle = 0;
				foreach($raw_text_words as $word)
				{
					if(empty($autobreak))
					{
						$text_words[$l][] = $word;
						
					} else { 
	        			$testbox = imagettfbbox($font_size, $angle, $fontfile, $word);
					$word_x = $testbox[2]-$testbox[0];
					$word_y = $testbox[3]-$testbox[7];

						if ($word_x > $text_w)
						{
							$word_offset = 0;
							
							for ($i = 0; $i < strlen($word); $i++)
							{
								$teststring = substr($word, $word_offset, $i);
		        					$testbox = imagettfbbox($font_size, $angle, $fontfile, $teststring);
								$word_x = $testbox[2]-$testbox[0];
								$word_y = $testbox[3]-$testbox[7];
	
								if ($word_x > $text_w)
								{
									$text_words[$l][] = $teststring."-";
									$word_offset = $i;
								}
							}
							$text_words[$l][] = substr($word, $word_offset);
						
						} else {
							$text_words[$l][] = $word;
						}
					}
				}
			$l++;
		}

		return $text_words;
	}

	function _get_text_pos($size, $font, $text)
	{
		$angle = 0;
	        $testbox = imagettfbbox($size, $angle, $font, $text);
		$word_x = $testbox[2]-$testbox[0];
		$word_y = $testbox[3]-$testbox[7];
		return array($word_x, $word_y);
	}

	function _get_line_height($fontfile, $font_size)
	{
		$angle = 0;

				$line_height = 0;
				for($char = 'a'; $char <= 'z'; $char++)
				{
	        			$testbox = imagettfbbox($font_size, $angle, $fontfile, $char);
					$char_w = $testbox[2]-$testbox[0];
					$char_h = $testbox[3]-$testbox[7];
					if ($char_h >$line_height) { $line_height = $char_h; }
				}
				for($char = 'A'; $char <= 'Z'; $char++)
				{
	        			$testbox = imagettfbbox($font_size, $angle, $fontfile, $char);
					$char_w = $testbox[2]-$testbox[0];
					$char_h = $testbox[3]-$testbox[7];
					if ($char_h >$line_height) { $line_height = $char_h; }
				}

				$line_height *= $this->line_spacing; # buffer

		return $line_height;
	}

	function _gd_scale_image($img, $w, $h, $make_trans = false)
	{
		$origw = imagesx($img);
		$origh = imagesy($img);

		$w2h = $origw / $origh;

		if (!$w && !$h)
		{
			$w = $origw;
			$h = $origh;
		} else if (!$w) {
			$w = ceil($w2h * $h);
		} else if (!$h) {
			$h = ceil($w / $w2h);
		}



		$newimg = imagecreatetruecolor($w,$h);

		/*
		# This isn't needed, messes up final transparency on hdtest, when background=1
		if ($make_trans)
		{
			# Preserve transparency....
			$trans = imagecolortransparent($img);
			imagepalettecopy($img, $newimg);
			imagefill($newimg, 0, 0, $trans);
			imagecolortransparent($newimg, $trans);
			imagetruecolortopalette($newimg, true, 256);
		}
		*/

		# ALWAYS DO TRANS ABILITY!
		# Now designate transparent color, and fill.
		$transparent = imagecolorallocatealpha($newimg, 0,0,0,127);
		imagefill($newimg, 0,0, $transparent); # This fills entire area, even spots not pasted upon.
		imagecolortransparent($newimg, $transparent); # This designates what the transparent color IS.

		#
		imagealphablending( $newimg, false );
		imagesavealpha( $newimg, true );


		imagecopyresampled($newimg, $img, 0,0,0,0, $w, $h, $origw, $origh);
		$new_w = imagesx($newimg);
		$new_h = imagesy($newimg);
		#return $img;
		return $newimg;
	}


	function get_product_image_path($code, $orient = 'horizontal', $generic = false, $template = '', $transbg = false, $build = array())
	{
		#error_log("GENERIC=$generic");
		if ($template && $template != 'standard') { $this->fullview = true; }

		$parent_code = $this->get_parent_code($code);
		if(!empty($parent_code) && !is_dir(APP."/../images/products/blanks/$code"))
		{
			$code = $parent_code;
		}

		$dir = $this->get_product_image_dir($code, $orient, $this->fullview, false, $build);

		#error_log("GOING WITH $dir");
		#if ($template) { $template = "-$template"; }
		#if ($this->fullview) { $template = "fullview"; }
		if($this->no_pers) { $template = 'imageonly_nopersonalization'; }

		#if (!$orient) { $orient = 'horizontal'; }
		if ($template == 'standard') { $template = ''; }
		$transimg_png = "$dir/original/$code-trans.png";
		$transimg_png_white = "$dir/original/$code-trans-white.png";
		$transimg_gif = "$dir/original/$code-trans.gif";

		$transimg = file_exists($transimg_png) ? $transimg_png : $transimg_gif;
		$transimg_white = file_exists($transimg_png_white) ? $transimg_png_white : null;

		#error_log("DARK??? {$this->dark}, TIW=$transimg_white");

		if(!empty($this->dark) && !empty($transimg_white))
		{
			$transimg = $transimg_white;
		}

		$srcfile = ($transbg || $this->transbg) ?  $transimg : "$dir/original/$code.png";

		# TOMAS_MALY loading trans.gif broken.
		#
		#
		if ($generic)
		{
			#error_log("GENERIC_TMPL=$template");
			if ($template && $template != 'standard')
			{
				$srcfile = APP."/webroot/images/preview/$code/$orient-$template/generic.png";
			} else {
				$srcfile = APP."/webroot/images/preview/$code/$orient/generic.png";
			}
			#error_log("GENRIC=$srcfile");
		}
		return $srcfile;
	}

	function save_transparency($img)
	{
		if (empty($this->transparency)) { return; }
		$this->transindex = imagecolortransparent($img);

		$totalcolors = imagecolorstotal($img);
		if($this->transindex >= $totalcolors)
		{
			$this->transindex = $totalcolors;
		}
		if($this->transindex >= 0 && $this->transindex < $totalcolors)
		{
			$this->transcol = imagecolorsforindex($img, $this->transindex);
		}
	}

	function preserve_transparency($in_img)
	{
		if (empty($this->transparency)) { return $in_img; }
		$w = imagesx($in_img);
		$h = imagesy($in_img);

		$out_img = imagecreatetruecolor($w,$h);
		#$transindex = imagecolortransparent($in_img);
		$transindex = $this->transindex;

		imagealphablending($out_img, false);
		if($transindex >= 0)
		{
			#$transcol = imagecolorsforindex($in_img, $transindex);
			$transcol = $this->transcol;
			$transindex = imagecolorallocatealpha($out_img, $transcol['red'], $transcol['green'], $transcol['blue'], 127);
			imagefill($out_img, 0, 0, $transindex);
		}
	
		imagecopyresampled($out_img, $in_img, 0,0,0,0, $w,$h, $w,$h);
	
		if ($transindex >= 0)
		{
			imagecolortransparent($out_img, $transindex);
			for($y=0; $y<$h; ++$y)
			    for($x=0; $x<$w; ++$x)
			          if(((imagecolorat($out_img, $x, $y)>>24) & 0x7F) >= 100) imagesetpixel($out_img, $x, $y, $transindex);
		}

		imagetruecolortopalette($out_img, true, 255);
		imagesavealpha($out_img, false);

		return $out_img;
	}

	function brightness($hex)
	{
		$hex = str_replace('#', '', $hex);

		$cr = hexdec(substr($hex, 0,2));
		$cg = hexdec(substr($hex, 2,2));
		$cb = hexdec(substr($hex, 4,2));

		$bright = ( ($cr*299) + ($cg*587) + ($cb*114) ) / 1000;

		#error_log("BRIGHT ($cr, $cg, $cb) = $bright");

		return $bright;
	}

}
?>
