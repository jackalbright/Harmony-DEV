<? $isNotAjax = empty($this->params['isAjax']) && empty($this->params['requested']); ?>

<div class="sidebar_block" id="">
<table width="100%">
<tr>
<td width="50%" valign="top">
	<h3> Pricing &amp; Shipping Calculator </h3>

	<div class="grey_header_top"><span>&nbsp;</span></div>
	<div class="" style="background-color: #CCC; padding: 5px;">

	<? $calcid = "Calculator".rand(10000,50000); ?>
	<?= $form->create("Product", array('url'=>"/products/calculator/$prod",'name'=>'pricingForm','id'=>$calcid)); ?>
	<script>
	if(self == top)
	{
		var target = j('#<?= $calcid ?>').closest('#modal').size() ? '#modal' : '#pricing_calculator_holder';
		j('#<?= $calcid ?>').ajaxForm({
			target: target
		});
	} // else iframe, so do normal form submit.
	</script>

	<? if ($product_option_field != "productCode") { ?>
		<input type="hidden" name="productCode" id="productCode" value="<?= $prod ?>"/>
	<? } ?>

	<? if (count($related_products) > 1) { ?>
		<div  class="bold" for="productCode">Select a style:</div>

		<select style="width: 100%;" id="<?= $product_option_field ?>" name="<?= $product_option_field ?>" class="required" XonChange="selectTab(this.value, 'gtab'); $('<?= $product_option_field ?>_hidden').value = this.value;" onChange="j('#atc_prod').val(this.value); ">
			<? foreach($related_products as $rp) { ?>
			<option <?= $rp['Product']['code'] == $prod ? "selected='selected'" : "" ?> value="<?= $rp['Product']['code'] ?>"><?= $rp['Product']['pricing_name'] ?><?= !empty($rp['Product']['pricing_description']) ? " &mdash; ".$rp['Product']['pricing_description'] : "" ?></option>
			<? } ?>
		</select>
	<? } else if ($prod == 'CH') { ?>
		<div class="bold">Select a charm:</div>
				<select name="charmID" onChange="j('#atc_charmID').val(this.value);">
					<? foreach($charms as $charm) { ?>
					<option <?= (!empty($charmID) && $charm['Charm']['charm_id'] == $charmID) ? "selected='selected'" : "" ?> value="<?= $charm['Charm']['charm_id'] ?>"><?= $charm['Charm']['name'] ?></option>
					<? } ?>
				</select>
	<? } else if ($prod == 'TA') { ?>
				<div class="bold">Select a tassel:</div>
				<select name="tasselID" onChange="j('#atc_tasselID').val(this.value);">
					<? foreach($tassels as $tassel) { ?>
					<option <?= (!empty($tasselID) && $tassel['Tassel']['tassel_id'] == $tasselID) ? "selected='selected'" : "" ?> value="<?= $tassel['Tassel']['tassel_id'] ?>"><?= ucwords($tassel['Tassel']['color_name']) ?></option>
					<? } ?>
				</select>
	<? } ?>

	<br/>

	<div class="bold">Your Quantity (Min: <?= $product['Product']['minimum'] ?>)</div>
	<table border=0 id="pricing_calculator" width="300">
	<tr>
		<td rowspan=1 colspan=1 align="left" width="35%">
			<input id='quantity_calc' align="right" type="text" name="data[Product][quantity]" value="<?= !empty($quantity) ? $quantity : $product['Product']['minimum'] ?>" size="4" onChange="var hidden = $('quantity_hidden'); var addtocart = $('quantity'); if(hidden) { hidden.value = this.value; } else if (addtocart) { addtocart.value = this.value; }; j('#atc_quantity').val(this.value);"/>
			<!-- return assertMinimum('<?= $product['ProductPricing'][0]['quantity'] ?>');"/> -->
		</td>
		<? if(!empty($each_total)) { ?>
		<td rowspan=1 width="30%" valign="bottom" >
			x $<span id="unit_price"><?= sprintf("%.02f", $each_total); ?></span> ea
		</td>
		<? if(!empty($subtotal)) { ?>
		<td valign="bottom" align="right" width="35%">
			= &nbsp;
			<? if (empty($is_wholesale) && !empty($savings_total) && $savings_total > 0) { ?>
			<span style="text-decoration: line-through; "><?= sprintf("$%.02f", $subtotal + $savings_total); ?></span>
			<? } else { ?>
			<span id="subtotal" style="<? if(!empty($savings_total) && $savings_total > 0) { echo "color: #B82A2A;"; } ?>"><?= sprintf("$%.02f", $subtotal); ?>
			<? } ?>
		</td>
		<? } ?>
	</tr>
	<? } ?>
	<tr>
		<td colspan=3 valign="top" align="right">
		<? if (empty($is_wholesale) && !empty($savings_total) && $savings_total > 0) { ?>
			<span id="subtotal" style="<? if(!empty($savings_total) && $savings_total > 0) { echo "color: #B82A2A;"; } ?>"><?= sprintf("$%.02f", $subtotal); ?>
			<br/>
			<? if (empty($is_wholesale) && $savings_total > 0) { echo sprintf(" (%d%% off)", ($savings_total/$original_subtotal*100)); } ?>
			</span>
		<? } ?>
		</td>
	</tr>
	<tr>
		<td colspan=3>
			<? if(!empty($next_tier)) { ?>
				Save more when you order <?= $next_tier ? "$next_tier or " : ""?>more.
			<? } ?>
		</td>
	</tr>

	<? if (!$product['Product']['is_stock_item']) { ?>
	<? $i = 0; foreach($product['ProductPart'] as $part) { 
	#print_r($part);
		if ($part['optional'] != 'yes' || $part['Part']['price'] <= 0) { continue; }
		if (empty($this->data["Product"]["options"][$part['Part']['part_code']])) { continue; } # Only count stuff we already picked...
	?>
	<? if ($i == 0) { ?>
	<tr class="">
		<th valign=top>Base price:</th>
		 <td valign=top colspan=1 align="right">
			$<span id="base_unit_price"><?= sprintf("%.02f base price each", $base_pricing); ?></span>
			<? if(empty($is_wholesale) && $base_discount_percent > 0) { ?>
			<div id="" style="color: #FF9900;">
			<?= sprintf("(%u%% off)", $base_discount_percent) ?>!
			</div>
			<? } ?>
		</td>
	</tr>
	<? } ?>
	<tr class="<?= $i++ % 2 == 0 ? "" : "" ?>">
		<td align="right">+</td>
		<td valign=top align="right">
			<?= sprintf("$%.02f", $part_price[$part["Part"]['part_code']]); ?>
			<?= strtolower($part['Part']['part_name']) ?>
			(optional)
		</td>
	</tr>
	<? } } ?>
	<? if(!empty($setup)) { ?>
	<tr>
		<th valign=top>
			Setup:
		</th>
		<td colspan=1 align="right">
			$<span id="setup"><?= sprintf("%.02f", $setup); ?></span>
			<input type="hidden" name="customized" value="<?= !empty($customized) ?>"/>
		</td>
	</tr>
	<? if(!empty($subtotal)) { ?>
	<tr style="">
		<th valign=top style="padding-top: 10px; padding-bottom: 10px;">
			Subtotal:
		</th>
		<td colspan=1 valign="top" align="right" style="padding-top: 10px; font-weight: bold; padding-bottom: 10px;">

			<? if (empty($is_wholesale) && $savings_total > 0) { ?>
			<span style="text-decoration: line-through; "><?= sprintf("$%.02f", $subtotal + $savings_total); ?></span>
			<? } ?>
			<span id="subtotal" style="<? if($savings_total > 0) { echo "color: red;"; } ?>"><?= sprintf("$%.02f", $subtotal); ?></span>
			<br/>
			<? if (empty($is_wholesale) && $savings_total > 0) { echo sprintf(" (%u%% off)", ($savings_total/$subtotal)); } ?>
		</td>
	</tr>
	<? } ?>
	<? } ?>
	<tr>
		<td colspan=3 valign="top">
			<div class="bold">Ship to Zip:</div>
			<div class="right">
				<input type="image" align="top" src="/images/buttons/small/Calculate-grey.gif" onClick="showPleaseWait();"/>
			</div>
			<input name="data[Product][zipCode]" value="<?= !empty($this->data['Product']['zipCode']) ? $this->data['Product']['zipCode'] : "" ?>" size="5"/>
		</td>
	</tr>

	<? if(!empty($this->data['Product']['zipCode'])) { ?>
	<tr>
		<td colspan=3>
			<div style='padding: 5px 0px;'>
				<div class='left bold' style='padding-right: 5px;'>Ships By:</div>
				<div style="overflow: hidden;">
					<?= $ships_by ?>
					(approximate)
					<br/>
					<div style="font-size: 12px;">
					If you have a time sensitive event, please call 888.293.1109 to discuss rush service
					</div>
				</div>
				<div class='clear'></div>
			</div>
			<div class="bold">Shipping:</div>
			<? $i = 0; foreach($shippingOptions as $so) { ?>
			<div>
				<?
					$old_shipcost = $so['shippingPricePoint']['cost'];
					$shipcost = $so[0]['cost'];
					$original_cost = !empty($so[0]['original_cost']) ? $so[0]['original_cost'] : $so[0]['cost'];
					$days = $so['shippingMethod']['dayMax'];
					$num2name = array('','One','Two','Three','Four','Five','Six','Seven','Eight','Nine','Ten');
					if($days == 1)
					{
						$daysname = 'Overnight';
					}
					else if($days == 5)
					{
						$daysname = 'Standard';
					} else {
						$daysname = $num2name[$days]. ' Day';
					}
				?>
					<label style="padding: 0px;">
					<div class="right" align="right">
						<? if($shipcost <= 0) { ?>
							<span style="text-decoration: line-through;"><?= sprintf("$%.02f", $original_cost); ?></span><br/>
							<span style="font-weight: bold; color: #FF0000;">FREE</span>
						<? } else { ?>
							<?= sprintf("$%.02f", $shipcost); ?>
						<? } ?>
					</div>
					<input type="radio" name="shippingMethodID" value="<?= $so['shippingMethod']['shippingMethodID'] ?>" <?= $i++ == 0 ? "checked='checked'" : "" ?> onClick="$$('.grandTotal').each(function(d) { d.addClassName('hidden'); }); $('grandTotal_<?= $so['shippingMethod']['shippingMethodID'] ?>').removeClassName('hidden');"/>
					<span class="blue bold" style=""> <?= $daysname ?> Shipping </span>
					<div class="clear"></div>
					</label>
			</div>
			<? } ?>

	</td>
	</tr>

	<tr>
		<td colspan=3 align="right">
			<? $i = 0; foreach($shippingOptions as $so) { $shipcost = $so[0]['cost']; ?>
			<div style="font-weight: bold; font-size: 1.1em;" class="bold red grandTotal <?= $i++ > 0 ? "hidden" : "" ?>" id="grandTotal_<?= $so['shippingMethod']['shippingMethodID'] ?>">
				Grand Total: 
				<?= sprintf("$%.02f", $subtotal + $shipcost); ?>
			</div>
			<? } ?>
		</td>
	</tr>

	<? } ?>

	</table>
	</form>

	<div class="clear"></div>

			<script>
				hidePleaseWait();
			</script>
	</div>
	<div class="grey_header_bottom"><span>&nbsp;</span></div>

