<div class="savedItems view">
<h2><?php  __('SavedItem');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Saved Item Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $savedItem['SavedItem']['saved_item_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Customer Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $savedItem['SavedItem']['customer_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $savedItem['SavedItem']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Build Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $savedItem['SavedItem']['build_data']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $savedItem['SavedItem']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $savedItem['SavedItem']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit SavedItem', true), array('action'=>'edit', $savedItem['SavedItem']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete SavedItem', true), array('action'=>'delete', $savedItem['SavedItem']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $savedItem['SavedItem']['id'])); ?> </li>
		<li><?php echo $html->link(__('List SavedItems', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New SavedItem', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
