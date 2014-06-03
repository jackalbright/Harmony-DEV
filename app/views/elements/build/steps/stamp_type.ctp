<div class="clear">
	<?php
		// Determine if the product is made with a real or reproduction stamp
		#if ( strtolower(get_class($image)) == 'stamp' && $this_product->stamp != 'Real') {
		if ( preg_match("/stamp/", strtolower(get_class($image))) && preg_match("/repro/", $this_product->image_type)) {
		# If CAN do repro, gie them the option to prefer, otherwise, assume original....
			#if ($this_product->stamp == 'Repro' || $stamp->reproducible == 'Only') {
			if ( (preg_match("/repro/", $this_product->image_type) && !preg_match("/real/", $this_product->image_type)) || $stamp->reproducible == 'Only') {
			# ONLY repro, NOT real!
				echo '<input type="hidden" id="reproductionStamp" name="reproductionStamp" value="yes" />';
			#} elseif ($stamp->reproducible == 'Yes' && $this_product->stamp != 'Repro') {
			} elseif ($stamp->reproducible == 'Yes' && preg_match("/real/", $this_product->image_type)) {
			# CAN do real... (not just repro-only)
				if (isset($this_product->parts->reproductionStamp)){
					if ($this_product->parts->reproductionStamp == true){
						echo '<input type="hidden" id="reproductionStamp" name="reproductionStamp" value="yes" />';
					} else {
						echo '<input type="hidden" id="reproductionStamp" name="reproductionStamp" value="no" />';
					};
				}else{
					echo '<input type="hidden" id="reproductionStamp" name="reproductionStamp" value="yes" />';
				}
				$counter++;
	?>
		<h2> <?php echo $counter;?>. Real Stamp or Reproduction?</h2>
		<p>This item may be created with either an authentic postage stamp or you may choose to use a <a href="/info/reproduction.php">licensed reproduction</a>. Using a reproduction may speed the production of your order.					    </p>
		<p><input name="useRepro" id="useStamp" type="radio" value="False" onClick = "return changeRepro(false);" <?php if ($stampReproduction=="Yes"){ echo "checked"; } ?> /> Use genuine postage stamp <?php if ($surchargePossible == true) { echo "(due to scarcity and value of this mint-condition stamp, a surcharge of $$surcharge per stamp will apply)";}?>.<br />
			<input name="useRepro" id="useRepro" type="radio" value="True" onClick = "return changeRepro(true);" <?php if ($stampReproduction!="Yes"){ echo "checked"; } ?> />
			Use <a href="/info/reproduction.php">licensed reproduction</a>.
			<?php if ($hasSurcharge == true){?>
<br/>
<span class="note">(Will reduce the price by eliminating the surcharge and may speed the production of your order.)</span>
<?php } else { ?>
<br/>
<span class="note">(May speed the production of your order.)</span>
<?php }; ?>
		</p>
	    <?php
			} else {
				echo '<input type="hidden" id="reproductionStamp" name="reproductionStamp" value="no" />';
			}
		}
	?>
</div>

