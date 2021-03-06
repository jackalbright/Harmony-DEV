<?
if(empty($minimum)) { $minimum = $product['Product']['minimum']; }
?>
<div>
	<? if(!empty($compare_products) && count($compare_products) > 1) { ?>
	<div align="left" style="margin-bottom: 10px;">
	<label class="bold">Select style</label>
	<select id="prod" name="prod" onChange="changeShippingLink(); if($('gallery_prod')) { var value = this.value ? this.value : '<?= $product['Product']['code'] ?>'; $('gallery_prod').value = value; }; updateMiniCalc('<?= $baseCode ?>');" style="width: 175px;">
		<? foreach($compare_products as $cp) { ?>
		<option <?= !empty($calc_prod) && $calc_prod == $cp['code'] ? "selected='selected'" : "" ?> value="<?= $cp['code'] ?>"><?= $cp['pricing_name'] ?></option>
		<? } ?>
	</select>
	</div>

	<? } else { ?>
		<input id="prod" type="hidden" name="prod" value="<?= $product['Product']['code'] ?>"/>
	<? }?>
	<div align="left" style="">
	<table width="100%"><tr>
	<td align="left" valign="bottom">
		Qty (Min <?= $minimum ?>)<br/>
		<nobr>
		<input type="text" id='quantity' name="quantity" size="3" value="<?= $quantity ?>" onChange="changeShippingLink(); if(assertMinimum('<?=$minimum?>')) { updateMiniCalc('<?= $baseCode ?>'); }"/>
		<? if(!empty($subtotal)) { ?>
		x <?= sprintf("$%.02f ea", $price_each) ?>
		<? } ?>
		</nobr>
	</td>
	<td align="right" valign="bottom">
		<? if(!empty($subtotal)) { ?>
			<? if(!empty($original_subtotal) && $original_subtotal > $subtotal) { ?>
				<div class="bold alert strike"><?= sprintf("$%.02f", $original_subtotal); ?></div>
			<? } ?>
		<nobr>= <b><?= sprintf("$%.02f", $subtotal) ?></b></nobr>
		<? } ?>
	</td>
	</tr>
	<? if(empty($is_wholesale) && !empty($discount_percent)) { ?>
	<tr>
		<td colspan=2>
			<div class="alert2" align="right">
				You save <?= sprintf("%u%% off list price", $discount_percent); ?>
			</div>
		</td>
	</tr>
	<? } ?>
	<tr>
		<td align="left">
			<a id='calc_shipping' rel="shadowbox;type=html;width=700;height=500" href="/products/calculator/<?= $prod ?>/<?= !empty($quantity) ? $quantity : null ?>">Shipping/Production</a>
		</td>
		<td align="right">
			<a href="Javascript:void(0)" onClick="var prod = $('prod'); if(prod && prod.value == '') { alert('Please select a product'); prod.focus(); } else { if(assertMinimum('<?=$minimum?>')) { updateMiniCalc('<?= $baseCode ?>'); } }">
				<img src="/images/buttons/small/Calculate-grey.gif"/>
			</a>

			<? if(!empty($this->params['isAjax'])) { ?>
			<script>
				Shadowbox.setup($('calc_shipping'));
			</script>
			<? } ?>
		</td>
	</tr>
	
	</table>

	</div>
	<div align="right">
	</div>
	
</div>

<? /* ?>
<table width="100%">
<? if($next_tier) { ?>
<tr>
	<td colspan=2>
	<div style="text-align: center; font-weight: bold; color: #666;" class="">Save <?= !empty($list_percent) ? "$list_percent% off list price<br/>" : "more" ?> when you order <?= $next_tier ?>+</div>
	</td>
</tr>
<? } ?>
<tr>
	<td align="left">
		Price each
	</td>
	<td valign="top" align="right" class="nobr"><?= sprintf("$%.02f", $price_each) ?></td>
</tr>
<tr>
	<td align="left" class="nobr">
		Quantity
	</td>
	<td align="right">
		x <input type="text" id='quantity' name="quantity" size="3" value="<?= $quantity ?>" onChange="if(assertMinimum('<?=$minimum?>')) { updateMiniCalc('<?= $baseCode ?>'); }"/>
	</td>
</tr>
<tr>
	<td align="left">
		<b>Total price</b>
	</td>
	<td align="right" class="bold">
		<? if(!empty($original_subtotal) && $subtotal < $original_subtotal) { ?>
			<span class="strike alert"><?= sprintf("$%.02f", $original_subtotal) ?></span>
		<? } ?>
		<?= sprintf("$%.02f", $subtotal) ?>
	</td>
</tr>
<tr>
	<td align="left">
	</td>
	<td align="right">
	</td>
</tr>
<? if($product['Product']['code'] == 'P') { ?>
<tr>
	<td colspan=2 class="green">
		<?= $snippets['pin_surcharge'] ?>
		
	</td>
</tr>
<? } ?>
<tr>
	<td colspan=2>
		<div class="left"><a id="ship_link" rel="shadowbox;type=html;width=700;height=500" href="/products/calculator/<?= $product['Product']['code'] ?>">Shipping Options</a>
		</div>
		<div class="right">
		<a href="Javascript:void(0)" onClick="if(assertMinimum('<?=$minimum?>')) { updateMiniCalc('<?= $baseCode ?>'); }">
			<img src="/images/buttons/small/Calculate-grey.gif"/>
		</a>
		</div>
		<div class="clear"></div>

	</td>
	<td align="right">
	</td>
</tr>
</table>
<div align="left" class="green">
		Production time for this quantity:<br/>
		<?
			$biz_days = 0;
			for($t = time(); $t < $ships_by_time; $t += 24*60*60)
			{
				$td = date('D', $t);
				if($td != 'Sun' && $td != 'Sat')
				{
					$biz_days++;
				}
			}

			$start_days = ceil($biz_days*3/4);
		?>
		Approx. 
		<? if($start_days < $biz_days) { ?>
			<?= $start_days ?> - 
		<? } ?>
		<?= $biz_days ?>
		business days
		<br/>
		<br/>
</div>
<?=$this->element("shipfree"); ?>


<script>
<? if(empty($this->params['isAjax'])) { ?>
Event.observe(window,'load', function() {
<? } ?>
Shadowbox.setup($('ship_link'));
<? if(empty($this->params['isAjax'])) { ?>
});
<? } ?>

</script>
<? */ ?>
