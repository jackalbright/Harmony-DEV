<?php
class ProductImage2Controller extends AppController {

	var $name = 'ProductImage2';
	var $helpers = array('Html', 'Form');
	var $uses = array("Product", "GalleryImage", "CustomImage","Charm","CharmCategory","CharmCategoryCharm","Tassel","Part","ShippingPricePoint","TrackingProductCalculatorRequest","Faq","FaqTopic","ContentSnippet","Border","CartItem","Ribbon","Frame","OrderItem",'SavedItem');
	var $black;
	var $white;
	var $grey;
	var $template;
	var $fullview = false;
	var $noimage = false;
	var $transbg = false;
	var $gif = false;
	var $filetype = false;
	var $orient = "horizontal"; # Default
	var $transindex = null;
	var $transcol = null;
	var $transparency = true;
	var $default_text = true;

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

	function tassel($tasselID)
	{
		$tassel = $this->Tassel->read(null, $tasselID);
		$color = preg_replace("/ /", "-", $tassel['Tassel']['color_name']);
		$path = "/tassels/thumbs/$color.gif";
		$this->redirect($path);
	}

	function charm($charmID)
	{
		$charm = $this->Charm->read(null, $charmID);
		$color = preg_replace("/ /", "-", $charm['Tassel']['color_name']);
		$path = $charm['Charm']['graphic_location'];
		$this->redirect($path);
	}

