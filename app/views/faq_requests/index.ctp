<div class="faqRequests index">
<h2><?php __('FaqRequests');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('organization');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<th><?php echo $paginator->sort('phone');?></th>
	<th><?php echo $paginator->sort('faq_topic_id');?></th>
	<th><?php echo $paginator->sort('question');?></th>
	<th><?php echo $paginator->sort('replied');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($faqRequests as $faqRequest):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $faqRequest['FaqRequest']['id']; ?>
		</td>
		<td>
			<?php echo $faqRequest['FaqRequest']['name']; ?>
		</td>
		<td>
			<?php echo $faqRequest['FaqRequest']['organization']; ?>
		</td>
		<td>
			<?php echo $faqRequest['FaqRequest']['email']; ?>
		</td>
		<td>
			<?php echo $faqRequest['FaqRequest']['phone']; ?>
		</td>
		<td>
			<?php echo $html->link($faqRequest['FaqTopic']['topic_name'], array('controller' => 'faq_topics', 'action' => 'view', $faqRequest['FaqTopic']['faq_topic_id'])); ?>
		</td>
		<td>
			<?php echo $faqRequest['FaqRequest']['question']; ?>
		</td>
		<td>
			<?php echo $faqRequest['FaqRequest']['replied']; ?>
		</td>
		<td>
			<?php echo $faqRequest['FaqRequest']['created']; ?>
		</td>
		<td>
			<?php echo $faqRequest['FaqRequest']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $faqRequest['FaqRequest']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $faqRequest['FaqRequest']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $faqRequest['FaqRequest']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $faqRequest['FaqRequest']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New FaqRequest', true), array('action' => 'add')); ?></li>
		<li><?php echo $html->link(__('List Faq Topics', true), array('controller' => 'faq_topics', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Faq Topic', true), array('controller' => 'faq_topics', 'action' => 'add')); ?> </li>
	</ul>
</div>
