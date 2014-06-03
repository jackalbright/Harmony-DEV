<div class="purchaseSteps form">
<?php echo $form->create('PurchaseStep');?>
	<fieldset>
 		<legend><?php __('Add PurchaseStep');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('title');
		echo $form->input('text');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List PurchaseSteps', true), array('action'=>'index'));?></li>
	</ul>
</div>
