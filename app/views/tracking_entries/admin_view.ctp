<div class="trackingEntries view">
<h2><?php  __('TrackingEntry');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tracking Entry Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingEntry['TrackingEntry']['tracking_entry_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tracking Area'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($trackingEntry['TrackingArea']['name'], array('controller'=> 'tracking_areas', 'action'=>'view', $trackingEntry['TrackingArea']['tracking_area_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tracking Task'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($trackingEntry['TrackingTask']['name'], array('controller'=> 'tracking_tasks', 'action'=>'view', $trackingEntry['TrackingTask']['tracking_task_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tracking Release'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($trackingEntry['TrackingRelease']['name'], array('controller'=> 'tracking_releases', 'action'=>'view', $trackingEntry['TrackingRelease']['tracking_release_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tracking Visit'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($trackingEntry['TrackingVisit']['tracking_visit_id'], array('controller'=> 'tracking_visits', 'action'=>'view', $trackingEntry['TrackingVisit']['tracking_visit_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Session Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingEntry['TrackingEntry']['session_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Referer'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingEntry['TrackingEntry']['referer']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Referer Qs'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingEntry['TrackingEntry']['referer_qs']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingEntry['TrackingEntry']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ip Address'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingEntry['TrackingEntry']['ip_address']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit TrackingEntry', true), array('action'=>'edit', $trackingEntry['TrackingEntry']['tracking_entry_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete TrackingEntry', true), array('action'=>'delete', $trackingEntry['TrackingEntry']['tracking_entry_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $trackingEntry['TrackingEntry']['tracking_entry_id'])); ?> </li>
		<li><?php echo $html->link(__('List TrackingEntries', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New TrackingEntry', true), array('action'=>'add')); ?> </li>
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
