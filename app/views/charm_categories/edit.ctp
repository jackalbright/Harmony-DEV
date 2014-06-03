<div class="charmCategory form">
<?php echo $form->create('CharmCategory');?>
	<fieldset>
 		<legend><?php __('Edit CharmCategory');?></legend>
	<?php
		echo $form->input('charm_category_id');
		echo $form->input('category_name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('CharmCategory.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('CharmCategory.id'))); ?></li>
		<li><?php echo $html->link(__('List CharmCategory', true), array('action'=>'index'));?></li>
	</ul>
</div>
