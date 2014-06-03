<div class="parts index">
<h2><?php __('Parts');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('part_id');?></th>
	<th><?php echo $paginator->sort('part_name');?></th>
	<th><?php echo $paginator->sort('part_description');?></th>
	<th><?php echo $paginator->sort('sort_index');?></th>
	<th><?php echo $paginator->sort('part_code');?></th>
	<th><?php echo $paginator->sort('part_title');?></th>
	<th><?php echo $paginator->sort('is_step');?></th>
	<th><?php echo $paginator->sort('price');?></th>
	<th><?php echo $paginator->sort('is_feature');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($parts as $part):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $part['Part']['part_id']; ?>
		</td>
		<td>
			<?php echo $part['Part']['part_name']; ?>
		</td>
		<td>
			<?php echo $part['Part']['part_description']; ?>
		</td>
		<td>
			<?php echo $part['Part']['sort_index']; ?>
		</td>
		<td>
			<?php echo $part['Part']['part_code']; ?>
		</td>
		<td>
			<?php echo $part['Part']['part_title']; ?>
		</td>
		<td>
			<?php echo $part['Part']['is_step']; ?>
		</td>
		<td>
			<?php echo $part['Part']['price']; ?>
		</td>
		<td>
			<?php echo $part['Part']['is_feature']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $part['Part']['part_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $part['Part']['part_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $part['Part']['part_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $part['Part']['part_id'])); ?>
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
		<li><?php echo $html->link(__('New Part', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Product Parts', true), array('controller'=> 'product_parts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product Parts', true), array('controller'=> 'product_parts', 'action'=>'add')); ?> </li>
	</ul>
</div>
