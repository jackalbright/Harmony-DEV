<div class="cart">

<? #print_r($cart_items); ?>
<? $subtotal = 0; 
if (!isset($zipCode)) { $zipCode = ""; }
if (!isset($shippingOptions)) { $shippingOptions = array(); }

?>

<form action="/cart/update.php" method="POST">

	<table class="" width="100%">
	<tr>
		<td valign=bottom align="left">
			<a href="/products"><img src="/images/buttons/Continue-Shopping-grey.gif"/></a>
			<!--<input type="image" name="action" value="changeQuantity" src="/images/buttons/Update-Qty-grey.gif"/>-->
			<a href="/checkout"><img src="/images/buttons/Checkout.gif"/></a>
		</td>
		<td align="right" valign='bottom'>
			<?= $this->element("cart/progress"); ?>
		</td>
	</tr>
	<tr>
	<td colspan="2">

	<?= $this->element("cart/cart",array()); ?>

	</td>
	</tr>
	<tr>
		<td align="left">
			<a href="/products"><img src="/images/buttons/Continue-Shopping-grey.gif"/></a>
			<!--<input type="image" name="action" value="changeQuantity" src="/images/buttons/Update-Qty-grey.gif"/>-->
			<a href="/checkout"><img src="/images/buttons/Checkout.gif"/></a>
		</td>
		<td>
			&nbsp;
		</td>
	</tr>
	</table>
</form>
</div>

