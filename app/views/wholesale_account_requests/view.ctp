<div class="wholesaleAccountRequests view">
<h2><?php  __('WholesaleAccountRequest');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wholesaleAccountRequest['WholesaleAccountRequest']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wholesaleAccountRequest['WholesaleAccountRequest']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Organization'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wholesaleAccountRequest['WholesaleAccountRequest']['organization']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wholesaleAccountRequest['WholesaleAccountRequest']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wholesaleAccountRequest['WholesaleAccountRequest']['phone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Reseller Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wholesaleAccountRequest['WholesaleAccountRequest']['reseller_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wholesaleAccountRequest['WholesaleAccountRequest']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $wholesaleAccountRequest['WholesaleAccountRequest']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit WholesaleAccountRequest', true), array('action' => 'edit', $wholesaleAccountRequest['WholesaleAccountRequest']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete WholesaleAccountRequest', true), array('action' => 'delete', $wholesaleAccountRequest['WholesaleAccountRequest']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $wholesaleAccountRequest['WholesaleAccountRequest']['id'])); ?> </li>
		<li><?php echo $html->link(__('List WholesaleAccountRequests', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New WholesaleAccountRequest', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
