<?
if (empty($class)) { $class = ""; }
if (!empty($width) && empty($size)) { $size = "$width"; }
else if (empty($width) && empty($size)) { $size = "550"; }
$products = isset($products['Product']) ? array($products) : $products;
$tabbed = false;
?>

<? $pix = 0; foreach($products as $product) { 
	#echo "P=$pix";	
	$id = $product['Product']['code'].'_gtab_content';
	#$class = 'gtab_content';
	#if ($pix++ == 0) { $class .= " selected_gtab_content"; }

	$productSampleImages = $product['ProductSampleImages'];
	if (!isset($gallery_title))
	{
		$gallery_title = "Sample " . ($product['Product']['is_stock_item'] ? $product['Product']['name'] . " Ideas" : $hd->pluralize($product['Product']['name']));
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
	}

?>


<div id="<?=$id?>" class="<?= $class ?>" style="">
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
	<div style="">
	<table style="width: 100%; " class="image_gallery " cellpadding=0 cellspacing=0 border=0>
	<!--
	<tr>
		<td>&nbsp; </td>
		<td colspan=1>
			<h3>Sample <?= ucwords($product['Product']['name']) ?> Gallery</h3>
		</td>
		<td>&nbsp; </td>
	</tr>
	-->
	<? if(empty($product['Product']['is_stock_item']) && $gallery_title) { ?>
	<tr>
		<td colspan=3 align="<?= !empty($gallery_title) ? "left" : "center" ?>">
			<? if($gallery_title) { ?><b><?= $gallery_title ?></b> -<? } ?>
		</td>
	</tr>
	<? } ?>
	<tr>
		<td align="right" style="width: 50px;">
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_left('<?=$id?>');"><img src="/images/buttons/small/Circle-left.gif"/></a>
		</td>
		<td align=center colspan=1>

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
				<table border=0 cellpadding=0 cellspacing=0>
				<tr>
					<td rowspan=1 valign="top">
						<a class="lightbox image_gallery_scroll_image sample_image_<?=$underpath?>" title="<?= $image['title'] ?>" rel="shadowbox[<?=$underpath?>]" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>">
							<img border="0" src="/images/galleries/cached/<?= $path ?>/<?= $image['product_image_id'] ?>/<?= $size ?>.<?=$image['file_ext'] ?>" id="image_gallery_<?=$underpath?>"/>
						</a>
					</td>
					<td valign='bottom'>
						<nobr><?= $i ?> of <?= count($productSampleImages); ?></nobr>
						<br/>
						<a class="lightbox" title="<?= $image['title'] ?>" rel="shadowbox[<?=$underpath?>]" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>"><img src="/images/icons/small/zoom.jpg"/></a>
					</td>
				</tr>
				</table>
				</div>
				<?
				}
				?>
			</div>
		</td>
		<td align="left" style="width: 50px;">
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_right('<?=$id?>');"><img src="/images/buttons/small/Circle-right.gif"/></a>
		</td>
	</tr>
	</table>
	</div>

<?
}
?>
</div>

<? } ?>
