<div class="customerTypes form">
<?php echo $form->create('CustomerType');?>
	<fieldset>
 		<legend><?php __('Add CustomerType');?></legend>
	<?php
		echo $form->input('customer_type_id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CustomerTypes', true), array('action'=>'index'));?></li>
	</ul>
</div>
