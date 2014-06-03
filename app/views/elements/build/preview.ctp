<? $this->set("shadowbox",true); ?>
<? if (empty($href)) { $href = ""; } ?>
<div id="" style="position: relative;" class="build_img_container">
<?
	if (!empty($thumb))
	{
		$href = "";
	}
	if(!empty($preview_layout) && empty($template)) { $template = $preview_layout; } # Keep compatibility!
	if (empty($build['template'])) { $build['template'] = ''; }
	if(!empty($layout)) { $template = $layout; }
	$template = !empty($template) ? $template : $build['template'];
	if($template == 'fullbleed' && !empty($build['GalleryImage'])) { $template = 'imageonly'; }
	$template_append = $template;
	if(!preg_match("/^-/", $template_append)) { $template_append = "-$template_append"; }
	if(!isset($fullbleed)) { $fullbleed = isset($build['options']['fullbleed']) ? $build['options']['fullbleed'] : 0; }
	if($template == 'standard') { $fullbleed = 0; }
	#echo "T=$template";
	#echo "L=$live";
	if(!isset($build['grid'])) { $build['grid'] = 0; }
	if(!isset($build['cart'])) { $build['cart'] = 0; }
	# Requires 'Product' and 'CustomImage' or 'GalleryImage' to be set....
	#echo "T=$template";
	#echo "FB=$fullbleed";

	if(!isset($large)) { $large = false; }

	#$prod = null;
	if (isset($build['Product']) && empty($product))
	{
		$product = $build['Product'];
	}
	if(!empty($product['Product'])) { $product = $product['Product']; }

	if (empty($prod) && !empty($build['orig_prod']))
	{
		$prod = $build['orig_prod']; # Since we may have BNT instead of B in Product
	}
	#echo "P=".$build['prod'];
	if (empty($prod) && !empty($product))
	{
		$prod = $product['code'];
	}

	$image_path = null;
	$img_id = "";
	$imgtype = "";
	$image_id = "";
	$catalog_number = "";

	if (isset($build['CustomImage']))
	{
		$image_path = "/app/webroot/".$build['CustomImage']['display_location'];
		$imgtype = "Custom";
		$img_id = $build['CustomImage']['Image_ID'];
		$image_id = $img_id;
	} else if (isset($build['GalleryImage'])) { 
		$image_path = $build['GalleryImage']['image_location'];
		$imgtype = "Gallery";
		$img_id = $build['GalleryImage']['catalog_number'];
		$catalog_number = $img_id;
	}

	# Load include file....
	$base_path = dirname(__FILE__)."/../../../../";

	#echo "IP=$base_path/$image_path";



	#if(!$image_path || !file_exists("$base_path/$image_path"))
	#{
	#	# Load generic 'no image selected' image....
	#	$image_path = "/images/your-image-here.jpg"; # XXX TODO
	#}

	if(!empty($order_item_id))
	{
			if(empty($scale)) { $scale = "-150x150"; }
			?>
				<a href="/product_image/order_view/-900x900.png?order_item_id=<?= $order_item_id?>" rel="shadowbox">
					<img src="/product_image/order_view/<?= $scale ?>.png?order_item_id=<?= $order_item_id ?>" onLoad="setTimeout('hidePleaseWait();', 200);"/>

				</a>
			<?
	}
	else if(!empty($cart_item_id))
	{
			if(empty($scale)) { $scale = "-150x150"; }
			?>
				<? if(empty($build['Product']['is_stock_item']) || !empty($build['options']['customized'])) { ?>
				<a href="/product_image/cart_view/-900x900.png?cart_item_id=<?= $cart_item_id?>" rel="shadowbox">
				<? } ?>
					<img src="/product_image/cart_view/<?= $scale ?>.png?cart_item_id=<?= $cart_item_id ?>"  onLoad="setTimeout('hidePleaseWait();', 200);"/>
				<? if(empty($build['Product']['is_stock_item']) || !empty($build['options']['customized'])) { ?>
				</a>
				<br/>
				<a id="view_larger" rel="shadowbox" style="text-decoration: none !important; " class="view_larger" rel="shadowbox;player=img" href="/product_image/cart_view/-900x900.png?cart_item_id=<?= $cart_item_id ?>">+ View Larger</a>
				<? } ?>
			<?
	}
	else if (!empty($product))
	{
		#echo "BP=$base_path / $image_path ";
		list($photo_w, $photo_h) = getimagesize("$base_path/$image_path");
		$code = $product['code'];
		#if ($code == 'BC') { $code = 'B'; }
		#if ($code == 'PSF') { $code = 'PS'; }
	
		$photo_orient = $orient = $photo_w >= $photo_h ? "horizontal" : "vertical";
		#$other_orient = $photo_orient == "horizontal" ? "vertical" : "horizontal";
		$other_orient = $photo_w >= $photo_h ? "vertical" : "horizontal";

		$parent_code = !empty($parent_codes[$code]) ? $parent_codes[$code] : null;
	
		$relblanksdir = "/images/products/blanks/$code";
		if(!empty($parent_code) && !is_dir(APP."/../$relblanksdir"))
		{
			$relblanksdir = "/images/products/blanks/$parent_code";
		}
		$blanks_dir = "$base_path/$relblanksdir";
	
		$orientation_dir = $orig_orientation_dir = "$base_path/$relblanksdir/$orient";
		$other_orientation_dir = "$base_path/$relblanksdir/$other_orient";

		#echo "ORDIR=$orientation_dir, OTH=$other_orientation_dir; ";

		if(!file_exists($orientation_dir) && file_exists($other_orientation_dir)) {
			$orient = $other_orient;
		}

		$config_file = "$blanks_dir/$orient/original/$code.inc";
		if(!empty($parent_code) && !file_exists($config_file))
		{
			$config_file = "$blanks_dir/$orient/original/$parent_code.inc";
		}
		#error_log("P=$code, OR=$orient, CONFIG=$config_file");
		?>
		<?
		if (!file_exists($config_file))
		{
			# Show generic image....
			if ($product['code'] == 'TA')
			{
				?> <img src="/product_image/tassel/<?= $build['options']['tasselID'] ?>" onLoad="setTimeout('hidePleaseWait();',200);"> <?
			} else if ($product['code'] == 'CH') { 
				?> <img src="/product_image/charm/<?= $build['options']['charmID'] ?>" onLoad="setTimeout('hidePleaseWait();',200);"> <?

			} else {
				?> <img src="/images/products/thumbnail/<?= $product['code'] ?>.png" onLoad="setTimeout('hidePleaseWait();',200);"> <?
			}
		} else {
			#echo "SCALE=$scale, ";
			$size = $large ? "large" : "medium";
			if (!empty($larger)) { $size = "large"; }
			$product_config = include($config_file);
			$product_image = $relblanksdir."/$orient/$size/$code.png";
			$overlay_image = $relblanksdir."/$orient/original/{$code}-overlay.gif";
			if (!file_exists("$base_path/$overlay_image")) { $overlay_image = null; }
	
			#print_r($product_config);
	
			list($product_x, $product_y, $product_w, $product_h) = $product_config['file'];
			list($placeholder_x, $placeholder_y, $placeholder_w, $placeholder_h) = array(0,0,0,0);#$product_config['image'];
			$product_h2w = $product_h / $product_w;

			#error_log("P=$code, PH=$product_h, PW=$product_w");
	
			#if ($product_h < $product_w)
			if ($code == 'RL' || $code == 'PB')
			{
				$large_h = 200;
				$large_w = $large_h / $product_h2w ;
			} else { # portrait image
				$large_w = 350;
				$large_h = $product_h2w * $large_w;
			}
	
			$orig_scaled_product_w = $scaled_product_w = $large ? $large_w : ((!empty($live) || !empty($preview)) ? 270 : 200);
			$orig_scaled_product_h = $scaled_product_h = $product_h2w * $scaled_product_w;

			if (!empty($build['youmightalsolike']))
			{
				$scaled_product_h = 75;
				$scaled_product_w = $scaled_product_h / $product_h2w;

				# Yet don't let width get larger than normal....
				if ($scaled_product_w > $orig_scaled_product_w)
				{
					$scaled_product_w = $orig_scaled_product_w;
					$scaled_product_h = $orig_scaled_product_h;
				}
			} else if (!empty($thumb)) { 
				$scaled_product_h = 125;
				$scaled_product_w = $scaled_product_h / $product_h2w;
			} else if ($build['cart']) {
				$scaled_product_w = 100;
				$scaled_product_h = $scaled_product_w * $product_h2w;
			} else if (!empty($vertical)) {
				$scaled_product_w = 800;
				$scaled_product_h = $scaled_product_w * $product_h2w;

			} else if ($build['grid'])
			{
				$scaled_product_h = 150;
				$scaled_product_w = $scaled_product_h / $product_h2w;

				#error_log("P1=$code, H1=$scaled_product_h, W1=$scaled_product_w, ORIG_W=$orig_scaled_product_w, H2W=$product_h2w");

				# Yet don't let width get larger than normal....
				if ($scaled_product_w > $orig_scaled_product_w)
				{
					$scaled_product_w = $orig_scaled_product_w;
					$scaled_product_h = $scaled_product_w * $product_h2w;
				}
				#error_log("P=$code, H=$scaled_product_h, W=$scaled_product_w");
			} else if (!empty($larger)) {
				$scaled_product_w = 350;
				$scaled_product_h = $scaled_product_w * $product_h2w;


				# Yet don't let width get larger than normal....
				#if ($scaled_product_w > $orig_scaled_product_w)
				#{
				#	$scaled_product_w = $orig_scaled_product_w;
				#	$scaled_product_h = $orig_scaled_product_h;
				#}

			}
			# 
	
			$scaled_full_ratio = $scaled_product_w / $product_w;
	
			$scaled_placeholder_w = ceil($scaled_full_ratio * $placeholder_w);
			$scaled_placeholder_h = ceil($scaled_full_ratio * $placeholder_h);
	
			# Now lets see whether we fit best by width or height....
			$scaled_photo_ratio = $scaled_placeholder_w / $photo_w;
	
			$photo_h2w = $photo_h / $photo_w;
	
			$scaled_photo_h = ceil($scaled_placeholder_w * $photo_h2w);
			$scaled_photo_w = ceil($scaled_photo_h / $photo_h2w);#floor($scaled_photo_h / $photo_h2w);
	
			$border = $large ? 8 : ($build['grid'] || $build['cart'] || !empty($thumb) ? 2 : 4);
	
			$inner_photo_w = $scaled_photo_w - $border*2;
			$inner_photo_h = ceil($inner_photo_w * $photo_h2w);#$scaled_photo_h - $border*2;
	
			if ($scaled_photo_h > $scaled_placeholder_h)
			{
				# Go by height.
				$scaled_photo_h = $scaled_placeholder_h;
				$scaled_photo_w = ceil($scaled_photo_h / $photo_h2w); #floor($scaled_placeholder_w / $photo_h2w);
	
				$inner_photo_h = $scaled_photo_h - $border*2;
				$inner_photo_w = ceil($inner_photo_h / $photo_h2w);#$scaled_photo_h - $border*2;
			}
	
			$placeholder_offset_x = ceil(($scaled_placeholder_w - $scaled_photo_w) / 2);
			$placeholder_offset_y = ceil(($scaled_placeholder_h - $scaled_photo_h) / 2);
	
			$scaled_placeholder_x = ceil($scaled_full_ratio * $placeholder_x) + $placeholder_offset_x;
			$scaled_placeholder_y = ceil($scaled_full_ratio * $placeholder_y) + $placeholder_offset_y;
	
			$img_bg = "#000000";

			$scaled_product_w = ceil($scaled_product_w);
			if(empty($scale)) { $scale = $scaled_product_w; }

			$append = "";

			if (!empty($cart_item_id))
			{
				$preview_path = "/product_image/cart_view";
				$append = "cart_item_id=$cart_item_id&";
			}
			else if (!empty($order_item_id))
			{
				$preview_path = "/product_image/order_view";
				$append = "order_item_id=$order_item_id&";
			}
			else if (!empty($email_view))
			{
				$preview_path = "/product_image/email_view";
			}
			else if (!empty($live))
			{
				$preview_path = "/product_image/build_view";
			} else {
				$preview_path = "/images/preview/$prod$template_append/$imgtype/_$img_id";
			}

			#if (!empty($prod))
			#{
			#	$append .= "&prod=$prod";
			#}
#
			$style = "position: relative; border: solid #CCC 1px !important; padding: 2px;";

			if (!empty($build_link))
			{
				$append .= "new=1&image_id=$image_id&catalog_number=$catalog_number";
			}
			if(!empty($template)) { 
				if ($template == 'fullbleed' || !empty($fullbleed))
				{
					$append .= "&template=imageonly&fullbleed=1";
				} else {
					$append .= "&template=".$template;
				}

			}

			if(!empty($noimage))
			{
				$append .= "&noimage=1";
			}

			if(!empty($build['options_string']))
			{
				$append .= "&".$build['options_string'];
			}
			if(!empty($rotate))
			{
				$append .= "&rotate=$rotate";
			}

			#$fullsize = "-900x650"; # Before.
			$fullsize = "-1500x800";

			?>

			<table cellpadding=0 cellspacing=0>
			<tr>
				<td>
				<? if(!empty($set_layout_link)) { ?>
					<a href="Javascript:void(0)" onClick="setLayout('<?=$template ?>'); ">
						<img title="Live Preview" alt="Loading, please wait...." id="" src="<?= $preview_path ?>/<?= $scale ?>.png?rand=<?= time(); ?>&<?= $append ?>" onDrag="return false;" onDragStart="return false;"  onLoad="setTimeout('hidePleaseWait();', 200);"/>
					</a>
				<? } else if(!empty($build_continue)) { ?>
					<a href="/build/customize">
						<img title="Live Preview" alt="Loading, please wait...." id="build_img" src="<?= $preview_path ?>/<?= $scale ?>.png?rand=<?= time(); ?>&<?= $append ?>" onReadyStateChange="hidePleaseWait();" onLoad="hidePleaseWait();" onDrag="return false;" onDragStart="return false;"/>
					</a>
				<? } else if(!empty($build_link)) { ?>
					<a href="/build/customize?prod=<?= $build['Product']['code'] ?>&<?= $append ?>&start_over=1">
						<img title="Live Preview" alt="Loading, please wait...." id="build_img" src="<?= $preview_path ?>/<?= $scale ?>.png?rand=<?= time(); ?>&<?= $append ?>" onReadyStateChange="hidePleaseWait();" onLoad="hidePleaseWait();" onDrag="return false;" onDragStart="return false;"/>
					</a>
				<? } else if (!empty($order_item_id) && !empty($reorder)) { ?>
					<a href="/build/customize?reorder=true&item_id=<?= $order_item_id ?>">
						<img title="Live Preview" alt="Loading, please wait...." id="build_img" src="<?= $preview_path ?>/<?= $scale ?>.png?rand=<?= time(); ?>&<?= $append ?>" onReadyStateChange="hidePleaseWait();" onLoad="hidePleaseWait();" onDrag="return false;" onDragStart="return false;"/>
					</a>
				<? } else { ?>
					<a class="view_larger" id="view_larger" rel="shadowbox;player=img" href="<?= $preview_path ?>/<?= $fullsize?>.png?rand=<?= time(); ?>&<?= $append ?>">
						<img title="Live Preview" alt="Loading, please wait...." id="build_img" src="<?= $preview_path ?>/<?= $scale ?>.png?rand=<?= time(); ?>&<?= $append ?>" onReadyStateChange="hidePleaseWait();" onLoad="hidePleaseWait();" onDrag="return false;" onDragStart="return false;"/>
					</a>
				<? } ?>
				</td>
			</tr>
			<tr>
				<td align="center" valign="middle">

				<? if(empty($no_view_larger) && empty($thumb) && !$large && !$build['grid'] && empty($build['youmightalsolike'])) { ?>
				<a id="view_larger" style="text-decoration: none !important; " class="view_larger" rel="shadowbox;player=img" href="<?= $preview_path ?>/<?= $fullsize ?>.png?rand=<?= time(); ?>&<?= $append ?>">+ View Larger</a>
				<br/>
				<br/>
				<? } ?>
				<? if(false && !empty($crop) && !empty($build['CustomImage'])) { ?>
				<a id="crop_adjust" class="crop_adjust" rel="shadowbox;width=700;height=600" href="/build/crop/<?= $build['template'] ?>">Crop/Adjust image</a>

				<? } ?>
				<div class="clear"></div>
				
				</td>
			</tr>
			</table>
			<!--
			CONTAINER=<?= $scaled_placeholder_w?>x<?=$scaled_placeholder_h?><br/>
			UNBORDERED_IMG=<?= $scaled_photo_w?>x<?=$scaled_photo_h?><br/>
			IMG=<?= $inner_photo_w?>x<?=$inner_photo_h?><br/>
	
			PHOTO_W2H=<?= $scaled_photo_w ?> x <?=$scaled_photo_h ?> = <?= 1/$photo_h2w ?> ?= <?= $inner_photo_w / $inner_photo_h ?><br/>
			PLACE=<?= $placeholder_x ?>,<?=$placeholder_y?> FULL, SCALED=<?=$scaled_placeholder_x?>,<?= $scaled_placeholder_y?><br/>
			SCALED_PHOTO_H=<?=$scaled_photo_h ?>, PLACE_H=<?= $scaled_placeholder_h ?><br/>
			IMG=<?= $scaled_placeholder_w ?> x <?= $scaled_placeholder_h ?><br/>
			ORIENT=<?= $photo_orient ?><br/>
			INNER_IMG=<?= $inner_photo_w ?> x <?= $inner_photo_h ?><br/>
			PROD=<?= $scaled_product_w ?> x <?= $scaled_product_h ?><br/>
			-->
	
			<?
		}
	} else { # No product...

		?>
		<div style="">
			<? if ($href) { ?><a href="<?= $href ?>"><? } ?>
			<img style="width: 100px;" src="<?= $image_path ?>" onLoad="setTimeout('hidePleaseWait();', 200);"/>
			<? if ($href) { ?></a><? } ?>
		</div>
		<?
	}

?>
<? if(false) { ?>
<? if(!$large && !$build['grid'] && !$build['cart'] && empty($thumb) && empty($build['youmightalsolike']) && empty($hidedisclaimer)) { ?>
<? if(!empty($vertical)) { ?>
<p>Note: Preview above is approximate. Your selected options will appear below.</p>
<? } else { ?>
<p>Note: Preview above is approximate. Your selected options will appear to the right.</p>
<? } ?>
<? }?>
<? } ?>
</div>

<script>
	// BLAH!
	<? if(!empty($build_preview)) { ?>
		if($('crop_adjust'))
		{
        		Shadowbox.setup("a.crop_adjust", {});
		}
        Shadowbox.setup("a.view_larger", {});
	<? } ?>
	/*hidePleaseWait();*/
</script>
