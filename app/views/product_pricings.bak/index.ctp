<div class="productPricings index">
<h2><?php __('ProductPricings');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('pricing_id');?></th>
	<th><?php echo $paginator->sort('product_id');?></th>
	<th><?php echo $paginator->sort('max_quantity');?></th>
	<th><?php echo $paginator->sort('pricing');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($productPricings as $productPricing):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $productPricing['ProductPricing']['pricing_id']; ?>
		</td>
		<td>
			<?php echo $productPricing['ProductPricing']['product_id']; ?>
		</td>
		<td>
			<?php echo $productPricing['ProductPricing']['max_quantity']; ?>
		</td>
		<td>
			<?php echo $productPricing['ProductPricing']['pricing']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $productPricing['ProductPricing']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $productPricing['ProductPricing']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $productPricing['ProductPricing']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productPricing['ProductPricing']['id'])); ?>
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
		<li><?php echo $html->link(__('New ProductPricing', true), array('action'=>'add')); ?></li>
	</ul>
</div>
