		<table>
		<tr>
			<td>
			Subtotal:
			</td>
			<td align="right">
				<?= sprintf("$%.02f", $subtotal); ?>
			</td>
		</tr>

		<? if(!empty($discount)) { ?>
			<tr>
				<td class="" style="">
				Promo Code:
				</td>
				<td class="" style="text-align: right;">
					-$<?= sprintf("%.02f", $discount); ?>
				</td>
			</tr>
		<? } ?>

		<? if (!empty($shippingTotal) || !empty($shippingTotalOrig)) { ?>
		<tr>
			<td>
			Shipping:
			</td>
			<td align="right">
			<?= empty($shippingOption[0]['cost']) ? "<span class='alert2'>FREE</span>" : sprintf("$%.02f", $shippingOption[0]['cost']); ?>
			</td>
		</tr>
		<? } ?>
		<? if(!empty($rush_cost)) { ?>
		<tr>
			<td>
			Rush charge:
			</td>
			<td align="right">
				<?= sprintf("$%.02f", $rush_cost); ?>
			</td>
		</tr>
		<? } ?>

		<tr><td colspan=2>
			<hr/>
		</td></tr>

		<tr>
			<td class="smallcaps" style="color: #B82A2A;">
			Grand Total:
			</td>
			<td class="bold" style="color: #B82A2A;" align="right">
				<? if(!empty($grandTotals)) { ?>
					<? $i = 0; foreach($grandTotals as $method_id => $grandTotal) { ?>
					<div id="grandTotal<?= $method_id ?>" class="<?= ($i++ == 0 && !$defaultShippingMethod) || $defaultShippingMethod == $method_id ? "" : "hidden" ?> grandTotal">
						<b><?= sprintf("$%.02f", $grandTotal); ?></b>
					</div>
					<? } ?>
				<? } else if (!empty($shippingTotal) || !empty($shippingTotalOrig)) { ?>
					<? if(empty($rush_cost)) { $rush_cost = 0; } ?>
					<? if(empty($discount)) { $discount = 0; } ?>
					<?= sprintf("$%.02f", $subtotal + $shippingTotal + $rush_cost - $discount); ?>
				<? } ?>
			</td>
		</tr>
		</table>

