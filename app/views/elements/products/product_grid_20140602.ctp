<script type="text/javascript" language="javascript">
var session = '<?php echo $_SESSION['myTemp']?>';
console.log("vars from customImages_controller");
console.log(session);
</script>
<?
$email_view = !empty($email_view);

if(empty($options_string)) { $options_string = ''; }
#$layout = !empty($build['template']) ? $build['template'] : 'standard';
$layout = !empty($build['preview_layout']) ? $build['preview_layout'] : 'standard';
if(!isset($live)) { $live = 1; }
if (!isset($image) && isset($build))
{
	$image = $build;
}
$gallery_image = isset($image["GalleryImage"]) ? $image['GalleryImage'] : null;
$custom_image = isset($image["CustomImage"]) ? $image['CustomImage'] : null;

$catalog_number = !empty($image['GalleryImage']) ? $image["GalleryImage"]['catalog_number'] : "";
$image_id = !empty($image['CustomImage']) ? $image["CustomImage"]['Image_ID'] : "";

$image_name = "";
if ($catalog_number)
{
	$image_name = $image['GalleryImage']['stamp_name'];
	$layout = 'standard'; # Always preview standard layout on stamps.
} else if ($image_id) {
	$image_name = $image['CustomImage']['Title'];
}
#if (!$image_id && !$catalog_number) { $live = 0; }

if (empty($items_per_row)) { 
	$items_per_row = 5;
}
?>

<? if(!empty($product_build_link)) { ?>
<table width="100%" cellpadding=0 cellspacing=0>
<tr>
	<td align="left" valign="bottom" width="685">
		<? if(!empty($links)) { ?>
			<?= $links ?>
		<? } ?>

	</td>
	<td valign="bottom" align="right">
		<div class="" style="color: #0369A7;"><?= count($products) ?> products available &mdash; Scroll down to view all</div>
	</td>
</tr>
</table>
<? } ?>

<div class="product_grid">
<? if(isset($a_name)) { ?>
<a name="<?= $a_name ?>"></a>
<? } ?>


<table width="100%" cellpadding=0 cellspacing=0>
<tr>
<td valign="bottom">
<? if(isset($title)) { ?>
<span class="color_steps" style="font-size: 16px;"><?= $title ?></span>
<? } ?>
<? if(!empty($intro)) { ?>
	<span style="color: black; font-size: 12px;">&ndash; <?= $intro ?></span>
<? } ?>
</td>

</tr>
</table>



