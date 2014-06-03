<div class="trackingTasks form">
<?php echo $form->create('TrackingTask');?>
	<fieldset>
 		<legend><?php __('Edit TrackingTask');?></legend>
	<?php
		echo $form->input('tracking_task_id');
		echo $form->input('tracking_area_id');
		echo $form->input('name');
		echo $form->input('url');
		echo $form->input('sort_index');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('TrackingTask.tracking_task_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('TrackingTask.tracking_task_id'))); ?></li>
		<li><?php echo $html->link(__('List TrackingTasks', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Tracking Areas', true), array('controller'=> 'tracking_areas', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Area', true), array('controller'=> 'tracking_areas', 'action'=>'add')); ?> </li>
	</ul>
</div>
