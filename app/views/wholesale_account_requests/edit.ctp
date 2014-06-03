<div class="wholesaleAccountRequests form">
<?php echo $form->create('WholesaleAccountRequest');?>
	<fieldset>
 		<legend><?php __('Edit WholesaleAccountRequest');?></legend>
	<?php
		echo $form->input('id');
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
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('WholesaleAccountRequest.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('WholesaleAccountRequest.id'))); ?></li>
		<li><?php echo $html->link(__('List WholesaleAccountRequests', true), array('action' => 'index'));?></li>
	</ul>
</div>
