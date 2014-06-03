<div class="updateComments form">
<?php echo $form->create('UpdateComment');?>
	<fieldset>
 		<legend><?php __('Edit UpdateComment');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('date');
		echo $form->input('comments');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('UpdateComment.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('UpdateComment.id'))); ?></li>
		<li><?php echo $html->link(__('List UpdateComments', true), array('action' => 'index'));?></li>
	</ul>
</div>
