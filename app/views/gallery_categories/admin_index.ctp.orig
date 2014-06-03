<div class="galleryCategory index">
<h2><?php __('GalleryCategories');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('browse_node_id');?></th>
	<th><?php echo $paginator->sort('browse_name');?></th>
	<th><?php echo $paginator->sort('parent_node');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($galleryCategories as $galleryCategory):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $galleryCategory['GalleryCategory']['browse_node_id']; ?>
		</td>
		<td>
			<?php echo $galleryCategory['GalleryCategory']['browse_name']; ?>
		</td>
		<td>
			<?php echo $html->link($galleryCategory['ParentCategory']['browse_node_id'], array('controller'=> 'gallery_categories', 'action'=>'view', $galleryCategory['ParentCategory']['browse_node_id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $galleryCategory['GalleryCategory']['browse_node_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $galleryCategory['GalleryCategory']['browse_node_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $galleryCategory['GalleryCategory']['browse_node_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $galleryCategory['GalleryCategory']['browse_node_id'])); ?>
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
		<li><?php echo $html->link(__('New GalleryCategory', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Gallery Categories', true), array('controller'=> 'gallery_categories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Parent Category', true), array('controller'=> 'gallery_categories', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Gallery Images', true), array('controller'=> 'gallery_images', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Gallery Image', true), array('controller'=> 'gallery_images', 'action'=>'add')); ?> </li>
	</ul>
</div>
