<?
if (empty($class)) { $class = ""; }
if (empty($width)) { $width = 200; }
$products = isset($products['Product']) ? array($products) : $products;
$tabbed = false;
?>

<? $pix = 0; foreach($products as $product) { 
	#echo "P=$pix";	
	$id = $product['Product']['code'].'_gtab_content';
	#$class = 'gtab_content';
	#if ($pix++ == 0) { $class .= " selected_gtab_content"; }

	$gallery_title = "Sample " . ($product['Product']['is_stock_item'] ? $product['Product']['name'] . " Ideas" : $hd->pluralize($product['Product']['name']));
	$productSampleImages = $product['ProductSampleImages'];
	#echo "PSI=".print_r($productSampleImages,true);

	$gallery_title = $hd->pluralize($product['Product']['name']);

	if($product['Product']['is_stock_item'])
	{
		if (count($products) <= 1) # Exclude title if stock and only one.
		{
			$gallery_title = "";
		}
	} else { 
		$gallery_title = "Sample $gallery_title";
	}
?>


<div id="<?=$id?>" class="<?= $class ?>" style="padding-bottom: 20px;">
<div class="grey_border_top"><span></span></div>
<div class="grey_border_sides">
<?
if (!isset($productSampleImages) && isset($product['ProductSampleImages']))
{
	$productSampleImages = $product['ProductSampleImages'];
}
#if (isset($product['Product']))
#{
#	$product = $product['Product'];
#}

$path = "products/".$product['Product']['prod'];

if (!isset($gallery_title)) { $gallery_title = 'Sample Gallery'; }
$pathclass = "image_gallery_" . preg_replace("/\//", "_", $path);

#error_log("P=$path");

#print_r($product);
$file_count = count($productSampleImages);

if ($file_count > 0)
{
	$underpath = preg_replace("/\W+/", "_", $path);
?>
	<div style="padding: 2px;">
	<table style="width: 220px; " class="image_gallery " cellpadding=2 cellspacing=0 border=0>
	<!--
	<tr>
		<td>&nbsp; </td>
		<td colspan=1>
			<h3>Sample <?= ucwords($product['Product']['name']) ?> Gallery</h3>
		</td>
		<td>&nbsp; </td>
	</tr>
	-->
	<? if($file_count > 1) { ?>
	<tr>
		<td align="right" style="width: 50px;">
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_left('<?=$id?>');"><img src="/images/buttons/small/Circle-left.gif"/></a>
		</td>
		<td>
			<b><?= $gallery_title ?></b>
		</td>
		<td align="left" style="width: 50px;">
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_right('<?=$id?>');"><img src="/images/buttons/small/Circle-right.gif"/></a>
		</td>
	</tr>
	<? } ?>
	<tr>
		<td align=center colspan=3>

			<div id="<?= $id ?>_row">
				<? 
				$i = 0;
				foreach($productSampleImages as $image) 
				{ 
					#$hidden = $i++ > 0 ? "hidden" : "";
					$hidden = "";
					#
				?>
				<div class="image <?= $i++ > 0 ? 'hidden' : "" ?>">
				<a class="lightbox image_gallery_scroll_image sample_image_<?=$underpath?>" title="<?= $image['title'] ?>" rel="shadowbox[<?=$underpath?>]" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>">
					<img border="0" width="<?= $width ?>" src="/images/galleries/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>" id="image_gallery_<?=$underpath?>"/>
				</a>
				<br/>
				<a class="lightbox image_gallery_scroll_image sample_image_<?=$underpath?>" title="<?= $image['title'] ?>" rel="shadowbox[<?=$underpath?>]" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>">+ View Larger</a>
				</div>
				<?
				}
				?>
			</div>
		</td>
	</tr>
	<? if($file_count > 1) { ?>
	<tr>
		<td align="right">
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_left('<?=$id?>');"><img src="/images/buttons/small/Circle-left.gif"/></a>
		</td>
		<td width="100"><span id="<?=$id?>_counter">1</span> of <?= $file_count ?></td>
		<td align="left">
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_right('<?=$id?>');"><img src="/images/buttons/small/Circle-right.gif"/></a>
		</td>
	</tr>
	<? } ?>
	</table>
	</div>

<?
}
?>
</div>
<div class="grey_border_bottom"><span></span></div>
</div>

<? } ?>
