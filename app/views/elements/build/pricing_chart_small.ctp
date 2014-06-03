<div id="pricing_chart_container">
	<? if (!empty($price_list)) { ?>
	<table id="pricing_chart_small" cellpadding=0 cellspacing=0 style="width: 100%; <?#= !empty($nocalc) ? "width: 175px !important;" : "" ?>">
	<tr>
		<? if(empty($nocalc) && !empty($prod)) { ?><th>&nbsp;</th><? } ?>
		<th valign="bottom">Quantity</th>
		<th width="40%" valign="bottom">Price ea.</th>
	</tr>
	<? for($i = 0; $i < count($price_list); $i++) { 
		
	?>
	<tr>
		<? if($i == 0 && empty($nocalc) && !empty($prod) && (true || $malysoft || $hdtest)) { ?> <td valign="top" rowspan="<?= count($price_list); ?>">
			<a href="/products/calculator/<?= $prod ?>" rel="shadowbox;width=600;height=500"><img src="/images/icons/calculator.gif"/></a>
		</td> <? } ?>
		<td valign="top">
			<?= $price_list[$i]['quantity']; ?>
			<? if ($i+1 < count($price_list)) { ?>
				- <?= $price_list[$i+1]['quantity']-1 ?>
			<? } else { ?>
				+
			<? } ?>
		</td>
		<td valign="top">
			<? if ($i+1 >= count($price_list)) { ?>
				<b>Call or <a href="Javascript:void(0);" onClick="return mail(this, 'info@harmonydesigns.com');">email</a></b>
			<? } else { ?>
				<?= sprintf("$%.02f ea", $price_list[$i]['price']); ?>
			<? } ?>
		</td>
	</tr>
	<? } ?>
	</table>
	<? } ?>
</div>
