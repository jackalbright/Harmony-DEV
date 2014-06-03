<?  $default_hide = false; # #(count($compare_products) > 1); 
?>
<a name="pricing_chart"></a>
<br/>
<div id="pricing_chart_container">
	<!--
	<div class="right">
		<a rel="shadowbox;type=html;width=700;height=500" href="/products/calculator/<?= $prod ?>">Calculate pricing/shipping</a> | 
		<a href="#" class="top" name="pricing">Top</a></div>
	</div>
	-->
	<div class="product_subsection_header">
		<?= count($compare_products) > 1 ? "Compare " : "" ?> <?= $product['Product']['short_name'] ?>
		Pricing
	</div>

	<?
		#print_r($price_lists);

		# Restructure price_lists so [qty][prod] instead of [prod][qty]
		$price_lists_qty = array();
		$qtys = array();
		foreach($price_lists as $p=>$qs)
		{
			foreach($qs as $level)
			{
				$qty = $level['quantity'];
				if(!in_array($qty, $qtys)) { $qtys[] = $qty; }
				$price = $level['price'];
				$price_lists_qty[$qty][$p] = $level;
			}
		}
		sort($qtys);
	?>

	<div id="price_compare" class="sections <?=$default_hide && empty($no_accordian) ?"hidden":""?>" style="border: solid black 1px;">
	<table id="pricing_chart_small" cellpadding=0 cellspacing=0 style="width: 100%;">
	<tr style="background-color: #EEEEFF; border-bottom: solid black 2px;">
		<th style="width: 200px; background-color: #DDD;">Quantity</th>
		<? foreach($compare_products as $rp) { $rprod = $rp['code']; ?>
		<th style="width: 90px; text-align: center;">
			<?= $rp['pricing_name'] ?>
		</th>
		<? } ?>
	</tr>
	<? for($i = 0; $i < count($qtys)-1; $i++) { $qty = $qtys[$i]; ?>
	<tr XXXstyle="background-color: <?= $i % 2 == 0 ? "#FFF" : "#DEDEDE"; ?>;">
		<td style="background-color: #DDD;">
			<?= $qtys[$i]; ?> -
			<?= $qtys[$i+1]-1; ?>
		</td>
		<? foreach($compare_products as $rp) { 
			$price = $price_lists_qty[$qty][$rp['code']]['price']; 
		?>
		<td align="center">
			<? if(empty($price)) { ?>
				&mdash;
			<? } else { ?>
				<?= sprintf("$%.02f", $price); ?>
			<? } ?>
		</td>
		<? } ?>
	</tr>
	<? } ?>
	</table>
	</div>

	<? if (false && !empty($price_lists[$prod])) { ?>
	<div id="price_compare" class="sections <?=$default_hide && empty($no_accordian) ?"hidden":""?>">
	<table id="pricing_chart_small" cellpadding=0 cellspacing=0 style="width: 100%;">
	<tr>
		<th style="" valign="bottom">Quantity</th>

		<? $p = 0; foreach($compare_products as $rp) { $rprod = $rp['code']; ?>
			<th valign="middle" style="font-weight: bold; width: 90px;" align="left"><?= count($compare_products) == 1 ? "Price" : $rp['pricing_name'] ?></th>
		<? } ?>
	</tr>

	<? for($i = 0; $i < count($price_lists_qty); $i++) { 
	?>
	<tr style="background-color: <?= $p++ % 2 == 0 ? "#FFF" : "#DEDEDE"; ?>;">
		<th>
			<nobr>
			<?= $price_lists[$prod][$i]['quantity']; ?>
				- <?= $price_lists[$prod][$i+1]['quantity']-1 ?>
			</nobr>
		</th>
		<? if(false) { ?>
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
	<div class="bold">Call 888.293.1109 or <a href="Javascript:void(0)" onClick="mail(this, 'info@harmonydesigns.com');">email us</a> for larger quantity pricing</div>
</div>
