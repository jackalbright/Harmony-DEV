<div class="purchases index">
<h2><?= empty($wholesale) ? "Purchases" : "Wholesale Purchases"; ?></h2>

<div class='right'>
	<a class='alert' href="/admin/purchases/log">Transaction Log</a>
</div>


<? if(!empty($wholesale)) { ?>
<a href="/admin/purchases">All Purchases</a>
<? } else { ?>
<a href="/admin/purchases/wholesale">Wholesale Purchases</a>
<? } ?>

<div class='clear'></div>

<p>

<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<h1>Purchases</h1>
<!--conditionsText:<?php //echo $conditionsText;?>-->
<form action="/admin/purchases/index" method="POST">
<p>PurchaseID: <input type="text" name="data[searchPurchaseID]" value=""><input type="submit" value="Search"></p>
</form>

<form method="POST" action="/admin/purchases/process">
<table cellpadding="0" cellspacing="0">
<tr>
	<th>&nbsp;</th>
	<th><?php echo $paginator->sort('purchase_id');?></th>
	<th><?php echo $paginator->sort('Order_Date');?></th>
	<th><?php echo $paginator->sort('Order_Status');?></th>
	<th><?php echo $paginator->sort('Customer_ID');?></th>
	<th><?php echo $paginator->sort('session_id');?></th>
	<th>Order Items</th>
	<th><?php echo $paginator->sort('Charge_Amount');?></th>
	<th><?php echo $paginator->sort('Credit_Card_ID');?></th>
	<th><?php echo $paginator->sort('Shipping_Method');?></th>
	<th><?php echo $paginator->sort('ships_by');?></th>
	<th><?php echo $paginator->sort('order_comment');?></th>
</tr>
<?php
$i = 0;
foreach ($purchases as $purchase):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<input type="checkbox" name="data[Purchase][purchase_id][<?= $i ?>]" value="<?= $purchase['Purchase']['purchase_id'] ?>"/>
		</td>
		<td>
			<a href="/admin38/order/vieworders2.php?purchaseID=<?= $purchase['Purchase']['purchase_id'] ?>">
			<?= $purchase['Purchase']['purchase_id']; ?>
			</a>
		</td>
		<td>
			<?= date("m/d/Y", strtotime($purchase['Purchase']['Order_Date'])); ?>
		</td>
		<td>
			<?php echo $purchase['Purchase']['Order_Status']; ?>
		</td>
		<td>
			<a href="/admin/account/view/<?= $purchase['Purchase']['Customer_ID']; ?>">
				<?php echo $purchase['Customer']['First_Name']; ?> <?= $purchase['Customer']['Last_Name'] ?><br/>
				<?= $purchase['Customer']['eMail_Address'] ?><br/>
				<?= $purchase['Customer']['Company'] ?><br/>
				<?= $purchase['Customer']['customer_id'] ?><br/>
			</a>
		</td>
		<td>
			<a href="/admin/tracking_requests/session/<?= $purchase['Purchase']['session_id']?>">
				<?= $purchase['Purchase']['session_id']; ?>
			</a>
		</td>
		<td>
			<? foreach($purchase['OrderItem'] as $item) { ?>
			<div>
				<?
					$pid = $item['product_type_id'];
					if (empty($products_by_id[$pid])) { continue; }
					$product = $products_by_id[$pid];
				?>
				<?= $product['Product']['name'] ?> (<?= $item['Quantity'] ?>) 
				
				<!-- @ <?= sprintf("$%.02f", $item['Price']) ?> ea. -->
			</div>
			<? } ?>
		</td>
		<td>
			<?= sprintf("$%.02f", $purchase['Purchase']['Charge_Amount']); ?>
		</td>
		<td>
			<? if($purchase['Purchase']['Credit_Card_ID'] == -1) { ?>
				PayPal
			<? } else if($purchase['Purchase']['Credit_Card_ID'] == -2) { ?>
				BillMe!
			<? } else if($purchase['Purchase']['Credit_Card_ID'] == -3) { ?>
				Amazon Payments
			<? } else { ?>
				Credit Card
			<? } ?>
		</td>
		<td>
			<?php echo $purchase['ShippingMethod']['name']; ?>
		</td>
		<td>
			<? $ships_by_time = strtotime($purchase['Purchase']['ships_by']); 
			$days = 3; # 
			
			?>
			<div class="<? time()+$days*24*60*60 > $ships_by_time ? 'bold alert' : '' ?>">
			<?= date("m/d",  $ships_by_time); ?>
			</div>
		</td>
		<td>
			<?php echo $purchase['Purchase']['order_comment']; ?>
		</td>
	</tr>
<?php endforeach; ?>
	<tr>
		<td colspan=6 align="left">
			<input type="submit" name="data[submit]" value="FedEx Address"/>
			<!--
			<input type="submit" name="data[submit]" value="MYOB Customer OLD"/>
			-->
			<input type="submit" name="data[submit]" value="MYOB Customer"/>
			<input type="submit" name="data[submit]" value="MYOB Item"/>
			<input type="submit" name="data[submit]" value="MYOB Purchase"/>
		</td>
		<td align="right" colspan=6>
			<input type="submit" name="data[submit]" value="Ship Order"/>
			<input type="submit" name="data[submit]" value="USPS Address"/>
			<input style="color: red;" type="submit" name="data[submit]" value="Delete Orders" onClick="return confirm('Are you sure you want to delete these orders?');"/>
		</td>
	</tr>
</table>

<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>


</form>
</div>


