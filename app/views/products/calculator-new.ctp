<div class="sidebar_block" id="">
	<div class="sidebar_header">
		Pricing Calculator:
	</div>

	<div class="sidebar_content">

	<? if (!empty($isNotAjax)) { ?>
		<form method="POST" action="/products/calculator/<?=$prod?>">
	<? } else { ?>
		<? echo $ajax->form("calculator/$prod",'post', array('model'=>'Product','enctype'=>'multipart/form-data','name'=>'pricingForm','id'=>'pricingForm','update'=>'pricing_calculator_holder')) ?>
	<? } ?>
	<? #,'onSubmit'=>"assertMinimum('".$product['ProductPricing'][0]['quantity']."'); return false;")); 
	?>

	<? if ($product_option_field != "productCode") { ?>
		<input type="hidden" name="productCode" id="productCode" value="<?= $prod ?>"/>
	<? } ?>

	<table border=0 id="pricing_calculator" width="100%">
	<? if (count($product_options) > 0) { ?>
	<tr>
		<th colspan=2>
				<label class="" for="productCode">Select a <?= strtolower($parent_product['Product']['short_name']) ?> style:</label>
		</th>
	<tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan=1>
				<select id="<?= $product_option_field ?>" name="<?= $product_option_field ?>" class="required" onChange="selectTab(this.value, 'gtab'); $('<?= $product_option_field ?>_hidden').value = this.value;">
					<? foreach($product_options as $key => $label) { ?>
					<option <?= $key == $prod ? "selected='selected'" : "" ?> value="<?= $key ?>"><?= $label ?></option>
					<? } ?>
				</select>
		</td>
	</tr>
	<? } ?>
	<tr>
		<th valign=top>
			Quantity:
		</th>
		<td colspan=1>
			<input id='quantity_calc' type="text" name="data[Product][quantity]" value="<?= $quantity ?>" size="4" onChange="var hidden = $('quantity_hidden'); var addtocart = $('quantity'); if(hidden) { hidden.value = this.value; } else if (addtocart) { addtocart.value = this.value; }"/>
			<!-- return assertMinimum('<?= $product['ProductPricing'][0]['quantity'] ?>');"/> -->
			Save more when you order <?= $next_tier ? "$next_tier or " : ""?>more.
		</td>
	</tr>

	<? if (!$product['Product']['is_stock_item']) { ?>
	<? $i = 0; foreach($product['ProductPart'] as $part) { 
		if ($part['optional'] != 'yes' || $part['Part']['price'] <= 0) { continue; }
	?>
	<tr>
		<th valign="top">
		Options:
		</th>
	</tr>


	<? $i = 0; foreach($product['ProductPart'] as $part) { 
		if ($part['optional'] != 'yes' || $part['Part']['price'] <= 0) { continue; }
		# XXX TODO

		# If optional, price gets added when checked.
		# If not optional, price gets deducted when unchecked.
	
	?>
	<? if ($i == 0) { ?>
	<tr class="">
		<th valign=top>Base price:</th>
		 <td valign=top colspan=1>
			$<span id="base_unit_price"><?= sprintf("%.02f each", $base_pricing); ?></span>
			<? if($base_discount_percent > 0) { ?>
			<div id="" style="color: #FF9900;">
			<?= sprintf("(%u%% off)", $base_discount_percent) ?>!
			</div>
			<? } ?>
		</td>
	</tr>
	<? } ?>
	<tr class="<?= $i++ % 2 == 0 ? "" : "" ?>">
		<th valign=top>
			<?= $part['Part']['part_name'] ?>:
			<br/>
			(optional)
		</th>
		<td valign=top>
			<div id="part_<?= $part['Part']['part_id']?>_checkbox">
			<?= $form->select("Product.options.".$part['Part']['part_code'], 
				array('0'=>"$0.00 - Not Included", '1'=>sprintf("+$%.02f - Included", $part_price[$part["Part"]['part_code']])), null, null, false); ?>
			</div>
			
		</td>
	</tr>
	<? } ?>
	<!--
	<? if($product['Product']['code'] != 'P') { ?>
	<tr>
		<th valign=top>Included:</th>
		<td>
		<? if(preg_match("/(custom|repro)/", $product['Product']['image_type'])) { ?>
		FREE full color printing<br/>
		<? } ?>
		FREE setup and design when our standard template is used<br/>
		<? if(isset($parts['Quote'])) { ?>
		FREE typesetting for your quotation or text<br/>
		<? } ?>
		<? if(isset($parts['Personalization'])) { ?>
		FREE  personalization/name drop/logo <br/>
		<? } ?>
		</td>
	</tr>
	<? } ?>
	-->
	<? } ?>
	<!--
	<tr>
		<th valign=top>Included (FREE):</th>
		<td>
		<ul>
			<li>Setup and design - FREE
			<? if (!$product['Product']['is_stock_item']) { ?>
			<li>Full color printing - FREE
			<? } ?>
			<? $i = 0; foreach($product['ProductPart'] as $part) { 
				if ($part['Part']['part_title'] && $part['Part']['is_feature'] && ($part['optional'] != 'yes' || $part['Part']['price'] <= 0)) { 
				?>
				<li><?= $part['Part']['part_title'] ?>
				<?
				}
			}
			?>
		</ul>
		</td>
	</tr>
	-->
	<tr>
		<th valign=top>
			Unit price:
		</th>
		<td colspan=1>
			$<span id="unit_price"><?= sprintf("%.02f", $each_total); ?></span> each
		</td>
	</tr>
	<!--
	<tr>
		<td colspan=2>
		<hr/>
		</td>
	</tr>
	-->
	<tr style="font-size: 1.2em; font-weight: bold; background-color: #EEEEFF; border: solid #CCC 1px; padding: 5px;">
		<th valign=top style="padding: 5px;">
			Subtotal:
		</th>
		<td colspan=1 style="padding: 5px;">
			<? if ($savings_total > 0) { ?>
			<span style="text-decoration: line-through; "><?= sprintf("$%.02f", $subtotal + $savings_total); ?></span><br/>
			<? } ?>
			<span id="subtotal" style="<? if($savings_total > 0) { echo "color: red;"; } ?>"><?= sprintf("$%.02f", $subtotal); ?></span>
			<br/>
			<? if ($savings_total > 0) { ?>
			<div id="" style="" class="savings">
			You save <?= sprintf("$%.02f", $savings_total) ?> <? if ($discount_percent < 100) { echo sprintf(" (%u%% off)", $discount_percent); } ?>!
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
		<th valign="top">Shipping:</th>
		<td colspan=1>
			<? if($ships_by) { ?>
			<i>Ships by: <?= $ships_by ?></i><br/>
			<? } ?>
			<? if(empty($this->data['Product']['zipCode'])) { ?>
			Enter your zip code to calculate shipping costs.
			<? } else { ?>
			<select id="shippingMethod" name="data[Product][shippingMethod]" onChange="showSelectedContent(this, 'grandtotal'); ">
				<? foreach($shippingOptions as $shippingOption) { ?>
				<? echo "SO=".print_r($shippingOption,true); ?>
				<?
					$dayMin = $shippingOption['shippingMethod']['dayMin'];
					$dayMax = $delivery_days = $shippingOption['shippingMethod']['dayMax'];
					$delivery_time = $ships_by_time + 24*60*60;
					while($delivery_days > 0)
					{
						$delivery_time += 24*60*60;
						$delivery_day = date("D", $delivery_time);
						if ($delivery_day != "Sun" && $delivery_date != "Mon") { $delivery_days--; }
					}
				?>
				<option value="<?= $shippingOption['shippingPricePoint']['shippingMethod']?>"><?= $shippingOption['shippingMethod']['name'] ?> - <?= sprintf("$%.02f", $shippingOption[0]['cost']); ?><!--: <?= $dayMax > $dayMin ? "$dayMin - $dayMax days" : "$dayMin day" ?> --> - by <?= date("l F j, Y", $delivery_time); ?></option>
				<? } ?>
			</select>
			<? } ?>
		</td>
	</tr>
	<? if (!empty($grand_totals)) { ?>
	<tr>
		<th valign=top>
			Grand total:
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
		<td colspan=2 align="right">
			<!--<input type="submit" value="Calculate" onClick="return assertMinimum('<?= $product['ProductPricing'][0]['quantity'] ?>'); "/>-->
			<input type="image" src="/images/buttons/Calculate-grey.gif"/>
			<!--<input type="submit" value="Create <?= $hd->pluralize($product['Product']['short_name']); ?>"/>-->
		</td>
	</tr>

	</table>
	</form>

	<div class="clear"></div>
</div>
