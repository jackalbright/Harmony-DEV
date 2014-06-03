<div id="pricing_chart_container">
	<? if (!empty($price_list)) { ?>
	<table id="pricing_chart_horizontal" cellpadding=0 cellspacing=0 style="">
	<tr>
		<th valign="bottom">
			Qty.
		</th>
		<? for($i = 0; $i < count($price_list); $i++) { ?>
		<td>
			<?= $price_list[$i]['quantity']; ?>
			<? if ($i+1 < count($price_list)) { ?>
				- <?= $price_list[$i+1]['quantity']-1 ?>
			<? } else { ?>
				+
			<? } ?>
		</td>
		<? } ?>
	</tr>
	<tr>
		<th valign="">
			Each
		</th>
		<? for($i = 0; $i < count($price_list); $i++) { 
		?>
		<td>
			<? if ($i+1 >= count($price_list)) { ?>
				<b>Call or <a href="Javascript:void(0);" onClick="mail(this, 'info@harmonydesigns.com');">email</a></b>
			<? } else { ?>
				<?= sprintf("$%.02f ea", $price_list[$i]['price']); ?>
			<? } ?>
		</td>
		<? } ?>
	</tr>
	</table>

	<? } ?>
</div>
