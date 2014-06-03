<div class="specialtyPage index">
<h2><?php __('SpecialtyPage');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('specialty_page_id');?></th>
	<th><?php echo $paginator->sort('page_title');?></th>
	<th><?php echo $paginator->sort('body_title');?></th>
	<th><?php echo $paginator->sort('meta_keywords');?></th>
	<th><?php echo $paginator->sort('meta_desc');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($specialtyPages as $specialtyPage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $specialtyPage['SpecialtyPage']['specialty_page_id']; ?>
		</td>
		<td>
			<?php echo $specialtyPage['SpecialtyPage']['page_title']; ?>
		</td>
		<td>
			<?php echo $specialtyPage['SpecialtyPage']['body_title']; ?>
		</td>
		<td>
			<?php echo $specialtyPage['SpecialtyPage']['meta_keywords']; ?>
		</td>
		<td>
			<?php echo $specialtyPage['SpecialtyPage']['meta_desc']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $specialtyPage['SpecialtyPage']['specialty_page_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $specialtyPage['SpecialtyPage']['specialty_page_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $specialtyPage['SpecialtyPage']['specialty_page_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $specialtyPage['SpecialtyPage']['specialty_page_id'])); ?>
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
		<li><?php echo $html->link(__('New SpecialtyPage', true), array('action'=>'add')); ?></li>
	</ul>
</div>
