<div class="faqTopics form">
<?php echo $form->create('FaqTopic');?>
	<fieldset>
 		<legend><?php __('Edit FaqTopic');?></legend>
	<?php
		echo $form->input('faq_topic_id');
		echo $form->input('topic_name');
		echo $form->input('enabled');
		#echo $form->input('global_enabled');
		#echo $form->input('product_enabled');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('FaqTopic.faq_topic_id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('FaqTopic.faq_topic_id'))); ?></li>
		<li><?php echo $html->link(__('List FaqTopics', true), array('action'=>'index'));?></li>
	</ul>
</div>

<div>
<h4>FAQs</h4>


<? foreach($this->data['Faq'] as $faq) { ?>
<ol>
	<li>
	<a href="/admin/faqs/edit/<?= $faq['faq_id'] ?>"><?= $faq['question'] ?></a>
</ol>
<? } ?>
<br/>
<div class="left_align">
<a href="/admin/faqs/add/<?= $this->data['FaqTopic']['faq_topic_id'] ?>">Add Question</a>
</div>
</div>
