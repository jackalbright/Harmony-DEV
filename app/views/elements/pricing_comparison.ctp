<?  $default_hide = false; # #(count($compare_products) > 1); 
?>
<a name="pricing_chart"></a>
<div id="pricing_chart_container">
	<div class="right">
		<? if(false && empty($wholesale) && empty($wholesale_site)) { ?>
		<a class="" style="font-variant: small-caps; font-weight: bold; color: #B82A2A;" href="#" onclick="var priceListImage = window.open('/info/reseller_pricing.php?prod=<?=$product['Product']['code']?>', 'Wholesaler_Pricing', 'location=no,toolbar=no,width=600,height=820,status=yes,resize=yes,scrollbars=yes,menubar=no'); priceListImage.focus(); return false;">View Wholesale Pricing</a>
		<? } ?>
		<br>
		<a style="color: #B82A2A; font-variant: small-caps; font-weight: bold;" class='modal' Xrel="shadowbox;type=html;width=625;height=625" href="/specialty_page_prospects/add">Request Wholesale Account</a>
	</div>
	<h3 class="product_subsection_header">
		<?= count($compare_products) > 1 ? "Compare " : "" ?> <?= $product['Product']['short_name'] ?>
		Pricing
	</h3>
	<div class="clear"></div>

	<? if (!empty($price_lists[$prod])) { ?>
	<div id="price_compare" class="sections <?=$default_hide && empty($no_accordian) ?"hidden":""?>">
	<table id="pricing_chart_small" cellpadding=10 cellspacing=0 style="width: 100%;">
	<tr>
		<th style="" valign="bottom">Quantity</th>

		<? for($i = 0; $i < count($price_lists[$prod]); $i++) { ?>
		<? if ($i+1 < count($price_lists[$prod])) { ?>
		<th>
			<nobr>
			<?= $price_lists[$prod][$i]['quantity']; ?>
				- <?= $price_lists[$prod][$i+1]['quantity']-1 ?>
			</nobr>
		</th>
		<? } ?>
		<? } ?>
	</tr>

	<? $p = 0; foreach($compare_products as $rp) { $rprod = $rp['code']; ?>
	<tr style="background-color: <?= $p++ % 2 == 0 ? "#FFF" : "#DEDEDE"; ?>;">
		<td valign="middle" style="font-weight: bold;" align="left"><?= count($compare_products) == 1 ? "Price" : $rp['pricing_name'] ?></td>
		<? for($i = 0; $i < count($price_lists[$rprod]); $i++) { ?>
		<? if ($i+1 < count($price_lists[$rprod])) { ?>
		<td valign="middle">
			<nobr><?= sprintf("$%.02f ea", $price_lists[$rprod][$i]['price']); ?> </nobr>
		</td>
		<? } ?>
		<? } ?>

	</tr>
	<? } ?>
	</table>
	</div>
	<? } ?>
	<? if(false && !in_array($prod, array('B',"BB","BNT","BC")) && empty($product['Product']['is_stock_item'])) { ?>
	<div class="right">
		<a rel="shadowbox;type=html;width=625;height=625" href="/sample_requests/add/<?= $prod ?>">Free Random Sample</a>
	</div>
	<? } ?>
	<div class="bold">

		<a href="/quote_requests/add/<?= $product['Product']['code'] ?>" class='modal' Xrel="shadowbox;type=html;width=625;height=625">Request a written price quote</a> for quantity pricing &gt; 1000

		<? if(in_array($product['Product']['code'], array('BB','BNT','BC','B'))) { ?>
		<br/>
		<br/>
			Printing on the back of bookmarks is available for a one-time $30 setup charge plus $.20 each for printing. If you need
			this service, please call: 888.293.1109
		<? } ?>
	</div>
</div>
