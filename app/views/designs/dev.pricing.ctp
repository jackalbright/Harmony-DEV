<div class='widget'>

<h3><?= Inflector::singularize($pricing['Product']['name']) ?> Pricing</h3>
<? $design = $this->Session->read("Design"); ?>
<? $sides = $this->Session->read("Design.Design.sides"); ?>
<div>


<div id="estimate_container">
<?
$quantity = !empty($pricing['quantity']) ? $pricing['quantity'] : null;#$pricing['Product']['minimum'];
#echo "Q=$quantity";
?>

		<div class="preview_option_quantity preview_option_value">
			<table cellpadding=2 cellspacing=0 width="100%">
			<tr>
				<td valign="middle" class="bold" rowspan=2>
					Qty.
				</td>
				<td align='right'>
					<input style="border: solid #B82A2A 1px; background-color: #FFF; padding: 5px; text-align: right; width: 3em;" id="quantity" type="text" name="data[Design][quantity]" value="<?= $quantity ?>" size="4"/>
					<br/>
					(Min: <?= $pricing["Product"]['minimum'] ?>)
				</td>
				<td colspan=2 align='right' class='bold' valign='top'>
				<div id="AddToCart" class='cta' align="right">
						<? if(!empty($design['Design']['cart_item_id'])) { ?>
							<?= $this->Form->submit("/images/buttons/Update-Cart.gif",array('value'=>'cart','onClick'=>"j.loading(); return j('#DesignForm').assertMinimum();",'div'=>false)); ?>
						<? } else { ?>
							<?= $this->Form->submit("/images/buttons/Add-to-Cart.gif",array('value'=>'cart','onClick'=>"j.loading(); return j('#DesignForm').assertMinimum();",'div'=>false)); ?>
						<? } ?>
					<div class='clear'></div>
					<br/>

				</div>
				</td>
			</tr>
			<tr>
				<td align='right'>
					<a class="update_button" href="Javascript:void(0);"><img align="top" alt="Calculate" src="/images/buttons/small/Calculate-grey.gif"/></a>
				</td>
				<td colspan=2 align='right'>
					<?= $this->Form->submit("/images/buttons/small/Save-For-Later-teal.gif",array('id'=>'SaveForLater','onClick'=>"j.loading();",'name'=>'data[form_submit]','value'=>'save','div'=>false)); ?>
				</td>
			</tr>
			<? if(empty($quantity)) { ?>
			<tr>
				<td colspan=4>
					<i>Type your quantity to calculate pricing</i>
				</td>
			</tr>
			<? } ?>
			<? if(!empty($quantity)) { ?>
			<tr>
				<td valign="top">
					<b>Unit Price</b>
				</td>
				<td align='right' valign="top">
					x <?= sprintf("$%.02f", $pricing['quantity_price_list']['base']); ?> 
				</td>
				<td valign='top'>
					=
				</td>
				<td align='right' valign='top'>
					<?= sprintf("$%.02f", $pricing['quantity_price_list']['base']*$quantity); ?>
				</td>
			</tr>
			<? if(!empty($pricing['quantity_price_list'])) { ?>
				<?
				foreach($pricing['quantity_price_list'] as $option => $option_cost)
				{
					# option_cost may be calculated based upon per item....

					if ($option == 'base' || $option == 'total' || $option == 'setup') { continue; }
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
					if($option == 'stamp') { $option_name = (in_array($pricing['Product']['code'], array('ST','P')) ? 'Surcharge <span style="font-size: 10px;">(High Value Stamp)</span>' : 'Surcharge <span style="font-size: 10px;">(Genuine Stamp)</span>'); }
				?>
				<tr>
					<td colspan=2 class=""> 
						<b>
						<? if ($option_cost < 0) { ?>
						No 
						<? } ?>
						<? if(false && in_array($option, $option_list)) { ?>
						<?= ucwords($option_name) ?> (optional) 
						<? } else { ?>
						<?= ucwords($option_name) ?>
						<? } ?>
						</b>
						<nobr>
						(<?= ($option_cost < 0) ? sprintf("-$%.02f", -$option_cost) : sprintf("+$%.02f", $option_cost); ?> ea)
						</nobr>
					</td>
					<? if ($option_cost < 0) { ?>
					<td valign='top'>
						-
					</td>
					<td align="right">
						<?= sprintf("$%.02f", -$option_cost*$quantity); ?>
					</td>
					<? } else { ?>
					<td valign='top'>
						+
					</td>
					<td align="right">
						<?= sprintf("$%.02f", $option_cost*$pricing['quantity']); ?>
					</td>
					<? } ?>
				</tr>
				<? } ?>
			<? } ?>

			<?
			$setup = !empty($pricing['quantity_price_list']['setup']) ? $pricing['quantity_price_list']['setup'] : 0;
			?>

			<? if(!empty($setup)) { ?>
			<tr>
				<td colspan=2>
					<b>Setup Charge</b>
				</td>
				<td valign='top'>
					+
				</td>
				<td valign="middle" align="right">
					<?= sprintf("$%.02f", $setup); ?>
					<input id="setupCharge" type="hidden" name="data[Design][setupPrice]" value="<?= $setup ?>"/>
				</td>
			</tr>
			<? } ?>

			<?
			?>

			<tr style='border-top: solid #999 1px;'>
				<td class="bold" colspan=2 valign='top'>
				Subtotal
				</td>
				<td valign='top'>
					=
				</td>
				<td class="" align="right">
				<?
				$discounted = ($pricing['retail_price_list']['total'] > $pricing['quantity_price_list']['total']);
				$subtotal = $pricing['quantity'] * $pricing['quantity_price_list']['total'] + $setup;
				?>
				<? if (empty($is_wholesale) && $discounted) { ?>
					<div id="estimate_retail" class="bold" style="text-decoration: line-through;"><?= sprintf("$%.02f", $retail = $pricing['quantity'] * $pricing['retail_price_list']['total'] + $setup); ?></div>
				<? } ?>
					<div id="estimate_total" class="bold" style="color: #B82A2A;"><?= sprintf("$%.02f", $estimate = (!empty($pricing['proof_only']) ? $proof_cost : $pricing['quantity'] * $pricing['quantity_price_list']['total'] + $setup)); ?></div>
				<? if (empty($is_wholesale) && $discounted) { ?>
					<i style='color: #555;'><?= sprintf("%u%%", 100-($estimate/$retail*100)); ?> off</i>
				<? } ?>

					<br/>
				</td>
			</tr>
			<? if(!empty($pricing['Product']['setup_charge'])) { ?>
			<tr>
				<td class="bold">
				Setup charge
				</td>
				<td class="bold" align="right">
					<?= sprintf("$%.02f", $pricing['Product']['setup_charge']); ?>
				</td>
			</tr>
			<? } ?>
			<? if(!empty($pricing['Product']['setup_charge'])) { ?>
			<tr>
				<td class="bold">
				Total
				</td>
				<td class="bold" align="right">
					<b style=""><?= sprintf("$%.02f", (!empty($pricing['proof_only']) ? $proof_cost : $pricing['quantity'] * $pricing['quantity_price_list']['total'])+$pricing['Product']['setup_charge'] ); ?></b>
				</td>
			</tr>

			<? } ?>

			<!--
			<tr>
				<td valign="middle" class="bold">
					Zip Code
				</td>
				<td align='right' valign='middle'>
					<?= $this->Form->input("zip_code", array('name'=>'data[zip_code]','size'=>7,'label'=>false,'align'=>'right','div'=>false)); ?>
				</td>
				<td colspan=2 align='right'>
				</td>
			</tr>
			-->
			<? } ?>
		</table>


		<? if(!empty($quantity)) { ?>
		<i>You'll be able to calculate shipping costs on the next page</i>
		<? } ?>
	</div>
	<? if(false && !empty($next_tier)) { ?>
	<div class="green" style="font-size: 10px;">
		Save more when you order <?= $next_tier ?> or more.
	</div>
	<? } ?>
</div>

<script>
j('#quantity').changeup(function() {
	if(j('#DesignForm').assertMinimum())
	{
		j.update_pricing(false, true);
	}
}, 1500);

j('.update_button').bind('click', function() { // get updated totals from qty
	if(j('#DesignForm').assertMinimum())
	{
		j.update_pricing(false, true);
		//j.update_pricing();
	}
});

j('#DesignForm :input').change(function() {
	j('#DesignForm').addClass('dirty');
});

j('#DesignForm input[type=image]').click(function() {
	j("input[type=image]", j(this).parents("form")).removeAttr('clicked');
	j(this).attr('clicked',true);
	j('#DesignForm').removeClass('dirty'); // ok to continue.
});
j('#DesignForm').submit(function() {
	j(this).data('submitted');
	var value = j('input[type=image][clicked=true]').val();

	j(this).attr('action', (value == 'save' ? "/designs/save_later" : "/designs/cart"));
});
</script>


</div>

</div>
