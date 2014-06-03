<div class="faqRequests view">
<h2><?php  __('FaqRequest');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $faqRequest['FaqRequest']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $faqRequest['FaqRequest']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Organization'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $faqRequest['FaqRequest']['organization']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<a href="mailto:<?php echo $faqRequest['FaqRequest']['email']; ?>">
			<?php echo $faqRequest['FaqRequest']['email']; ?>
			</a>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $faqRequest['FaqRequest']['phone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Faq Topic'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($faqRequest['FaqTopic']['topic_name'], array('controller' => 'faq_topics', 'action' => 'view', $faqRequest['FaqTopic']['faq_topic_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Question'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $faqRequest['FaqRequest']['question']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Replied'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $faqRequest['FaqRequest']['replied']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $faqRequest['FaqRequest']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $faqRequest['FaqRequest']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit FaqRequest', true), array('action' => 'edit', $faqRequest['FaqRequest']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete FaqRequest', true), array('action' => 'delete', $faqRequest['FaqRequest']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $faqRequest['FaqRequest']['id'])); ?> </li>
		<li><?php echo $html->link(__('List FaqRequests', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New FaqRequest', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Faq Topics', true), array('controller' => 'faq_topics', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Faq Topic', true), array('controller' => 'faq_topics', 'action' => 'add')); ?> </li>
	</ul>
</div>
