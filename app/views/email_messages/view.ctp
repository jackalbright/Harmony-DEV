<div class="emailMessages view">
<h2><?php  __('EmailMessage');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email Message Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailMessage['EmailMessage']['email_message_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Email Template'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($emailMessage['EmailTemplate']['name'], array('controller'=> 'email_templates', 'action'=>'view', $emailMessage['EmailTemplate']['email_template_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Catalog Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailMessage['EmailMessage']['catalog_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailMessage['EmailMessage']['image_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Layout'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailMessage['EmailMessage']['layout']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Custom Message'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $emailMessage['EmailMessage']['custom_message']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit EmailMessage', true), array('action'=>'edit', $emailMessage['EmailMessage']['email_message_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete EmailMessage', true), array('action'=>'delete', $emailMessage['EmailMessage']['email_message_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $emailMessage['EmailMessage']['email_message_id'])); ?> </li>
		<li><?php echo $html->link(__('List EmailMessages', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New EmailMessage', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Email Templates', true), array('controller'=> 'email_templates', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Template', true), array('controller'=> 'email_templates', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Email Message Recipients', true), array('controller'=> 'email_message_recipients', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Message Recipient', true), array('controller'=> 'email_message_recipients', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Email Message Recipients');?></h3>
	<?php if (!empty($emailMessage['EmailMessageRecipient'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Email Message Recipient Id'); ?></th>
		<th><?php __('Email Message Id'); ?></th>
		<th><?php __('Customer Id'); ?></th>
		<th><?php __('Email'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($emailMessage['EmailMessageRecipient'] as $emailMessageRecipient):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $emailMessageRecipient['email_message_recipient_id'];?></td>
			<td><?php echo $emailMessageRecipient['email_message_id'];?></td>
			<td><?php echo $emailMessageRecipient['customer_id'];?></td>
			<td><?php echo $emailMessageRecipient['email'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'email_message_recipients', 'action'=>'view', $emailMessageRecipient['email_message_recipient_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'email_message_recipients', 'action'=>'edit', $emailMessageRecipient['email_message_recipient_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'email_message_recipients', 'action'=>'delete', $emailMessageRecipient['email_message_recipient_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $emailMessageRecipient['email_message_recipient_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Email Message Recipient', true), array('controller'=> 'email_message_recipients', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
