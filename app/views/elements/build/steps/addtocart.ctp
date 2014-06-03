<div class="clear">
			<h2>						

				<?php echo ++$counter;?>. Choose your quantity &amp;
				<?php
					if ($isNewItem) {
						echo 'add to';
					} else {
						echo 'update';
					}
				?>
				cart
			</h2>
			<p>Save more when you order more.  See the price chart (above right) for more details.</p>
			<?php 
				#if ($this_product->stamp != 'Repro' && $hasSurcharge && $itemReproduction!="Yes" )
				if (preg_match("/real/", $this_product->image_type) && $hasSurcharge && $itemReproduction!="Yes" )
				# Can do real image....
			{?>
				<?php 
					#if ($stamp->reproducible == 'Yes' && $this_product->stamp != 'Real'){
					if ($stamp->reproducible == 'Yes' && preg_match("/repro/", $this_product->image_type)) {
					# Not just real only, (can do repro)
				?>
				<p class="note">Due to stamp scarcity and value, a surcharge is added unless a <a href="/info/reproduction.php">licensed reproduction</a> is chosen.</p>
				<?php 
					#} elseif ($stamp->reproducible == 'Yes' && $this_product->stamp == 'Real'){
					} elseif ($stamp->reproducible == 'Yes' && !preg_match("/repro/", $this_product->image_type)) {
					# can only do real, no repro
				?>
				<p class="note">Due to stamp scarcity and value, a surcharge is added.</p>
				<?php } ?>
			<?php 
				#} elseif ($this_product->stamp != 'Repro' && $hasSurcharge) { 
				} elseif (!preg_match("/repro/", $this_product->image_type) && $hasSurcharge) { 
				# Only real.
			?>
				<p class="note">Due to stamp scarcity and value, a surcharge is added.</p>
			    <?php } ?>
			<table width="240">
				<tr>
					<td align="right"> (Min.) Quantity:</td>
					<td align="left"><input type="text" id="quantity" name="quantity" style="text-align: right;" value="<?php
	$query = "Select min(quantity) from `pricePoint` where `productCode` = '$productCode'";
	$result = mysql_query($query);
	while ($temp = mysql_fetch_row($result)){
$min_quantity = $temp[0];
	}

	echo (isset($currentItem->quantity) ? $currentItem->quantity : $min_quantity);?>" size="5" onChange="checkMinimum(this.value, <?php echo $min_quantity; ?>);"/></td>
					<td align="right">
						<button class="imgButton" type="submit">
							<?php
								if ($isNewItem) {
									echo '<img src="/new-buttons/Add-to-Cart-dk.gif" width="106" height="36" alt="add to cart" />s';
								} else {
									echo '<img src="/new-buttons/Update-Cart-dk.gif" width="96" height="29" alt="update cart" />';
								}
							?>
						</button>
					</td>
				</tr>
			</table>
<p class="note">All items are <a href="/info/guarantee.php">unconditionally guaranteed</a> against defects in materials and workmanship.  Most orders ship within 3 business days.</p>
<!-- //////  End Quantity Selection & Submit Button ////// -->
		</form>
		<?php } else  if ($actionSwitch == "display error") { ?>
			<p>
				An error was detected. Please take care of the following:
			</p>
			<ul>
				<?php
					foreach ($errorMessages as $error) {
						echo '<li>' . $error . '</li>' . "\n";
					}
				?>
			</ul>

		<?php } ?>
</div>

