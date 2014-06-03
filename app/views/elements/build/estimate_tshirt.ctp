<div id="estimate_container">

<?
$discounted = ($build['retail_price_list']['total'] > $build['quantity_price_list']['total']);
if(empty($product)) { $product = $build; }
?>
<table cellpadding=3 cellspacing=0>
<? if(isset($build['quantity'])) { ?>
<tr>
	<td valign="top">
		<div class="preview_option_quantity preview_option_value">
		<script>
		function quantitySizeChange()
		{
			var qty = 0;
			var inputs = document.getElementsByClassName("quantity_size");
			for(var i = 0; i < inputs.length; i++)
			{
				if(inputs[i].value > 0)
				{
					qty += parseInt(inputs[i].value);
				}
			}

			$('quantity').value = qty;
			$('quantity_text').innerHTML = qty;

		}
		</script>
			<div class="bold">Choose your quantities. You may mix and match sizes to meet your minimum (<?= $product['Product']['minimum'] ?>).</div>
			<?
				$adult_sizes = array(
					'S',
					'M',
					'L',
					'XL',
					'XXL',
					'XXXL'
				);

				$youth_sizes = array(
					'YS',
					'YM',
					'YL',
					'YXL'
				);
			?>

			<table>
			<tr><th colspan=3>Adult</th></tr>
			<? foreach($adult_sizes as $size) { 
				$surcharge = !empty($build['Product']["surcharge_$size"]) ? $build['Product']["surcharge_$size"] : 0;
				$price = $build['quantity_price_list']['total'] + $surcharge;
			?>
			<tr>
				<th><?= $size ?></th>
				<td>
					<input class="quantity_size" id="quantity_size_<?=$size?>" type="text" name="data[options][quantity_size][<?=$size?>]" value="<?= !empty($build['options']['quantity_size'][$size]) ? $build['options']['quantity_size'][$size] : null; ?>" size="4" onChange="quantitySizeChange(this);" style="width: 3em;"/>
				</td>
				<td>
					x <?= sprintf("$%.02f", $price); ?> ea
				</td>
			</tr>
			<? } ?>

			<tr><th colspan=3>Youth</th></tr>
			<? foreach($youth_sizes as $size) { 
				$surcharge = !empty($build['Product']["surcharge_$size"]) ? $build['Product']["surcharge_$size"] : 0;
				$price = $build['quantity_price_list']['total'] + $surcharge;
			?>
			<tr>
				<th><?= $size ?></th>
				<td>
					<input class="quantity_size" id="quantity_size_<?=$size?>" type="text" name="data[options][quantity_size][<?=$size?>]" value="<?= !empty($build['options']['quantity_size'][$size]) ? $build['options']['quantity_size'][$size] : null; ?>" size="4" onChange="quantitySizeChange(this);" style="width: 3em;"/>
				</td>
				<td>
					x <?= sprintf("$%.02f", $price); ?> ea
				</td>
			</tr>
			<? } ?>

			<tr>
				<td>Qty</td>
				<td align="center">
					<input id="quantity" type="hidden" name="data[quantity]" value="<?= $build['quantity'] ?>"/>
					<span id="quantity_text"><?= !empty($build['quantity']) ? $build["quantity"] : $build['Product']['minimum']; ?></span>
				</td>
				<td align="right">
					<a id="update_button" href="Javascript:void(0);" onClick="quantitySizeChange(); if(assertMinimum('<?= $build['Product']['minimum'] ?>')) { update_build_pricing(); };" onUpdate="hidePleaseWait();"><img src="/images/buttons/small/Calculate-grey.gif"/></a>
				</td>
			</tr>


			<tr>
				<td colspan=2 align="right" valign="bottom">
					<hr/>
					<b style="color: red;"><?= sprintf("$%.02f", (!empty($build['proof_only']) ? $proof_cost : $build['quantity'] * $build['quantity_price_list']['total'] + (!empty($build['quantity_price_list']['surcharge']) ? $build['quantity_price_list']['surcharge'] : 0) )); ?></b>
					&nbsp;
				</td>
				<td valign="bottom">
					your cost
					<? if(!empty($build['proof_only'])) { ?><b>PROOF ONLY</b><? } ?>
				</td>
			</tr>
			</table>
	
		</div>
	</td>
</tr>
<? } ?>
</table>


</div>
