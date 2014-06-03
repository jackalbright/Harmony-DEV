<div class="pageFolders view">
<h2><?php  __('PageFolder');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Folder Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pageFolder['PageFolder']['folder_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Folder Url'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pageFolder['PageFolder']['folder_url']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Folder Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $pageFolder['PageFolder']['folder_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent Folder'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($pageFolder['ParentFolder']['folder_id'], array('controller'=> 'page_folders', 'action'=>'view', $pageFolder['ParentFolder']['folder_id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit PageFolder', true), array('action'=>'edit', $pageFolder['PageFolder']['folder_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete PageFolder', true), array('action'=>'delete', $pageFolder['PageFolder']['folder_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pageFolder['PageFolder']['folder_id'])); ?> </li>
		<li><?php echo $html->link(__('List PageFolders', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New PageFolder', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Page Folders', true), array('controller'=> 'page_folders', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Parent Folder', true), array('controller'=> 'page_folders', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Static Pages', true), array('controller'=> 'static_pages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Pages', true), array('controller'=> 'static_pages', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Page Folders');?></h3>
	<?php if (!empty($pageFolder['ChildFolder'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Folder Id'); ?></th>
		<th><?php __('Folder Url'); ?></th>
		<th><?php __('Folder Name'); ?></th>
		<th><?php __('Parent Folder Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($pageFolder['ChildFolder'] as $childFolder):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $childFolder['folder_id'];?></td>
			<td><?php echo $childFolder['folder_url'];?></td>
			<td><?php echo $childFolder['folder_name'];?></td>
			<td><?php echo $childFolder['parent_folder_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'page_folders', 'action'=>'view', $childFolder['folder_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'page_folders', 'action'=>'edit', $childFolder['folder_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'page_folders', 'action'=>'delete', $childFolder['folder_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $childFolder['folder_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Child Folder', true), array('controller'=> 'page_folders', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Static Pages');?></h3>
	<?php if (!empty($pageFolder['Pages'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Static Page Id'); ?></th>
		<th><?php __('Page Name'); ?></th>
		<th><?php __('Folder Id'); ?></th>
		<th><?php __('Page Title'); ?></th>
		<th><?php __('Body Title'); ?></th>
		<th><?php __('Meta Desc'); ?></th>
		<th><?php __('Meta Keywords'); ?></th>
		<th><?php __('Full Width'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($pageFolder['Pages'] as $pages):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $pages['static_page_id'];?></td>
			<td><?php echo $pages['page_name'];?></td>
			<td><?php echo $pages['folder_id'];?></td>
			<td><?php echo $pages['page_title'];?></td>
			<td><?php echo $pages['body_title'];?></td>
			<td><?php echo $pages['meta_desc'];?></td>
			<td><?php echo $pages['meta_keywords'];?></td>
			<td><?php echo $pages['full_width'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'static_pages', 'action'=>'view', $pages['static_page_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'static_pages', 'action'=>'edit', $pages['static_page_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'static_pages', 'action'=>'delete', $pages['static_page_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pages['static_page_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Pages', true), array('controller'=> 'static_pages', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
