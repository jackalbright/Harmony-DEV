<div class="updateComments form">
<?php echo $ajax->form('add','post',array('update'=>'comments')); ?>
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
