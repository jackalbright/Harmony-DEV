<div class="productSampleImage form">
<?php echo $form->create('ProductSampleImage',array('url'=>array('action'=>'edit'))); ?>
	<fieldset>
 		<legend><?php __('Edit ProductSampleImage');?></legend>
	<?php
		echo $form->input('product_image_id');
		echo $form->input('product_type_id');
		echo $form->input('title',array('label'=>'Alt Tag'));
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('ProductSampleImage.product_image_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('ProductSampleImage.product_image_id'))); ?></li>
		<li><?php echo $html->link(__('List ProductSampleImage', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Products', true), array('controller'=> 'products', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller'=> 'products', 'action'=>'add')); ?> </li>
	</ul>
</div>
