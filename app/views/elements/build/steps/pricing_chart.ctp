<div>
<?php
	if ($productCode == 'B') {
		echo "<h5>Bookmarks without charms</h5>";
	}
	#if ($hasSurcharge && $this_product->stamp == 'Repro') {
	# NOT real
	if ($hasSurcharge && !preg_match("/real/", $this_product->image_type)) {
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

	if ($productCode == 'B') {
		echo "<h5>Bookmarks with charms</h5>";

	#if ($hasSurcharge && $this_product->stamp == 'Repro') {
	if ($hasSurcharge && !preg_match("/real/", $this_product->image_type)) {
	# NO real allowed
		echo '<table align="center" id="pricing" style="background-color:#FFFFEE">';
		echo '<tr><th align="right">Quantity</th><th align="right">Price <span class="note">(ea.)</span></th></tr>';
		for ($i = 0;  $i < count($pricePoints) - 1; $i++) {
			echo '<tr><td align="right" class="note"  style="background-color:#FFFFEE">';
			echo $pricePoints[$i];
			if ( $i+1 != count($pricePoints) ) {
				echo ' - ';
				echo $pricePoints[$i+1] - 1;
			}
			echo '</td><td align="right"  style="background-color:#FFFFEE">$';
			printf("%.2f", $pricing[$i] + 1);
			echo '</td></tr>';
		}
		echo '</table>';
	} else {
		echo '<table align="center" id="pricing" style="background-color:#FFFFEE">';
		echo '<tr><th align="right">Quantity</th><th align="right">Price <span class="note">(ea.)</span></th></tr>';
		for ($i = 0;  $i < count($pricePoints) - 1; $i++) {
			echo '<tr><td align="right" class="note"  style="background-color:#FFFFEE">';
			echo $pricePoints[$i];
			if ( $i+1 != count($pricePoints) ) {
				echo ' - ';
				echo $pricePoints[$i+1] - 1;
			}
			echo '</td><td align="right"  style="background-color:#FFFFEE">$';
			printf("%.2f", $pricing[$i] + 1);
			echo '</td></tr>';
		}
		echo '</table>';
	}
	}
?>
	<?php 
		#if ($this_product->stamp != 'Repro' && $hasSurcharge && $itemReproduction!="Yes" )
		if (preg_match("/real/", $this_product->image_type) && $hasSurcharge && $itemReproduction!="Yes" )
		# real allowed (not just repro only)
		{?>
		<?php if ($stamp->reproducible == 'Yes'){?>
		<p class="note">Pricing reflects a surcharge when actual stamps are used.  No added surcharge when reproductions are used.</p>
		<?php } ?>
	<?php 
		#} elseif ($this_product->stamp != 'Repro' && $hasSurcharge) { 
		# Real allowed
		} elseif (preg_match("/real/", $this_product->image_type) && $hasSurcharge) { 
	?>
		<p class="note">Due to stamp scarcity and value, a surcharge is added.</p>
	    <?php } ?>
	<p class="note">More than 1000: please call 888 293 1109.</p>

</div>
