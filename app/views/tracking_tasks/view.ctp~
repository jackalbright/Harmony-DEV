<div class="trackingTasks view">
<h2><?php  __('TrackingTask');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tracking Task Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingTask['TrackingTask']['tracking_task_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tracking Area'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($trackingTask['TrackingArea']['name'], array('controller'=> 'tracking_areas', 'action'=>'view', $trackingTask['TrackingArea']['tracking_area_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingTask['TrackingTask']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Url'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingTask['TrackingTask']['url']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingTask['TrackingTask']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit TrackingTask', true), array('action'=>'edit', $trackingTask['TrackingTask']['tracking_task_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete TrackingTask', true), array('action'=>'delete', $trackingTask['TrackingTask']['tracking_task_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $trackingTask['TrackingTask']['tracking_task_id'])); ?> </li>
		<li><?php echo $html->link(__('List TrackingTasks', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New TrackingTask', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Tracking Areas', true), array('controller'=> 'tracking_areas', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Area', true), array('controller'=> 'tracking_areas', 'action'=>'add')); ?> </li>
	</ul>
</div>
