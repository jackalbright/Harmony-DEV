<div class="trackingLinks form">
<?php echo $form->create('TrackingLink');?>
	<fieldset>
 		<legend><?php __('Edit TrackingLink');?></legend>
	<?php
		echo $form->input('id');
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
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('TrackingLink.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('TrackingLink.id'))); ?></li>
		<li><?php echo $html->link(__('List TrackingLinks', true), array('action' => 'index'));?></li>
	</ul>
</div>
