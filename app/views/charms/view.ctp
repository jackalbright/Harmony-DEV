<div class="charms view">
<h2><?php  __('Charm');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Charm Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $charm['Charm']['charm_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $charm['Charm']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Graphic Location'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $charm['Charm']['graphic_location']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Available'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $charm['Charm']['available']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Charm', true), array('action'=>'edit', $charm['Charm']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Charm', true), array('action'=>'delete', $charm['Charm']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $charm['Charm']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Charms', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Charm', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
