<div class="emailTemplates form">
<?php echo $form->create('EmailTemplate');?>
	<fieldset>
 		<legend><?php __('Edit EmailTemplate');?></legend>
	<?php
		echo $form->input('email_template_id');
		echo $form->input('name');
		echo $form->input('subject');
		echo $form->input('message');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('EmailTemplate.email_template_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('EmailTemplate.email_template_id'))); ?></li>
		<li><?php echo $html->link(__('List EmailTemplates', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Email Messages', true), array('controller'=> 'email_messages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Message', true), array('controller'=> 'email_messages', 'action'=>'add')); ?> </li>
	</ul>
</div>
