<hr/>

<? if (!isset($images_per_row)) { $images_per_row = 5; } ?>

<? $width = intval(100 / $images_per_row); ?>

<div class="productSampleImage index productSampleImage_sortable">

<div class="bold left">
	<?= $product['Product']['pricing_name'] ?> Sample Gallery
	| <a rel='shadowbox;width=400;height=500' href="/admin/product_sample_images/add/<?= $product['Product']['product_type_id'] ?>">Upload New Image</a>
</div>
<div class="clear"></div>
<br/>

<div id="productSampleImage_<?= $product['Product']['code'] ?>_sortable">
<?  $i = 0; foreach ($productSampleImages as $productSampleImage) { ?>
	<div class="float_left padded" align="center" id="photo_<?= $productSampleImage['ProductSampleImage']['product_image_id'] ?>" style="width: 150px;">
		<img height="100" src="/images/galleries/cached/products/<?= $product['Product']['prod'] ?>/<?= $productSampleImage['ProductSampleImage']['product_image_id'] ?>/-100x100.<?= $productSampleImage['ProductSampleImage']['file_ext']; ?>">
		<br/>
		<a rel="shadowbox;width=500;height=400" href="/admin/product_sample_images/edit/<?= $productSampleImage['ProductSampleImage']['product_image_id'] ?>">
			<?= empty($productSampleImage['ProductSampleImage']['description']) ? "Edit" : $productSampleImage['ProductSampleImage']['description']; ?>
		</a>
	</div>
<? } ?>
<div class="clear divider">&nbsp;</div>
</div>

<?
echo $ajax->sortable("productSampleImage_{$product['Product']['code']}_sortable", array('tag'=>'div','url'=>"/admin/product_sample_images/resort/$product_id"));
?>

</div>
