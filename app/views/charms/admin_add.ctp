<div class="charms form">
<?php echo $form->create('Charm');?>
	<fieldset>
 		<legend><?php __('Add Charm');?></legend>
	<?php
		echo $form->input('charm_id');
		echo $form->input('name');
		#echo $form->input('graphic_location');
		echo $form->input('charm_code');
		echo $form->input('available');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Charms', true), array('action'=>'index'));?></li>
	</ul>
</div>
