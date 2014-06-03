<div class="trackingAreas view">
<h2><?php  __('TrackingArea');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tracking Area Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingArea['TrackingArea']['tracking_area_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingArea['TrackingArea']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Url'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingArea['TrackingArea']['url']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $trackingArea['TrackingArea']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit TrackingArea', true), array('action'=>'edit', $trackingArea['TrackingArea']['tracking_area_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete TrackingArea', true), array('action'=>'delete', $trackingArea['TrackingArea']['tracking_area_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $trackingArea['TrackingArea']['tracking_area_id'])); ?> </li>
		<li><?php echo $html->link(__('List TrackingAreas', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New TrackingArea', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Tracking Tasks', true), array('controller'=> 'tracking_tasks', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Task', true), array('controller'=> 'tracking_tasks', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Tracking Tasks');?></h3>
	<?php if (!empty($trackingArea['TrackingTask'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Tracking Task Id'); ?></th>
		<th><?php __('Tracking Area Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Url'); ?></th>
		<th><?php __('Description'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($trackingArea['TrackingTask'] as $trackingTask):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $trackingTask['tracking_task_id'];?></td>
			<td><?php echo $trackingTask['tracking_area_id'];?></td>
			<td><?php echo $trackingTask['name'];?></td>
			<td><?php echo $trackingTask['url'];?></td>
			<td><?php echo $trackingTask['description'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'tracking_tasks', 'action'=>'view', $trackingTask['tracking_task_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'tracking_tasks', 'action'=>'edit', $trackingTask['tracking_task_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'tracking_tasks', 'action'=>'delete', $trackingTask['tracking_task_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $trackingTask['tracking_task_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Tracking Task', true), array('controller'=> 'tracking_tasks', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
