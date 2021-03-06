	<?
	if(isset($build['CustomImage'])) {
		?>
		<input type="hidden" id="customImageID" name="customImageID" value="<?= $build['CustomImage']['Image_ID'] ?>"/>
		<?
	} else if (isset($build['GalleryImage']['catalog_number'])) { 
		?>
		<input type="hidden" id="catalogNumber" name="catalogNumber" value="<?= $build['GalleryImage']['catalog_number'] ?>"/>
		<?
	}

	foreach($build['options'] as $stepkey => $stepdata)
	{
		#echo "SK=$stepkey";
		foreach($stepdata as $stepdatakey => $stepdatavalue)
		{
		?>
			<input type="hidden" id="<?= $stepdatakey ?>" name="data[<?= $stepkey ?>][<?= $stepdatakey ?>]" value="<?=$stepdatavalue?>"/>
			<input type="hidden" id="<?= $stepdatakey ?>" name="<?= $stepdatakey ?>" value="<?=$stepdatavalue?>"/>
		<?
		}
	}
	?>
	<input type="hidden" id="productCode" name="productCode" value="<?= $build['Product']['code'] ?>" />
	<input type="hidden" id="cartID" name="cartID" value="<?= isset($build['cartID']) ? $build['cartID'] : "" ?>" />
	<input type="hidden" id="cart_item_id" name="cart_item_id" value="<?= isset($build['cart_item_id']) ? $build['cart_item_id'] : "" ?>" />


		<? include(dirname(__FILE__)."/stamp_type.ctp"); ?>

		<!-- //////  Begin Quantity Selection & Submit Button ////// -->
		<div class="clear">

				<!--	<h2>	<?php echo $counter;?>. Confirm your quantity &amp;
						<?php
							if ($isNewItem) {
								echo 'add to';
							} else {
								echo 'update';
							}
						?>
						cart
					</h2>
					-->
					<p>Save more when you order more.  </p>
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
							<td align="right" valign="top"> Quantity:</td>
							<td align="left" valign="top"><input type="text" id="quantity" name="quantity" value="<?= $quantity ?>" size="5" onChange="return checkMinimum(this.value, <?php echo $minimum; ?>);"/>
							</td>
							<td align="right">
								<!--<button class="imgButton" type="submit">
									<?php
										if ($isNewItem) {
											echo '<img src="/new-buttons/Add-to-Cart-dk.gif" width="106" height="36" alt="add to cart" />s';
										} else {
											echo '<img src="/new-buttons/Update-Cart-dk.gif" width="96" height="29" alt="update cart" />';
										}
									?>
								</button>
								-->
							</td>
						</tr>
						<tr>
							<td align="right"> Minimum:</td>
							<td align='left'> <?= $minimum ?>
							</td>
						</tr>
					</table>
<p class="note">All items are <a href="/info/guarantee.php">unconditionally guaranteed</a> against defects in materials and workmanship.  Most orders ship within 3 business days.</p>
		<!-- //////  End Quantity Selection & Submit Button ////// -->
		</div>
