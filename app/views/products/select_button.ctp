<?
$url = $product['Product']['is_stock_item'] ? "/cart/add.php" : "/products/select";

$name = $product['Product']['short_name'];
if (!$name) { $name = $product['Product']['name']; }
$plural_product_name = $hd->pluralize($name);
$label = ($product['Product']['is_stock_item'] ? "Add to Cart" : "Create $plural_product_name"); 

?>
<form id="product_select_form" method="POST" action="<?= $url ?>" onSubmit="return (verifyRequiredFields(this.id) && assertMinimum('<?= $product['ProductPricing'][0]['quantity']?>'));">
	<input type="hidden" name="quantity" id="quantity_hidden" value="<?= $quantity ?>"/>
	<table width="" align="right">
	<? if(count($related) > 0) { ?>
	<tr>
		<td>
				<label class="" for="productCode">Select a Product:</label>
				<select id="productCode" name="productCode" class="required" onChange="selectTab(this.value, 'gtab');">
					<option value="<?= $product['Product']['code'] ?>"><?= $product['Product']['name'] ?></option>
					<? foreach($related as $rel) { ?>
					<option value="<?= $rel['Product']['code'] ?>"><?= $rel['Product']['name'] ?></option>
					<? } ?>
				</select>
		</td>
	</tr>
	<? } else { ?>
		<input type="hidden" id="productCode" name="productCode" value="<?= $product['Product']['code']?>"/>
	<? } ?>
	<tr>
		<td align="right">
			<table cellpadding=0 cellspacing=0 class="button">
			<tr>
				<td class="button_left">&nbsp;</td>
				<td class="button_main">
					<input type="submit" value="<?= $label ?>"/>
				</td>
				<td class="button_right">&nbsp;</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</form>
