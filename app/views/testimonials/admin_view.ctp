<div class="testimonials view">
<h2><?php  __('Testimonial');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Testimonial Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $testimonial['Testimonial']['testimonial_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Text'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $testimonial['Testimonial']['text']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Attribution'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $testimonial['Testimonial']['attribution']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Testimonial', true), array('action'=>'edit', $testimonial['Testimonial']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Testimonial', true), array('action'=>'delete', $testimonial['Testimonial']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $testimonial['Testimonial']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Testimonials', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Testimonial', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
