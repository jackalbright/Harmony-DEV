<div class="purchaseSteps index">
<h2><?php __('PurchaseSteps');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('purchase_step_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('title');?></th>
	<th><?php echo $paginator->sort('text');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($purchaseSteps as $purchaseStep):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $purchaseStep['PurchaseStep']['purchase_step_id']; ?>
		</td>
		<td>
			<?php echo $purchaseStep['PurchaseStep']['name']; ?>
		</td>
		<td>
			<?php echo $purchaseStep['PurchaseStep']['title']; ?>
		</td>
		<td>
			<?php echo $purchaseStep['PurchaseStep']['text']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $purchaseStep['PurchaseStep']['purchase_step_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $purchaseStep['PurchaseStep']['purchase_step_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $purchaseStep['PurchaseStep']['purchase_step_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $purchaseStep['PurchaseStep']['purchase_step_id'])); ?>
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
		<li><?php echo $html->link(__('New PurchaseStep', true), array('action'=>'add')); ?></li>
	</ul>
</div>