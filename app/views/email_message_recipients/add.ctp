<div class="emailMessageRecipients form">
<?php echo $form->create('EmailMessageRecipient');?>
	<fieldset>
 		<legend><?php __('Add EmailMessageRecipient');?></legend>
	<?php
		echo $form->input('email_message_id');
		echo $form->input('customer_id');
		echo $form->input('email');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List EmailMessageRecipients', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Email Messages', true), array('controller'=> 'email_messages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Message', true), array('controller'=> 'email_messages', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Customers', true), array('controller'=> 'customers', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Customer', true), array('controller'=> 'customers', 'action'=>'add')); ?> </li>
	</ul>
</div>
