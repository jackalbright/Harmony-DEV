<div class="parts form">
<?php echo $form->create('Part');?>
	<fieldset>
 		<legend><?php __('Edit Part');?></legend>
	<?php
		echo $form->input('part_id');
		echo $form->input('part_name');
		echo $form->input('part_description');
		echo $form->input('sort_index');
		echo $form->input('part_code');
		echo $form->input('part_title');
		echo $form->input('is_step');
		echo $form->input('price');
		echo $form->input('is_feature');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Part.part_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Part.part_id'))); ?></li>
		<li><?php echo $html->link(__('List Parts', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Product Parts', true), array('controller'=> 'product_parts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product Parts', true), array('controller'=> 'product_parts', 'action'=>'add')); ?> </li>
	</ul>
</div>
