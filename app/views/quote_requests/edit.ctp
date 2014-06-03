<div class="quoteRequests form">
<?php echo $form->create('QuoteRequest');?>
	<fieldset>
 		<legend><?php __('Edit QuoteRequest');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('product_id');
		echo $form->input('quantity');
		echo $form->input('options');
		echo $form->input('comments');
		echo $form->input('name');
		echo $form->input('organization');
		echo $form->input('email');
		echo $form->input('phone');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('QuoteRequest.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('QuoteRequest.id'))); ?></li>
		<li><?php echo $html->link(__('List QuoteRequests', true), array('action' => 'index'));?></li>
	</ul>
</div>
