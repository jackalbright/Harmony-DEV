<div class="productPricings view">
<h2><?php  __('ProductPricing');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pricing Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productPricing['ProductPricing']['pricing_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productPricing['ProductPricing']['product_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Max Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productPricing['ProductPricing']['max_quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pricing'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productPricing['ProductPricing']['pricing']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit ProductPricing', true), array('action'=>'edit', $productPricing['ProductPricing']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete ProductPricing', true), array('action'=>'delete', $productPricing['ProductPricing']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productPricing['ProductPricing']['id'])); ?> </li>
		<li><?php echo $html->link(__('List ProductPricings', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New ProductPricing', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
