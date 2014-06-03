<div class="trackingAreas index">
<h2><?php __('TrackingAreas');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('tracking_area_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('url');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($trackingAreas as $trackingArea):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $trackingArea['TrackingArea']['tracking_area_id']; ?>
		</td>
		<td>
			<?php echo $trackingArea['TrackingArea']['name']; ?>
		</td>
		<td>
			<?php echo $trackingArea['TrackingArea']['url']; ?>
		</td>
		<td>
			<?php echo $trackingArea['TrackingArea']['description']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Report', true), array('controller'=>'tracking_entries','action'=>'area_report', $trackingArea['TrackingArea']['url'])); ?>
			<?php echo $html->link(__('View', true), array('action'=>'view', $trackingArea['TrackingArea']['tracking_area_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $trackingArea['TrackingArea']['tracking_area_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $trackingArea['TrackingArea']['tracking_area_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $trackingArea['TrackingArea']['tracking_area_id'])); ?>
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
		<li><?php echo $html->link(__('New TrackingArea', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Tracking Tasks', true), array('controller'=> 'tracking_tasks', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Task', true), array('controller'=> 'tracking_tasks', 'action'=>'add')); ?> </li>
	</ul>
</div>
