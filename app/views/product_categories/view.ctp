<div class="productCategories view">
<h2><?php  __('ProductCategory');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product Category Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productCategory['ProductCategory']['product_category_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $productCategory['ProductCategory']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit ProductCategory', true), array('action'=>'edit', $productCategory['ProductCategory']['product_category_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete ProductCategory', true), array('action'=>'delete', $productCategory['ProductCategory']['product_category_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productCategory['ProductCategory']['product_category_id'])); ?> </li>
		<li><?php echo $html->link(__('List ProductCategories', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New ProductCategory', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Products', true), array('controller'=> 'products', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller'=> 'products', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Products');?></h3>
	<?php if (!empty($productCategory['Product'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Product Type Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Description'); ?></th>
		<th><?php __('Weight'); ?></th>
		<th><?php __('ShipWeight'); ?></th>
		<th><?php __('Height'); ?></th>
		<th><?php __('Width'); ?></th>
		<th><?php __('Depth'); ?></th>
		<th><?php __('Code'); ?></th>
		<th><?php __('Sort Index'); ?></th>
		<th><?php __('Quote Limit'); ?></th>
		<th><?php __('PersonalizationLimit'); ?></th>
		<th><?php __('Stamp'); ?></th>
		<th><?php __('Available'); ?></th>
		<th><?php __('Buildable'); ?></th>
		<th><?php __('Income Acct'); ?></th>
		<th><?php __('Cust Invoice Acct'); ?></th>
		<th><?php __('Address Length'); ?></th>
		<th><?php __('Is Popular'); ?></th>
		<th><?php __('Popularity'); ?></th>
		<th><?php __('Prod'); ?></th>
		<th><?php __('Main Intro'); ?></th>
		<th><?php __('Main Desc'); ?></th>
		<th><?php __('Secondary Desc'); ?></th>
		<th><?php __('Meta Keywords'); ?></th>
		<th><?php __('Meta Desc'); ?></th>
		<th><?php __('Page Title'); ?></th>
		<th><?php __('Body Title'); ?></th>
		<th><?php __('Is Stock Item'); ?></th>
		<th><?php __('Minimum'); ?></th>
		<th><?php __('Normal Ship Time Days'); ?></th>
		<th><?php __('Max Per 10 Days'); ?></th>
		<th><?php __('Pricing Name'); ?></th>
		<th><?php __('Parent Product Type Id'); ?></th>
		<th><?php __('Made In Usa'); ?></th>
		<th><?php __('Main Desc New'); ?></th>
		<th><?php __('Short Name'); ?></th>
		<th><?php __('Image Type'); ?></th>
		<th><?php __('Wholesale Minimum'); ?></th>
		<th><?php __('Quality Desc'); ?></th>
		<th><?php __('Base Price'); ?></th>
		<th><?php __('Production Quantity Per Day'); ?></th>
		<th><?php __('Product Category Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($productCategory['Product'] as $product):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $product['product_type_id'];?></td>
			<td><?php echo $product['name'];?></td>
			<td><?php echo $product['description'];?></td>
			<td><?php echo $product['weight'];?></td>
			<td><?php echo $product['shipWeight'];?></td>
			<td><?php echo $product['height'];?></td>
			<td><?php echo $product['width'];?></td>
			<td><?php echo $product['depth'];?></td>
			<td><?php echo $product['code'];?></td>
			<td><?php echo $product['sort_index'];?></td>
			<td><?php echo $product['quote_limit'];?></td>
			<td><?php echo $product['personalizationLimit'];?></td>
			<td><?php echo $product['stamp'];?></td>
			<td><?php echo $product['available'];?></td>
			<td><?php echo $product['buildable'];?></td>
			<td><?php echo $product['income_acct'];?></td>
			<td><?php echo $product['cust_invoice_acct'];?></td>
			<td><?php echo $product['address_length'];?></td>
			<td><?php echo $product['is_popular'];?></td>
			<td><?php echo $product['popularity'];?></td>
			<td><?php echo $product['prod'];?></td>
			<td><?php echo $product['main_intro'];?></td>
			<td><?php echo $product['main_desc'];?></td>
			<td><?php echo $product['secondary_desc'];?></td>
			<td><?php echo $product['meta_keywords'];?></td>
			<td><?php echo $product['meta_desc'];?></td>
			<td><?php echo $product['page_title'];?></td>
			<td><?php echo $product['body_title'];?></td>
			<td><?php echo $product['is_stock_item'];?></td>
			<td><?php echo $product['minimum'];?></td>
			<td><?php echo $product['normal_ship_time_days'];?></td>
			<td><?php echo $product['max_per_10_days'];?></td>
			<td><?php echo $product['pricing_name'];?></td>
			<td><?php echo $product['parent_product_type_id'];?></td>
			<td><?php echo $product['made_in_usa'];?></td>
			<td><?php echo $product['main_desc_new'];?></td>
			<td><?php echo $product['short_name'];?></td>
			<td><?php echo $product['image_type'];?></td>
			<td><?php echo $product['wholesale_minimum'];?></td>
			<td><?php echo $product['quality_desc'];?></td>
			<td><?php echo $product['base_price'];?></td>
			<td><?php echo $product['production_quantity_per_day'];?></td>
			<td><?php echo $product['product_category_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'products', 'action'=>'view', $product['product_type_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'products', 'action'=>'edit', $product['product_type_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'products', 'action'=>'delete', $product['product_type_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $product['product_type_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Product', true), array('controller'=> 'products', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
