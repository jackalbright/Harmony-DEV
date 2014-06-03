<div>

<form action="/checkout/receipt" method="POST">

<table width="100%">
<tr>
	<td width="25%"><b>Shipping Address:</b></td>
	<td width="25%"><b>Billing Address:</b></td>
	<td width="25%"><b>Shipping Speed:</b></td>
	<td width="25%"><b>Payment Method:</b></td>
	<!--<td width="20%"><b>Order Summary:</b></td>-->
</tr>
<tr>
	<td valign=top>
		<?= !empty($shippingAddress['Company']) ? "ATTN: ":""?>
		<?= $shippingAddress['In_Care_Of'] ?><br/>
		<?= !empty($shippingAddress['Company']) ? $shippingAddress['Company']."<br/>" : "" ?>
		<?= $shippingAddress['Address_1'] ?><br/>
		<? if(!empty($shippingAddress['Address_2'])) { ?>
			<?= $shippingAddress['Address_2'] ?><br/>
		<? } ?>
		<?= $shippingAddress['City'] ?>, <?= $shippingAddress['State'] ?><br/>
		<?= $shippingAddress['Zip_Code'] ?><br/>
		<?= $shippingAddress['Country'] ?><br/>
		<br/>
	</td>
	<td valign=top>
		<?= !empty($billingAddress['Company']) ? "ATTN: ":""?>
		<?= $billingAddress['In_Care_Of'] ?><br/>
		<?= !empty($billingAddress['Company']) ? $billingAddress['Company']."<br/>" : "" ?>
		<?= $billingAddress['Address_1'] ?><br/>
		<? if(!empty($billingAddress['Address_2'])) { ?>
			<?= $billingAddress['Address_2'] ?><br/>
		<? } ?>
		<?= $billingAddress['City'] ?>, <?= $billingAddress['State'] ?><br/>
		<?= $billingAddress['Zip_Code'] ?><br/>
		<?= $billingAddress['Country'] ?><br/>
		<br/>
	</td>
	<td valign="top">
		<?
			$dayMin = $shippingOption['shippingMethod']['dayMin'];
			$dayMax = $shippingOption['shippingMethod']['dayMax'];
			$num2name = array('Zero','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten');
			$shiptype = ucfirst($num2name[$dayMax]) . " Day";
			if($dayMax >= 5) { $shiptype = 'Standard'; }
		?>
		<?= $shiptype ?> Shipping <? if($shiptype == 'Standard') { ?>(<?= $dayMin ?> - <?= $dayMax ?> days)<? } ?><br/>


		<!--<?= $shippingOption['shippingMethod']['name'] ?><br/> -->
		<!--<?= $shippingOption['shippingMethod']['dayMin'] ?> <? if($shippingOption['shippingMethod']['dayMax'] > $shippingOption['shippingMethod']['dayMin']) { echo " - " .$shippingOption['shippingMethod']['dayMax']; } ?> day(s)<br/>-->
		<? if(!empty($rush_date) && !empty($rush_ships_by_start)) { ?>
			<b>RUSH PROCESSING</b>
			<!--Receive by: <?= date("D M j", strtotime($rush_date)); ?><br/>(Rush charges may apply)-->
			Ships by <?= date("D M j", strtotime($ships_by_start)); ?>
		<? } else { ?>
			Ships by <?= date("D M j", strtotime($ships_by_start)); ?>
			<!--Receive by: <?= $delivery_end ?>-->
		<? } ?>
		<br/>
	</td>
	<td valign=top>
		<? if(!empty($paypal)) { ?>
			PayPal
		<? } else if(!empty($billme)) { ?>
			Bill Me Later
			<? if($customer_po) { ?>
			<br/>
			PO #<?= $customer_po ?>
			<? } ?>
		<? } else { ?>
		<?= $billingMethod['Cardholder'] ?><br/>
		<?= $billingMethod['Card_Type'] ?>: ends in -<?= substr($billingMethod['NumberPlain'], -4); ?><br/>
		Expires: <?= date("m/Y", strtotime($billingMethod['Expiration'])); ?></br>
		<br/>
		<? } ?>
	</td>
	<!--
	<td valign="top" style="border: solid #CCC 1px; background-color: #EEE;">
		<?= $this->element("checkout/order_summary"); ?>
	</td>
	-->
</tr>
<tr>
	<td>
		<a href="/checkout/shipping_select">Change address</a>
	</td>
	<td>
		<a href="/checkout/billing_select">Change address</a>
	</td>
	<td>
		<a href="/checkout/shipping_method">Change shipping speed</a>
	</td>
	<td>
		<a href="/checkout/payment_select">Change payment method</a>
	</td>
</tr>
</table>
<br/>

	<div class="center">
		<div id="place_order">
			<input type="image" src="/images/buttons/Place-Your-Order.gif" onClick="$('place_order').addClassName('hidden'); $('processing').removeClassName('hidden'); showPleaseWait();"/>
		</div>
		<div id="processing" style="font-weight: bold; font-size: 14px;" class="hidden">
			Processing order...
		</div>
	</div>

	<?= $this->element("cart/cart",array('checkout'=>1,'review'=>1,'read_only_summary'=>1,'receipt'=>1)); ?>

	<div class="center">
		<input type="image" src="/images/buttons/Place-Your-Order.gif" onClick="showPleaseWait();"/>
	</div>

</form>

<div>
</div>

</div>
