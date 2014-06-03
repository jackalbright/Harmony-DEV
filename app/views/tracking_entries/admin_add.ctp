<div class="trackingEntries form">
<?php echo $form->create('TrackingEntry');?>
	<fieldset>
 		<legend><?php __('Add TrackingEntry');?></legend>
	<?php
		echo $form->input('tracking_area_id');
		echo $form->input('tracking_task_id');
		echo $form->input('tracking_release_id');
		echo $form->input('tracking_visit_id');
		echo $form->input('session_id');
		echo $form->input('referer');
		echo $form->input('referer_qs');
		echo $form->input('ip_address');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List TrackingEntries', true), array('action'=>'index'));?></li>
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
