	<table class="pricing_chart_small" cellpadding=0 cellspacing=0 style="width: 100%;" border=0>
	<tr>
		<? for($i = 0; $i < count($pricing['price_list']); $i++) { ?>
		<? if ($i+1 < count($pricing['price_list'])) { ?>
		<th>
			<nobr><?= $pricing['price_list'][$i]['quantity']; ?>
				- <?= $pricing['price_list'][$i+1]['quantity']-1 ?></nobr>
		</th>
		<? } ?>
		<? } ?>
	</tr>

	<tr>
		<? for($i = 0; $i < count($pricing['price_list']); $i++) { ?>
		<? if ($i+1 < count($pricing['price_list'])) { ?>
		<td valign="middle">
			<nobr><?= sprintf("$%.02f ea", $pricing['price_list'][$i]['price']); ?> </nobr>
		</td>
		<? } ?>
		<? } ?>
	</tr>
	</table>

