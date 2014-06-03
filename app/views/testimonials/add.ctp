<div class="testimonials form">
<?php echo $form->create('Testimonial');?>
	<fieldset>
 		<legend><?php __('Add Testimonial');?></legend>
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
		<li><?php echo $html->link(__('List Testimonials', true), array('action'=>'index'));?></li>
	</ul>
</div>
