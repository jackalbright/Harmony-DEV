<div class="trackingReleases index">
<h2><?php __('TrackingReleases');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('tracking_release_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($trackingReleases as $trackingRelease):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $trackingRelease['TrackingRelease']['tracking_release_id']; ?>
		</td>
		<td>
			<?php echo $trackingRelease['TrackingRelease']['name']; ?>
		</td>
		<td>
			<?php echo $trackingRelease['TrackingRelease']['description']; ?>
		</td>
		<td>
			<?php echo $trackingRelease['TrackingRelease']['created']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $trackingRelease['TrackingRelease']['tracking_release_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $trackingRelease['TrackingRelease']['tracking_release_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $trackingRelease['TrackingRelease']['tracking_release_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $trackingRelease['TrackingRelease']['tracking_release_id'])); ?>
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
		<li><?php echo $html->link(__('New TrackingRelease', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Tracking Release Tracking Areas', true), array('controller'=> 'tracking_release_tracking_areas', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Release Tracking Area', true), array('controller'=> 'tracking_release_tracking_areas', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Tracking Areas', true), array('controller'=> 'tracking_areas', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Area', true), array('controller'=> 'tracking_areas', 'action'=>'add')); ?> </li>
	</ul>
</div>
