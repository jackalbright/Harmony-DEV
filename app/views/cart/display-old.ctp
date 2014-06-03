<div class="cart">

<? #print_r($cart_items); ?>

<form action="/cart/update.php" method="POST">

<table id="cartDisplay" width="100%">
<tr>
	<th class="item_description">Item Description</th>
	<th>Quantity</th>
	<th>Unit Price</th>
	<th>Total Price</th>
	<th>&nbsp;</th>
</tr>

<? $i = 0; $subTotal = 0; foreach($cart_items as $cart_item) { 
	$catalog_number = isset($cart_item['catalog_number']) ? $cart_item['catalog_number'] : null;
	$image_id = isset($cart_item['image_id']) ? $cart_item['image_id'] : null;
?>
<tr>
	<td valign=top>
		<?= $this->element("cart/item_description", array('cart_item'=>$cart_item)); ?>
	</td>
	<td valign=top>
		<input type="text" size="4" name="data[<?= $i ?>][quantity]" value="<?= $cart_item['quantity'] ?>" onChange="checkMinimum('<?=$cart_item['productCode']?>', this.value, <?=$i?>)"/>
		<br/>
		<input type="checkbox" name="data[<?= $i ?>][remove]" value="1"/> Remove From Cart
	</td>
	<td valign=top>
		<?= sprintf("\$%.02f", $cart_item['unit_price']); ?>
	</td>
	<td valign=top>
		<?
			$itemSubtotal = $cart_item['quantity'] * $cart_item['unit_price']; 
			echo sprintf("\$%.02f", $itemSubtotal);
			$subTotal += $itemSubtotal;
		?>
	</td>
	<td valign=top>
		<? if(!$cart_item['Product']['is_stock_item']) { ?>
		<a href="/product/build.php?catalogNumber=<?=$catalog_number?>&imageID=<?=$image_id?>&cartID=<?=$i?>">modify item</a><br/>
		<br/>
		<? } ?>
		<? if($image_id != "" || $catalog_number != "") { ?>
		<a href="/products/select?new=1">build another item using this image</a><br/>
		<br/>
		<? } ?>

		<? if($cart_item['Product']['is_stock_item']) { ?>
			<a href="/details/<?= $cart_item['Product']['prod']?>.php">shop for more</a><br/>
		<? } ?>
	</td>
</tr>
<? $i++; } ?>

<tr>
	<td colspan=2>
	</td>
	<th>
		Subtotal: 
	</th>
	<td>
		<?= sprintf("$%.02f", $subTotal); ?>
	</td>
</tr>
<tr>
	<td colspan=5 align="right">
		<input type="submit" name="submit" value="Update"/>
		<input type="submit" name="submit" value="Checkout"/>
	</td>
</tr>

</table>

</form>

</div>

