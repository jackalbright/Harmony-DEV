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
	<th><?php echo $paginator->sort('productCode');?></th>
	<th><?php echo $paginator->sort('quantity');?></th>
	<th><?php echo $paginator->sort('price');?></th>
	<th><?php echo $paginator->sort('price_point_id');?></th>
	<th><?php echo $paginator->sort('product_type_id');?></th>
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
			<?php echo $productPricing['ProductPricing']['productCode']; ?>
		</td>
		<td>
			<?php echo $productPricing['ProductPricing']['quantity']; ?>
		</td>
		<td>
			<?php echo $productPricing['ProductPricing']['price']; ?>
		</td>
		<td>
			<?php echo $productPricing['ProductPricing']['price_point_id']; ?>
		</td>
		<td>
			<?php echo $productPricing['ProductPricing']['product_type_id']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $productPricing['ProductPricing']['pricing_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $productPricing['ProductPricing']['pricing_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $productPricing['ProductPricing']['pricing_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productPricing['ProductPricing']['pricing_id'])); ?>
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
