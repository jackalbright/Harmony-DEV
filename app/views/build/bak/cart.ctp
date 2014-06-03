CART
<form method="POST" action="/cart/add.php">
<div>
<?
	if(isset($build['CustomImage'])) {
		?>
		<input type="hidden" id="customImageID" name="customImageID" value="<?= $build['CustomImage']['imageID'] ?>"/>
		<?
	} else if (isset($build['GalleryImage'])) { 
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
	<input type="hidden" id="cartID" name="cartID" value="<?= $build['cartID'] ?>" />

	<table width="100%" table=1">
	<tr>
		<td width="" rowspan=2 valign=top style="width: 200px;">
			<?= $this->element("build/preview"); ?>
			<?= $this->element("build/details_selected"); ?>
		</td>
		<td valign=top>
			<? include(dirname(__FILE__)."/../../../product/build/cart.php"); ?>

			<div class="right_align">
			<input type="submit" name="action" value="Add to Cart"/>
			</div>
		</td>
	</tr>
	</table>

</div>
</form>
