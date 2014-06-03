<div class="trackingReleases view">
<h2><?php  __('TrackingRelease');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tracking Release Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingRelease['TrackingRelease']['tracking_release_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingRelease['TrackingRelease']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingRelease['TrackingRelease']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingRelease['TrackingRelease']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit TrackingRelease', true), array('action'=>'edit', $trackingRelease['TrackingRelease']['tracking_release_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete TrackingRelease', true), array('action'=>'delete', $trackingRelease['TrackingRelease']['tracking_release_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $trackingRelease['TrackingRelease']['tracking_release_id'])); ?> </li>
		<li><?php echo $html->link(__('List TrackingReleases', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New TrackingRelease', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Tracking Release Tracking Areas', true), array('controller'=> 'tracking_release_tracking_areas', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Release Tracking Area', true), array('controller'=> 'tracking_release_tracking_areas', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Tracking Areas', true), array('controller'=> 'tracking_areas', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Area', true), array('controller'=> 'tracking_areas', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Tracking Release Tracking Areas');?></h3>
	<?php if (!empty($trackingRelease['TrackingReleaseTrackingArea'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Tracking Release Tracking Area Id'); ?></th>
		<th><?php __('Tracking Release Id'); ?></th>
		<th><?php __('Tracking Area Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($trackingRelease['TrackingReleaseTrackingArea'] as $trackingReleaseTrackingArea):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $trackingReleaseTrackingArea['tracking_release_tracking_area_id'];?></td>
			<td><?php echo $trackingReleaseTrackingArea['tracking_release_id'];?></td>
			<td><?php echo $trackingReleaseTrackingArea['tracking_area_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'tracking_release_tracking_areas', 'action'=>'view', $trackingReleaseTrackingArea['tracking_release_tracking_area_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'tracking_release_tracking_areas', 'action'=>'edit', $trackingReleaseTrackingArea['tracking_release_tracking_area_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'tracking_release_tracking_areas', 'action'=>'delete', $trackingReleaseTrackingArea['tracking_release_tracking_area_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $trackingReleaseTrackingArea['tracking_release_tracking_area_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Tracking Release Tracking Area', true), array('controller'=> 'tracking_release_tracking_areas', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Tracking Areas');?></h3>
	<?php if (!empty($trackingRelease['TrackingArea'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Tracking Area Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Url'); ?></th>
		<th><?php __('Description'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($trackingRelease['TrackingArea'] as $trackingArea):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $trackingArea['tracking_area_id'];?></td>
			<td><?php echo $trackingArea['name'];?></td>
			<td><?php echo $trackingArea['url'];?></td>
			<td><?php echo $trackingArea['description'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'tracking_areas', 'action'=>'view', $trackingArea['tracking_area_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'tracking_areas', 'action'=>'edit', $trackingArea['tracking_area_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'tracking_areas', 'action'=>'delete', $trackingArea['tracking_area_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $trackingArea['tracking_area_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Tracking Area', true), array('controller'=> 'tracking_areas', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
