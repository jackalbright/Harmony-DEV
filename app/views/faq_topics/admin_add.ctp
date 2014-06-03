<div class="faqTopics form">
<?php echo $form->create('FaqTopic');?>
	<fieldset>
 		<legend><?php __('Add FaqTopic');?></legend>
	<?php
		echo $form->input('faq_topic_id');
		echo $form->input('topic_name');
		echo $form->input('enabled',array('checked'=>'checked'));
		#echo $form->input('global_enabled',array('checked'=>'checked'));
		#echo $form->input('product_enabled');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List FaqTopics', true), array('action'=>'index'));?></li>
	</ul>
</div>
