<div class="productSampleImage view">
<h2><?php  __('ProductSampleImage');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product Image Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productSampleImage['ProductSampleImage']['product_image_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($productSampleImage['Product']['name'], array('controller'=> 'products', 'action'=>'view', $productSampleImage['Product']['product_type_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productSampleImage['ProductSampleImage']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productSampleImage['ProductSampleImage']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit ProductSampleImage', true), array('action'=>'edit', $productSampleImage['ProductSampleImage']['product_image_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete ProductSampleImage', true), array('action'=>'delete', $productSampleImage['ProductSampleImage']['product_image_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productSampleImage['ProductSampleImage']['product_image_id'])); ?> </li>
		<li><?php echo $html->link(__('List ProductSampleImage', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New ProductSampleImage', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Products', true), array('controller'=> 'products', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller'=> 'products', 'action'=>'add')); ?> </li>
	</ul>
</div>
