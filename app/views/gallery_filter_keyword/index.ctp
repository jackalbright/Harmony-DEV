<div class="galleryFilterKeyword index">
<h2><?php __('GalleryFilterKeyword');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('filter_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($galleryFilterKeyword as $galleryFilterKeyword):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $galleryFilterKeyword['GalleryFilterKeyword']['filter_id']; ?>
		</td>
		<td>
			<?php echo $galleryFilterKeyword['GalleryFilterKeyword']['name']; ?>
		</td>
		<td>
			<?php echo $galleryFilterKeyword['GalleryFilterKeyword']['description']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $galleryFilterKeyword['GalleryFilterKeyword']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $galleryFilterKeyword['GalleryFilterKeyword']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $galleryFilterKeyword['GalleryFilterKeyword']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $galleryFilterKeyword['GalleryFilterKeyword']['id'])); ?>
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
		<li><?php echo $html->link(__('New GalleryFilterKeyword', true), array('action'=>'add')); ?></li>
	</ul>
</div>
