<div class="faqTopics index">
<h2><?php __('FaqTopics');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('faq_topic_id');?></th>
	<th><?php echo $paginator->sort('topic_name');?></th>
	<th><?php echo $paginator->sort('global_enabled');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($faqTopics as $faqTopic):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $faqTopic['FaqTopic']['faq_topic_id']; ?>
		</td>
		<td>
			<?php echo $faqTopic['FaqTopic']['topic_name']; ?>
		</td>
		<td>
			<?php echo $faqTopic['FaqTopic']['global_enabled']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $faqTopic['FaqTopic']['faq_topic_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $faqTopic['FaqTopic']['faq_topic_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $faqTopic['FaqTopic']['faq_topic_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $faqTopic['FaqTopic']['faq_topic_id'])); ?>
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
		<li><?php echo $html->link(__('New FaqTopic', true), array('action'=>'add')); ?></li>
	</ul>
</div>
