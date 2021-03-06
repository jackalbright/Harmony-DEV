<div style="">
	<table id="pricing_chart" cellspacing=0> 
	<tr>
		<td colspan="<?= count($product_pricings[0]['pricing_data'])-2; ?>">
			<? if(!empty($title) && !empty($url)) { ?>
			<a href="<?= $url ?>"><h3><?= $title ?></h3></a>
			<? } else if (!empty($title)) { ?>
				<h3><?= strip_tags($title) ?></h3>
			<? } ?>
		</td>
		<td style="text-align: right;" colspan="1">
			<? if(false && empty($wholesale) && empty($wholesale_site)) { ?>
			<nobr>
			<a class="" style='font-weight: bold; color: #B82A2A; text-decoration: underline;' href="#" onclick="var priceListImage = window.open('/info/reseller_pricing.php?prod=<?= !empty($product)?$product['Product']['code'] : "" ?>', 'Wholesaler_Pricing', 'location=no,toolbar=no,width=600,height=820,status=yes,resize=yes,scrollbars=yes,menubar=no'); priceListImage.focus(); return false;">View Wholesale Pricing</a>
			</nobr>
			<? } ?>
		</td>
	</tr>
		<? 
		foreach($product_pricings as $product_pricing)
		{
			$pricing_data = $product_pricing['pricing_data'];
		?>
		<tr>
			<th class="product_heading" colspan="<?= count($pricing_data) ?>">
			<?= strip_tags($product_pricing['name']) ?> <?= !empty($product_pricing['desc']) ? "&mdash; ".$product_pricing['desc']:""; ?>
			<? if (isset($customer) && $customer['is_wholesale']) { ?>
			<b class="highlight_secondary">
			- Wholesale
			</b>
			<? } ?>
			</th>
		</tr>
		<tr>
			<?
			for($i = 0; $i < count($pricing_data)-1; $i++)
			{
				$pricing = $pricing_data[$i];
			#foreach($pricing_data as $pricing) {
			?>
			<td class="nobr">
				<?= $pricing['min_quantity'] ?> <?= ($pricing['max_quantity'] > $pricing['min_quantity']) ? ' - ' . $pricing['max_quantity'] : " or more"; ?>
			</td>
			<?
			}
			?>

		</tr>
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
		<tr>
			<td style="background-color: #CECECE;" colspan="<?= count($pricing_data)-1 ?>">
				Need larger quantities? Please call: 888.293.1109
			</td>
		</tr>
		<!--
		<tr>
			<td style="background-color: #CECECE;" colspan="<?= count($pricing_data)-1 ?>">
				Prices are slightly higher for <a href="/info/about-us.php#StampPrices">rare and high value stamps</a>.
			</td>
		</tr>
		<tr>
			<td style="" colspan="<?= count($pricing_data)-1 ?>">
			<i>Prices listed are for each item.</i>
			</td>
		</tr>
		-->
		</table>
</div>
