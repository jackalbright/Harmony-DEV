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
	     	<i>Welcome, <?= $this_customer['First_Name'] != "" ? $this_customer['First_Name'] : $this_customer['eMail_Address']; ?>!</i><br/>
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
	<td>&nbsp;</td>
</tr>
<tr>
  <td class="Xmainnav" colspan=2 valign=top>
	<? include("dropdown_primary.inc"); ?>
  </td>
  <td id="search" valign=top>
		<div class="">
			<? include(dirname(__FILE__)."/sidebarSearch2.inc"); ?>
		</div>
		<div class="clear"></div>
		<div id="freesample" class="right">Free sample with every order<br /><span style="font-weight:600;">Questions?</span> 888.293.1109</div>
	</td>
</tr>
</table>
