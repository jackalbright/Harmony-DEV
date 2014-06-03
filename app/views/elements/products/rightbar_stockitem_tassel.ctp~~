<div class="sidebar_content">
<div class="sidebar_header">Add Tassel To Cart</div>
<form action="/cart/add.php" method="POST">
	<br/>
	<input type="hidden" value="<?= $product['Product']['code'] ?>" name="productCode"/>
	<input type="hidden" name="cartID" value="none"/> 
	<input id="customTassel" type="hidden" value="" name="tasselID"/>
	<div>
	Tassel: <span id="tassel_name">[Select a Tassel]</span>
	</div>
	<div>
		<table><tr><td valign=middle>
		Preview:
		</td><td>
		<a rel="shadowbox" id="tassel_img_large" href="/tassels/no-tassel.gif">
		<img id="tassel_img" src="/tassels/thumbs/no-tassel.gif" height="50"/>
		<br/>
		+ View Larger
		</a>
		</td></tr></table>
	</div>
	<div class="clear"></div>
	<br/>
	Quantity:
	<input type="text" id='quantity' size="3" value="<?= $product_minimum ?>" name="quantity" onChange="if (this.value < <?= $product_minimum ?>) { alert('Minimum is <?= $product_minimum ?>'); this.value = <?= $product_minimum ?>; }"/>
	<br/>
	<br/>
	<input type="image" src="/images/buttons/Add-to-Cart.gif" onClick="return confirmTasselSelected('customTassel');"/>
	<br/>
	<br/>
</form>

</div>
