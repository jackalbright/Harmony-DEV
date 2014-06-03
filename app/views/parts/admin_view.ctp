<div class="parts view">
<h2><?php  __('Part');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Part Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['part_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Part Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['part_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Part Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['part_description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sort Index'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['sort_index']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Part Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['part_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Part Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['part_title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Step'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['is_step']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Price'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['price']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Is Feature'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $part['Part']['is_feature']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Part', true), array('action'=>'edit', $part['Part']['part_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Part', true), array('action'=>'delete', $part['Part']['part_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $part['Part']['part_id'])); ?> </li>
		<li><?php echo $html->link(__('List Parts', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Part', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Product Parts', true), array('controller'=> 'product_parts', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product Parts', true), array('controller'=> 'product_parts', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Product Parts');?></h3>
	<?php if (!empty($part['ProductParts'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Product Type Id'); ?></th>
		<th><?php __('Part Id'); ?></th>
		<th><?php __('Optional'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Product Part Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($part['ProductParts'] as $productParts):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $productParts['product_type_id'];?></td>
			<td><?php echo $productParts['part_id'];?></td>
			<td><?php echo $productParts['optional'];?></td>
			<td><?php echo $productParts['quantity'];?></td>
			<td><?php echo $productParts['product_part_id'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'product_parts', 'action'=>'view', $productParts['product_part_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'product_parts', 'action'=>'edit', $productParts['product_part_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'product_parts', 'action'=>'delete', $productParts['product_part_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $productParts['product_part_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Product Parts', true), array('controller'=> 'product_parts', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