<div class="clear"></div>
<?php //$items_per_row = -1; // testing ?>
<div class="rounded product_table" style="<?= !empty($bg_color) ? "background-color: $bg_color; " : "" ?>">
<? if($items_per_row == -1) { ?> 
<table style="width: 700px;">
<tr>
	<td style="width: 40px;">
		<a href="Javascript:void(0)" onClick="return image_gallery_scroll_left('product_grid_row');"><img src="/images/buttons/Circle-left.gif"/></a>
	</td>
	<td>
		<div style="width: 600px; overflow: hidden;">
<? } ?>
<table class="" border=1 cellpadding=2 width="100%" cellspacing=0>
	<? 
		if (empty($template)) { $template = 'standard'; }
		if($items_per_row == -1) { ?> <tr id="product_grid_row"> <? } 
		$i = 0; 
		#print_r($products);
		$row = 0;
		$column = 0;
		$base_surcharge = !empty($config['base_stamp_surcharge']) ? $config['base_stamp_surcharge'] : 0;
		$surcharge = !empty($stamp_surcharge) ? $stamp_surcharge['StampSurcharge']['surcharge'] + $base_surcharge : 0;

		for ($i = 0; $i < count($products); $i++)
		{
			$product = $products[$i];
			#$buy_now_url = $product['Product']['is_stock_item'] ? "/details/".$product['Product']['prod'].".php" : "/products/select/".$product['Product']['code']."?catalog_number=".$catalog_number."&image_id=".$image_id;
			$buy_now_url = "/details/".$product['Product']['prod'].".php?catalog_number=$catalog_number&image_id=$image_id";
			if($i % $items_per_row == 0 && $i > 0 && $items_per_row > 0) { ?> </tr> <? $row++; $column = 0; } 
			if($i % $items_per_row == 0 && $items_per_row > 0) { ?> <tr class=""> <? } 
			#$url = isset($details_link) ? "/details/".$product['Product']['prod'].".php" : "/products/select/".$product['Product']['code']."?catalog_number=$catalog_number&image_id=$image_id";
			$min_pricing = 0;
			$max_pricing = 0;

			if(!empty($product['ProductPricing']))
			{
				$pricing_level = !empty($effective_customer['pricing_level']) ? $effective_customer['pricing_level'] : 1;

				foreach($product['ProductPricing'] as $product_pricing)
				{
					# XXX
					if(empty($max_pricing))
					{
						$max_pricing = $product_pricing['price']+$surcharge;
					}

					if($min_pricing <= 0 || $min_pricing > $product_pricing['price']+$surcharge)
					{
						$min_pricing = $product_pricing['price']+$surcharge;
					}

				}
			}
			$fullbleed = 0;
			$l = $layout;
			if($layout == 'fullbleed') { $l = 'imageonly'; $fullbleed = 1; }
			if(!empty($catalog_number)) { $fullbleed = 0; }


			if($l == 'imageonly' && empty($fullbleed) && empty($product['Product']['imageonly']))
			{
				$l = 'imageonly';
				$fullbleed = 1;
			}

			if(!empty($catalog_number))
			{
				$l = 'standard';
			}

			$layout = !empty($_REQUEST['layout']) ? $_REQUEST['layout'] : null;

			#$url = !empty($product_build_link) ? "/build/customize?prod=".$product['Product']['code']."&new=1&image_id=$image_id&catalog_number=$catalog_number&template=$l&start_over=1" : "/details/".$product['Product']['prod'].".php?catalog_number=$catalog_number&image_id=$image_id";
			#$url = !empty($product_build_link) ? "/build/customize?new=1&start_over=1&layout=$layout&catalog_number=$catalog_number&image_id=$image_id&prod=".$product['Product']['code'] : "/details/".$product['Product']['prod'].".php?catalog_number=$catalog_number&image_id=$image_id";
			#####$url = !empty($product_build_link) ? "/build/customize?prod=".$product['Product']['code'] : "/details/".$product['Product']['prod'].".php?catalog_number=$catalog_number&image_id=$image_id";
			$url = !empty($product_build_link) ? ("/products/design/".$product['Product']['code']."?"): "/details/".$product['Product']['prod'].".php?catalog_number=$catalog_number&image_id=$image_id";

			if(!empty($_REQUEST['layout']))
			{
				$options_string .= "&layout=".$_REQUEST['layout'];
			}

			# XXX TODO TOMAS_MALY PASS ALONG PARAMS...
			if(!empty($options_string)) { $url .= "&$options_string"; } #error_log("PARAMS=$options_string"); }

			if(empty($_REQUEST['change'])) # Product not being changed, starting from scratch.
			{
				$url .= "&new=1&image_id=$image_id&catalog_number=$catalog_number&start_over=1";
			}

			error_log("OPTS=$options_string");

			if(!empty($homepage))
			{
				$url = "/details/".$product['Product']['prod'].".php";
			}

			?>
				<td valign=bottom class="image <?= false && !empty($build['Product']) && $build['Product']['code'] == $product['Product']['code'] ? "selected_product" : "" ?>" align=center style="<?= !empty($live) ? "border-bottom: solid #CCC 1px;" : "" ?>">
						<? if($live) { ?>
							<? if(!empty($gallery_image)) { ?>
							<div align="center">
								<?= $this->element("build/preview", array('scale'=>'-125x125', 'href'=>$url, 'layout'=>$l,'build'=>array('Product'=>$product['Product'],'GalleryImage'=>$gallery_image, 'CustomImage'=>$custom_image,'grid'=>1,'template'=>$l,'options_string'=>$options_string),'fullbleed'=>$fullbleed, 'build_link'=>1,'email_view'=>$email_view)); ?>
							</div>
							<? } else { ?>
							<div align="center" style="height: 110px; text-align: center;">
							<table width="100%" height="100%"> <tr> <td valign="middle">
							<?
								$blankProd = $product['Product']['code'];
								if(in_array($blankProd, array('BC'))) { $blankProd = 'B'; }
								if(in_array($blankProd, array('PSF'))) { $blankProd = 'PS'; }
								$blankdir = "/images/products/blanks/{$blankProd}";
								$vimg = is_dir(APP."/../$blankdir/vertical-fullview") ? 
									"$blankdir/vertical-fullview/small/{$blankProd}.png" :
									"$blankdir/vertical/small/{$blankProd}.png";

								$himg = is_dir(APP."/../$blankdir/horizontal-fullview") ? 
									"$blankdir/horizontal-fullview/small/{$blankProd}.png" :
									"$blankdir/horizontal/small/{$blankProd}.png";
								$img = file_exists(APP."/..".$himg) ? $himg : $vimg;

							?>
								<!--<a href="/build/customize?prod=<?=$product['Product']['code'] ?>&<?= $options_string ?>"><img src="<?= $img ?>"/></a>-->
                                 <a href="<?php echo $url?>"><img src="<?= $img ?>"/></a>
							</td></tr></table>
							</div>
							<? } ?>
							<div class="clear"></div>
						<? } else if (isset($product_build_link)) { ?>
							<a class="" href="/products/select/<?= $product['Product']['code']?>?catalog_number=<?=$catalog_number?>">
							<img src="/images/products/thumbnail/<?= $product['Product']['code'] ?>.png" title="<?= $product['Product']['name'] ?>" alt="<?= $product['Product']['name'] ?>"></a>
							<br/>

						<? } else { ?>
							<a class="" href="/details/<?= $product['Product']['prod']?>.php">
							<img src="/images/products/thumbnail/<?= $product['Product']['code'] ?>.png" alt="<?= $product['Product']['name'] ?>" title="<?= $product['Product']['name'] ?>"></a>
							<br/>
						<? } ?>
						<?
							$name = $product['Product']['short_name'] ? $hd->pluralize($product['Product']['short_name']) : $hd->pluralize($product['Product']['name']);

							#if (preg_match("/custom/", $product['Product']['image_type']) && !preg_match("/Custom/i", $name) && !$product['Product']['is_stock_item'])
							#{
							#	$name = "Custom $name";$product['Product']['code']
							#}

							if (!empty($image_name) && !empty($live))
							{
								#$name = preg_replace("/Custom /", "", $name);
								#$name = '"' . $image_name . '" ' . $name;
							}
							

						?>
						<a class="" href="<?= $url ?>"><?= preg_replace("/^Custom /", "Custom<br/>", $name) ?></a>
							<br/>
							<br/>
							<? if((!empty($details) || !empty($show_pricing)) && $min_pricing > 0) { ?>
							<div style="color: #333; font-weight: bold;">Price <?= sprintf("$%.02f - $%.02f", $min_pricing, $max_pricing); ?> ea</div>
							<div>Minimum: <?= $product['Product']['minimum'] ?></div>
							<? } ?>
					<? if(empty($email_view) && !empty($live) && empty($no_view_larger)) { echo $this->element("products/view_larger_link", array('prod'=>$product['Product']['code'],'image'=>$image,'template'=>(!empty($preview_layout) ? "-$preview_layout" : ""))); } ?>
					<? if (isset($product_build_link) && !$live) { ?>
						<!--
						<br/>
						[<a class="" href="/details/<?= $product['Product']['prod']?>.php">more info</a>]
						<br/>
						<br/>
						-->
						<form method="GET" action="/products/select/<?= $product['Product']['code'] ?>">
							<input type="hidden" name="catalog_number" value="<?=$catalog_number?>"/>
							<input type="hidden" name="image_id" value="<?=$image_id?>"/>
							<input type="submit" value="Create Product &raquo;">
						</form>

					<? } ?>
				</td>
			<?
		}

	if($items_per_row == -1) { ?> </tr> <? } 
	?>

</table>
	<? if(isset($link_href)) { ?>
		<div class="right_align">
			<a href="<?= $link_href ?>"><?= isset($link_label) ? $link_label : "View more..." ?></a>
		</div>
	<? } ?>
<? if($items_per_row == -1) { ?> 
		</div>
	</td>
	<td style="width: 40px;">
		<a href="Javascript:void(0)" onClick="return image_gallery_scroll_right('product_grid_row');"><img src="/images/buttons/Circle-right.gif"/></a>
	</td>
</tr>
</table>
<? } ?>
</div>

</div>
