<div class="emailTemplates index">
<h2><?php __('EmailTemplates');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('email_template_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('subject');?></th>
	<th><?php echo $paginator->sort('message');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($emailTemplates as $emailTemplate):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $emailTemplate['EmailTemplate']['email_template_id']; ?>
		</td>
		<td>
			<?php echo $emailTemplate['EmailTemplate']['name']; ?>
		</td>
		<td>
			<?php echo $emailTemplate['EmailTemplate']['subject']; ?>
		</td>
		<td>
			<?php echo $emailTemplate['EmailTemplate']['message']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $emailTemplate['EmailTemplate']['email_template_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $emailTemplate['EmailTemplate']['email_template_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $emailTemplate['EmailTemplate']['email_template_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $emailTemplate['EmailTemplate']['email_template_id'])); ?>
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
		<li><?php echo $html->link(__('New EmailTemplate', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Email Messages', true), array('controller'=> 'email_messages', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Message', true), array('controller'=> 'email_messages', 'action'=>'add')); ?> </li>
	</ul>
</div>
