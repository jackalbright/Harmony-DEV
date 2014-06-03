<div class="trackingReleases form">
<?php echo $form->create('TrackingRelease');?>
	<fieldset>
 		<legend><?php __('Add TrackingRelease');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('description');
		echo $form->input('TrackingArea.TrackingArea');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List TrackingReleases', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Tracking Release Tracking Areas', true), array('controller'=> 'tracking_release_tracking_areas', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Release Tracking Area', true), array('controller'=> 'tracking_release_tracking_areas', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Tracking Areas', true), array('controller'=> 'tracking_areas', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Area', true), array('controller'=> 'tracking_areas', 'action'=>'add')); ?> </li>
	</ul>
</div>
