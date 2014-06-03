<div class="buildEmails form">
<?php echo $form->create('BuildEmail');?>
	<fieldset>
 		<legend><?php __('Add BuildEmail');?></legend>
	<?php
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
		<li><?php echo $html->link(__('List BuildEmails', true), array('action' => 'index'));?></li>
	</ul>
</div>
