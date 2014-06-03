<div class="updateComments form">
<?php echo $ajax->form('add','post',array('model'=>'UpdateComment','update'=>'comments')); ?>
	<fieldset>
 		<legend><?php __('Add UpdateComment');?></legend>
	<?php
		echo $form->input('date');
		echo $form->input('comments');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
