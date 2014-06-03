<div class="pageFolders index">
<h2><?php __('PageFolders');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('folder_id');?></th>
	<th><?php echo $paginator->sort('folder_url');?></th>
	<th><?php echo $paginator->sort('folder_name');?></th>
	<th><?php echo $paginator->sort('parent_folder_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($pageFolders as $pageFolder):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $pageFolder['PageFolder']['folder_id']; ?>
		</td>
		<td>
			<?php echo $pageFolder['PageFolder']['folder_url']; ?>
		</td>
		<td>
			<?php echo $pageFolder['PageFolder']['folder_name']; ?>
		</td>
		<td>
			<?php echo $html->link($pageFolder['ParentFolder']['folder_id'], array('controller'=> 'page_folders', 'action'=>'view', $pageFolder['ParentFolder']['folder_id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $pageFolder['PageFolder']['folder_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $pageFolder['PageFolder']['folder_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $pageFolder['PageFolder']['folder_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pageFolder['PageFolder']['folder_id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New PageFolder', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Page Folders', true), array('controller'=> 'page_folders', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Parent Folder', true), array('controller'=> 'page_folders', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Static Pages', true), array('controller'=> 'static_pages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Pages', true), array('controller'=> 'static_pages', 'action'=>'add')); ?> </li>
	</ul>
</div>
