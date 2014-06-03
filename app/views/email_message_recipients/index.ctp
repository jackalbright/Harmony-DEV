<div class="emailMessageRecipients index">
<h2><?php __('EmailMessageRecipients');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('email_message_recipient_id');?></th>
	<th><?php echo $paginator->sort('email_message_id');?></th>
	<th><?php echo $paginator->sort('customer_id');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($emailMessageRecipients as $emailMessageRecipient):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $emailMessageRecipient['EmailMessageRecipient']['email_message_recipient_id']; ?>
		</td>
		<td>
			<?php echo $html->link($emailMessageRecipient['EmailMessage']['email_message_id'], array('controller'=> 'email_messages', 'action'=>'view', $emailMessageRecipient['EmailMessage']['email_message_id'])); ?>
		</td>
		<td>
			<?php echo $html->link($emailMessageRecipient['Customer']['customer_id'], array('controller'=> 'customers', 'action'=>'view', $emailMessageRecipient['Customer']['customer_id'])); ?>
		</td>
		<td>
			<?php echo $emailMessageRecipient['EmailMessageRecipient']['email']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $emailMessageRecipient['EmailMessageRecipient']['email_message_recipient_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $emailMessageRecipient['EmailMessageRecipient']['email_message_recipient_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $emailMessageRecipient['EmailMessageRecipient']['email_message_recipient_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $emailMessageRecipient['EmailMessageRecipient']['email_message_recipient_id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New EmailMessageRecipient', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Email Messages', true), array('controller'=> 'email_messages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Message', true), array('controller'=> 'email_messages', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Customers', true), array('controller'=> 'customers', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Customer', true), array('controller'=> 'customers', 'action'=>'add')); ?> </li>
	</ul>
</div>
