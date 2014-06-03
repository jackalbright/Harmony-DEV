<div class="parts form">
<?php echo $form->create('Part');?>
	<fieldset>
 		<legend><?php __('Add Part');?></legend>
	<?php
		echo $form->input('part_name');
		echo $form->input('part_summary');
		echo $form->input('part_description');
		echo $form->input('sort_index');
		echo $form->input('part_code');
		echo $form->input('part_title');
		echo $form->input('is_step');
		#echo $form->input('price',array('label'=>'Price/Setup Cost'));
		#echo $form->input('price_each');
		echo $form->input('is_feature');
		echo $form->input('design_tips');
	?>
	</fieldset>
	Save the part to add pricing.
<?php echo $form->end('Save Part');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Parts', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Product Parts', true), array('controller'=> 'product_parts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product Parts', true), array('controller'=> 'product_parts', 'action'=>'add')); ?> </li>
	</ul>
</div>
