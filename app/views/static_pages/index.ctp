<div class="staticPages index">
<h2><?php __('StaticPages');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('static_page_id');?></th>
	<th><?php echo $paginator->sort('page_name');?></th>
	<th><?php echo $paginator->sort('folder_id');?></th>
	<th><?php echo $paginator->sort('page_title');?></th>
	<th><?php echo $paginator->sort('body_title');?></th>
	<th><?php echo $paginator->sort('meta_desc');?></th>
	<th><?php echo $paginator->sort('meta_keywords');?></th>
	<th><?php echo $paginator->sort('full_width');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($staticPages as $staticPage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $staticPage['StaticPage']['static_page_id']; ?>
		</td>
		<td>
			<?php echo $staticPage['StaticPage']['page_name']; ?>
		</td>
		<td>
			<?php echo $staticPage['StaticPage']['folder_id']; ?>
		</td>
		<td>
			<?php echo $staticPage['StaticPage']['page_title']; ?>
		</td>
		<td>
			<?php echo $staticPage['StaticPage']['body_title']; ?>
		</td>
		<td>
			<?php echo $staticPage['StaticPage']['meta_desc']; ?>
		</td>
		<td>
			<?php echo $staticPage['StaticPage']['meta_keywords']; ?>
		</td>
		<td>
			<?php echo $staticPage['StaticPage']['full_width']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $staticPage['StaticPage']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $staticPage['StaticPage']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $staticPage['StaticPage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $staticPage['StaticPage']['id'])); ?>
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
		<li><?php echo $html->link(__('New StaticPage', true), array('action'=>'add')); ?></li>
	</ul>
</div>
