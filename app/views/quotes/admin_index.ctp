<div class="quotes index">
<h2><?php __('Quotes');?></h2>
<p>
<?= $paginator->counter(array( 'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true))); ?>
</p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('quote_id');?></th>
	<th><?php echo $paginator->sort('text');?></th>
	<th><?php echo $paginator->sort('title');?></th>
	<th><?php echo $paginator->sort('attribution');?></th>
	<th><?php echo $paginator->sort('text_length');?></th>
	<th><?php echo $paginator->sort('attrib_length');?></th>
	<th><?php echo $paginator->sort('use_quote_marks');?></th>
	<th><?php echo $paginator->sort('subjects');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($quotes as $quote):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $quote['Quote']['quote_id']; ?>
		</td>
		<td>
			<?php echo $quote['Quote']['text']; ?>
		</td>
		<td>
			<?php echo $quote['Quote']['title']; ?>
		</td>
		<td>
			<?php echo $quote['Quote']['attribution']; ?>
		</td>
		<td>
			<?php echo $quote['Quote']['text_length']; ?>
		</td>
		<td>
			<?php echo $quote['Quote']['attrib_length']; ?>
		</td>
		<td>
			<?php echo $quote['Quote']['use_quote_marks']; ?>
		</td>
		<td>
			<?php echo $quote['Quote']['subjects']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $quote['Quote']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $quote['Quote']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $quote['Quote']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $quote['Quote']['id'])); ?>
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
		<li><?php echo $html->link(__('New Quote', true), array('action'=>'add')); ?></li>
	</ul>
</div>
