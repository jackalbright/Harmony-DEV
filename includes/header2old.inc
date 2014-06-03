<script src="/javascript/mootools.js" type="text/javascript"></script>
<table id="header_row" border=0 cellspacing=0>
<tr>
	<td id="logo" rowspan=4 valign=top>
		<a name="top" href="/index.php"><img class="logo" src="/images-shared/large-logo.gif" alt="harmony designs logo" border="0" /></a>
	</td>
	<td rowspan=2 id="slogan">
		<!--
  		<img class="slogan" src="/images-shared/personalizedGifts.gif" alt="Personalized Gifts" border="0">
		<br/>
		-->
		<h2>Creating personalized gifts since 1992</h2>
	</td>
	<td colspan=2 id="account">
		<?
		# If have cookie but no session customer info, regenerate....
		$this_customer = $_SESSION['customerRecord'];
		#error_log("CU=".print_r($this_customer,true));
		?>
	
	     <? if (!empty($this_customer)) { ?>
	     	Welcome, <?= $this_customer['First_Name'] != "" ? $this_customer['First_Name'] : $this_customer['eMail_Address']; ?> |
	     	<a href="/custserv/logout.php">Logout</a> |
	     <? } else { ?>
	     	<a href="/custserv/">Login</a> |
	     <? } ?>
	     <a href="/custserv/menu.php">My Account</a> |
	     <a href="/custom/imageList.php">My Images</a>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td id="cart">
	 <?php
		#if (strpos ($_SERVER['SCRIPT_NAME'], 'cart') > 0 ) {
		#	echo '<img src="/images-shared/cart.gif" alt="Shopping Cart" width="29" height="29" border="0" class="carticon">';
		#} else {
			echo '<a href="/cart/display.php"><img src="/images-shared/cart.gif" alt="Shopping Cart" width="29" height="29" border="0" class="carticon"></a>';
		#}
	?>
	<?php
			#if (strpos ($_SERVER['SCRIPT_NAME'], 'cart') > 0 ) {
			#	echo 'View Cart';
			#} else {
				echo '<a href="/cart/display.php" class="viewcart">View Cart</a>';
			#}
			echo ' | ';
			if (strpos ($_SERVER['SCRIPT_NAME'], 'checkout/review') > 0 ) {
				echo 'Checkout';
			} else if (strpos ($_SERVER['SCRIPT_NAME'], 'checkout') > 0 ) {
				echo '<a href="/checkout/index.php" class="viewcart">Checkout</a>';
			} else  if (count($_SESSION['shoppingCart']) > 0) {
				echo '<a href="/checkout/index.php" class="viewcart">Checkout</a>';
			} else {
				echo 'Checkout';
			}
		?><br />
      Item Total:
	  <?php
			$subTotal = 0;
			foreach ($_SESSION['shoppingCart'] as $cartItem) {
				$subTotal += $cartItem->quantity * $cartItem->unitPrice;
			}
			printf("$%.02f",  $subTotal);
		?>
	</td>
</tr>
<tr>
	<td valign=bottom colspan=2>
		<div id="specialty">
  		<b>Specialty Services:</b>
  		<a href="/specialties/corporate.php">Corporate</a> |
  		<a href="/specialties/educator.php">Education</a> |
  		<a href="/specialties/museumstore.php">Museums</a> |
  		<a href="/specialties/wedding.php">Weddings</a>
		</div>
	</td>
	<td id="freesample" class="freesamplecaption">Free sample with every order<br /><span style="font-weight:600;">Questions?</span> 888.293.1109
	</td>
