<div class="faqTopics form">
<?php echo $form->create('FaqTopic');?>
	<fieldset>
 		<legend><?php __('Edit FaqTopic');?></legend>
	<?php
		echo $form->input('faq_topic_id');
		echo $form->input('topic_name');
		echo $form->input('global_enabled');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('FaqTopic.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('FaqTopic.id'))); ?></li>
		<li><?php echo $html->link(__('List FaqTopics', true), array('action'=>'index'));?></li>
	</ul>
</div>
