<div class="customerRatings form">
<?php echo $form->create('CustomerRating');?>
	<fieldset>
 		<legend><?php __('Add CustomerRating');?></legend>
	<?php
		echo $form->input('customer_rating_id');
		echo $form->input('name');
		echo $form->input('organization');
		echo $form->input('email');
		echo $form->input('product_rating');
		echo $form->input('service_rating');
		echo $form->input('customer_type_id');
		echo $form->input('permission');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CustomerRatings', true), array('action'=>'index'));?></li>
	</ul>
</div>
