<div class="faqRequests form">
<?php echo $form->create('FaqRequest');?>
	<fieldset>
 		<legend><?php __('Edit FaqRequest');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
		echo $form->input('organization');
		echo $form->input('email');
		echo $form->input('phone');
		echo $form->input('faq_topic_id');
		echo $form->input('question');
		echo $form->input('replied');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('FaqRequest.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('FaqRequest.id'))); ?></li>
		<li><?php echo $html->link(__('List FaqRequests', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Faq Topics', true), array('controller' => 'faq_topics', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Faq Topic', true), array('controller' => 'faq_topics', 'action' => 'add')); ?> </li>
	</ul>
</div>
