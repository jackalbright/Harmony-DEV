<?
		if (isset($currentItem->parts->shirtSize)){
			$shirtSize = $currentItem->parts->shirtSize;
		} else {
			$shirtSize = "";
		};

?>
<div class="clear">
		<!--<h2><?php echo $counter;?>. Choose your T-Shirt Size</h2>-->
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
 		<tr>
 			<td valign="top"><strong>Adult Sizes:</strong><br />
					<label class="tshirt"><input name="shirtSize" type="radio" value="S" <?php if ($shirtSize=='S' || $shirtSize==''){ echo "checked"; }; ?> />Small</label><br />
					<label class="tshirt"><input name="shirtSize" type="radio" value="M" <?php if ($shirtSize=='M'){ echo "checked"; }; ?> />Medium</label><br />
					<label class="tshirt"><input name="shirtSize" type="radio" value="L" <?php if ($shirtSize=='L'){ echo "checked"; }; ?> />Large</label><br />
					<label class="tshirt"><input name="shirtSize" type="radio" value="XL" <?php if ($shirtSize=='XL'){ echo "checked"; }; ?> />X-Large</label><br />
					<label class="tshirt"><input name="shirtSize" type="radio" value="XXL" <?php if ($shirtSize=='XXL'){ echo "checked"; }; ?> />XX-Large</label><br />

			</td>
			<td valign="top"><strong>Youth Sizes:</strong><br />
					<label class="tshirt"><input name="shirtSize" type="radio" value="YS" <?php if ($shirtSize=='YS'){ echo "checked"; }; ?> />Small</label><br />
					<label class="tshirt"><input name="shirtSize" type="radio" value="YM" <?php if ($shirtSize=='YM'){ echo "checked"; }; ?> />Medium</label><br />
					<label class="tshirt"><input name="shirtSize" type="radio" value="YL" <?php if ($shirtSize=='YL'){ echo "checked"; }; ?> />Large</label><br />
					<label class="tshirt"><input name="shirtSize" type="radio" value="YXL" <?php if ($shirtSize=='YXL'){ echo "checked"; }; ?> />X-Large</label><br />
			</td>
  		</tr>
		</table>
</div>

