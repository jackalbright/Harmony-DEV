<div class="emailLetters index">
<h2><?php __('Email Letters');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('email_letter_id');?></th>
	<th><?php echo $paginator->sort('letter_name');?></th>
	<th><?php echo $paginator->sort('subject');?></th>
	<th><?php echo $paginator->sort('catalog_number');?></th>
	<th><?php echo $paginator->sort('image_id');?></th>
	<th><?php echo $paginator->sort('email_template_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($emailLetters as $emailLetter):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $emailLetter['EmailLetter']['email_letter_id']; ?>
		</td>
		<td>
			<?php echo $emailLetter['EmailLetter']['letter_name']; ?>
		</td>
		<td>
			<?php echo $emailLetter['EmailLetter']['subject']; ?>
		</td>
		<td>
			<?php echo $emailLetter['EmailLetter']['catalog_number']; ?>
		</td>
		<td>
			<?php echo $emailLetter['EmailLetter']['image_id']; ?>
		</td>
		<td>
			<?php echo $html->link($emailLetter['EmailTemplate']['name'], array('controller'=> 'email_templates', 'action'=>'view', $emailLetter['EmailTemplate']['email_template_id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit Letter', true), array('action'=>'edit', $emailLetter['EmailLetter']['email_letter_id'])); ?>
			<?php echo $html->link(__('Send Message', true), array('controller'=>'email_messages','action'=>'add', 'email_letter_id'=>$emailLetter['EmailLetter']['email_letter_id'])); ?>
			<br/>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $emailLetter['EmailLetter']['email_letter_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $emailLetter['EmailLetter']['email_letter_id'])); ?>
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
		<li><?php echo $html->link(__('New EmailLetter', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Email Templates', true), array('controller'=> 'email_templates', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Email Template', true), array('controller'=> 'email_templates', 'action'=>'add')); ?> </li>
	</ul>
</div>
