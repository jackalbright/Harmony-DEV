<div class="purchaseSteps form">
<?php echo $form->create('PurchaseStep');?>
	<fieldset>
 		<legend><?php __('Edit PurchaseStep');?></legend>
	<?php
		echo $form->input('purchase_step_id');
		echo $form->input('name');
		echo $form->input('title');
		echo $form->input('text');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('PurchaseStep.purchase_step_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('PurchaseStep.purchase_step_id'))); ?></li>
		<li><?php echo $html->link(__('List PurchaseSteps', true), array('action'=>'index'));?></li>
	</ul>
</div>
