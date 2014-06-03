<div class="emailMessageRecipients view">
<h2><?php  __('EmailMessageRecipient');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email Message Recipient Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailMessageRecipient['EmailMessageRecipient']['email_message_recipient_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email Message'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($emailMessageRecipient['EmailMessage']['email_message_id'], array('controller'=> 'email_messages', 'action'=>'view', $emailMessageRecipient['EmailMessage']['email_message_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Customer'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($emailMessageRecipient['Customer']['customer_id'], array('controller'=> 'customers', 'action'=>'view', $emailMessageRecipient['Customer']['customer_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailMessageRecipient['EmailMessageRecipient']['email']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit EmailMessageRecipient', true), array('action'=>'edit', $emailMessageRecipient['EmailMessageRecipient']['email_message_recipient_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete EmailMessageRecipient', true), array('action'=>'delete', $emailMessageRecipient['EmailMessageRecipient']['email_message_recipient_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $emailMessageRecipient['EmailMessageRecipient']['email_message_recipient_id'])); ?> </li>
		<li><?php echo $html->link(__('List EmailMessageRecipients', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New EmailMessageRecipient', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Email Messages', true), array('controller'=> 'email_messages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Message', true), array('controller'=> 'email_messages', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Customers', true), array('controller'=> 'customers', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Customer', true), array('controller'=> 'customers', 'action'=>'add')); ?> </li>
	</ul>
</div>
