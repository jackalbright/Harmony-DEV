<div class="updateComments form">
<?php echo $form->create('UpdateComment');?>
	<fieldset>
 		<legend><?php __('Add UpdateComment');?></legend>
	<?php
		echo $form->input('date');
		echo $form->input('comments');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List UpdateComments', true), array('action' => 'index'));?></li>
	</ul>
</div>
