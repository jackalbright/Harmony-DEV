<? if (empty($href)) { $href = ""; } ?>
<div style="position: relative;">
<?
	if(!isset($build['grid'])) { $build['grid'] = 0; }
	if(!isset($build['cart'])) { $build['cart'] = 0; }
	# Requires 'Product' and 'CustomImage' or 'GalleryImage' to be set....

	if(!isset($large)) { $large = false; }

	$prod = null;
	if (isset($build['Product']))
	{
		$product = $build['Product'];
	}

	$image_path = null;

	if (isset($build['CustomImage']))
	{
		$image_path = "/app/webroot/".$build['CustomImage']['display_location'];
	} else if (isset($build['GalleryImage'])) { 
		$image_path = $build['GalleryImage']['image_location'];
	}

	# Load include file....
	$base_path = dirname(__FILE__)."/../../../../";

	#echo "IP=$base_path/$image_path";


	if(!$image_path || !file_exists("$base_path/$image_path"))
	{
		# Load generic 'no image selected' image....
		$image_path = "/images/your-image-here.jpg"; # XXX TODO
	}

	if ($product)
	{
		#echo "BP=$base_path / $image_path ";
		list($photo_w, $photo_h) = getimagesize("$base_path/$image_path");
		$code = $product['code'];
		if ($code == 'BC') { $code = 'B'; }
		if ($code == 'PSF') { $code = 'PS'; }
	
		$photo_orient = $orient = $photo_w > $photo_h ? "horizontal" : "vertical";
		#$other_orient = $photo_orient == "horizontal" ? "vertical" : "horizontal";
		$other_orient = $photo_w > $photo_h ? "vertical" : "horizontal";
	
		$relblanksdir = "/images/products/blanks/$code";
		$blanks_dir = "$base_path/$relblanksdir";
	
		$orientation_dir = $orig_orientation_dir = "$base_path/$relblanksdir/$orient";
		$other_orientation_dir = "$base_path/$relblanksdir/$other_orient";

		#echo "ORDIR=$orientation_dir, OTH=$other_orientation_dir; ";

		if(!file_exists($orientation_dir) && file_exists($other_orientation_dir)) {
			$orient = $other_orient;
		}

		$config_file = "$blanks_dir/$orient/original/$code.inc";
		if (!file_exists($config_file))
		{
			# Show generic image....
			?>
			<img src="/images/products/thumbnail/<?= $product['code'] ?>.jpg">
			<?
		} else {
			$size = $large ? "large" : "medium";
			$product_config = include($config_file);
			$product_image = $relblanksdir."/$orient/$size/$code.png";
			$overlay_image = $relblanksdir."/$orient/original/{$code}-overlay.gif";
			if (!file_exists("$base_path/$overlay_image")) { $overlay_image = null; }
	
			#print_r($product_config);
	
			list($product_x, $product_y, $product_w, $product_h) = $product_config['file'];
			list($placeholder_x, $placeholder_y, $placeholder_w, $placeholder_h) = $product_config['image'];
			$product_h2w = $product_h / $product_w;
	
			#if ($product_h < $product_w)
			if ($code == 'RL')
			{
				$large_h = 200;
				$large_w = $large_h / $product_h2w ;
			} else { # portrait image
				$large_w = 400;
				$large_h = $product_h2w * $large_w;
			}
	
			$orig_scaled_product_w = $scaled_product_w = $large ? $large_w : 200;
			$orig_scaled_product_h = $scaled_product_h = $product_h2w * $scaled_product_w;

			if ($build['grid'] || $build['cart'])
			{
				$scaled_product_h = 150;
				$scaled_product_w = $scaled_product_h / $product_h2w;

				# Yet don't let width get larger than normal....
				if ($scaled_product_w > $orig_scaled_product_w)
				{
					$scaled_product_w = $orig_scaled_product_w;
					$scaled_product_h = $orig_scaled_product_h;
				}
			}

			# 
	
			$scaled_full_ratio = $scaled_product_w / $product_w;
	
			$scaled_placeholder_w = floor($scaled_full_ratio * $placeholder_w);
			$scaled_placeholder_h = floor($scaled_full_ratio * $placeholder_h);
	
			# Now lets see whether we fit best by width or height....
			$scaled_photo_ratio = $scaled_placeholder_w / $photo_w;
	
			$photo_h2w = $photo_h / $photo_w;
	
			$scaled_photo_h = floor($scaled_placeholder_w * $photo_h2w);
			$scaled_photo_w = floor($scaled_photo_h / $photo_h2w);#floor($scaled_photo_h / $photo_h2w);
	
			$border = $large ? 8 : ($build['grid'] || $build['cart'] ? 2 : 4);
	
			$inner_photo_w = $scaled_photo_w - $border*2;
			$inner_photo_h = floor($inner_photo_w * $photo_h2w);#$scaled_photo_h - $border*2;
	
			if ($scaled_photo_h > $scaled_placeholder_h)
			{
				# Go by height.
				$scaled_photo_h = $scaled_placeholder_h;
				$scaled_photo_w = floor($scaled_photo_h / $photo_h2w); #floor($scaled_placeholder_w / $photo_h2w);
	
				$inner_photo_h = $scaled_photo_h - $border*2;
				$inner_photo_w = floor($inner_photo_h / $photo_h2w);#$scaled_photo_h - $border*2;
			}
	
			$placeholder_offset_x = floor(($scaled_placeholder_w - $scaled_photo_w) / 2);
			$placeholder_offset_y = floor(($scaled_placeholder_h - $scaled_photo_h) / 2);
	
			$scaled_placeholder_x = floor($scaled_full_ratio * $placeholder_x) + $placeholder_offset_x;
			$scaled_placeholder_y = floor($scaled_full_ratio * $placeholder_y) + $placeholder_offset_y;
	
			$img_bg = "#000000";
	
			?>
			<div style="position: relative; border: solid #CCC 1px; padding: 2px; width: <?=$scaled_product_w?>px; ">
			<div style="position: relative;">
				<? if($overlay_image) { ?>
				<div style="position: absolute;">
				<? if ($href) { ?><a href="<?= $href ?>"><? } ?>
					<img style="width: <?= $scaled_product_w ?>px;" src="<?= $overlay_image ?>"/>
				<? } ?>
				<? if ($href) { ?></a><? } ?>
				</div>
				<? if ($href) { ?><a href="<?= $href ?>"><? } ?>
				<img style="width: <?= $scaled_product_w ?>px; " src="<?= $product_image ?>"/>
				<? if ($href) { ?></a> <? } ?>
				<div style="background-color: <?=$img_bg?>; position: absolute; width: <?= $inner_photo_w+$border*2 ?>px; height: <?= $inner_photo_h+$border*2?>px; top: <?= $scaled_placeholder_y ?>px; left: <?= $scaled_placeholder_x ?>px;">
						<? if ($href) { ?><a href="<?= $href ?>"><? } ?>
						<img style="position: absolute; left: <?= $border?>px; top: <?=$border?>px; width: <?=$inner_photo_w?>px; height: <?=$inner_photo_h?>px;" src="<?= $image_path ?>"/>
						<? if ($href) { ?></a><? } ?>
				</div>
				<? if(!$large && !$build['grid']) { ?>
				<div align="center">
				<a rel="shadowbox;width=<?= $large_w+25 ?>;height=<?= $large_h+25 ?>;player=iframe" href="/build/product_view_large/<?= $product['code'] ?>?catalogNumber=<?= !empty($build['GalleryImage']) ? $build['GalleryImage']['catalog_number'] : "" ?>&imageID=<?= !empty($build['CustomImage']) ? $build['CustomImage']['Image_ID'] : "" ?>">View Larger</a>
				</div>
				<? } ?>
				<div class="clear"></div>
			</div>
			</div>
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
			<img style="width: 100px;" src="<?= $image_path ?>"/>
		</div>
		<?
	}

?>
</div>
<? if(!$large && !$build['grid'] && !$build['cart']) { ?>
<p>Note: Preview above is approximate. Your selected options will show below.</p>
<? }?>
