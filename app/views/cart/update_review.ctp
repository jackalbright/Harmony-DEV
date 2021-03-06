<div>
	<table style="width: 275px !important; border: solid #CCC 1px; border-style: solid; margin: 5px; background-color: #EEEEFF;" class="solid_border" cellpadding=5>

	<? if(true || empty($review)) { ?>
	<tr>
		<td colspan='3' style="background-color: #AAA; color: #B82A2A !important; font-weight: bold;">
			Calculate Shipping
		</td>
	</tr>
	<tr style="background-color: #EEEEFF;">
		<td colspan="1" align="left" valign="top">

		<b>Subtotal:</b>
		</td>
		<td colspan="1" align="right" valign="top">
			<?= sprintf("$%.02f", $subtotal); ?>
		</td>
		<td valign="top" align="right">
			&nbsp;
		</td>
	</tr>
	<? if(!empty($discount)) { ?>
	<tr>
		<td colspan="1" align="left" valign="top">
		<b>Promo Code:</b>
		</td>
		<td colspan="1" rowspan=1 valign=top align="right">
			<?= sprintf("-$%.02f", $discount ); ?>
		</td>
	</tr>
	<? } else { $discount = 0; } ?>
	<? if(empty($read_only_summary) && (empty($checkout) || !empty($zipCode))) { ?>
	<tr>
		<td align="left" valign="top" colspan=3>
		<b>Ship to:</b>
		<table width="100%" style="font-size: 12px;">
		<tr>
			<td valign="top">Country:</td>
			<td valign="top">
				<? if(empty($checkout)) { ?>
				<?= $form->select("Country", $countries_map, (!empty($country)?$country:'US'), array(), false); ?>
				<? } else { ?>
					<?= empty($country) || empty($countries_map[$country]) ? $countries_map['US'] : $countries_map[$country]; ?><br/>
				<? } ?>
			</td>
		</tr>
		<tr>
			<td valign="top">Postal Code:</td>
			<td valign="top">
				<? if(empty($checkout)) { ?>
				<input align="left" type="text" size="6" name="zipCode" value="<?= $zipCode ?>"/>
				<input type="image" valign="bottom" height="25" onClick="$('shippingWait').removeClassName('hidden'); $('shippingOptions').addClassName('hidden'); return updateCartReview();" style="vertical-align: top;" src="/images/buttons/small/Calculate-grey.gif"/>
				<? } else { ?>
					<?= $zipCode ?>
				<? } ?>
			</td>
		</tr>
		</table>

		</td>
	</tr>
	<? } ?>

	<tbody id="shippingWait" class="hidden">
	<tr>
		<td colspan=3 align="center" class="bold"> 
			Please wait...
		</td>
	</tr>
	</tbody>

	<tbody id="shippingOptions">
	<? if(!empty($zipCode) && empty($shippingOptions)) { ?>
	<tr>
		<td colspan=3>
	<div class="alert bold">Could not calculate shipping. Please double check country and postal code for accuracy.</div>
		</td>
	<? } ?>

<? if(empty($checkout) && empty($read_only_summary) && (!empty($shippingTotal) || !empty($shippingTotalOrig))) { ?>
	<?= $this->element("cart/shipping_select"); ?>
<? } else if(empty($checkout)) { ?>
<tr>
	<td colspan=3>
	Type in your postal code to choose a shipping speed and calculate shipping.
	</td>
</tr>
<? } ?>

	<? if(!empty($shippingTotal) || !empty($shippingTotalOrig)) { ?>
	<tr>
		<td colspan="1" align="left" valign="top">
		<b>Shipping:</b>
		</td>
		<td colspan="1" rowspan=1 valign=top align="right">
			<? if(empty($shippingTotal) && !empty($shippingTotalOrig)) { ?>
				<span style='text-decoration: line-through; '><?= sprintf("$%.02f", $shippingTotalOrig ); ?></span> <span class="alert bold">FREE</span>
			<? } else { ?>
			<?= sprintf("$%.02f", $shippingTotal ); ?>
			<? } ?>
		</td>
	</tr>
	<? } ?>
	<? if(!empty($rush_cost)) { ?>
	<tr>
		<td colspan="1" align="left" valign="top">
		<b>Rush Charges:</b>
		</td>
		<td colspan="1" rowspan=1 valign=top align="right">
			<?= sprintf("$%.02f", $rush_cost ); ?>
		</td>
	</tr>
	<? } else { $rush_cost = 0; } ?>


	<? if (!empty($shippingTotal) || !empty($shippingTotalOrig)) { $grandTotal = $subtotal + $shippingTotal + $rush_cost - $discount; ?>
	<tr style="background-color: #EEEEFF; font-variant: small-caps;" class="">
		<td colspan="1" align="left" class="bold alert" valign="bottom">
			<b>Grand Total:</b>
		</td>
		<td colspan=1 valign="bottom" class="bold alert" align="right">
			<div id="grandTotal<?= $defaultShippingMethod ?>" class="grandTotal">
					<b><?= sprintf("$%.02f", $grandTotal); ?></b>
			</div>
		</td>
		<td>&nbsp;</td>
	</tr>
	<? } ?>
	<? } ?>

	<? if(!empty($review)) { ?>
	<tr>
			<td valign="top" class="border" colspan=3>
				<b>Comments:</b>
				<textarea style="width: 95%; height: 150px;" name="orderComment"></textarea>
			</td>
	</tr>
	<? } ?>

	</tbody>

	</table>
</div>
