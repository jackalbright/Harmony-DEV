<div class="testimonials form">
<?php echo $form->create('Testimonial');?>
	<fieldset>
 		<legend><?php __('Edit Testimonial');?></legend>
	<?php
		echo $form->input('testimonial_id');
		echo $form->input('text');
		echo $form->input('attribution');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Testimonial.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Testimonial.id'))); ?></li>
		<li><?php echo $html->link(__('List Testimonials', true), array('action'=>'index'));?></li>
	</ul>
</div>
