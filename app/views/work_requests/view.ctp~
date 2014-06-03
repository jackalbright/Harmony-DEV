<div class="workRequests view">
<h2><?php  __('WorkRequest');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Work Request Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['work_request_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['phone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($workRequest['Product']['name'], array('controller'=> 'products', 'action'=>'view', $workRequest['Product']['product_type_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image Location'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['image_location']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Credit Card'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($workRequest['CreditCard']['credit_card_id'], array('controller'=> 'credit_cards', 'action'=>'view', $workRequest['CreditCard']['credit_card_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Billing Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($workRequest['BillingAddress']['Contact_ID'], array('controller'=> 'contact_infos', 'action'=>'view', $workRequest['BillingAddress']['Contact_ID'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Shipping Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($workRequest['ShippingAddress']['Contact_ID'], array('controller'=> 'contact_infos', 'action'=>'view', $workRequest['ShippingAddress']['Contact_ID'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Comments'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workRequest['WorkRequest']['comments']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit WorkRequest', true), array('action'=>'edit', $workRequest['WorkRequest']['work_request_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete WorkRequest', true), array('action'=>'delete', $workRequest['WorkRequest']['work_request_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $workRequest['WorkRequest']['work_request_id'])); ?> </li>
		<li><?php echo $html->link(__('List WorkRequests', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New WorkRequest', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Products', true), array('controller'=> 'products', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller'=> 'products', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Credit Cards', true), array('controller'=> 'credit_cards', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Credit Card', true), array('controller'=> 'credit_cards', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Infos', true), array('controller'=> 'contact_infos', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Billing Address', true), array('controller'=> 'contact_infos', 'action'=>'add')); ?> </li>
	</ul>
</div>
