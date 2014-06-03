<div class="tips view">
<h2><?php  __('Tip');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tip Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tip['Tip']['tip_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tip Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tip['Tip']['tip_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tip['Tip']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Content'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tip['Tip']['content']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Tip', true), array('action'=>'edit', $tip['Tip']['tip_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Tip', true), array('action'=>'delete', $tip['Tip']['tip_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tip['Tip']['tip_id'])); ?> </li>
		<li><?php echo $html->link(__('List Tips', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tip', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
