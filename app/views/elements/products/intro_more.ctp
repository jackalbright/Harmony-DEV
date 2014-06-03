		<ul style="padding: 0px 0px 0px 1.2em; margin: 0px;">
		<? if ($product['Product']['width'] > 0) { ?>
			<li class="hidden">Size: 
			<?
				if(isset($product['AllRelatedProducts']) && count($product['AllRelatedProducts']))
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
					foreach($product['AllRelatedProducts'] as $subProduct)
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
			<?
				$normal_ship_time_days = $product['Product']['normal_ship_time_days'];
				if ($normal_ship_time_days <= 4)
				{
					$normal_ship_time = ($normal_ship_time_days * 24) . " hours";
				} else {
					$normal_ship_time = $normal_ship_time_days . " days";
				}
			
			?>
		</ul>

		<?= $product['Product']['main_desc'] ?>

