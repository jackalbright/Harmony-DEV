<div class="charms index">
<h2><?php __('Charms');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('charm_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('graphic_location');?></th>
	<th><?php echo $paginator->sort('available');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($charms as $charm):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $charm['Charm']['charm_id']; ?>
		</td>
		<td>
			<?php echo $charm['Charm']['name']; ?>
		</td>
		<td>
			<?php echo $charm['Charm']['graphic_location']; ?>
		</td>
		<td>
			<?php echo $charm['Charm']['available']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $charm['Charm']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $charm['Charm']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $charm['Charm']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $charm['Charm']['id'])); ?>
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
		<li><?php echo $html->link(__('New Charm', true), array('action'=>'add')); ?></li>
	</ul>
</div>
