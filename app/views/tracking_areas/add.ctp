<div class="trackingAreas form">
<?php echo $form->create('TrackingArea');?>
	<fieldset>
 		<legend><?php __('Add TrackingArea');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('url');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List TrackingAreas', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Tracking Tasks', true), array('controller'=> 'tracking_tasks', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Tracking Task', true), array('controller'=> 'tracking_tasks', 'action'=>'add')); ?> </li>
	</ul>
</div>
