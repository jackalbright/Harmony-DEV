<div class="savedItems form">
<?php echo $form->create('SavedItem');?>
	<fieldset>
 		<legend><?php __('Add SavedItem');?></legend>
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
		<li><?php echo $html->link(__('List SavedItems', true), array('action'=>'index'));?></li>
	</ul>
</div>
