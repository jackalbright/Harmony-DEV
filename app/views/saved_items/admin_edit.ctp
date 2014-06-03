<div class="savedItems form">
<?php echo $form->create('SavedItem');?>
	<fieldset>
 		<legend><?php __('Edit SavedItem');?></legend>
	<?php
		echo $form->input('saved_item_id');
		echo $form->input('customer_id');
		echo $form->input('name');
		echo $form->input('build_data');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('SavedItem.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('SavedItem.id'))); ?></li>
		<li><?php echo $html->link(__('List SavedItems', true), array('action'=>'index'));?></li>
	</ul>
</div>
