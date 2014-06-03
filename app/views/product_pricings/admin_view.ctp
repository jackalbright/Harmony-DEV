<div class="productPricings view">
<h2><?php  __('ProductPricing');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('ProductCode'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productPricing['ProductPricing']['productCode']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productPricing['ProductPricing']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Price'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productPricing['ProductPricing']['price']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Price Point Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productPricing['ProductPricing']['price_point_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product Type Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productPricing['ProductPricing']['product_type_id']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit ProductPricing', true), array('action'=>'edit', $productPricing['ProductPricing']['pricing_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete ProductPricing', true), array('action'=>'delete', $productPricing['ProductPricing']['pricing_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productPricing['ProductPricing']['pricing_id'])); ?> </li>
		<li><?php echo $html->link(__('List ProductPricings', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New ProductPricing', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
