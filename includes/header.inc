<?php
	if  ($_SERVER['SCRIPT_NAME'] == '/index.php') { 
		echo '<img id="logo" src="/new-images/large-logo.gif" alt="hd logo" width="160" height="79" border="0" />';
	} else {
		echo '<a href="/index.php"><img id="logo" src="/new-images/large-logo.gif" alt="harmony designs logo" width="160" height="79" border="0" /></a>';
	}
?>
	<img id="slogan" src="/new-images/Tag-line.gif" width="368" height="15" alt="custom products for gifts and promotions" />
<div id="cart">
	<?php
		if (strpos ($_SERVER['SCRIPT_NAME'], 'cart') > 0 ) {
			echo '<img src="/new-images/cart.gif" alt="cart icon" width="30" height="24" />';
		} else {
			echo '<a href="/cart/display.php"><img src="/new-images/cart.gif" alt="cart icon" width="30" height="24" /></a>';
		}
	?>
	<p>
		<?php
			if (strpos ($_SERVER['SCRIPT_NAME'], 'cart') > 0 ) {
				echo '<img src="/new-buttons/View-Cart-lt.gif" width="69" height="17" alt="View Cart" />';
			} else {
				echo '<a href="/cart/display.php"><img src="/new-buttons/View-Cart-dk.gif" width="69" height="17" alt="View Cart" /></a>';
			}
			echo '<img src="/new-buttons/pipe.gif" width="7" height="17" alt=" " />';
			if (strpos ($_SERVER['SCRIPT_NAME'], 'checkout/review') > 0 ) {
				echo '<img src="/new-buttons/Checkout-lt.gif" width="67" height="17" alt="Checkout" />';
			} else if (strpos ($_SERVER['SCRIPT_NAME'], 'checkout') > 0 ) {
				echo '<a href="/checkout/index.php"><img src="/new-buttons/Checkout-lt.gif" width="67" height="17" alt="Checkout" /></a>';
			} else  if (count($shoppingCart) > 0) {
				echo '<a href="/checkout/index.php"><img src="/new-buttons/Checkout-dk.gif" width="67" height="17" alt="Checkout" /></a>';
			} else {
				echo '<img src="/new-buttons/checkout-gray.gif" width="67" height="17" alt="Checkout (inactive)" />';
			}
		?>
	</p>
	<p>
		Item Total:
		<?php
			$subTotal = 0;
			foreach ($shoppingCart as $cartItem) {
				$subTotal += $cartItem->quantity * $cartItem->unitPrice;
			}
			$pos = strpos($subTotal, '.');
			if ($pos === false)
				$subTotal = $subTotal . '.00';
				else if (strlen ($subTotal) - $pos == 2)
					$subTotal = $subTotal . '0';
			echo '$';
			echo $subTotal;
		?>
	</p>
</div>
<?php
	if ( count($tempImages) > 0 ) {
		echo "<div id=\"imageAlert\">\n";
		echo "<p>You have " . count($tempImages) . " <a href=\"/custserv/index.php\">unsaved image" . ( count($tempImages) > 1 ? 's' : '' ) . "</a></p>\n";
		echo "</div>\n";
	}
?>
<div id="lost">
	<a href="/info/sitemap.php">Site Map</a>

</div>
<div id="buttons">
	<?php 
		if  ($_SERVER['SCRIPT_NAME'] == '/index.php') { 
			echo '<img src="/new-buttons/home-lt.gif" width="108" height="29" alt="Home" />';
		 } else { 
			echo '<a href="/index.php"><img src="/new-buttons/Home-dk.gif" width="108" height="29" alt="Home" /></a>';
		 } 
		 if (strpos ($_SERVER['SCRIPT_NAME'], 'custom/') > 0 ) { 
			echo '<img src="/new-buttons/Use-Your-Art-lt.gif" alt="Use Your Art" width="108" height="29" />';
		 } else {
			echo ( (count($tempImages)+$savedImageCt)>0 ? '<a href="/custom/imageList.php">' : '<a href="/custom/imageUpload.php">' ) . '<img src="/new-buttons/Use-Your-Art-dk.gif" width="108" height="29" alt="Use Your Art" /></a>';
		 } 
		 if (strpos ($_SERVER['SCRIPT_NAME'], 'quantityPricing.php') > 0 ) { 
			echo '<img src="/new-buttons/pricing-lt.gif" alt="Pricing" width="108" height="29" />';
		 } else { 
			echo '<a href="/info/quantityPricing.php"><img src="/new-buttons/pricing-dk.gif" width="108" height="29" alt="Pricing" /></a>';
		} 
		 if (strpos ($_SERVER['SCRIPT_NAME'], 'about-us.php') > 0 ) { 
			echo '<img src="/new-buttons/About-Us-lt.gif" alt="About Harmony Designs" width="108" height="29" />';
		 } else { 
			echo '<a href="/info/about-us.php"><img src="/new-buttons/about-us-dk.gif" width="108" height="29" alt="About Us" /></a>';
		 } 
		 if (strpos ($_SERVER['SCRIPT_NAME'], 'custserv') > 0 ) {
		 	if (strpos ($_SERVER['SCRIPT_NAME'], 'menu.php') > 0 || strpos ($_SERVER['SCRIPT_NAME'], 'index.php') > 0) {
				echo '<img src="/new-buttons/your-account-lt.gif" alt="Your Account" width="108" height="29" />';
			} else {
				echo '<a href="/custserv/index.php"><img src="/new-buttons/your-account-lt.gif" alt="Your Account" width="108" height="29" /></a>';
			}
		 } else { 
			echo '<a href="/custserv/index.php"><img src="/new-buttons/your-account-dk.gif" width="108" height="29" alt="Your Account" /></a>';
		} 
	 ?>
</div>
