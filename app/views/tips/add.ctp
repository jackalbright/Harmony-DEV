<div class="tips form">
<?php echo $form->create('Tip');?>
	<fieldset>
 		<legend><?php __('Add Tip');?></legend>
	<?php
		echo $form->input('tip_code');
		echo $form->input('title');
		echo $form->input('content');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Tips', true), array('action'=>'index'));?></li>
	</ul>
</div>