</tr>
<tr>
  <td class="mainnav" colspan=3>
	<table width="100%" border=0 cellspacing=0>
	<tr>
	<td valign=top align="left">
		<table id="mainnav_new" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="mainnav_button_left"><a href="/">Home</a></td>
			<td class="mainnav_button" onMouseOver="$('mainnav_submenu_products').addClass('mainnav_submenu_selected');" onMouseOut="$('mainnav_submenu_products').removeClass('mainnav_submenu_selected');">
				<a href="/">Products</a>
				<table id="mainnav_submenu_products" class="mainnav_submenu" border=0>
				<tr>
					<td class="mainnav_subbutton_left"><a href="/details/bookmark.php">Bookmarks</a></td>
					<td class="mainnav_subbutton"><a href="/details/framedstamp.php">Framed Stamps</a></td>
				</tr>
				<tr>
					<td class="mainnav_subbutton_left"><a href="/details/paperweight.php">Glass Paperweights</a></td>
					<td class="mainnav_subbutton"><a href="/details/bagtag.php">Luggage Tags</a></td>
				</tr>
				<tr>
					<td class="mainnav_subbutton_left"><a href="/details/magnet.php">Magnets</a></td>
					<td class="mainnav_subbutton"><a href="/details/ornament.php">Ornaments</a></td>
				</tr>
				<tr>
					<td class="mainnav_subbutton_left"><a href="/details/mug.php">Mugs</a></td>
					<td class="mainnav_subbutton"><a href="/details/pin.php">Pins and Tie Tacks</a></td>
				</tr>
				<tr>
					<td class="mainnav_subbutton_left"><a href="/details/keychain.php">Keychains</a></td>
					<td class="mainnav_subbutton"><a href="/details/poster.php">Posters</a></td>
				</tr>
				<tr>
					<td class="mainnav_subbutton_left">&nbsp;</td>
					<td class="mainnav_subbutton"><a href="/details/postcard.php">Postcards</a></td>
				</tr>
				<tr>
					<td class="mainnav_subbutton_left"><b>Stock Items:</b></td>
					<td class="mainnav_subbutton"><a href="/details/puzzle.php">Puzzles</a></td>
				</tr>
				<tr>
					<td class="mainnav_subbutton_left"><a href="/details/ruler.php">Presidents Rulers</a></td>
					<td class="mainnav_subbutton"><a href="/details/customruler.php">Rulers (Custom)</a></td>
				</tr>
				<tr>
					<td class="mainnav_subbutton_left"><a href="/details/paperweightkit.php">Blank Paperweight Kits</a></td>
					<td class="mainnav_subbutton"><a href="/details/stamp-on-card.php">Stamps on Cards</a></td>
				</tr>
				<tr>
					<td class="mainnav_subbutton_left"><a href="/details/tassel.php">Bookmark Tassels</a></td>
					<td class="mainnav_subbutton"><a href="/details/t-shirt.php">T-Shirts</a></td>
				</tr>
				<tr>
					<td class="mainnav_subbutton_left"><a href="/details/charm.php">Charms</a></td>
					<td class="mainnav_subbutton"><a href="/details/totebag.php">Tote Bags</a></td>
				</tr>
				</table>

			</td>
			<td class="mainnav_button"> <a href="/info/quantityPricing.php">Pricing</a> </td>
			<td class="mainnav_button" onMouseOver="$('mainnav_submenu_faq').addClass('mainnav_submenu_selected');" onMouseOut="$('mainnav_submenu_faq').removeClass('mainnav_submenu_selected');">
				<a href="/info/faq.php">FAQ</a>
				<table id="mainnav_submenu_faq" class="mainnav_submenu" border=0>
				<tr>
					<td class="mainnav_subbutton_top">
						<a href="/info/faq.php">General</a>
					</td>
				</tr>
				<tr>
					<td class="mainnav_subbutton">
						<a href="/info/shippingCalculator.php">Shipping Calculator</a>
					</td>
				</tr>
				<tr>
					<td class="mainnav_subbutton">
						<a href="/custom/designServices.php">Design Services</a>
					</td>
				</tr>
				<tr>
					<td class="mainnav_subbutton">
						<a href="/info/faq.php#production">Production Time</a>
					</td>
				</tr>
				<tr>
					<td class="mainnav_subbutton">
						<a href="/info/guarantee.php">Guarantee</a>
					</td>
				</tr>
				<tr>
					<td class="mainnav_subbutton">
						<a href="/info/security.php">Security</a>
					</td>
				</tr>
				<tr>
					<td class="mainnav_subbutton">
						<a href="/info/privacy.php">Privacy Policy</a>
					</td>
				</tr>
				</table>
			</td>
			<td class="mainnav_button"><a href="/info/testimonials.php">Testimonials</a></td>
			<td class="mainnav_button"><a href="/info/contact_us.php">Contact Us</a></td>
			<td class="mainnav_button"><a href="/info/about.php">About Us</a></td>
		</tr>
		</table>
	</td>
	<td valign=top align="center">
  	<!-- <? include(dirname(__FILE__)."/productsDropdown.inc"); ?> -->
	</td>
	<td valign=top align=right>
		<? include(dirname(__FILE__)."/sidebarSearch2.inc"); ?>
	</td>
	</tr>
	</table>
  </td>
</tr>
</table>
