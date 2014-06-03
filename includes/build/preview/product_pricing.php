<? include(dirname(__FILE__)."/../../product_pricing.php"); ?>
<hr/>
<div>

<?php

	$product = $build["Product"];
	$catalogNumber = isset($build['catalog_number']) ? $build['catalog_number'] : null;
	$galleryImage = isset($build['GalleryImage']) ? $build["GalleryImage"] : array();

	$product_id = $product['product_type_id'];

	print_pricing_chart($product, $catalogNumber);

	$related_product_list = get_related_products($product['product_type_id']);

	foreach($related_product_list as $related_product)
	{
		if ($related_product['available'] == 'yes' && $related_product['buildable'] == 'no')
		# Only show related products that get choosed via the build process itself.
		{
			print_pricing_chart($related_product, $catalogNumber);
		}
	}
	
	function get_related_products($product_id)
	{
		global $database;
		$products = array();
		$result = mysql_query ("Select * FROM product_type WHERE parent_product_type_id = '$product_id'", $database);
		#echo "RES ($product_id)=". print_r($result,true);
		while ( $temp = mysql_fetch_assoc($result) ) {
			$products[] = $temp;
		}
		return $products;
	}


	function add_surcharge_pricing($product, &$pricing, $catalogNumber)
	{
		if (!$catalogNumber) { return false; }

		global $database;
		$hasSurcharge = false;
		$itemReproduction = "No"; # For now......
	
		$result = mysql_query ("Select surcharge from stamp_surcharge where catalog_number = '$catalogNumber'", $database);
		 if ( mysql_num_rows ($result) > 0 ) {
		 	$hasSurcharge = true;
		 	$surchargePossible = true;
			while ($temp = mysql_fetch_object ($result)){
		 	$surcharge = $temp->surcharge;}
			#if (!($product['stamp'] != 'Repro' && $hasSurcharge && $itemReproduction!="Yes"))
			# Real allowed...
			if (!(preg_match("/real/", $product['image_type']) && $hasSurcharge && $itemReproduction!="Yes"))
			{	$surcharge = 0;}
		 	for ($i = 0; $i < count($pricing); $i++) {
		 		$add = $surcharge;
				if ($add == 0) {
					$hasSurcharge = false;
				};
				$pricing[$i] = sprintf("%.02f", $pricing[$i] + $add);
			 }
		 }
		 return $hasSurcharge;
	}

	function print_pricing_chart($product, $catalogNumber)
	{
		list($pricePoints, $pricing) = get_product_pricing($product['code']);
		$itemReproduction = "No"; # For now......

		$hasSurcharge = add_surcharge_pricing($product, $pricing, $catalogNumber);

		?> <h5><?= $product['name'] ?></h5> <?
		if ($hasSurcharge && !preg_match('/real/', $product['image_type'])) {
			echo '<table align="center" id="pricing"  style="background-color:#FFFFEE">';
			echo '<tr><th align="right">Quantity</th><th align="right">Price <span class="note">(ea.)</span></th></tr>';
			for ($i = 0;  $i < count($pricePoints) - 1; $i++) {
				echo '<tr><td align="right" class="note"  style="background-color:#FFFFEE">';
				echo $pricePoints[$i];
				if ( $i+1 != count($pricePoints) ) {
					echo ' - ';
					echo $pricePoints[$i+1] - 1;
				}
				echo '</td><td align="right"  style="background-color:#FFFFEE">$';
				echo $pricing[$i];
				echo '</td></tr>';
			}
			echo '</table>';
		} else {
			echo '<table align="center" id="pricing" style="background-color:#FFFFEE">';
			echo '<tr><th align="right">Quantity</th><th align="right">Price <span class="note">(ea.)</span></th></tr>';
			for ($i = 0;  $i < count($pricePoints) - 1; $i++) {
				echo '<tr><td align="right" class="note" style="background-color:#FFFFEE">';
				echo $pricePoints[$i];
				if ( $i+1 != count($pricePoints) ) {
					echo ' - ';
					echo $pricePoints[$i+1] - 1;
				}
				echo '</td><td align="right"  style="background-color:#FFFFEE">$';
				echo $pricing[$i];
				echo '</td></tr>';
			}
			echo '</table>';
		}


	?>
		<?php 
			#if ($product['stamp'] != 'Repro' && $hasSurcharge && $itemReproduction!="Yes" )
			# REAL allowed
			if (preg_match("/real/", $product['image_type']) && $hasSurcharge && $itemReproduction!="Yes" )
			{
			$galleryImage = isset($build['GalleryImage']) ? $build["GalleryImage"] : array();
		?>
			<?php if ($galleryImage && $galleryImage['reproducible'] == 'Yes'){?>
			<p class="note">Pricing reflects a surcharge when actual stamps are used.  No added surcharge when reproductions are used.</p>
			<?php } ?>
		<?php 
			#} elseif ($product['stamp'] != 'Repro' && $hasSurcharge) { 
			} else if (preg_match("/real/", $product['image_type']) && $hasSurcharge) { 
			# REAL allowed
		?>
			<p class="note">Due to stamp scarcity and value, a surcharge is added.</p>
		    <?php } ?>
	<?}?>

	<p class="note">More than 1000: please call 888 293 1109.</p>
</div>
