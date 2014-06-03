<?
$name = ucwords($product['Product']['short_name']);
?>
<div>
<h3>Calculate <?= $name ?> Shipping Costs (US Only):</h3>

<? echo $ajax->form("calculator/$prod",'post', array('model'=>'Shipping','enctype'=>'multipart/form-data','name'=>'shippingForm','id'=>'shippingForm','update'=>'shipping_calculator')); ?>

<table>
<tr>
<? if (!$prod) { ?>
<td>
	<select name="prod">
		<? foreach($products as $product_option) { ?>
			<option value="<?= $product_option['Product']['code']?>"><?= $product_option['Product']['name']?></option>
		<? } ?>
	</select>
</td>
<? } ?>
<td>
<?= $form->input("Shipping.quantity",array('size'=>10)); ?>
</td>
<td>
<?= $form->input("Shipping.zipCode",array('size'=>8)); ?>
</td>
<td>
<?= $form->submit('Calculate'); ?>
</td>
</tr>
</table>

<?= $form->end(); ?>

</div>

<? if (isset($shippingOptions)) { ?>
<table width="85%" border=0 cellspacing=0 cellpadding=5 class="shippingOptionContainer">
<tr class="shippingOptionHeader">
	<!--<th>Quantity</th>-->
	<th width="45%">Method</th>
	<th>Days</th>
	<!--<th>Destination</th>-->
	<th>Price</th>
	<th>Order</th>
</tr>
<? 
$i = 0;
foreach($shippingOptions as $shippingOption) { 
$shippingOptionEven = $i++ % 2 ? "shippingOptionEven" : "shippingOptionOdd";
?>
<tr class="shippingOption <?= $shippingOptionEven ?>">
	<!--<td>
		<?= $this->data['Shipping']['quantity']; ?>
		<?= $hd->pluralize($product['Product']['name']); ?>
		(<?= $shippingOption['shippingPricePoint']['weight'] ?> lbs.)
	</td>
	-->
	<td>
		<?= $shippingOption['shippingMethod']['name'] ?>
	</td>
	<td>
		<?= $shippingOption['shippingMethod']['dayMin'] ?>
		<? if ($shippingOption['shippingMethod']['dayMin'] < $shippingOption['shippingMethod']['dayMax']) { ?>
		 - <?= $shippingOption['shippingMethod']['dayMax'] ?>
		<? } ?>
		days
	</td>
	<!--
	<td>
		<?= $this->data['Shipping']['zipCode'] ?>
	</td>
	-->
	<td class="bold">
		$<?= sprintf("%.02f", $shippingOption[0]['cost']); ?>
	</td>
	<td align=right>
		<!--<input type="submit" value="Order <?= $hd->pluralize($product['Product']['name']); ?> &gt;"/>-->
		<?= $this->element("button", array('url'=>"/products/select/".$product['Product']['code']."?quantity=".$this->data['Shipping']['quantity']."&shippingMethod=".$shippingOption['shippingPricePoint']['shippingMethod'], "label"=>"Order $name >")); ?>
	</td>
</tr>
<? } ?>
</table>
<? } else if (isset($shippingOptions)) { ?>
No shipping options available.
<? } ?>
