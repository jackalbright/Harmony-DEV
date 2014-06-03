<div class="customerTypes index">
<h2><?php __('CustomerTypes');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('customer_type_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($customerTypes as $customerType):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $customerType['CustomerType']['customer_type_id']; ?>
		</td>
		<td>
			<?php echo $customerType['CustomerType']['name']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $customerType['CustomerType']['customer_type_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $customerType['CustomerType']['customer_type_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $customerType['CustomerType']['customer_type_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $customerType['CustomerType']['customer_type_id'])); ?>
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
		<li><?php echo $html->link(__('New CustomerType', true), array('action'=>'add')); ?></li>
	</ul>
</div>
