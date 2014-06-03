<div class="trackingLinks form">
<?php echo $form->create('TrackingLink');?>
	<fieldset>
 		<legend><?php __('Add TrackingLink');?></legend>
	<?php
		echo $form->input('referer');
		echo $form->input('url');
		echo $form->input('name');
		echo $form->input('x');
		echo $form->input('y');
		echo $form->input('session_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List TrackingLinks', true), array('action' => 'index'));?></li>
	</ul>
</div>
