<?
if (!isset($image) && isset($build))
{
	$image = $build;
}
$gallery_image = isset($image["GalleryImage"]) ? $image['GalleryImage'] : null;
$custom_image = isset($image["CustomImage"]) ? $image['CustomImage'] : null;

?>
<div class="product product_view">

<table width="100%">
<tr>
	<td valign=top style="width: 200px;">
		<?= $this->element("build/preview", array('build'=>array('Product'=>$product['Product'],'GalleryImage'=>$gallery_image, 'CustomImage'=>$custom_image))); ?>
	</td>
	<td valign=top style="width: 450px;">
		<?= $this->element("products/tabbed_details"); ?>
	</td>
</tr>
<tr>
	<td colspan=2 style="padding-top: 20px;">

<?
$products = array($product);
if (count($related_products) > 0) { 
	$products = array_merge($products, $related_products);
}
echo $hd->product_element("products/sample_gallery_album",$product['Product']['prod'],array('products'=>$products));
?>

	</td>
</tr>
</table>

<br/>




</div>
