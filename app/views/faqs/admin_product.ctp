<div class="faqs index">
<h2><?php __('Faqs');?></h2>
<?= $this->element("admin/products/nav"); ?>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('faq_id');?></th>
	<th><?php echo $paginator->sort('faq_topic_id');?></th>
	<th><?php echo $paginator->sort('product_type_id');?></th>
	<th><?php echo $paginator->sort('part_id');?></th>
	<th><?php echo $paginator->sort('enabled');?></th>
	<th><?php echo $paginator->sort('question');?></th>
	<th><?php echo $paginator->sort('answer');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($faqs as $faq):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $faq['Faq']['faq_id']; ?>
		</td>
		<td>
			<?php echo $faq['FaqTopic']['topic_name']; ?>
		</td>
		<td>
			<?= !empty($faq['Product']) ?  $faq['Product']['name'] : "N/A"; ?>
		</td>
		<td>
			<?= !empty($faq['Part']) ? $faq['Part']['part_name'] : "None" ; ?>
		</td>
		<td>
			<?= $faq['Faq']['enabled'] ? "Yes" : "No"; ?>
		</td>
		<td>
			<?php echo $faq['Faq']['question']; ?>
		</td>
		<td>
			<?php echo $faq['Faq']['answer']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $faq['Faq']['faq_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $faq['Faq']['faq_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $faq['Faq']['faq_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $faq['Faq']['faq_id'])); ?>
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
		<li><?php echo $html->link(__('New Faq', true), array('action'=>'add', $product['Product']['code'])); ?></li>
	</ul>
</div>
