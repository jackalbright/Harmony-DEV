<div class="completedArtImages form">
<?php echo $form->create('CompletedArtImage');?>
	<fieldset>
 		<legend><?php __('Add CompletedArtImage');?></legend>
	<?php
		echo $form->input('product_id');
		echo $form->input('name');
		echo $form->input('email');
		echo $form->input('phone');
		echo $form->input('organization');
		echo $form->input('comments');
		echo $form->input('original_path');
		echo $form->input('display_path');
		echo $form->input('thumb_path');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CompletedArtImages', true), array('action' => 'index'));?></li>
	</ul>
</div>
