<div class="productPricings form">
<?php echo $form->create('ProductPricing');?>
	<fieldset>
 		<legend><?php __('Add ProductPricing');?></legend>
	<?php
		echo $form->input('pricing_id');
		echo $form->input('product_id');
		echo $form->input('max_quantity');
		echo $form->input('pricing');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List ProductPricings', true), array('action'=>'index'));?></li>
	</ul>
</div>
