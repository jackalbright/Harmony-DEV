<div class="sidebar_block" id="">
	<div class="sidebar_header">
		Pricing Calculator:
	</div>

	<div class="sidebar_content">

	<script>
	//var product_pricing = new Array();

	<? foreach($product['ProductPricing'] as $pricing) { ?>
	//product_pricing[<?= $pricing['quantity'] ?>] = <?= sprintf("%.02f", $pricing['price']) ?>;
	<? } ?>

	</script>

	<!--<form method="POST" action="/products/calculator/<?=$prod?>">-->
	<? echo $ajax->form("calculator/$prod",'post', array('model'=>'Product','enctype'=>'multipart/form-data','name'=>'pricingForm','id'=>'pricingForm','update'=>'pricing_calculator_holder')); ?>

	<table border=0 id="pricing_calculator" width="100%">
	<tr>
		<th valign=top>
			Quantity:
		</th>
		<td colspan=1>
			<input type="text" name="data[Product][quantity]" value="<?= $quantity ?>" size="4"/>
			<br/>
			Save more when you buy more.
		</td>
	</tr>
	<tr class="">
		<th valign=top>Base price each:</th>
		 <td valign=top colspan=1>
			$<span id="base_unit_price"><?= sprintf("%.02f", $base_pricing); ?></span>
		</td>
	</tr>
	<? $i = 0; foreach($product['ProductPart'] as $part) { 
		if ($part['optional'] != 'yes' || $part['Part']['price'] <= 0) { continue; }
		# XXX TODO

		# If optional, price gets added when checked.
		# If not optional, price gets deducted when unchecked.
	
	?>
	<tr class="<?= $i++ % 2 == 0 ? "even" : "odd" ?>">
		<th valign=top>
			<?= $part['Part']['part_name'] ?>:
			<br/>
			(optional)
		</th>
		<td valign=top>
			<? if (!empty($this->data['Product']['options'][$part['Part']['part_name']])) { ?>
			<div id="part_<?= $part['Part']['part_id']?>_checked">
			<?= $form->checkbox("Product.options.".$part['Part']['part_name'], array('value'=>1)); ?>
				<?= sprintf("$%.02f", $part['Part']['price']); ?>
			</div>
			<? } else { ?>
			<div id="part_<?= $part['Part']['part_id']?>_unchecked">
			<?= $form->checkbox("Product.options.".$part['Part']['part_name'], array('value'=>1)); ?>
				<span class="" style="font-weight: bold; color: #00FF00;">
					<?= sprintf("You save $%.02f", $part['Part']['price']); ?>
				</span>
			</div>
			<? } ?>
			
		</td>
	</tr>
	<? } ?>
	<tr>
		<th valign=top>
			Total price each:
		</th>
		<td colspan=1>
			$<span id="unit_price"><?= sprintf("%.02f", $each_total); ?></span>
		</td>
	</tr>
	<tr>
		<td colspan=2>&nbsp;</td>
	</tr>
	<tr>
		<th valign=top>
			Subtotal:
		</th>
		<td colspan=1>
			$<span id="subtotal"><?= sprintf("%.02f", $subtotal); ?></span>
			<br/>
			<? if ($subtotal < $individual_subtotal) { ?>
			<div id="" style="color: #00FF00;">
			You save <?= sprintf("$%.02f", $individual_subtotal-$subtotal) ?> by ordering more!
			</div>
			<? } ?>
		</td>
	</tr>
	<tr>
		<th valign=top>Zip Code:</th>
		<td colspan=1>
			<?= $form->input("Product.zipCode", array('size'=>5,'label'=>'')); ?>
		</td>
	</tr>

	<tr>
		<td colspan=2 align="right">
			<input type="submit" value="Calculate"/>
			<!--<input type="submit" value="Create <?= $hd->pluralize($product['Product']['short_name']); ?>"/>-->
		</td>
	</tr>
	<tr>
		<td colspan=2>
			<label for="shippingMethod"><b>Shipping:</b></label>
			<br/>
			<? if(empty($this->data['Product']['zipCode'])) { ?>
			Enter in your zip code to calculate shipping costs.
			<? } else { ?>
			<select id="shippingMethod" name="data[Product][shippingMethod]" onChange="showSelectedContent(this, 'grandtotal'); ">
				<? foreach($shippingOptions as $shippingOption) { ?>
				<option value="<?= $shippingOption['shippingPricePoint']['shippingMethod']?>"><?= $shippingOption['shippingMethod']['name'] ?> - <?= sprintf("$%.02f", $shippingOption[0]['cost']); ?></option>
				<? } ?>
			</select>
			<? } ?>
		</td>
	</tr>
	<? if (!empty($grand_totals)) { ?>
	<tr>
		<th valign=top>
			Grand Total:
		</th>
		<td valign=top>
			<? $i = 0; foreach($grand_totals as $method => $grand_total) { ?>
				<? if ($grand_total > 0) { ?>
					<div id="grandtotal_<?=$method ?>" class="grandtotal <?= $i++ > 0 ? "hidden" : "" ?>">
					$<span class=""><?= sprintf("%.02f", $grand_total); ?></span>
					</div>
				<? } ?>
			<? } ?>
		</td>
	</tr>
	<? } ?>

	<tr>
		<td colspan=2>
		<?= $hd->product_element("products/select_button", $product['Product']['prod'], array('product'=>$product,'related'=>$related_products)); ?>
		</td>
	</tr>

	</table>

	</div>
	
</div>
