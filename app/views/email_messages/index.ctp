<div class="emailMessages index">
<h2><?php __('EmailMessages');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('email_message_id');?></th>
	<th><?php echo $paginator->sort('email_template_id');?></th>
	<th><?php echo $paginator->sort('catalog_number');?></th>
	<th><?php echo $paginator->sort('image_id');?></th>
	<th><?php echo $paginator->sort('layout');?></th>
	<th><?php echo $paginator->sort('custom_message');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($emailMessages as $emailMessage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $emailMessage['EmailMessage']['email_message_id']; ?>
		</td>
		<td>
			<?php echo $html->link($emailMessage['EmailTemplate']['name'], array('controller'=> 'email_templates', 'action'=>'view', $emailMessage['EmailTemplate']['email_template_id'])); ?>
		</td>
		<td>
			<?php echo $emailMessage['EmailMessage']['catalog_number']; ?>
		</td>
		<td>
			<?php echo $emailMessage['EmailMessage']['image_id']; ?>
		</td>
		<td>
			<?php echo $emailMessage['EmailMessage']['layout']; ?>
		</td>
		<td>
			<?php echo $emailMessage['EmailMessage']['custom_message']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $emailMessage['EmailMessage']['email_message_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $emailMessage['EmailMessage']['email_message_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $emailMessage['EmailMessage']['email_message_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $emailMessage['EmailMessage']['email_message_id'])); ?>
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
		<li><?php echo $html->link(__('New EmailMessage', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Email Templates', true), array('controller'=> 'email_templates', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Template', true), array('controller'=> 'email_templates', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Email Message Recipients', true), array('controller'=> 'email_message_recipients', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Message Recipient', true), array('controller'=> 'email_message_recipients', 'action'=>'add')); ?> </li>
	</ul>
</div>
