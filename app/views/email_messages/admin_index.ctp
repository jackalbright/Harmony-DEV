<div class="emailMessages index">
<h2><?php __('Email Message History');?></h2>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Create New Letter', true), array('controller'=>'email_letters','action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Letters / Send Email', true), array('controller'=> 'email_letters', 'action'=>'index')); ?> </li>
	</ul>
</div>
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
	<th><?php echo $paginator->sort('subject');?></th>
	<th><?php echo $paginator->sort('recipients');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($emailMessages as $emailMessage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="odd"';
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
			<?php echo $emailMessage['EmailMessage']['subject']; ?>
		</td>
		<td>
			<?= nl2br($emailMessage['EmailMessage']['recipients']); ?>
		</td>
		<td>
			<?= date("m/d/Y H:i:s", strtotime($emailMessage['EmailMessage']['created'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $emailMessage['EmailMessage']['email_message_id'])); ?>
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
