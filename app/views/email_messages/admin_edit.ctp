<div class="emailMessages form">
<?php echo $form->create('EmailMessage');?>
	<fieldset>
 		<legend><?php __('Edit EmailMessage');?></legend>
	<?php
		echo $form->input('email_message_id');
		echo $form->input('email_template_id');
		echo $form->input('catalog_number');
		echo $form->input('image_id');
		echo $form->input('layout');
		echo $form->input('custom_message');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('EmailMessage.email_message_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('EmailMessage.email_message_id'))); ?></li>
		<li><?php echo $html->link(__('List EmailMessages', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Email Templates', true), array('controller'=> 'email_templates', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Template', true), array('controller'=> 'email_templates', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Email Message Recipients', true), array('controller'=> 'email_message_recipients', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Message Recipient', true), array('controller'=> 'email_message_recipients', 'action'=>'add')); ?> </li>
	</ul>
</div>
