<div class="contactRequests form">
<?php echo $this->Form->create('ContactRequest');?>
	<fieldset>
		<legend><?php __('Admin Add Contact Request'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('phone');
		echo $this->Form->input('email');
		echo $this->Form->input('message');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Contact Requests', true), array('action' => 'index'));?></li>
	</ul>
</div>