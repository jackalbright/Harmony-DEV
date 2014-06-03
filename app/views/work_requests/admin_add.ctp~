<div class="workRequests form">
<?php echo $form->create('WorkRequest');?>
	<fieldset>
 		<legend><?php __('Add WorkRequest');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('email');
		echo $form->input('phone');
		echo $form->input('product_type_id');
		echo $form->input('quantity');
		echo $form->input('image_location');
		echo $form->input('credit_card_id');
		echo $form->input('billing_id');
		echo $form->input('shipping_id');
		echo $form->input('comments');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List WorkRequests', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Products', true), array('controller'=> 'products', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller'=> 'products', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Credit Cards', true), array('controller'=> 'credit_cards', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Credit Card', true), array('controller'=> 'credit_cards', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Infos', true), array('controller'=> 'contact_infos', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Billing Address', true), array('controller'=> 'contact_infos', 'action'=>'add')); ?> </li>
	</ul>
</div>
