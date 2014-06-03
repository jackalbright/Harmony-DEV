<div class="cartItems form">
<?php echo $form->create('CartItem');?>
	<fieldset>
 		<legend><?php __('Add CartItem');?></legend>
	<?php
		echo $form->input('customer_id');
		echo $form->input('quantity');
		echo $form->input('session_id');
		echo $form->input('productCode');
		echo $form->input('unitPrice');
		echo $form->input('parts');
		echo $form->input('comments');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CartItems', true), array('action'=>'index'));?></li>
	</ul>
</div>
