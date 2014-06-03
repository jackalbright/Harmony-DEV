<div class="productCategories form">
<?php echo $form->create('ProductCategory');?>
	<fieldset>
 		<legend><?php __('Edit ProductCategory');?></legend>
	<?php
		echo $form->input('product_category_id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('ProductCategory.product_category_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('ProductCategory.product_category_id'))); ?></li>
		<li><?php echo $html->link(__('List ProductCategories', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Products', true), array('controller'=> 'products', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller'=> 'products', 'action'=>'add')); ?> </li>
	</ul>
</div>
