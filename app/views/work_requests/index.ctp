<div class="workRequests index">
<h2><?php __('WorkRequests');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('work_request_id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('email');?></th>
	<th><?php echo $paginator->sort('phone');?></th>
	<th><?php echo $paginator->sort('product_type_id');?></th>
	<th><?php echo $paginator->sort('quantity');?></th>
	<th><?php echo $paginator->sort('image_location');?></th>
	<th><?php echo $paginator->sort('credit_card_id');?></th>
	<th><?php echo $paginator->sort('billing_id');?></th>
	<th><?php echo $paginator->sort('shipping_id');?></th>
	<th><?php echo $paginator->sort('comments');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($workRequests as $workRequest):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $workRequest['WorkRequest']['work_request_id']; ?>
		</td>
		<td>
			<?php echo $workRequest['WorkRequest']['name']; ?>
		</td>
		<td>
			<?php echo $workRequest['WorkRequest']['email']; ?>
		</td>
		<td>
			<?php echo $workRequest['WorkRequest']['phone']; ?>
		</td>
		<td>
			<?php echo $html->link($workRequest['Product']['name'], array('controller'=> 'products', 'action'=>'view', $workRequest['Product']['product_type_id'])); ?>
		</td>
		<td>
			<?php echo $workRequest['WorkRequest']['quantity']; ?>
		</td>
		<td>
			<?php echo $workRequest['WorkRequest']['image_location']; ?>
		</td>
		<td>
			<?php echo $html->link($workRequest['CreditCard']['credit_card_id'], array('controller'=> 'credit_cards', 'action'=>'view', $workRequest['CreditCard']['credit_card_id'])); ?>
		</td>
		<td>
			<?php echo $html->link($workRequest['BillingAddress']['Contact_ID'], array('controller'=> 'contact_infos', 'action'=>'view', $workRequest['BillingAddress']['Contact_ID'])); ?>
		</td>
		<td>
			<?php echo $html->link($workRequest['ShippingAddress']['Contact_ID'], array('controller'=> 'contact_infos', 'action'=>'view', $workRequest['ShippingAddress']['Contact_ID'])); ?>
		</td>
		<td>
			<?php echo $workRequest['WorkRequest']['comments']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $workRequest['WorkRequest']['work_request_id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $workRequest['WorkRequest']['work_request_id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $workRequest['WorkRequest']['work_request_id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $workRequest['WorkRequest']['work_request_id'])); ?>
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
		<li><?php echo $html->link(__('New WorkRequest', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Products', true), array('controller'=> 'products', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Product', true), array('controller'=> 'products', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Credit Cards', true), array('controller'=> 'credit_cards', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Credit Card', true), array('controller'=> 'credit_cards', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Contact Infos', true), array('controller'=> 'contact_infos', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Billing Address', true), array('controller'=> 'contact_infos', 'action'=>'add')); ?> </li>
	</ul>
</div>
