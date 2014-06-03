<div class="wholesaleAccountRequests form">
<?php echo $form->create('WholesaleAccountRequest');?>
	<fieldset>
 		<legend><?php __('Add WholesaleAccountRequest');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('organization');
		echo $form->input('email');
		echo $form->input('phone');
		echo $form->input('reseller_number');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List WholesaleAccountRequests', true), array('action' => 'index'));?></li>
	</ul>
</div>
