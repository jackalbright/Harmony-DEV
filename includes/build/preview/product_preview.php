<?

# If /images/blanks/$name dir exists....

# IF NO PRODUCT, JUST SHOW IMG....

function product_preview($build = null, $large = false)
{
	if (!$build)
	{
		$build = $_SESSION['Build'];
	}
	$image = null;
	if (isset($build['CustomImage']))
	{
		$image = $build['CustomImage'];
	} else if (isset($build['GalleryImage'])) {
		$image = $build['GalleryImage'];
	} else if (isset($build['catalog_number'])) {
		$image = get_db_record('stamp', array('catalog_number'=>$build['catalog_number']));
	}

	$product = null;
	if (isset($build['Product']))
	{
		$product = $build['Product'];
	} else if (isset($build['code'])) {
		$product = get_db_record('product_type', array('code'=>$build['code']));
	}
	$orientation = get_image_orientation($image, $large);

	$product_name = $product['prod'];

	$code = $product['code'];
	$base_path = dirname(__FILE__)."/../../../images/products/blanks/$code/$orientation";
	if (!is_dir($base_path))
	{
		$other_orientation = ($orientation == 'vertical' ? 'horizontal' : 'vertical');
		$orientation = $other_orientation;
		$base_path = dirname(__FILE__)."/../../../images/products/blanks/$code/$other_orientation";
	} # Default to other orientation

	$path = "/images/products/blanks/$code/$orientation";
	if ($large) { $base_path = "$base_path/large/"; $path = "$path/large/"; }

	# Load flat original to calculate width/height...
	$flat_original = "$base_path/original/$code.png";
	list($width, $height) = get_image_width_height($flat_original);
	if (!$width || !$height)
	{
		$width = 200;
		$height = 200;
	}
	$width += 20;
	$height += 10;

?>
	<div class="center">
		<!--<? if (!$large) { change_links($product, $image); } ?>-->
		<div class="center" style="margin: 0px auto 0px auto;">
			<table border=0 cellpadding=0 cellspacing=0 class="<?= $product['prod'] ?> <?= $product['prod'] ?>_<?= $orientation ?> <?= $orientation ?>" style="border: solid black 1px; background-color: #FFFFFF;">
			<?
				if (($code && is_dir($base_path)))
				{
					$product_file = dirname(__FILE__)."/products/{$product_name}_{$orientation}.php";
					$default_file = dirname(__FILE__)."/products/default_vertical.php";
					if (file_exists($product_file))
					{
						include($product_file);
					} else {
						include($default_file);
					}
				} else {
					#include(dirname(__FILE__)."/products/default_image.php"); # No product specified.
					echo "<tr><td align=center>";
					product_preview_image($image, null, $width/2, $height/2);
					if (!$code)
					{
						echo "<b>NO PRODUCT SPECIFIED</b>";
					}
					echo "</td></tr>";
				}
			?>
			</table>
		</div>
		<!--<a class="hover_underline" rel="shadowbox[width=<?=$width?>;height=<?=$height?>]" href="/build/product_view_large.php">-->
		<? if (!$large) { ?>
		<a class="hover_underline" rel="shadowbox[width=<?=$width?>; height=<?=$height?>" href="/build/product_view_large.php">
			<? view_larger($product, $image); ?>
		</a>
		<? } ?>
	</div>
<?
	product_preview_options($product, $image);
}

function product_preview_image($image, $large = false, $maxw = null, $maxh = null)
{
	# TODO XXX include generic placeholder image!
	if (!$image) { echo "<b>NO IMAGE SELECTED</b>"; return; }
	$name = "";
	$img_url = "";
	#$width = $large ? 200 : 100*.33/.5;
	$width = $large ? 200 : 97;
	#$width = $large ? 160 : 80;
	#$border = $large ? 8 : 4*.33/.5;
	$border = $large ? 8 : 2;
	$base_path = "";

	//print_r($image);

	if (isset($image['Image_ID'])) # Custom image.
	{
		$base_path = dirname(__FILE__)."/../../../app/webroot/";
		$name = $image['Title'];
		$large_img_url = $image['display_location'];
		$thumb_img_url = $image['thumbnail_location'];
	} else { # Stamp
		$base_path = dirname(__FILE__)."/../../../";
		$name = $image['stamp_name'];
		$large_img_url = $image['image_location'];
		$thumb_img_url = $image['thumbnail_location'];
	}
	#echo "NAME=$name";

	if ($large)
	{
		$img_url = $large_img_url;
	} else {
		$img_url = $thumb_img_url;
	}
	list ($imgw, $imgh) = get_image_width_height($image, $large);
	#error_log("IMGW=$imgw, IMGH=$imgh");
	
	$orient = ($imgw > $imgh) ? "horizontal" : "vertical";

	# Stretch by larger side first. If too large for other side, switch.
	$width = $maxw;
	$height = $maxh;

	if ($imgw > $imgh)
	{
		$width = $maxw;
		$height = intval($width * $imgh/$imgw);

		if ($height > $maxh)
		{
			$height = $maxh;
			$width = intval($height * $imgw/$imgh);
		}
	} else {
		$height = $maxh;
		$width = intval($height * $imgw/$imgh);

		if ($width > $maxw)
		{
			$width = $maxw;
			$height = intval($width * $imgh/$imgw);
		}
	}

	#$orientation = get_image_orientation($image);
	$inner_width = ($width - $border*2);
	$inner_height = ($height - $border*2);
	#$orientation_size = $orientation == 'horizontal' ? "width: $size"."px;" : "height: $size"."px;"; 
	#$container_size = $orientation == 'horizontal' ? "width: $width"."px;" : "height: $width"."px;"; 

	$orientation_size = "width: {$inner_width}px; height: {$inner_height}px;";
	$container_size = "width: {$width}px; height: {$height}px;"; 

	# minus 2 pixes on each side for border

	$bgcolor = "#060606";

	?>
	<div style="overflow: hidden; <? #echo $container_size?>;">
	<table style="width: 100%; height: 100%;" border=0 cellpadding=0 cellspacing=0>
		<tr>
		<td valign=middle align=center>
			<img style="padding: <?= $border ?>px; background-color: <?= $bgcolor ?>; <?=$orientation_size?>" id="thumbnail" src="<?= $large_img_url ?>" alt="<?= $name ?>" title="<?= $name ?>" />
		</td>
		</tr>
	</table>
	</div>

	<?
}

