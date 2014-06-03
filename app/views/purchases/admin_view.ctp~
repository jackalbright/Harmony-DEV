<div class="purchases view">
<h2><?php  __('Purchase');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Order Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['Order_Date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Order Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['Order_Status']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Shipping Method'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['Shipping_Method']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Customer ID'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['Customer_ID']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Shipping ID'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['Shipping_ID']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Purchase Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['purchase_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Credit Card ID'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['Credit_Card_ID']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Billing ID'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['Billing_ID']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Shipping Cost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['Shipping_Cost']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Order Comment'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['order_comment']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Shipper'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['shipper']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Tracking Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['tracking_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Request Proof'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['request_proof']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Charge Amount'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['Charge_Amount']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Ships By'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $purchase['Purchase']['ships_by']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Purchase', true), array('action'=>'edit', $purchase['Purchase']['purchase_id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Purchase', true), array('action'=>'delete', $purchase['Purchase']['purchase_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $purchase['Purchase']['purchase_id'])); ?> </li>
		<li><?php echo $html->link(__('List Purchases', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Purchase', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Order Items', true), array('controller'=> 'order_items', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Order Item', true), array('controller'=> 'order_items', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Order Items');?></h3>
	<?php if (!empty($purchase['OrderItem'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Order Item Id'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Price'); ?></th>
		<th><?php __('Purchase Id'); ?></th>
		<th><?php __('Product Type Id'); ?></th>
		<th><?php __('SpecialID'); ?></th>
		<th><?php __('Comments'); ?></th>
		<th><?php __('Accepted'); ?></th>
		<th><?php __('Reproduction'); ?></th>
		<th><?php __('Customization Xml'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($purchase['OrderItem'] as $orderItem):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $orderItem['order_item_id'];?></td>
			<td><?php echo $orderItem['Quantity'];?></td>
			<td><?php echo $orderItem['Price'];?></td>
			<td><?php echo $orderItem['Purchase_id'];?></td>
			<td><?php echo $orderItem['product_type_id'];?></td>
			<td><?php echo $orderItem['specialID'];?></td>
			<td><?php echo $orderItem['comments'];?></td>
			<td><?php echo $orderItem['accepted'];?></td>
			<td><?php echo $orderItem['reproduction'];?></td>
			<td><?php echo $orderItem['customization_xml'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'order_items', 'action'=>'view', $orderItem['order_item_id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'order_items', 'action'=>'edit', $orderItem['order_item_id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'order_items', 'action'=>'delete', $orderItem['order_item_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $orderItem['order_item_id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Order Item', true), array('controller'=> 'order_items', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
