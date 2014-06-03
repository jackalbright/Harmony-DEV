<div id="estimate_container">

<?
$discounted = ($build['retail_price_list']['total'] > $build['quantity_price_list']['total']);

?>

		<div class="preview_option_quantity preview_option_value">
			<table cellpadding=0 cellspacing=2 width="100%">
			<? if(!empty($build['quantity_price_list'])) { ?>
				<tr>
					<td> Unit price</td>
					<td align="right"> <?= sprintf("$%.02f", $build['quantity_price_list']['base']); ?> </td>
				</tr>
				<?
				foreach($build['quantity_price_list'] as $option => $option_cost)
				{
					if ($option == 'base' || $option == 'total') { continue; }
					$option_name = $option;
					if (!empty($options))
					{
						foreach($options as $opt)
						{
							if ($opt['Part']['part_code'] == $option && !empty($opt['Part']['part_name']))
							{
								$option_name = $opt['Part']['part_name'];
							}
							
						}
					}
					if($option == 'stamp') { $option_name = 'Surcharge - high value stamp'; }
				?>
				<tr>
					<td> 
						<? if ($option_cost < 0) { ?>
						No 
						<? } ?>
						<? if(in_array($option, $option_list)) { ?>
						<?= ucfirst($option_name) ?> (optional) 
						<? } else { ?>
						<?= ucfirst($option_name) ?>
						<? } ?>
					</td>
					<? if ($option_cost < 0) { ?>
					<td align="right">
						<?= sprintf("-$%.02f", -$option_cost); ?>
					</td>
					<? } else { ?>
					<td align="right">
						<?= sprintf("+$%.02f", $option_cost); ?>
					</td>
					<? } ?>
				</tr>
				<? } ?>
				<? if ($build['quantity_price_list']['base'] < $build['quantity_price_list']['total']) { ?>
				<tr>
					<td> Unit price</td>
					<td align="right"> <?= sprintf("$%.02f", $build['quantity_price_list']['total']); ?> </td>
				</tr>
				<? } ?>
			<? } ?>
			<tr>
				<td valign="top">
					<b>Quantity</b><br/>
					(Minimum: <?= $build["Product"]['minimum'] ?>)
				</td>
				<td valign="middle" align="right">
					<input id="setupCharge" type="hidden" name="data[setup_charge]" value="<?= !empty($build['Product']['setup_charge']) ? $build['Product']['setup_charge'] : 0 ?>"/>
					<input style="text-align: right;" id="quantity" type="text" name="data[quantity]" value="<?= !empty($build['quantity']) ? $build['quantity'] : $build['Product']['minimum']; ?>" size="4"/>
					<br/>
					<a id="update_button" href="Javascript:void(0);" onClick="if(assertMinimum('<?= $build['Product']['minimum'] ?>')) { update_build_pricing(); }" onUpdateXXX="hidePleaseWait();"><img align="top" alt="Calculate" src="/images/buttons/small/Calculate-grey.gif"/></a>
				</td>
			</tr>
			<tr>
				<td class="bold">
				Price
				</td>
				<td class="bold" align="right">
				<? if ($discounted) { ?>
					<div style="text-decoration: line-through;"><?= sprintf("$%.02f", $build['quantity'] * $build['retail_price_list']['total']); ?></div>
				<? } ?>
					<div style="<?= $discounted ? "color: red;" : "" ?>"><?= sprintf("$%.02f", (!empty($build['proof_only']) ? $proof_cost : $build['quantity'] * $build['quantity_price_list']['total'])); ?></div>
				<? if ($discounted) { ?>
					(<?= sprintf("%u%%", ($build['retail_price_list']['total'] - $build['quantity_price_list']['total']) / $build['retail_price_list']['total']*100); ?></b> off)
				<? } ?>
				</td>
			</tr>
			<? if(!empty($build['Product']['setup_charge'])) { ?>
			<tr>
				<td class="bold">
				Setup charge
				</td>
				<td class="bold" align="right">
					<?= sprintf("$%.02f", $build['Product']['setup_charge']); ?>
				</td>
			</tr>
			<? } ?>
			<? if(!empty($build['Product']['setup_charge'])) { ?>
			<tr>
				<td class="bold">
				Total
				</td>
				<td class="bold" align="right">
					<b style=""><?= sprintf("$%.02f", (!empty($build['proof_only']) ? $proof_cost : $build['quantity'] * $build['quantity_price_list']['total'])+$build['Product']['setup_charge'] ); ?></b>
				</td>
			</tr>
			<? } ?>
</table>
	<? if(!empty($next_tier)) { ?>
	<div class="green" style="font-size: 10px;">
		Save more when you order <?= $next_tier ?> or more.
	</div>
	<? } ?>

</div>
