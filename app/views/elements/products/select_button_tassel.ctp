<?
$url = $product['Product']['is_stock_item'] ? "/cart/add.php" : "/products/select/".$product['Product']['code'];

$name = $product['Product']['short_name'];
if (!$name) { $name = $product['Product']['name']; }
$plural_product_name = $hd->pluralize($name);
$label = ($product['Product']['is_stock_item'] ? "Add to Cart" : "Create $plural_product_name >"); 
$button_src = $product['Product']['is_stock_item'] ? "/images/buttons/Add-to-Cart.gif" : "/images/buttons/Build-Products.gif";

?>
<form method="POST" action="<?= $url ?>" onSubmit="return assertTasselSelected('<?= $product['ProductPricing'][0]['quantity']?>');">
	<div>
	<label class="bold">Select a tassel:</label>
	<select name="tasselID" id="tasselID">
		<? foreach($tassels as $tassel) { ?>
			<option value="<?= $tassel['Tassel']['tassel_id']?>"><?= ucwords($tassel['Tassel']['color_name']) ?></option>
		<? } ?>
	</select>
	</div>
	<input type="hidden" name="cartID" value="none"/> 
	<? if($product['Product']['is_stock_item']) { ?>
	<b>Quantity:</b>
		<input type="text" name="quantity" id="quantity" value="<?= $quantity ?>" size=4 onChange="if(assertMinimum(<?=$product['Product']['minimum']?>)) { $('quantity_calc').value = this.value;} "/>
		<input type="hidden" name="productCode" id="productCode_hidden" value="<?= $product['Product']['code'] ?>"/>
		<br/>
	<? } else { ?>
	<input type="hidden" name="quantity" id="quantity_hidden" value="<?= $quantity ?>"/>
	<? } ?>
	<input type="image" src="<?= $button_src ?>"/>


</form>