function product_preview_options($product, $image)
{
	$build = $_SESSION['Build'];
	$product_id = $product['product_type_id'];
	$options = get_db_records("product_part, part_type", array(array("product_part.part_id = part_type.part_id"), "product_part.product_type_id"=>$product_id));

	foreach($options as $option)
	{
		$option_name = $option['part_code'];
		#print_r($option);
		#echo "OPT=$option_name";
		if (!empty($build['options'][$option_name]))
		{
			$option_preview_function = "option_preview_$option_name";
			if (function_exists($option_preview_function)) { 
			?>
			<div>
			<b><?= $option['part_name'] ?></b>:
				<? $option_preview_function($build['options'][$option_name]); ?>
			</div>
			<?
			}
		}
	}
}

########################## DISPLAYS FOR EACH OPTION.....
function option_preview_tassel($data)
{
	$tassel = get_db_record("tassel", array("tassel_id"=>$data['tasselID']));
	$name = preg_replace("/ /", "-", $tassel['color_name']);
?>
	<img src="/tassels/thumbs/<?= $name ?>.gif"/>
	<br/>
	<?= ucwords($tassel['color_name']) ?>
<?
}

function option_preview_border($data)
{
	$border = get_db_record("border", array("border_id"=>$data['borderID']));
?>
	<img src="<?= $border['location'] ?>"/>
	<br/>
	<?= $border['name'] ?>

<?
}

function option_preview_charm($data)
{
	$charm = get_db_record("charm", array("charm_id"=>$data['charmID']));
?>
	<img src="<?= $charm['graphic_location'] ?>"/>
	<br/>
	<?= $charm['name'] ?>

<?
}



##########################

function product_preview_text($short = false)
{
	return; # For now, exclude content!
?>
<p class="left"><span style="float: left; font-size: 2.0em; font-weight: bold;">Y</span>our quotation, wording, or other text here.</p>
<? if (!$short) { ?>
<p class="center">We can also center your text like this if you prefer.</p>
<? } ?>
<?
}

function product_preview_personalization()
{
	return; # No content.
?>
<div>Personalization</div>
<?
}

function change_links($prod, $img)
{
?>
<div class="right_align">
[ <a href="/products/select?new=1"><? echo ($prod ? "Change" : "Select"); ?> Product</a> ]<br/>
[ <a href="/gallery?new=1"><? echo ($img ? "Change" : "Select"); ?> Image</a> ]
</div>
<br/>
<?
}

function view_larger($prod, $img)
{
?>
<br/>
<div>
+ View Larger
</div>
<?
}

function get_image_width_height($image, $large = false)
{
	if (!is_array($image) && $image != "")
	{
		$path = $image;
	} else {
		if (isset($image['Image_ID'])) # Custom image
		{
			$path = dirname(__FILE__) . "/../../../app/webroot/".
				($large ? $image['display_location'] : $image['thumbnail_location']);
		} else {
			$path = dirname(__FILE__) . "/../../../".
				($large ? $image['image_location'] : $image['thumbnail_location']);
		}
	}
	#error_log("PATH=$path");
	if (!is_file($path))
	{
		return array(null,null);
	}
	return getimagesize($path);
}

function get_image_orientation($image, $large = false)
{
	$orient = 'vertical';
	list($w, $h) = get_image_width_height($image, $large);
	if ($w > $h) { $orient = 'horizontal'; }
	return $orient;
}


?>
