<div class="charmCategory view">
<h2><?php  __('CharmCategory');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Charm Category Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $charmCategory['CharmCategory']['charm_category_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Category Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $charmCategory['CharmCategory']['category_name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit CharmCategory', true), array('action'=>'edit', $charmCategory['CharmCategory']['charm_category_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete CharmCategory', true), array('action'=>'delete', $charmCategory['CharmCategory']['charm_category_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $charmCategory['CharmCategory']['charm_category_id'])); ?> </li>
		<li><?php echo $html->link(__('List CharmCategory', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New CharmCategory', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
