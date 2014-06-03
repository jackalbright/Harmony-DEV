<div>
<h2>Product Diagram</h2>

	<div>
		<form method="POST" enctype="multipart/form-data">
		<?= $form->input('product_diagram_file',array('type'=>'file','label'=>'Upload File: ')); ?>
		<input type="submit" value="Upload">
		</form>
	</div>
	<div>
		Click to view full size:<br/>
		<a href="/images/view/products/<?= $this->data['Product']['name'] ?>/diagram.jpg">
			<!--<img src="/images/zoom/w=200/products/<?= $this->data['Product']['name'] ?>/diagram.jpg">-->
			<img src="/images/view/products/<?= $this->data['Product']['name'] ?>/diagram.jpg">
		</a>
	</div>

</div>
