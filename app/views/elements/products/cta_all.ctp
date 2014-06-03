<?if(empty($product['Product']['is_stock_item'])) { ?>

<div align="center" class="bold">
<? if(preg_match("/custom/", $product['Product']['image_type'])) { ?>
<a href="/custom_images/add?prod=<?= $prod?>"><img src="/images/buttons/Upload-Image.gif"/></a>
<br/>
or
<br/>
<? } ?>
<? if(preg_match("/(real|repro)/", $product['Product']['image_type'])) { ?>
<a href="/gallery/browse?prod=<?= $prod?>"><img src="/images/buttons/small/Browse-Our-Images.gif"/></a>
<br/>
<? if(preg_match("/custom/", $product['Product']['image_type'])) { ?>
or
<br/>
<? } ?>
<? } ?>
<? if(preg_match("/custom/", $product['Product']['image_type'])) { ?>
<a href="mailto:info@harmonydesigns.com?subject=Completed Art">Email your completed<br/>art as an attachment</a>
<br/>
<? } ?>

</div>

<? } else { ?>
<div align="left" class="">
	<form method="POST" action="/cart/add.php" onSubmit="return (verifyRequiredFields(this.id) && assertMinimum('<?= $product['Product']['minimum'] ?>'));">

	<div class="bold">Select a style:</div>
	<table cellpadding=0 cellspacing=0>
	<? $i = 0; foreach($compare_products as $cp) { ?>
	<tr>
		<td valign="top">
			<input type="radio" name="productCode" value="<?= $cp['code'] ?>" <?= empty($i) ? "checked='checked'" : "" ?> />
		</td>
		<td valign="top">
			<?= $cp['pricing_name'] ?>
			<br/>
			<br/>
		</td>
	</tr>
	<? $i++; } ?>
	</table>

	<div align="center">

	<b>Quantity:</b>
	<input value="<?= $product['Product']['minimum'] ?>" onchange="return assertMinimum(<?= $product['Product']['minimum'] ?>);" size="3" name="quantity" id="quantity">

		<br/>

		<input type="image" class="" src="/images/buttons/Add-to-Cart.gif">
	</div>
	</form>
</div>

<? } ?>
