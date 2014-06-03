<div class="pageEmails form">
<?php echo $form->create('PageEmail');?>
	<fieldset>
 		<legend><?php __('Edit PageEmail');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('your_name');
		echo $form->input('recipient');
		echo $form->input('subject');
		echo $form->input('url');
		echo $form->input('custom_message');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('PageEmail.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('PageEmail.id'))); ?></li>
		<li><?php echo $html->link(__('List PageEmails', true), array('action' => 'index'));?></li>
	</ul>
</div>
