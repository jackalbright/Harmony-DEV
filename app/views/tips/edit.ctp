<div class="tips form">
<?php echo $form->create('Tip');?>
	<fieldset>
 		<legend><?php __('Edit Tip');?></legend>
	<?php
		echo $form->input('tip_id');
		echo $form->input('tip_code');
		echo $form->input('title');
		echo $form->input('content');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Tip.tip_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Tip.tip_id'))); ?></li>
		<li><?php echo $html->link(__('List Tips', true), array('action'=>'index'));?></li>
	</ul>
</div>
