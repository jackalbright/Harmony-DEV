<div class="clients form">
<?php echo $form->create('Client');?>
	<fieldset>
 		<legend><?php __('Add Client');?></legend>
	<?php
		echo $form->input('company');
		echo $form->input('name');
		echo $form->input('comments');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Clients', true), array('action'=>'index'));?></li>
	</ul>
</div>
