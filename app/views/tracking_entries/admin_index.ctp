<div class="trackingEntries index">
<h2><?php __('TrackingEntries');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('tracking_entry_id');?></th>
	<th><?php echo $paginator->sort('tracking_area_id');?></th>
	<th><?php echo $paginator->sort('tracking_task_id');?></th>
	<th><?php echo $paginator->sort('tracking_release_id');?></th>
	<th><?php echo $paginator->sort('tracking_visit_id');?></th>
	<th><?php echo $paginator->sort('session_id');?></th>
	<th><?php echo $paginator->sort('ip_address');?></th>
	<th><?php echo $paginator->sort('referer');?></th>
	<th><?php echo $paginator->sort('referer_qs');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($trackingEntries as $trackingEntry):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $trackingEntry['TrackingEntry']['tracking_entry_id']; ?>
		</td>
		<td>
			<?php echo $html->link($trackingEntry['TrackingArea']['name'], array('controller'=> 'tracking_areas', 'action'=>'view', $trackingEntry['TrackingArea']['tracking_area_id'])); ?>
		</td>
		<td>
			<?php echo $html->link($trackingEntry['TrackingTask']['name'], array('controller'=> 'tracking_tasks', 'action'=>'view', $trackingEntry['TrackingTask']['tracking_task_id'])); ?>
		</td>
		<td>
			<?php echo $html->link($trackingEntry['TrackingRelease']['name'], array('controller'=> 'tracking_releases', 'action'=>'view', $trackingEntry['TrackingRelease']['tracking_release_id'])); ?>
		</td>
		<td>
			<?php echo $html->link($trackingEntry['TrackingVisit']['tracking_visit_id'], array('controller'=> 'tracking_visits', 'action'=>'view', $trackingEntry['TrackingVisit']['tracking_visit_id'])); ?>
		</td>
		<td>
			<a href="/admin/tracking_requests/session/<?= $trackingEntry['TrackingEntry']['session_id']; ?>">
			<?= $trackingEntry['TrackingEntry']['session_id']; ?>
			</a>
		</td>
		<td>
			<?php echo $trackingEntry['TrackingEntry']['ip_address']; ?>
		</td>
		<td>
			<?php echo $trackingEntry['TrackingEntry']['referer']; ?>
		</td>
		<td>
			<?php echo $trackingEntry['TrackingEntry']['referer_qs']; ?>
		</td>
		<td>
			<?php echo $trackingEntry['TrackingEntry']['created']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $trackingEntry['TrackingEntry']['tracking_entry_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $trackingEntry['TrackingEntry']['tracking_entry_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $trackingEntry['TrackingEntry']['tracking_entry_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $trackingEntry['TrackingEntry']['tracking_entry_id'])); ?>
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
		<li><?php echo $html->link(__('New TrackingEntry', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Tracking Areas', true), array('controller'=> 'tracking_areas', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Area', true), array('controller'=> 'tracking_areas', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Tracking Tasks', true), array('controller'=> 'tracking_tasks', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Task', true), array('controller'=> 'tracking_tasks', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Tracking Releases', true), array('controller'=> 'tracking_releases', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Release', true), array('controller'=> 'tracking_releases', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Tracking Visits', true), array('controller'=> 'tracking_visits', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Visit', true), array('controller'=> 'tracking_visits', 'action'=>'add')); ?> </li>
	</ul>
</div>