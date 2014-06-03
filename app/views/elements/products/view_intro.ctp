<p style="font-weight: bold;">
	<?= $product['Product']['main_intro']; ?>
</p>

<div>
<?= $hd->product_element("products/view_intro_create", $product['Product']['prod'], array('product'=>$product,'position'=>'top')); ?>
</div>

<div>
	<ul>
	<? if ($product['Product']['width'] > 0) { ?>
		<li>Size: 
		<?
			if(isset($product['RelatedProducts']) && count($product['RelatedProducts']))
			{
				?><ul>
				<li>
				<?= $product['Product']['pricing_name'] ?>: 
				<? if ($product['Product']['height'] > 0) { ?>
					<?= $hd->mmToIn($product['Product']['width'], 8, true); ?>" x <?= $hd->mmToIn($product['Product']['height'], 8, true); ?>"
				<? } else { ?> 
					<?= $hd->mmToIn($product['Product']['width'], 8, true); ?>" diameter
				<? } ?>
				</li>
				<?
				foreach($product['RelatedProducts'] as $subProduct)
				{
					
					if ($subProduct['width'] > 0 && $subProduct['height'] > 0) { ?>
					<li>
						<?= $subProduct['pricing_name'] ?>: 
						<?= $hd->mmToIn($subProduct['width'], 8, true); ?>" x <?= $hd->mmToIn($subProduct['height'], 8, true); ?>"
					</li>
					<? } else if ($subProduct['width'] > 0) { ?>
					<li>
						<?= $subProduct['pricing_name'] ?>: 
						<?= $hd->mmToIn($subProduct['width'], 8, true); ?>" diameter 
					</li>
					<? } 
				}
				?></ul><?
			} else {
				echo $hd->mmToIn($product['Product']['width'], 8, true) ?>" x <?= $hd->mmToIn($product['Product']['height'], 8, true) . '"';
			}
		?>
	<? } ?>
		<? if (!$product['Product']['is_stock_item']) { ?>
		<li><b>Use your <a href="/custom_images">own art</a> or select an image from <a href="/gallery/browse">our gallery</a></b>
		<li><b>No <a href="/custom/designServices.php">design or setup charges</a></b> when our standard template is used 
		<? } ?>
		<li><b>Low minimums</b> (<?= $product['ProductPricing'][0]['quantity'] ?><?= !$product['Product']['is_stock_item'] ? " per design" : "" ?>) 
		<li><a href="/info/quantityPricing.php#<?=$product['Product']['prod']?>">Discounts</a> for larger quantities 
		<?
			$normal_ship_time_days = $product['Product']['normal_ship_time_days'];
			if ($normal_ship_time_days <= 4)
			{
				$normal_ship_time = ($normal_ship_time_days * 24) . " hours";
			} else {
				$normal_ship_time = $normal_ship_time_days . " days";
			}
		
		?>
		<li><b>Fast service:</b> Most <? $product['Product']['is_stock_item'] ? "" : "custom " ?><?= strtolower($product['Product']['short_name'] ? $product['Product']['short_name'] : $product['Product']['name']) ?> orders ship within <?= $normal_ship_time ?>
		<?
			$main_desc = preg_split("/(\n|<br\s*\/?>)/", $product['Product']['main_desc']);
			foreach($main_desc as $main_desc_item)
			{
				$main_desc_item = preg_replace("/(<\/?(ul|li)[^>]*>)/i", "", $main_desc_item);
				if (!preg_match("/\w/", $main_desc_item)) { continue; }
				?>
				<li><?= $main_desc_item ?>
				<?
			}
			
		?>
		<li><a href="#details">Detailed <?= strtolower($product['Product']['short_name'] ? $product['Product']['short_name'] : $product['Product']['name']) ?> information</a>

		<li><a class="highlight_secondary" href="#" onclick="var priceListImage = window.open('/info/reseller_pricing.php?prod=<?=$product['Product']['code']?>', 'Wholesaler_Pricing', 'location=no,toolbar=no,width=600,height=820,status=yes,resize=yes,scrollbars=yes,menubar=no');">Wholesale info</a></p>

	</ul>
</div>

