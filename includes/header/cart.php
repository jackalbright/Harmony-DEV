CART!
<div>
		  	<?php
				$subTotal = 0;
				$subQuantity = 0;
	
				$session_id = session_id();
				$customer_id = !empty($_SESSION['Auth']['Customer']['customer_id']) ? $_SESSION['Auth']['Customer']['customer_id'] : null;
	
				$cartItems = get_db_records("cart_items", " customer_id = '$customer_id' OR session_id = '$session_id' ");
				echo "CID=$customer_id, SID=$session_id, ";
				echo "CI=".count($cartItems);
	
				foreach ($cartItems as $cartItem)
				{
					if (is_object($cartItem))
					{
						$subTotal += $cartItem->quantity * $cartItem->unitPrice;
						$subQuantity += $cartItem->quantity;
					} else if (is_array($cartItem)) {
						$unitPrice = !empty($cartItem['unitPrice']) ? $cartItem['unitPrice'] : 0;
						$subTotal += $cartItem['quantity'] * $unitPrice;
						$subQuantity += $cartItem['quantity'];
					}
				}
				if (false && $subTotal > 0) { 
					printf("($%.02f Total)",  $subTotal);
					echo " | ";
					echo '<a href="/cart/checkout" class="viewcart">Checkout</a>';
				}
			?>

			<table cellpadding=2 cellspacing=0 width="100%" border=0>
			<tr>
			<td valign="top" align="left">
				<? include("images.php"); ?>
				<? include("designs.php"); ?>
			</td>
			<td>
		 	<div class="relative right" style="padding-left: 3px; width: 40px; height: 35px; background-image: url('/images/icons/shopping_cart.png'); background-repeat: no-repeat; margin: 0 auto; text-align: center;">
				<a href="/cart/display.php" class="block nounderline" style="height: 35px; position: relative; left: 0px; width: 35px; color: #009900; font-weight: bold; font-size: 16px;"><?= $subQuantity ?></a>
			</div>
			</td>
			<td>
				<img src="/images/icons/paypal-cc.png" height="25"/>
			</td>
			</tr>
			</table>
</div>
