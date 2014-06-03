<div class="productPricings form">
<?php echo $form->create('ProductPricing');?>
	<fieldset>
 		<legend><?php __('Edit ProductPricing');?></legend>
	<?php
		echo $form->input('productCode');
		echo $form->input('quantity');
		echo $form->input('price');
		echo $form->input('price_point_id');
		echo $form->input('product_type_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('ProductPricing.pricing_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('ProductPricing.pricing_id'))); ?></li>
		<li><?php echo $html->link(__('List ProductPricings', true), array('action'=>'index'));?></li>
	</ul>
</div>
