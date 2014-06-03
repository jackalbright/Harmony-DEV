<div class="trackingAreas form">
<?php echo $form->create('TrackingArea');?>
	<fieldset>
 		<legend><?php __('Edit TrackingArea');?></legend>
	<?php
		echo $form->input('tracking_area_id');
		echo $form->input('name');
		echo $form->input('url');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('TrackingArea.tracking_area_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('TrackingArea.tracking_area_id'))); ?></li>
		<li><?php echo $html->link(__('List TrackingAreas', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Tracking Tasks', true), array('controller'=> 'tracking_tasks', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Task', true), array('controller'=> 'tracking_tasks', 'action'=>'add')); ?> </li>
	</ul>
</div>
