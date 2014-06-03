<div class="purchases form">
<?php echo $form->create('Purchase');?>
	<fieldset>
 		<legend><?php __('Edit Purchase');?></legend>
	<?php
		echo $form->input('Order_Date');
		echo $form->input('Order_Status');
		echo $form->input('Shipping_Method');
		echo $form->input('Customer_ID');
		echo $form->input('Shipping_ID');
		echo $form->input('purchase_id');
		echo $form->input('Credit_Card_ID');
		echo $form->input('Billing_ID');
		echo $form->input('Shipping_Cost');
		echo $form->input('order_comment');
		echo $form->input('shipper');
		echo $form->input('tracking_number');
		echo $form->input('request_proof');
		echo $form->input('Charge_Amount');
		echo $form->input('ships_by');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Purchase.purchase_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Purchase.purchase_id'))); ?></li>
		<li><?php echo $html->link(__('List Purchases', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Order Items', true), array('controller'=> 'order_items', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Order Item', true), array('controller'=> 'order_items', 'action'=>'add')); ?> </li>
	</ul>
</div>
