<div class="configs form">
<?php echo $form->create('Config');?>
	<fieldset>
 		<legend><?php __('Edit Config');?></legend>
	<?php
		echo $form->input('config_id');
		echo $form->input('name');
		echo $form->input('value');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Config.config_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Config.config_id'))); ?></li>
		<li><?php echo $html->link(__('List Configs', true), array('action'=>'index'));?></li>
	</ul>
</div>
