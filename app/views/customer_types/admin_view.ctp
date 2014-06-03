<div class="customerTypes view">
<h2><?php  __('CustomerType');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Customer Type Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $customerType['CustomerType']['customer_type_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $customerType['CustomerType']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit CustomerType', true), array('action'=>'edit', $customerType['CustomerType']['customer_type_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete CustomerType', true), array('action'=>'delete', $customerType['CustomerType']['customer_type_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $customerType['CustomerType']['customer_type_id'])); ?> </li>
		<li><?php echo $html->link(__('List CustomerTypes', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New CustomerType', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
