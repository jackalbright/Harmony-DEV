<div class="customer index">
<h2><?php __('Customers');?></h2>

<div>
	<? if(empty($wholesale)) { ?>
	<a href="/admin/customers/index/wholesale">WHOLESALE CUSTOMERS</a>
	<? } else { ?>
	<a href="/admin/customers/index">ALL CUSTOMERS</a>
	<? } ?>
</div>

<div class="right_align">
	<form method="POST" action="/admin/account/search">
	Search: 

	<select name="data[field]" id="field">
		<option value="firstlast">Full Name</option>
		<option value="lastfirst">Last, First</option>
		<option value="email">Email</option>
		<option value="company">Company</option>
	</select>
	<?= $javascript->codeBlock("Event.observe(window, 'load', function() { \$('field').value = '". $this->data['field'] ."'; });"); ?>
	
	<input type="text" name="data[value]" value="<?= $this->data['value'] ?>"/>
	<input type="submit" value="Search"/>
	<a href="/admin/account">View All</a>
	</form>
</div>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('customer_id');?></th>
	<th><?php echo $paginator->sort('First_Name');?></th>
	<th><?php echo $paginator->sort('Last_Name');?></th>
	<th><?php echo $paginator->sort('eMail_Address');?></th>
	<th>Completed Orders</th>
	<th>Cart Items</th>
	<th><?php echo $paginator->sort('Company');?></th>
	<th><?php echo $paginator->sort('is_wholesale');?></th>
	<th><?php echo $paginator->sort('billme');?></th>
	<th><?php echo $paginator->sort('Phone');?></th>
	<th><?php echo $paginator->sort('dateAdded');?></th>
	<th>&nbsp;</th>
</tr>
<?php
$i = 0;
foreach ($customers as $customer):
?>
	<tr style="background-color: <?= $i++ % 2 == 0 ? "#FFF":"#CCC" ?>;">
		<td>
			<?php echo $customer['Customer']['customer_id']; ?> - 
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $customer['Customer']['customer_id'])); ?>
		</td>
		<td>
			<?php echo $customer['Customer']['First_Name']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Last_Name']; ?>
		</td>
		<td>
			<a href="/admin/account/view/<?= $customer['Customer']['customer_id'] ?>">
				<?php echo $customer['Customer']['eMail_Address']; ?>
			</a>
			| 
			<a href="/admin/tracking_requests/session/<?= $customer['Customer']['eMail_Address'] ?>">
			Track
			</a>
			</a>
		</td>
		<td>
			<?= $customer['order_count']; ?>
		</td>
		<td>
			<?= $customer['cart_items_count']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Company']; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['is_wholesale'] ? "Wholesale" : "No"; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['billme'] ? "BillMe" : "No"; ?>
		</td>
		<td>
			<?php echo $customer['Customer']['Phone']; ?>
		</td>
		<td>
			<?php echo $hd->unixToHumanDate($customer['Customer']['dateAdded'],true); ?>
		</td>
		<td>
			<?php echo $html->link(__('Billing/Shipping/Payment', true), array('action'=>'raw', $customer['Customer']['customer_id'])); ?>
			| <?php echo $html->link(__('Add Cart Item', true), array('controller'=>'cart_items','action'=>'add', 'customer_id'=>$customer['Customer']['customer_id'])); ?>
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
		<li><?php echo $html->link(__('New Customer', true), array('action'=>'add')); ?></li>
	</ul>
</div>
