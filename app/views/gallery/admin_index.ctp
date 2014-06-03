<div class="gallery index">
<h2><?php __('Gallery');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($galleries as $gallery):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $gallery['GalleryCategory'][''])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $gallery['GalleryCategory'][''])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $gallery['GalleryCategory']['']), null, sprintf(__('Are you sure you want to delete # %s?', true), $gallery['GalleryCategory'][''])); ?>
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
		<li><?php echo $html->link(__('New Gallery', true), array('action'=>'add')); ?></li>
	</ul>
</div>
