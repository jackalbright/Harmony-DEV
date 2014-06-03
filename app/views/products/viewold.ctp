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
	<td valign=top style="width: 300px;">
		<?
				$products = array($product);
				if (count($related_products) > 0) { 
					$products = array_merge($products, $related_products);
				}
				echo $hd->product_element("products/sample_gallery_left",$product['Product']['prod'],array('products'=>$products));
		?>
	</td>
	<td valign=top style="width: 450px !important;">
		<?= $this->element("products/tabbed_details"); ?>
	</td>
</tr>
</table>

<br/>




</div>
