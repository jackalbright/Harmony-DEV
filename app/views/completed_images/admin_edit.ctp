<div class="completedImages form">
<?php echo $this->Form->create('CompletedImage');?>
	<fieldset>
		<legend><?php __('Admin Edit Completed Image'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('full_name');
		echo $this->Form->input('email');
		echo $this->Form->input('phone');
		echo $this->Form->input('zip_code');
		echo $this->Form->input('company');
		echo $this->Form->input('product_type_id');
		echo $this->Form->input('quantity');
		echo $this->Form->input('proof');
		echo $this->Form->input('needed_by');
		echo $this->Form->input('needed_by_strict');
		echo $this->Form->input('comments');
		echo $this->Form->input('image_size');
		echo $this->Form->input('image_file');
		echo $this->Form->input('image_type');
		echo $this->Form->input('image_ext');
		echo $this->Form->input('image2_size');
		echo $this->Form->input('image2_file');
		echo $this->Form->input('image2_type');
		echo $this->Form->input('image2_ext');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('CompletedImage.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('CompletedImage.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Completed Images', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Products', true), array('controller' => 'products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product', true), array('controller' => 'products', 'action' => 'add')); ?> </li>
	</ul>
</div>
