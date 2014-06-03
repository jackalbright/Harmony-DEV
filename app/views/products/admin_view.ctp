<div class="products view">
<h2><?php  __('Product');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['product_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Prod'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['prod']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Plural Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['plural_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Rank'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['rank']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Size'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['size']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Minimum'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['minimum']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Normal Ship Time Days'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['normal_ship_time_days']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Weight'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['weight']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Weight Count'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['weight_count']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Image Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['image_type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Main Intro'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['main_intro']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Main Desc'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['main_desc']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Secondary Desc'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['secondary_desc']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Meta Keywords'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['meta_keywords']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Meta Desc'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['meta_desc']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Page Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['page_title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Body Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['body_title']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Product', true), array('action'=>'edit', $product['Product']['product_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Product', true), array('action'=>'delete', $product['Product']['product_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $product['Product']['product_id'])); ?> </li>
		<li><?php echo $html->link(__('List Products', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Product Customization Options', true), array('controller'=> 'product_customization_options', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product Customization Option', true), array('controller'=> 'product_customization_options', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Product Pricings', true), array('controller'=> 'product_pricings', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product Pricing', true), array('controller'=> 'product_pricings', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Product Testimonials', true), array('controller'=> 'product_testimonials', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product Testimonial', true), array('controller'=> 'product_testimonials', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Product Customization Options');?></h3>
	<?php if (!empty($product['ProductCustomizationOption'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Product Customization Option Id'); ?></th>
		<th><?php __('Product Id'); ?></th>
		<th><?php __('Customization Option Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($product['ProductCustomizationOption'] as $productCustomizationOption):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $productCustomizationOption['product_customization_option_id'];?></td>
			<td><?php echo $productCustomizationOption['product_id'];?></td>
			<td><?php echo $productCustomizationOption['customization_option_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'product_customization_options', 'action'=>'view', $productCustomizationOption['product_customization_option_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'product_customization_options', 'action'=>'edit', $productCustomizationOption['product_customization_option_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'product_customization_options', 'action'=>'delete', $productCustomizationOption['product_customization_option_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productCustomizationOption['product_customization_option_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Product Customization Option', true), array('controller'=> 'product_customization_options', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Product Pricings');?></h3>
	<?php if (!empty($product['ProductPricing'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Pricing Id'); ?></th>
		<th><?php __('Product Id'); ?></th>
		<th><?php __('Max Quantity'); ?></th>
		<th><?php __('Pricing'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($product['ProductPricing'] as $productPricing):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $productPricing['pricing_id'];?></td>
			<td><?php echo $productPricing['product_id'];?></td>
			<td><?php echo $productPricing['max_quantity'];?></td>
			<td><?php echo $productPricing['pricing'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'product_pricings', 'action'=>'view', $productPricing['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'product_pricings', 'action'=>'edit', $productPricing['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'product_pricings', 'action'=>'delete', $productPricing['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productPricing['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Product Pricing', true), array('controller'=> 'product_pricings', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Product Testimonials');?></h3>
	<?php if (!empty($product['ProductTestimonial'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Product Testimonial Id'); ?></th>
		<th><?php __('Product Id'); ?></th>
		<th><?php __('Testimonial Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($product['ProductTestimonial'] as $productTestimonial):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $productTestimonial['product_testimonial_id'];?></td>
			<td><?php echo $productTestimonial['product_id'];?></td>
			<td><?php echo $productTestimonial['testimonial_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'product_testimonials', 'action'=>'view', $productTestimonial['product_testimonial_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'product_testimonials', 'action'=>'edit', $productTestimonial['product_testimonial_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'product_testimonials', 'action'=>'delete', $productTestimonial['product_testimonial_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productTestimonial['product_testimonial_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Product Testimonial', true), array('controller'=> 'product_testimonials', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
