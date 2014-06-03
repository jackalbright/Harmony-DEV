<div class="faqTopics view">
<h2><?php  __('FaqTopic');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Faq Topic Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $faqTopic['FaqTopic']['faq_topic_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Topic Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $faqTopic['FaqTopic']['topic_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Global Enabled'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $faqTopic['FaqTopic']['global_enabled']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit FaqTopic', true), array('action'=>'edit', $faqTopic['FaqTopic']['faq_topic_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete FaqTopic', true), array('action'=>'delete', $faqTopic['FaqTopic']['faq_topic_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $faqTopic['FaqTopic']['faq_topic_id'])); ?> </li>
		<li><?php echo $html->link(__('List FaqTopics', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New FaqTopic', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
