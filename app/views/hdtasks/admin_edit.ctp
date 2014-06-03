<div class="hdtasks form">
<?php echo $form->create('Hdtask');?>
	<fieldset>
 		<legend><?php __('Edit Hdtask');?></legend>
	<?php
		echo $form->input('hdtask_id');
		echo $form->input('title');
		echo $form->input('summary');
		echo $form->input('priority');
		echo $form->input('status');
		echo $form->input('due_date');
		echo $form->input('expected_completion_date');
		echo $form->input('reference');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Hdtask.hdtask_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Hdtask.hdtask_id'))); ?></li>
		<li><?php echo $html->link(__('List Hdtasks', true), array('action'=>'index'));?></li>
	</ul>
</div>
