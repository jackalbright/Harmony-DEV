<div>
<h2>Sample Gallery</h2>

	<div>
		<form method="POST" enctype="multipart/form-data" action="/admin/product_sample_images/add/<?= $this->data['Product']['product_type_id'] ?>">
		<?= $form->input('product_sample_image_file',array('type'=>'file','label'=>'Upload File: ')); ?>
		<input type="submit" value="Upload">
		</form>
	</div>

	<?= $this->element("admin/products/pricing_list", array('product_id' =>$this->data['Product']['product_type_id'])); ?>

</div>
