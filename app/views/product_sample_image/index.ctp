<div class="productSampleImage index">
<h2><?php __('ProductSampleImage');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('product_image_id');?></th>
	<th><?php echo $paginator->sort('product_type_id');?></th>
	<th><?php echo $paginator->sort('title');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($productSampleImage as $productSampleImage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $productSampleImage['ProductSampleImage']['product_image_id']; ?>
		</td>
		<td>
			<?php echo $html->link($productSampleImage['Product']['name'], array('controller'=> 'products', 'action'=>'view', $productSampleImage['Product']['product_type_id'])); ?>
		</td>
		<td>
			<?php echo $productSampleImage['ProductSampleImage']['title']; ?>
		</td>
		<td>
			<?php echo $productSampleImage['ProductSampleImage']['description']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $productSampleImage['ProductSampleImage']['product_image_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $productSampleImage['ProductSampleImage']['product_image_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $productSampleImage['ProductSampleImage']['product_image_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productSampleImage['ProductSampleImage']['product_image_id'])); ?>
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
		<li><?php echo $html->link(__('New ProductSampleImage', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Products', true), array('controller'=> 'products', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller'=> 'products', 'action'=>'add')); ?> </li>
	</ul>
</div>
