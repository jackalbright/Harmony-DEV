<div>
<?= $this->element("admin/products/nav"); ?>
<h3>Product Images:</h3>
<table width="100%">
<tr>
	<td>
		<?= $this->element("admin/image_upload", array('title'=>'Thumbnail','name'=>'thumbnail','caption'=>'(for all related products)','imgfolder'=>'/images/products/thumbnail', 'scaleheight'=>94, 'imgfile'=>$product['Product']['code'].".jpg", 'url'=>'/admin/products/image_upload/'.$product['Product']['product_type_id'], 'no_scale'=>1)); ?>
	</td>
	<td>
		<?= $this->element("admin/image_upload", array('title'=>'Diagram','name'=>'diagram','imgfolder'=>'/images/products/diagram/', 'imgfile'=>$product['Product']['code'].".jpg", 'scalewidth'=>150, 'url'=>'/admin/products/image_upload/'.$product['Product']['product_type_id'])); ?>
	</td>
</tr>
</table>
</div>
