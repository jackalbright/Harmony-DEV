<div class="galleryImage index">
<h2><?php __('GalleryImage');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('stampID');?></th>
	<th><?php echo $paginator->sort('catalog_number');?></th>
	<th><?php echo $paginator->sort('face_value');?></th>
	<th><?php echo $paginator->sort('issue_date');?></th>
	<th><?php echo $paginator->sort('series');?></th>
	<th><?php echo $paginator->sort('stamp_name');?></th>
	<th><?php echo $paginator->sort('long_description');?></th>
	<th><?php echo $paginator->sort('short_description');?></th>
	<th><?php echo $paginator->sort('keywords');?></th>
	<th><?php echo $paginator->sort('HTML_Keywords');?></th>
	<th><?php echo $paginator->sort('image_location');?></th>
	<th><?php echo $paginator->sort('available');?></th>
	<th><?php echo $paginator->sort('thumbnail_location');?></th>
	<th><?php echo $paginator->sort('country');?></th>
	<th><?php echo $paginator->sort('trivia');?></th>
	<th><?php echo $paginator->sort('filedUnder');?></th>
	<th><?php echo $paginator->sort('notes');?></th>
	<th><?php echo $paginator->sort('reproducible');?></th>
	<th><?php echo $paginator->sort('entry_date');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($galleryImage as $galleryImage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $galleryImage['GalleryImage']['stampID']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['catalog_number']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['face_value']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['issue_date']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['series']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['stamp_name']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['long_description']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['short_description']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['keywords']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['HTML_Keywords']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['image_location']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['available']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['thumbnail_location']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['country']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['trivia']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['filedUnder']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['notes']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['reproducible']; ?>
		</td>
		<td>
			<?php echo $galleryImage['GalleryImage']['entry_date']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $galleryImage['GalleryImage']['stampID'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $galleryImage['GalleryImage']['stampID'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $galleryImage['GalleryImage']['stampID']), null, sprintf(__('Are you sure you want to delete # %s?', true), $galleryImage['GalleryImage']['stampID'])); ?>
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
		<li><?php echo $html->link(__('New GalleryImage', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Gallery Categories', true), array('controller'=> 'gallery_categories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Gallery Categories', true), array('controller'=> 'gallery_categories', 'action'=>'add')); ?> </li>
	</ul>
</div>
