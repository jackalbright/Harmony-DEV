<div class="faqs form">
<?php echo $form->create('Faq');?>
	<fieldset>
 		<legend><?php __('Edit Faq');?></legend>
	<?php
		echo $form->input('faq_id');
		echo $form->input('faq_topic_id');
		echo $form->input('product_type_id');
		echo $form->input('part_id');
		echo $form->input('enabled');
		echo $form->input('question');
		echo $form->input('answer');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Faq.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Faq.id'))); ?></li>
		<li><?php echo $html->link(__('List Faqs', true), array('action'=>'index'));?></li>
	</ul>
</div>
