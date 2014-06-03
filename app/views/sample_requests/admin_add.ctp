<div class="sampleRequests form">
<?php echo $form->create('SampleRequest');?>
	<fieldset>
 		<legend><?php __('Add SampleRequest');?></legend>
	<?php
		echo $form->input('product_type_id');
		echo $form->input('name');
		echo $form->input('organization');
		echo $form->input('address_1');
		echo $form->input('address_2');
		echo $form->input('city');
		echo $form->input('state');
		echo $form->input('zip_code');
		echo $form->input('email');
		echo $form->input('phone');
		echo $form->input('comments');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List SampleRequests', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
