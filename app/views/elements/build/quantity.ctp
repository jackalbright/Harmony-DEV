<?
$discounted = ($build['retail_price_list']['total'] > $build['quantity_price_list']['total']);
?>

<? if(isset($build['quantity'])) { ?>
	<!-- switch to ajax option? -->
	<form method="POST" action="<?= $url ?>">
	<div class="preview_option_title">Your Cost</div>
	<div class="preview_option_quantity preview_option_value">
		<table cellpadding=0 cellspacing=2>
		<? if(!empty($build['quantity_price_list'])) { ?>
			<tr>
				<td>&nbsp;</td>
				<td> <?= sprintf("$%.02f", $build['quantity_price_list']['base']); ?> </td>
				<td> Base price ea.</td>
			</tr>
			<?
			foreach($build['quantity_price_list'] as $option => $option_cost)
			{
				if ($option == 'base' || $option == 'total') { continue; }
			?>
			<tr>
				<td>+</td>
				<td>
					<?= sprintf("$%.02f", $option_cost); ?>
				</td>
				<td> 
					<? if(in_array($option, $option_list)) { ?>
					<a href="/build/step/<?= $option ?>"><?= $option ?></a> (optional) 
					<? } else { ?>
					<?= $option ?>
					<? } ?>
				</td>
			</tr>
			<? } ?>
			</tr>
			<? if ($build['quantity_price_list']['base'] < $build['quantity_price_list']['total']) { ?>
			<tr>
				<td>&nbsp;</td>
				<td> <?= sprintf("$%.02f", $build['quantity_price_list']['total']); ?> </td>
				<td> unit price ea.</td>
			</tr>
			<? } ?>
		<? } ?>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">
				<input type="text" name="quantity" value="<?= $build['quantity'] ?>" size="4"/>
			</td>
			<td valign="top">
				qty. (min: <?= $build["Product"]['minimum'] ?>)
				<br/>
				<input type="image" src="/images/buttons/Update-Qty-grey.gif" height="20"/>
			</td>
		</tr>
		<tr>
			<td colspan=3>
				<div><a href="/products/pricing_chart/<?= $build['Product']['code'] ?>" rel="shadowbox;player=iframe;width=500;height=500">Save more when you order more</a></div>
			</td>
		</tr>
		<? if (!empty($build['quantity_price'])) { ?>
		<tr>
			<td colspan=3><hr/>
			</td>
		</tr>

		<? if($discounted) { ?>
		<tr>
			<td>&nbsp;</td>
			<td class="bold">
				<div style="text-decoration: line-through;"><?= sprintf("$%.02f", $build['quantity'] * $build['retail_price_list']['total']); ?></div>
			</td>
			<td class="bold">
			list price
			</td>
		</tr>
		<? } ?>
		<tr>
			<td>&nbsp;</td>
			<td>
				<b style="color: red;"><?= sprintf("$%.02f", $build['quantity'] * $build['quantity_price_list']['total']); ?></b>
			</td>
			<td>
				your cost
			</td>
		</tr>
		<? if ($discounted) { ?>
		<tr>
			<td>&nbsp;</td>
			<td align="right">
				(<?= sprintf("%u%%", ($build['retail_price_list']['total'] - $build['quantity_price_list']['total']) / $build['retail_price_list']['total']*100); ?></b>
			</td>
			<td>
				off list price)
			</td>
		</tr>
		<? } ?>
		<? } ?>
		<? if(!empty($stamp_surcharge['StampSurcharge']) && preg_match("/real/", $build["Product"]['image_type'])) { ?>
		<tr>
			<td colspan=3>
		<i>Note: 
		Prices may be slightly higher for <a href="/info/about-us.php#StampPrices">rare and high value stamps.</a></i>
			</td>
		</tr>
		<? } ?>
		</table>
	</div>
	</form>
</div>
<? } ?>

