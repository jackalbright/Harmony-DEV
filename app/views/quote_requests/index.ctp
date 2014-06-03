<div class="quoteRequests index">
<h2><?php __('QuoteRequests');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('product_id');?></th>
	<th><?php echo $paginator->sort('quantity');?></th>
	<th><?php echo $paginator->sort('options');?></th>
	<th><?php echo $paginator->sort('comments');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('organization');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<th><?php echo $paginator->sort('phone');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($quoteRequests as $quoteRequest):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $quoteRequest['QuoteRequest']['id']; ?>
		</td>
		<td>
			<?php echo $quoteRequest['QuoteRequest']['product_id']; ?>
		</td>
		<td>
			<?php echo $quoteRequest['QuoteRequest']['quantity']; ?>
		</td>
		<td>
			<?php echo $quoteRequest['QuoteRequest']['options']; ?>
		</td>
		<td>
			<?php echo $quoteRequest['QuoteRequest']['comments']; ?>
		</td>
		<td>
			<?php echo $quoteRequest['QuoteRequest']['name']; ?>
		</td>
		<td>
			<?php echo $quoteRequest['QuoteRequest']['organization']; ?>
		</td>
		<td>
			<?php echo $quoteRequest['QuoteRequest']['email']; ?>
		</td>
		<td>
			<?php echo $quoteRequest['QuoteRequest']['phone']; ?>
		</td>
		<td>
			<?php echo $quoteRequest['QuoteRequest']['created']; ?>
		</td>
		<td>
			<?php echo $quoteRequest['QuoteRequest']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $quoteRequest['QuoteRequest']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $quoteRequest['QuoteRequest']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $quoteRequest['QuoteRequest']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $quoteRequest['QuoteRequest']['id'])); ?>
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
		<li><?php echo $html->link(__('New QuoteRequest', true), array('action' => 'add')); ?></li>
	</ul>
</div>
