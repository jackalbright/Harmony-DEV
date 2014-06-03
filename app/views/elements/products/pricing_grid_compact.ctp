<div style="" class="pricing_chart_compact">
	<? 
	$pricing_data = $product_pricings[0]['pricing_data'];
	$cols = count($pricing_data)-1;
	?>

	<table id="pricing_chart" cellspacing=0 cellpadding=0 class="" width="100%" border=0> 
	<tr>
		<td colspan="<?= $cols ?>">
			<h4 class="inline"><?= ucwords($product['Product']['short_name']) ?> Pricing Chart</h4> - 
			<div class="inline"><a class="highlight_secondary" href="#" onclick="var priceListImage = window.open('/info/reseller_pricing.php', 'Wholesaler_Pricing', 'location=no,toolbar=no,width=600,height=820,status=yes,resize=yes,scrollbars=yes,menubar=no');">Wholesale Pricing</a>
			</div>

		</td>
	</tr>
		<tr style="background-color: #EFEFEF;">
			<?
			for($i = 0; $i < count($pricing_data)-1; $i++)
			{
				$pricing = $pricing_data[$i];
			#foreach($pricing_data as $pricing) {
			?>
			<td class="nobr">
				<?= $pricing['min_quantity'] ?> <?= ($pricing['max_quantity'] > $pricing['min_quantity']) ? ' - ' . $pricing['max_quantity'] : "+"; ?>
			</td>
			<?
			}
			?>
		</tr>
	</tr>
		<? 
		foreach($product_pricings as $product_pricing)
		{
			$pricing_data = $product_pricing['pricing_data'];
		?>
		<? if(count($product_pricings) > 1) { ?>
		<tr>
			<td class="bold" colspan="<?= count($pricing_data)-1 ?>">
				<?= $product_pricing['name'] ?>
			</td>
		</tr>
		<? } ?>

		<tr>
			<?
			for($i = 0; $i < count($pricing_data)-1; $i++)
			{
				$pricing = $pricing_data[$i];
			#foreach($pricing_data as $pricing) {
				echo "<td style='border-top: black solid 1px;' class='nobr'>";
				echo sprintf("$%.02f ea", $pricing['price']);
				echo "</td>";
			}
			?>
		</tr>
		<!--
		<tr>
			<td class="product_spacer" colspan="<?= count($pricing_data) ?>">&nbsp;</td>
		</tr>
		-->
		<? } ?>
		<tr class="hidden">
			<td style="background-color: #CECECE;" colspan="<?= count($pricing_data)-1 ?>">
				Need larger quantities? Please call: 888.293.1109
			</td>
		</tr>
		<tr class="hidden">
			<td style="background-color: #CECECE;" colspan="<?= count($pricing_data)-1 ?>">
				Prices are slightly higher for <a href="/info/about-us.php#StampPrices">rare and high value stamps</a>.
			</td>
		</tr>
		<tr class="hidden">
			<td style="" colspan="<?= count($pricing_data)-1 ?>">
			<i>Prices listed are for each item.</i>
			</td>
		</tr>
		</table>
</div>
