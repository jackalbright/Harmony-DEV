<div class="productSampleImage form">
<?php echo $form->create('ProductSampleImage',array('type'=>'file'));?>
	<fieldset>
 		<legend><?php __('Add ProductSampleImage');?></legend>
	<?php
		echo $form->hidden('product_type_id');
		echo $form->input('file',array('type'=>'file','label'=>'Upload File: '));
		echo $form->input('title');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List ProductSampleImage', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Products', true), array('controller'=> 'products', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller'=> 'products', 'action'=>'add')); ?> </li>
	</ul>
</div>
