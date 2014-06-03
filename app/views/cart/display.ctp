<div class="cart">

<?php #print_r($cart_items);
session_start(); 
$testCartItem = $session->read("testCartItem");// these two test items are set when we come here from the product orders
$testCartParts = $session->read("testCartParts");
$parts_side_1 = $session->read("parts_side_1"); // this test item is set when we come here from the build page

?>
<script type="text/javascript">
//var session = '(<?php //echo json_encode($_SESSION['testCartItem']);?>';
var session = '(<?php echo $_SESSION['testCartItem'];?>';
 console.log(session);
//var session = '(<?php //echo json_encode($_SESSION['testCartParts']);?>';
 //console.log(session);
 var session = '(<?php echo json_encode($_SESSION['testSide1']);?>';
 console.log(session);
  var session = '(<?php echo json_encode($_SESSION['testSide2']);?>';
 console.log(session);
 
 //parts_side_1
 console.log("test cart item");
 var session = '(<?php echo json_encode($_SESSION['testCartItem']);?>';
 console.log(session);
 
 console.log("parts_side_1");
 var session = '(<?php echo json_encode($_SESSION['parts_side_1']);?>';
 console.log(session);
 //parts_side_2
 console.log("parts_side_2");
 var session = '(<?php echo json_encode($_SESSION['parts_side_2']);?>';
 console.log(session);
</script>
<? 
if (!isset($zipCode)) { $zipCode = ""; }
if (!isset($shippingOptions)) { $shippingOptions = array(); }

?>
<style>
</style>

<form id="cartForm" action="/cart/update.php" method="POST">
	<? if($session->read("reorder")) { ?>
	<div style="background-color: #FFFF9C; border: solid 1px #436077; width: 500px; padding: 10px;">
		To change your reordered items, click on 'Modify this item'.<br/>
		<br/>
		<a href="/purchases">Return to order history</a>
		<br/>
		<br/>
	</div>
	<? } ?>

	<? if($session->read("Auth.Customer.is_wholesale") && !empty($settings['wholesale_purchase_minimum']) && $subtotal < $settings['wholesale_purchase_minimum']) { ?>
	<div id="flashMessage" class="warn">
		For wholesale customers, we require that your order be a minimum of $<?= $settings['wholesale_purchase_minimum'] ?>.
		Please add $<?= sprintf("%.02f", $settings['wholesale_purchase_minimum'] - $subtotal); ?> more to your cart in order to checkout.
	</div>
	<? 
	$this->Session->delete("under_wholesale_mininum"); 
	} ?>

	<table class="" width="100%" border=0>
	<tr>
		<td valign=bottom align="left">
			<?= $this->element("cart/progress"); ?>
		</td>
		<td align="right" valign='bottom' style="width: 300px;">
			<table width="100%">
			<tr>
				<td align="right" valign="top">
					<a href="/products"><img src="/images/webButtons2014/grey/large/continueShopping.png"/></a>
				</td>
				<td align="right" valign="top">
					<a href="/checkout" onClick="showPleaseWait(); track_complete('cart','display','<?= $tracking_entry_id ?>');"><img src="/images/webButtons2014/orange/large/checkout.png"/></a>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
	<td colspan="2">

	<?= $this->element("cart/cart",array()); ?>

	</td>
	</tr>
	<tr>
		<td>
			&nbsp;
		</td>
		<td align="right">
			<a href="/products"><img src="/images/webButtons2014/grey/large/continueShopping.png"/></a>
			<!--<input type="image" name="action" value="changeQuantity" src="/images/buttons/Update-Qty-grey.gif"/>-->
			<a href="/checkout" onClick="track_complete('cart','display','<?= $tracking_entry_id ?>');"><img src="/images/webButtons2014/orange/large/checkout.png"/></a>
		</td>
	</tr>
	</table>
</form>
</div>