<? if(false && empty($customer['is_wholesale'])) { ?>
	<a onclick="var priceListImage = window.open('/info/reseller_pricing.php', 'Wholesaler_Pricing', 'location=no,toolbar=no,width=600,height=820,status=yes,resize=yes,scrollbars=yes,menubar=no'); priceListImage.focus(); return false;" href="#" style="font-variant: small-caps; font-weight: bold; color: #B82A2A;" class="">View Wholesale Pricing</a>
<? } ?>

</td>
<td valign="top" style="border-left: solid #CCC 1px; padding: 5px; padding-top: 35px;">
	<?= $parent_product['Product']['free_with_your_order']; ?>
	<?= $this->element("shipfree",array('nobr'=>1,'ul'=>1)); ?>

	<br/>
	<div style="text-align: center;">
	<? if($product['Product']['is_stock_item']) { ?>
	<form action="/cart/add.php" target='_top'>
		<? if($prod == 'CH') { ?>
			<input id="atc_charmID" type="hidden" name="charmID" value="<?= !empty($charmID) ? $charmID : $charms[0]['Charm']['charm_id'] ?>"/>
		<? } ?>
		<? if($prod == 'TA') { ?>
			<input id="atc_tasselID" type="hidden" name="tasselID" value="<?= !empty($tasselID) ? $tasselID : $tassels[0]['Tassel']['tassel_id'] ?>"/>
		<? } ?>
		<input id="atc_prod" type="hidden" name="productCode" value="<?= $prod ?>"/>
		<input id="atc_quantity" type="hidden" name="quantity" value="<?= !empty($quantity) ? $quantity : $product['Product']['minimum'] ?>"/>
		<input type="image" src="/images/buttons/Add-to-Cart.gif"/>
	</form>
	<? } else { ?>
	<form action="/gallery" target='_top'>
		<input id="atc_prod" type="hidden" name="prod" value="<?= $prod ?>"/>
		<input id="atc_quantity" type="hidden" name="quantity" value="<?= !empty($quantity) ? $quantity : $product['Product']['minimum'] ?>"/>
		<? if(in_array($prod, array('ST','P'))) { ?>
			<input type="image" src="/images/buttons/Browse-Stamps.gif"/>
		<? } else { ?>
			<input type="image" src="/images/buttons/Get-Started-teal.gif"/>
		<? } ?>
	</form>

	<? } ?>
	</div>

</td>
</tr>
</table>

</div>

<script>
Shadowbox.setup(target+" a[rel=shadowbox]", {});
</script>
