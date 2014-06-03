<div class="updateComments view">
<h2><?php  __('UpdateComment');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $updateComment['UpdateComment']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $updateComment['UpdateComment']['date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Comments'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $updateComment['UpdateComment']['comments']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $updateComment['UpdateComment']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $updateComment['UpdateComment']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit UpdateComment', true), array('action' => 'edit', $updateComment['UpdateComment']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete UpdateComment', true), array('action' => 'delete', $updateComment['UpdateComment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $updateComment['UpdateComment']['id'])); ?> </li>
		<li><?php echo $html->link(__('List UpdateComments', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New UpdateComment', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
