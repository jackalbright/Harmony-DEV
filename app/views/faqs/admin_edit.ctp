<div class="faqs form">
<?php echo $form->create('Faq');?>
	<fieldset>
 		<legend><?php __('Edit Question');?></legend>
	<?php
		echo $form->input('faq_id');
		#echo $form->input('faq_topic_id', array('after'=>'&nbsp;<a href="/admin/faq_topics/add">Add Topic</a>'));
		echo $form->input('faq_topic_id', array('empty'=>'None','after'=>'&nbsp;<a href="/admin/faq_topics/add">Add Topic</a>'));
		#echo $form->input('product_type_id',array('empty'=>'None'));
		#echo $form->input('part_id',array('empty'=>'None'));
		echo $form->input('enabled');
		echo $form->input('question',array('class'=>'full_width'));
		echo $form->input('answer');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Faq.faq_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Faq.id'))); ?></li>
		<li><?php echo $html->link(__('List Faqs', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('View Topics', true), array('controller'=>'faq_topics','action'=>'index'));?></li>
	</ul>
</div>