	function image_rotate($image_id, $angle = 0)
	{
		$image = $this->CustomImage->read(null, $image_id);

		$display_location = $image['CustomImage']['display_location'];
		$image_location = $image['CustomImage']['Image_Location'];

		$img = $this->_gd_load_image(APP."/webroot/".$image_location);

		# Rotate.
		$rotimg = imagerotate($img, $angle, 0);

		$this->_output_image($rotimg);
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


	function _gd_load_image($path, $crop_data = false)
	{
		ini_set("memory_limit","200M");
		error_log("PATH=$path");
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


		if (!empty($crop_data))
		{
			# SOMETIMES we might be a little off, so make sure neither width nor height are too small given other dimension.
			# (allow for slight clipping)
			list($crop_x,$crop_y,$crop_w,$crop_h) = $crop_data;

			# Due to ceil(), we may be off by a pixel or two too much.

			if(!$crop_w || !$crop_h) { return $img; }
			$crop_w2h = $crop_w/$crop_h;

			if($crop_x < 0) { $crop_x = 0; } # Panned around.
			if($crop_y < 0) { $crop_y = 0; }

			# Let them zoom out and deal with crop coordinates bigger than image.
			# Scaling down is handled later.
			$canvas_w = $crop_w;
			$canvas_h = $crop_h;
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

			$crop_img = imagecreatetruecolor($canvas_w,$canvas_h);
			
						#imagealphablending($this->canvas, false);
						#$color = imagecolortransparent($this->canvas, imagecolorallocatealpha($this->canvas, 0,0,0,127));
						#imagefill($this->canvas, 0,0, $color);
						#imagesavealpha($this->canvas, true);

			imagealphablending( $crop_img, false );
			imagesavealpha( $crop_img, true );

			# d, s, dx, dy, sx, sy, dw, dh, dw, sh
			$dx = 0;
			$dy = 0;
			$sx = $crop_x;
			$sy = $crop_y;
			$sw = $crop_w;
			$sh = $crop_h;
			$dw = $canvas_w;
			$dh = $canvas_h;

			imagecopyresampled($crop_img, $img, $dx,$dy, $sx, $sy, $dw, $dh, $sw, $sh);
			return $crop_img;
		} else {
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

		$parts = $orderItem['ItemPart'];
		#array_change_key_case($parts,CASE_LOWER);

		# Fix stuff...
		foreach($parts as $partkey => $partvalue)
		{
			$newpartkey = preg_replace("/_/", "", $partkey);
			$parts[$newpartkey] = $partvalue;
		}
		$parts['customQuote'] = $parts['custom_quote'];
		$parts['personalizationInput'] = $parts['personalization'];

		$build['options'] = $parts;

		#$layout = !empty($build['options']['template']) ? $build['options']['template'] : 'standard';
		$layout = $build['template'];

		#$build['template'] = $layout;
		$build['crop'][$layout] = !empty($build['options']['imageCrop']) ? split(",", $build['options']['imageCrop']) : null;
		$imgtype = null;
		$imgid = null;
		if (!empty($build['template']) && $build['template'] == 'imageonly')
		{
			$this->fullview = true;
		}
		if (!empty($build['options']['imageID'])) { 
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
		if (!$is_stock_item)
		{
			$this->default_text = false;
			$this->_display_image($prod, $imgtype, $imgid, $scale, $build, false);
		} else {
			if ($prod == 'TA')
			{
				$tassel_id = $build['options']['tassel_ID'];
				$tassel = $this->Tassel->find("tassel_id = '$tassel_id'");
				$tasselname = preg_replace("/ /", "-", $tassel['Tassel']['color_name']);
				$filename = APP."/../tassels/$tasselname.gif";
				# Get filename for specific tassel
				$this->transparency = false;
			} else if ($prod == 'CH') { 
				$charm_id = $build['options']['charm_ID'];
				$charm = $this->Charm->find("charm_id = '$charm_id'");
				$charmname = preg_replace("/ /", "-", $charm['Charm']['charm_code']);
				# Get filename for specific charm
				$filename = APP."/../charms/large/$charmname.jpg";
			} else { #if ($prod == 'PR' || $prod == 'PWK' || $prod == 'DPWK') { 
				$filename = APP."/webroot/images/products/thumbnail/$prod.jpg";
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

		
		$build = $cartItem['CartItem'];
		$prod = $build['productCode'];
		$build['options'] = unserialize($cartItem['CartItem']['parts']);
		$layout = !empty($build['template']) ? $build['template'] : 'standard';


		$build['template'] = $layout;
		if(is_array($build['options']['imageCrop']))
		{
			$build['crop'][$layout] = $build['options']['imageCrop'];
			#echo "IC=".print_r($build['crop'],true);
			#exit(0);
		} else {
			$build['crop'][$layout] = !empty($build['options']['imageCrop']) ? split(",", $build['options']['imageCrop']) : null;
		}
		$imgtype = null;
		$imgid = null;
		if (!empty($build['template']) && $build['template'] == 'imageonly')
		{
			$this->fullview = true;
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
			if ($template == 'imageonly' || $template == 'textonly')
			{
				$this->fullview = true;
			}
		}

		if (!empty($_REQUEST['noimage']))
		{
			$this->noimage = true;
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

	function build_view($scale = '')
	{
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
			if ($template == 'imageonly' || $template == 'textonly')
			{
				$this->fullview = true;
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

		$this->Session->write("Build", $this->build);

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

		if (!empty($build['template']) && $build['template'] == 'imageonly')
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
		# 
		$build = array();
		$template = null;
		if (preg_match("/^(.+)-(standard|imageonly|fullview|fullbleed)$/", $prod, $matches))# && $prod != 'ORN-CER')
		{
			$prod = $matches[1];
			$template = $matches[2];
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
		# Get correct master image! (base off template!)
		$this->_display_image($prod, $imgtype, $imgid, $scale, $build);
	}

	function _save_image($canvas, $file)
	{
			$dir = dirname($file);
			if (!file_exists($dir))
			{
				mkdir($dir, 0777, true);
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

	function _load_product_image($generic, $product, $orient, $template = '')
	{
		$prod = !empty($product['Product']) ? $product['Product']['code'] : $product['code'];
		$product_image_path = $this->get_product_image_path($prod, $orient, null, $template, !empty($_REQUEST['background'])); 
		error_log("PIP=$product_image_path");
		# This here, loading the transparent version messes up the rest of the image
		# (somehow affects color palette?)
		#

		#error_log("PIP=$product_image_path");
		# Need to cache stock text file....


		if ($generic) # Stock text, etc...
		{
			$build = array();
			$generic_product_image_path = $this->get_product_image_path($prod, $orient, $generic, $template); 
			# We need to get a generic file...

			if (!file_exists($generic_product_image_path))
			{
				$product_config = $this->get_product_config($prod, $orient, $this->fullview);
				# Generate!
				$generic_canvas = $this->_gd_load_image($product_image_path);
				#if (!$this->fullview)
				#{
					$this->_fill_build_text($generic_canvas, $product, $product_config, $build, true);
				#}
				$rc = $this->_save_image($generic_canvas, $generic_product_image_path);
			}
			
			return $this->_gd_load_image($generic_product_image_path);
		} else {
			return $this->_gd_load_image($product_image_path);
		}
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

		if ($prod == 'BC') { $prod = 'B'; }
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

		if (!$template) { $template = (!empty($build['template']) && $build['template'] != 'standard') ? $build['template'] : null; }


		$ext = "png";
		$cache_file = APP."/webroot/".join("/", $urlparts).".$ext";

 
		$product = $this->Product->find(" code = '$prod' ");

		$build['Product'] = $product['Product'];

		$image_path = "";

		$is_custom = ($imgtype == 'Custom');

		if($imgtype == 'Custom')
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

		$crop = !empty($build['crop'][$template]) ? $build['crop'][$template] : null;

		$this->orient = $orient = $this->get_image_orientation($thumb_image_path, null, $crop);
		# Base product orientation off of ORIGINAL image's orientation, not rotated one...
		
		$product_image_path = $this->get_product_image_path($prod, $orient); # Need to pass info about custom image, orientation etc.
		$overlay_path = null;

		if (empty($this->transbg))
		{
			$overlay_path = dirname($product_image_path)."/$prod-overlay.png";
			if (!is_file($overlay_path))
			{
				$overlay_path = dirname($product_image_path)."/$prod-overlay.gif";
			}
		}


		#$src = imagecreatetruecolor(80, 40);
		$this->canvas = $this->_load_product_image($cache, $product, $orient, $template);
		$proof_w = $proof_x = imagesx($this->canvas);
		$proof_h = $proof_y = imagesy($this->canvas);
		$proof_w2h = $proof_w/$proof_h;

		if(!empty($build['options']['fullbleed']) && !empty($build['GalleryImage']))
		{
			unset($build['options']['fullbleed']);
		}

		# Get coordinates of where image should go....
		$product_config = $this->get_product_config($prod, $orient, $this->fullview);

		if (!$this->noimage)
		{
			$topalign = in_array($prod, array('B','BC','BNT'));
			if($topalign && $this->fullview && empty($build['options']['fullbleed']))
			{
				$topalign = 'topoffset'; # Only offset on fit/image-only
			}
			$this->_load_image($image_path, $is_custom, $product_config, $cache, $build, $topalign);

		}

		if(!empty($_REQUEST['background'])) { $this->transbg = true; }

		# XXX fit another copy of image on, with background cropped out.
		# TODO
		$trans_bg_img_path = $this->get_product_image_path($prod, $orient, false, null, true); # Need to pass info about custom image, orientation etc.
		error_log("TRANS_BG_IMG_PATH=$trans_bg_img_path");
		if (file_exists($trans_bg_img_path))
		{
			$this->_insert_graphic($trans_bg_img_path, array(0,0,$proof_w,$proof_h));
		}



		# Rotating image for bookmark?
		# Maybe if proper orientation image isn't available, we should rotate WHOLE canvas (config would be adjusted, tho)
		# maybe just rotate image and then in the end rotate product so image looks upright, etc.


		#if (!$cache && $template != 'imageonly') { $this->_fill_build_text($this->canvas, $product, $product_config, $build); }
		if (!$cache && empty($_REQUEST['background'])) { $this->_fill_build_text($this->canvas, $product, $product_config, $build); }

		# Personalization on image only okay.

		if (!$cache && !empty($build['options']['charmID']) != "") { 
			if ($prod != 'BNT' && ($prod == 'B' || $template != 'imageonly' || $prod == 'ORN'))
			{
				$this->_fill_build_charm($this->canvas, $product, $product_config, $build); 
			}
		}
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

		#$final_img = $this->_scale_image($scale, $this->transbg);
		#$this->_output_image($final_img, $cache ? $cache_file : null);
		#exit(0);



		if (!$cache && !empty($build['options']['charmID']) && (!isset($build['options']['tasselID']) || $build['options']['tasselID'] != -1)) { 
			if ($prod != 'BNT' && ($prod == 'B' || $template != 'imageonly'))
			{
				$this->_fill_build_charm($this->canvas, $product, $product_config, $build); 
			}
		}


		if ($cache)# || !isset($build['options']['charmID']) ) # Put in generic charm...
		{
			$default_charms = array(
				#'PW'=>157, # shooting star
				'B'=>17, # Book
				'BC'=>17, # Book
				'ORN'=>17
			);
			if(!empty($default_charms[$prod]))
			{
				$build['options']['charmID'] = $default_charms[$prod];
				#if ($prod == 'B' || $template != 'imageonly' || $prod == 'ORN')
				# Don't show charm on cached bookmark w/tassel (just w/tass+charm)
				if ($orig_prod == 'BC' || ($prod == 'PW' && $template != 'imageonly') || $prod == 'ORN')
				{
					$this->_fill_build_charm($this->canvas, $product, $product_config, $build);
				}
			}
		}


		$fullview = $imageonly = $this->fullview;
		$fullbleed = !empty($build['options']['fullbleed']) || $template == 'fullbleed';

		#if (!$fullview && ((!$cache && !empty($build['options']['borderID'])) || $prod == 'B' || $prod == 'BC')) { $this->_fill_build_border($this->canvas, $product, $product_config, $build); }
		if (!$fullbleed && ((!$cache && !empty($build['options']['borderID'])) )) { $this->_fill_build_border($this->canvas, $product, $product_config, $build); }
		# DEFAULT
		if (!$fullview && ($prod == 'B' || $prod == 'BNT' || $prod == 'BC') && empty($build['options']['borderID'])) { $this->_fill_build_border($this->canvas, $product, $product_config, $build); }
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

		
		$this->_load_overlay($overlay_path);


		if (!empty($_REQUEST['watermark']))
		{
			$watermark_path = APP."/../images/watermark.png";
			$this->_load_overlay($watermark_path, true);
		}

		if(!empty($build['rotate'])) 
		{
			$this->canvas = imagerotate($this->canvas, 360-$build['rotate'], 0xFFFFFF);
		}


		$final_img = $this->_scale_image($scale, $this->transbg);
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
		$charmID = !empty($build['options']['charmID']) ? $build['options']['charmID'] : null;
		if ($product['Product']['code'] == 'ORN' && !$charmID) { $charmID = 161; } # snowflake Default.

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
		}
	}

	function _insert_graphic($image_path, $box, $border_style = null, $image_crop = array(), $clip = false, $main_img = false, $topalign = false)
	# Scales down... or clips
	{
		list ($box_x,$box_y,$box_w,$box_h) = $box;

		if ($image_path && file_exists($image_path))
		{
			# Load size of image.

			# place black background of 10 pixels etc more.
			# Adjust size and coordinate for image....



			# place image above....
			$image_crop_list = !empty($image_crop['w']) ? array($image_crop['x'], $image_crop['y'], $image_crop['w'], $image_crop['h']) : $image_crop;
			# Might be x,y,w,h OR 0,1,2,3

			# What stretches this is the CROP! (bogus crop coords)

			# We need to figure out how small we're scaling the image since coordinates are relative to FULL image...
			$cropx = !empty($image_crop_list[0]) ? $image_crop_list[0] : null;
			$cropy = !empty($image_crop_list[1]) ? $image_crop_list[1] : null;
			$cropw = !empty($image_crop_list[2]) ? $image_crop_list[2] : null;
			$croph = !empty($image_crop_list[3]) ? $image_crop_list[3] : null;

			# Allow for offset of image lower/higher/etc.
			# These coordinates need to be adjusted, as 0,0 means top left; we REALLY 

			$img = $this->_gd_load_image($image_path, $image_crop_list); 
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
	
					imagecopy($this->canvas, $scaled_img, $box_x, $box_y, $scaled_img_x, $scaled_img_y, $box_w, $box_h);#, $scaled_img_w, $scaled_img_h);
					#imagecopyresampled($this->canvas, $scaled_img, $box_x, $box_y, $scaled_img_x, $scaled_img_y, $box_w, $box_h, $scaled_img_w, $scaled_img_h);
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

					imagecopy($this->canvas, $scaled_img, $box_x, $box_y, 0, 0, $box_w, $box_h);
					#imagecopyresampled($this->canvas, $scaled_img, $box_x, $box_y, 0, 0, $box_w, $box_h, $scaled_img_w, $scaled_img_h);
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
					#	error_log("HERE IS BAD... $imagescale = $img_w/$cropw ; $imagescale * $box_w = new_img_w = $new_img_w, NEW_IMG_H (wrong) = $new_img_w / $img_w2h = $new_img_h");
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

					$align_factor = 3/4; # ratio of top padding to bottom padding.
		
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
	
					$scaled_img = $this->_gd_scale_image($img, $scaled_img_w, $scaled_img_h, empty($main_img));
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

					imagecopy($this->canvas, $scaled_img, $scaled_img_x, $scaled_img_y, 0, 0, $scaled_img_w, $scaled_img_h);
					# imagecopy() plays nicer than imagecopyresampled() with transparent gifs (trans layer)
					#imagecopyresampled($this->canvas, $scaled_img, $scaled_img_x, $scaled_img_y, 0, 0, $scaled_img_w, $scaled_img_h, $scaled_img_w, $scaled_img_h);
					# SCALING the thing messes up transparency...
					# imagecopyresampled is making things blank underneath.
				}
			}
		}
	}

	function _load_image($image_path, $is_custom, $product_config, $cache = false, $build = array(), $top = false)
	{
		$template = !empty($build['template']) ? $build['template'] : null;


		list($prod) = preg_split("/[.]/", basename($image_path));

		$proof_image_x = $proof_image_y = $proof_image_w = $proof_image_h = 0;

		# If we have no personalization and the image can stretch, let it.
		$options = Set::extract($this->load_product_options($build['Product']['code'], false, $build), '{n}.Part.part_code');
		$cant_do_personalization = !in_array('personalization', $options);

		$personalization = !empty($build["options"]["personalizationInput"]) ? $build['options']['personalizationInput'] : '';
		# Only do overlap when fullbleed. But stretch image when no personalization otherwise.
		#
		# dont stretch image if personalization and not fullbleed.)
		$box = 'image';
		if(!empty($product_config['image.nopersonalization']) && 
			(
				!empty($build['options']['personalizationNone']) || $cant_do_personalization || empty($personalization)
			) 
		)
		{
			$this->default_text = false;
			$box = 'image.nopersonalization';
		} else if (!empty($product_config['image'])) {
			$box = 'image';
		}

		$layout_crop = $is_custom ? $this->get_build_crop_coords($template, $product_config, $build, $cache) : null;
		# XXX TODO
		#$bestfit = !empty($layout_crop[4]);
		#
		$bestfit = !empty($build['options']['fullbleed']);
		# Could let product gid default to best fit, but seems buggy.... TODO

		$stretch = false;

		if ($template == 'imageonly' && !empty($product_config['fullbleed'])) # && (!empty($build['fullbleed']) || !empty($build['CustomImage']))) # Only full bleed on custom images, not stamps.
		{
			$box = 'fullbleed';
		} else if ($template == 'imageonly' && !empty($product_config['fullview']))# && (!empty($build['fullbleed']) || !empty($build['CustomImage']))) # Only full bleed on custom images, not stamps.
		{
			$box = 'fullview';
		} else if ($template == 'textonly') { 
			return;
		}
		list($proof_image_x, $proof_image_y, $proof_image_w, $proof_image_h) = $product_config[$box];
		$stretch = $bestfit ? 'stretch' : null; # Make bigger if ratio off, so we don't get whitespace.
		$border_style = $is_custom ? null : "frame";

		# Now get 'cropped' coordinates....
		#print_r($build);
		list ($x,$y) = getimagesize($image_path);


		$this->_insert_graphic($image_path, array($proof_image_x, $proof_image_y, $proof_image_w, $proof_image_h), $border_style, $layout_crop, $stretch, true, $top);

		if($template == 'imageonly' && !empty($product_config['image.nopersonalization.2']) && 
			(
				!empty($build['options']['personalizationNone']) || $cant_do_personalization || empty($personalization)
			) 
		)
		{
			$this->_insert_graphic($image_path, $product_config['image.nopersonalization.2'], $border_style, $layout_crop, $stretch, true, $top);
		} else if ($template == 'imageonly' && !empty($product_config['fullview.2']))
		{
			$this->_insert_graphic($image_path, $product_config['fullview.2'], $border_style, $layout_crop, $stretch, true, $top);
		} else if ($template == 'imageonly' && !empty($product_config['image.2']) && empty($product_config['fullview']))
		{
			$this->_insert_graphic($image_path, $product_config['image.2'], $border_style, $layout_crop, $stretch, true, $top);
		}


		#$color = $this->colorcreate(255,0,0);
		#imagefilledrectangle($this->canvas, $proof_image_x, $proof_image_y, $proof_image_w+$proof_image_x, $proof_image_h+$proof_image_y, $color);
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
		// Output and free from memory
		if (!empty($_REQUEST['plain']) || !empty($_REQUEST['debug']))
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
		header('Pragma: public');
		header('Cache-Control: max-age=0');


		# Should show w/trans here, then means stuff below drops trans.
		#imagepng($final_img);
		#exit(0);

		$w = imagesx($final_img);
		$h = imagesy($final_img);

		if(!empty($_REQUEST['debug']))
		{
			exit(0);
		}

		if ($cache_file)
		{
			$rc = $this->_save_image($final_img, $cache_file);

			#imagepng($final_img); #Save for cache, so dont need to reload every time...
	
			if (!$rc) { error_log("Failed to save cached image $cache_file"); }
	
	
			$img_content = file_get_contents($cache_file);
			echo $img_content;
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
		$template = !empty($build['template']) ? $build['template'] : null;
		$prod = $product['Product']['code'];
		$quote_limit = $product['Product']['quote_limit'];
		$text_x = $text_y = $text_w = $text_h = null;
		$pers_x = $pers_y = $pers_w = $pers_h = null;

		$text_size = 40;

		$this->line_spacing = 1.2; # buffer...
		$this->drop_factor = 1.60;

		$cwd = dirname(__FILE__);
		$this->script_fontfile = "$cwd/lte50517.ttf";
		$this->block_fontfile = "$cwd/lte50070.ttf"; 
		$text_fontfile = $this->block_fontfile;
		$pers_fontfile = (empty($build['options']['personalizationStyle']) || $build['options']['personalizationStyle'] == 'block') ? $this->block_fontfile : $this->script_fontfile;
		$text_size = null;
		$boxname = 'text';
		if ($template == 'textonly') { $boxname = 'fullview'; }

		if(empty($build['options']['charmID']) && !empty($product_config['text.nocharm'])) # ie for PW, use more room for text if no charm in way.
		{
			$boxname = 'text.nocharm';
		}

		if (!empty($product_config[$boxname]))
		{
			list($text_x, $text_y, $text_w, $text_h) = $product_config[$boxname];

			# Place quotation there....
	
			$full_text = ($this->default_text ? "Your wording, quotation or other text here" : "");
			$text_color = 0x888888;
			if (!empty($build['options']['customQuote'])) { $full_text = $build['options']['customQuote']; $text_color = 0x0; }
			#$full_text = '“'.$full_text.'”';

			if (!empty($build['options']['quoteID'])) { 
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
						if (!empty($quote['Quote']['attribution'])) { $full_text .= "\n\n- ".$quote['Quote']['attribution']; }
						$text_color = 0x0;
					}
				}
			}
	
			# ALWAYS CLIP PER PRODUCT LENGTH....
			if($quote_limit > strlen($full_text)) { $full_text = substr($full_text, 0, $quote_limit); }
			$dropcap = true;
			$center = false;

			if(!empty($_REQUEST['centerquote']) || !empty($build['options']['centerQuote']))
			{
				$dropcap = false;
				$center = true;
			}

			if (!$this->fullview)
			{
				$text_size = $this->_put_multiline_text($canvas, $text_fontfile, null, $text_x, $text_y, $text_w, $text_h, $text_color, $full_text, $dropcap, $center);
			}
		}

		$pers_size = intval($text_size*0.75);

		$options = Set::extract($this->load_product_options($product['Product']['code'], false, $build), '{n}.Part.part_code');
		$cant_do_personalization = !in_array('personalization', $options);


		# NOW DO PERSONALIZATION....... (Always even on fullview)
		if (!empty($product_config['personalization']) && !$cant_do_personalization)
		{
			list($pers_x, $pers_y, $pers_w, $pers_h) = $product_config['personalization'];
			#error_log("FV=".$this->fullview.", DT=".$this->default_text.", PN=". (!empty($build['options']['personalizationNone'])?$build['options']['personalizationNone']:""));


			$personalization = !empty($build["options"]["personalizationInput"]) ? $build['options']['personalizationInput'] : (empty($this->fullview) && $this->default_text && empty($build['options']['personalizationNone']) ? "Personalization" : "");
			# Don't show dummy personalization on fullview.

			# Can't show dummy personalization since shows on top of 
			#"Happy Anniversary, October 12th 2009";

			#$personalization = preg_replace("/\n/", " ", $personalization); # Convert newlines to spaces
			# No longer remove newlines. Let them do linebreaks as chosen to look better (ie dates, etc)

			#error_log("BOPT=".print_r($build['options'],true));

			$persColorName = !empty($build['options']['personalizationColor']) ? $build['options']['personalizationColor'] : "black";

			$persColor = 0x000000;
			if($persColorName == 'white') { $persColor = 0xFFFFFF; }

			#imagerectangle($canvas, $pers_x,$pers_y,$pers_x+$pers_w,$pers_y+$pers_h,0xFF0000);


			$pers_color = $prod == 'RL' ? 0xFFFFFF : (!empty($build["options"]["personalizationInput"]) ? $persColor : 0x888888); #$this->white : $this->black;
			$this->_put_multiline_text($canvas, $pers_fontfile, $pers_size, $pers_x, $pers_y, $pers_w, $pers_h, $pers_color, $personalization, false, true, 'middle', ($template == 'imageonly'), false);
		}

		if (!empty($product_config['personalization.2']) && !empty($this->fullview))
		{
			list($pers_x, $pers_y, $pers_w, $pers_h) = $product_config['personalization.2'];

			$personalization = !empty($build["options"]["personalizationInput"]) ? $build['options']['personalizationInput'] : (empty($this->fullview) && $this->default_text && empty($build['options']['personalizationNone']) ? "Personalization" : "");

			$personalization = preg_replace("/\n/", " ", $personalization); # Convert newlines to spaces

			$pers_color = $prod == 'RL' ? 0xFFFFFF : (!empty($build["options"]["personalizationInput"]) ? 0x000000 : 0x888888); #$this->white : $this->black;

			#$this->_put_multiline_text($canvas, $pers_fontfile, $pers_size, $pers_x, $pers_y, $pers_w, $pers_h, $pers_color, $personalization, false, true, 'middle', ($template == 'imageonly'));
			$this->_put_multiline_text($canvas, $pers_fontfile, $pers_size, $pers_x, $pers_y, $pers_w, $pers_h, $pers_color, $personalization, false, true, 'middle', ($template == 'imageonly'), false);
		}

		if (!empty($product_config['personalization.right']))
		# RIGHT JUSTIFIED VERSION INSTEAD...
		{
			list($pers_x, $pers_y, $pers_w, $pers_h) = $product_config['personalization.right'];

			$personalization = !empty($build["options"]["personalizationInput"]) ? $build['options']['personalizationInput'] : "Personalization";
			#"Happy Anniversary, October 12th 2009";

			$personalization = preg_replace("/\n/", " ", $personalization); # Convert newlines to spaces

			$pers_color = $prod == 'RL' ? 0xFFFFFF : 0x000000; #$this->white : $this->black;
			#$this->_put_multiline_text($canvas, $pers_fontfile, intval($text_size*.80), $pers_x, $pers_y, $pers_w, $pers_h, $pers_color, $personalization, false, true, 'bottom');
			#$this->_put_multiline_text($canvas, $pers_fontfile, null, $pers_x, $pers_y, $pers_w, $pers_h, $pers_color, $personalization, false, true, 'bottom');
			$this->_put_multiline_text($canvas, $pers_fontfile, $pers_size, $pers_x, $pers_y, $pers_w, $pers_h, $pers_color, $personalization, false, 'right', 'middle');
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

function imagettfstroketext(&$image, $size, $angle, $x, $y, &$textcolor, &$strokecolor, $fontfile, $text, $px) {

    for($c1 = ($x-abs($px)); $c1 <= ($x+abs($px)); $c1++)
        for($c2 = ($y-abs($px)); $c2 <= ($y+abs($px)); $c2++)
            $bg = imagettftext($image, $size, $angle, $c1, $c2, $strokecolor, $fontfile, $text);

   return imagettftext($image, $size, $angle, $x, $y, $textcolor, $fontfile, $text);
}


	function _put_multiline_text($canvas, $fontfile, $font_size, $text_x, $text_y, $text_w, $text_h, $text_color, $full_text, $do_dropcap = false, $do_center = false, $vert_align = 'top', $do_stroke = false, $autobreak = true)
	{
		$full_text = trim($full_text);
		#$vert_align = 'bottom';
		$text_size = $font_size;
		#$do_center = true;
		###########imagerectangle($this->canvas, $text_x, $text_y, $text_x+$text_w, $text_y+$text_h, $this->grey);

		$min_font_size = 12;
		$max_font_size = $font_size > 0 ? ($font_size >= $min_font_size ? $font_size : $min_font_size) : 40;

		if ($fontfile == $this->script_fontfile) # Since it's smaller...
		{
			#$min_font_size *= 1.5; # Don't screw up if only smaller font works.
			$max_font_size *= 1.5;
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

			list($layer, $layer_content_w, $layer_content_h, $dropcap_filled, $lines, $whitespace_percentage) = $this->_generate_multiline_text($testlayer, $fontfile, $test_font_size, $text_x, $text_y, $text_w, $text_h, $text_color, $full_text, $do_dropcap, $do_center, $do_stroke, $autobreak);


			# This returns height we used so we can properly align vertical middle or bottom align....

			#$fits = ($layer_content_w <= $text_w && $layer_content_h <= $text_h && (!$do_dropcap || $dropcap_filled || $text_done));
			$fits = ($layer_content_w <= $text_w && $layer_content_h <= $text_h);# && (!$do_dropcap || $dropcap_filled || $text_done));
			$font_too_small = ($test_font_size <= $min_font_size); # Just go with.
			$droptest = true;
			$droptest = ($dropcap_filled || $lines <= 1 || !$do_dropcap);

			# ALWAYS try to fill dropcap, so it's not just one word on that line.
			# BUT, if the text is all used up, don't keep on going. Stop.

			$whitespace_limit = 50;


			# If we allow way too much whitespace, then it looks choppy, unprofessional, etc. Try to shrink font until there's a reasonable fill each line.

			if (($fits && $droptest)) # && ($whitespace_percentage < $whitespace_limit || $test_font_size-$font_interval <= $min_font_size)))
			{
				# Middle alignment, vertically...
				$y_offset = 0;
				if ($vert_align == 'middle')
				{
					$y_offset = ($text_h - $layer_content_h)/2;
				} else if ($vert_align == 'bottom') {
					$y_offset = ($text_h - $layer_content_h);
				}

				$x_offset = 0;


				$this->_generate_multiline_text($canvas, $fontfile, $test_font_size, $text_x+$x_offset, $text_y+$y_offset, $text_w, $text_h, $text_color, $full_text, $do_dropcap, $do_center, $do_stroke, $autobreak);
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

		if($font_too_small && !$fits)
		{
			# Start clipping off lines until it fits.
			while(!$fits)
			{
				$full_text = preg_replace("/(\w+\W+)$/", "", $full_text);
				list($layer, $layer_content_w, $layer_content_h, $dropcap_filled, $lines) = $this->_generate_multiline_text($testlayer, $fontfile, $test_font_size, $text_x, $text_y, $text_w, $text_h, $text_color, $full_text, $do_dropcap, $do_center, $do_stroke, $autobreak);
				$fits = ($layer_content_w <= $text_w && $layer_content_h <= $text_h);# && (!$do_dropcap || $dropcap_filled || $text_done));
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
		$lines = 1;
		$left_quote = '"'; $right_quote = '"';

		$fulltext_w = 0;


		$original_font_size = $font_size;
		
		$offset_x = $offset_y = 0;

		$line_height = $this->_get_line_height($fontfile, $font_size); # Get max height for ALL letters.... so all lines even spaced.... 

		$dropcap = null;
		$dropcap_width = $dropcap_height = 0;
		$dropcap_filled = false;
		$text = null;

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
			list ($dropcap_width, $dropcap_height) = $this->_put_text($layer, $line_height*$this->drop_factor, $text_x, $text_y+$line_height*$this->drop_factor, $text_color, $fontfile, $dropcap);
		} else {
			$text = $full_text;
		}

		$lines = $this->_format_words($fontfile, $font_size, $text, $text_w, $autobreak);
		# Split text into lines and words (arrays of arrays)

		$default_offset_dropcap_x = $offset_dropcap_x = $dropcap_width*1.1;

		$offset_x = $offset_h = 0;
		$pos_x = $pos_y = 0;
		$largest_layer_x = 0;

		$linecount = count($lines);


		foreach($lines as $words)
		{
			$is_attrib = false;
			if (preg_match("/^-/", join(" ", $words))) # is an attribution, should right align, etc.
			{
				$font_size = $original_font_size *0.80;
				$is_attrib = true;
				$words[0] = preg_replace("/^-/", "—", $words[0]);
			}
			if(true) { 
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

	
					if ($offset_y > 0 && $offset_y <= $dropcap_height && $line != "")
					{
						$dropcap_filled = true;
					}
	
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
						$offset_y += $line_count*$line_height;
						$linecount++;
					}
	
					# If no room left, abort.
					if ($offset_y >= $text_h) # Can't fit any more lines.
					{
						break;
					}
	
				}
			}

			$offset_y += $line_count*$line_height;

			if ($offset_x > $largest_layer_x) { $largest_layer_x = $offset_x; }
		}
		$layer_x = $offset_x;
		$layer_y = $offset_y;

		$total_size = ($linecount) * $largest_layer_x;
		$whitespace_percentage = $total_size > 0 ? intval( ($total_size - $fulltext_w) / $total_size * 100) : 0;

		return array($layer, $largest_layer_x, $layer_y, $dropcap_filled, $linecount, $whitespace_percentage);
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


		if ($make_trans)
		{
			# Preserve transparency....
			$trans = imagecolortransparent($img);
			imagepalettecopy($img, $newimg);
			imagefill($newimg, 0, 0, $trans);
			imagecolortransparent($newimg, $trans);
			imagetruecolortopalette($newimg, true, 256);
		}

		# ALWAYS DO TRANS ABILITY!
		imagealphablending( $newimg, false );
		imagesavealpha( $newimg, true );

		imagecopyresampled($newimg, $img, 0,0,0,0, $w, $h, $origw, $origh);
		$new_w = imagesx($newimg);
		$new_h = imagesy($newimg);
		return $newimg;
	}


	function get_product_image_path($code, $orient = 'horizontal', $generic = false, $template = '', $transbg = false)
	{
		if ($template && $template != 'standard') { $this->fullview = true; }
		$dir = $this->get_product_image_dir($code, $orient, $this->fullview);
		#if ($template) { $template = "-$template"; }
		if ($this->fullview) { $template = "fullview"; }
		#if (!$orient) { $orient = 'horizontal'; }
		if ($template == 'standard') { $template = ''; }
		$transimg_png = "$dir/original/$code-trans.png";
		$transimg_gif = "$dir/original/$code-trans.gif";
		$transimg = file_exists(APP.$transimg_png) ? $transimg_png : $transimg_gif;

		$srcfile = ($transbg || $this->transbg) ?  $transimg : "$dir/original/$code.png";

		# TOMAS_MALY loading trans.gif broken.
		#
		#
		if ($generic)
		{
			if ($template && $template != 'standard')
			{
				$srcfile = APP."/webroot/images/preview/$code/$orient-$template/generic.png";
			} else {
				$srcfile = APP."/webroot/images/preview/$code/$orient/generic.png";
			}
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

}
?>
