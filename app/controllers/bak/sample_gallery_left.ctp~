<?
$products = isset($products['Product']) ? array($products) : $products;
$tabbed = false;
?>

<? $pix = 0; foreach($products as $product) { 
	$id = $product['Product']['code'].'_gtab_content';
	$class = 'gtab_content';
	if ($pix++ == 0) { $class .= " selected_gtab_content"; }

	$gallery_title = "Sample " . ($product['Product']['is_stock_item'] ? $product['Product']['name'] . " Ideas" : $hd->pluralize($product['Product']['name']));
	$productSampleImages = $product['ProductSampleImages'];
	#echo "PSI=".print_r($productSampleImages,true);

	$gallery_title = (!$product['Product']['is_stock_item'] ? "Sample " : "") . $hd->pluralize($product['Product']['name']);
?>


<div id="<?=$id?>" class="" style="padding-bottom: 20px;">
<h4><?= $gallery_title ?></h4>
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
	<div style="padding: 10px;">
	<table style="width: 100%; " class="image_gallery ">
	<!--
	<tr>
		<td>&nbsp; </td>
		<td colspan=1>
			<h3>Sample <?= ucwords($product['Product']['name']) ?> Gallery</h3>
		</td>
		<td>&nbsp; </td>
	</tr>
	-->
	<tr>
		<td align="right">
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_left('<?=$id?>_row');"><img src="/images/buttons/Circle-left.gif" width=""/></a>
		</td>
		<td width="100">&nbsp;</td>
		<td align="left">
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_right('<?=$id?>_row');"><img src="/images/buttons/Circle-right.gif" width=""/></a>
		</td>
	</tr>
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
					<img border="0" width="300" src="/images/galleries/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>" id="image_gallery_<?=$underpath?>"/>
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
	</table>
	</div>

<?
}
?>
</div>

<? } ?>
