<div class="productQuotes view">
<h2><?php  __('ProductQuote');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product Quote Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productQuote['ProductQuote']['product_quote_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($productQuote['Product']['name'], array('controller'=> 'products', 'action'=>'view', $productQuote['Product']['product_type_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quote'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($productQuote['Quote']['title'], array('controller'=> 'quotes', 'action'=>'view', $productQuote['Quote']['quote_id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit ProductQuote', true), array('action'=>'edit', $productQuote['ProductQuote']['product_quote_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete ProductQuote', true), array('action'=>'delete', $productQuote['ProductQuote']['product_quote_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productQuote['ProductQuote']['product_quote_id'])); ?> </li>
		<li><?php echo $html->link(__('List ProductQuotes', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New ProductQuote', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Products', true), array('controller'=> 'products', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller'=> 'products', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Quotes', true), array('controller'=> 'quotes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Quote', true), array('controller'=> 'quotes', 'action'=>'add')); ?> </li>
	</ul>
</div>
