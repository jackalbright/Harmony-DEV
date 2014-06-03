	<? $rprod = $prod; ?>
	<table id="pricing_chart_small" cellpadding=0 cellspacing=0 style="width: 100%;">
	<tr>
		<td rowspan=2 align="center">
			<a title="Calculate Pricing" href="/products/calculator/<?= $prod ?>" rel="shadowbox;type=html;width=700;height=500"><img src="/images/icons/small/calculator.png"/></a>
		</td>
		<? for($i = 0; $i < count($price_lists[$prod]); $i++) { ?>
		<? if ($i+1 < count($price_lists[$prod])) { ?>
		<th>
			<nobr>
			<?= $price_lists[$prod][$i]['quantity']; ?>
				- <?= $price_lists[$prod][$i+1]['quantity']-1 ?>
			</nobr>
		</th>
		<? } else { ?>
		<th>
			<nobr>
				> <?= $price_lists[$prod][$i]['quantity']-1; ?>
			</nobr>
		</th>
		<? } ?>
		<? } ?>
	</tr>

	<tr style="background-color: <?= $p++ % 2 == 0 ? "#FFF" : "#DEDEDE"; ?>;">
		<? for($i = 0; $i < count($price_lists[$rprod]); $i++) { ?>
		<? if ($i+1 < count($price_lists[$rprod])) { ?>
		<td valign="middle">
			<nobr><?= sprintf("$%.02f ea", $price_lists[$rprod][$i]['price']); ?> </nobr>
		</td>
		<? } else { ?>
		<td valign="middle">
			<nobr>Call</nobr>
		</td>
		<? } ?>
		<? } ?>

	</tr>
	</table>
