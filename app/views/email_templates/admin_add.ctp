<div class="emailTemplates form">
<?php echo $form->create('EmailTemplate');?>
	<fieldset>
 		<legend><?php __('Add EmailTemplate');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('subject');
		echo $form->input('message');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List EmailTemplates', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Email Messages', true), array('controller'=> 'email_messages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Message', true), array('controller'=> 'email_messages', 'action'=>'add')); ?> </li>
	</ul>
</div>
