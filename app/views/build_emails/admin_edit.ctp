<div class="buildEmails form">
<?php echo $form->create('BuildEmail');?>
	<fieldset>
 		<legend><?php __('Edit BuildEmail');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('your_name');
		echo $form->input('recipient');
		echo $form->input('subject');
		echo $form->input('custom_message');
		echo $form->input('build_data');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('BuildEmail.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('BuildEmail.id'))); ?></li>
		<li><?php echo $html->link(__('List BuildEmails', true), array('action' => 'index'));?></li>
	</ul>
</div>
