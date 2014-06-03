	<form id="chooseProductForm" method="POST" action="/cart/add.php" onSubmit="return (verifyRequiredFields(this.id) && assertMinimum('<?= $product['Product']['minimum'] ?>'));">

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

	<table>
	<tr>
		<td class="bold">Quantity:</td>
		<td>
			<input value="<?= $product['Product']['minimum'] ?>" onchange="return (assertMinimum(<?= $product['Product']['minimum'] ?>) && calculateStockSubtotal('<?= $product['Product']['code'] ?>');" size="3" name="quantity" id="quantity">
			<a href="Javascript:void(0)" onClick="return calculateStockSubtotal('<?= $product['Product']['code'] ?>');"><img align="middle" src="/images/buttons/small/Calculate-grey.gif"/></a>
		</td>
	</tr>
	<tr>
		<td class='bold'>Subtotal:</td>
		<td>
			<span id="subtotal"></span>
		</td>
	</tr>
	<tr>
		<td colspan=2 align="center">
			<input type="image" class="" src="/images/buttons/Add-to-Cart.gif">
		</td>
	</tr>
	</table>


	</form>

