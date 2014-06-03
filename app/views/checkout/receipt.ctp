<script type="text/javascript">
var session = '<?php echo $_SESSION['testCartValue']?>';
console.log('testCartValue');
console.log(session);
</script>
<div>
	<p>A copy of your order has been emailed to you.

	<p>Your order number is <?= $purchase_id ?>.

	<p><a href="Javascript:void(0)" onClick="window.print();">Print this order</a>

	<table width="65%">
	<tr>
		<td>
			<a href="/products"><img src="/images/buttons/Continue-Shopping-grey.gif"/></a>
		</td>
		<td align="right">
			<div id="questions">
			Questions? 888.293.1109
			</div>
		</td>
	</tr>
	</table>
	</div>

	<table width="100%">
	<tr>
		<td>
			<?= $this->element("cart/cart",array('checkout'=>1,'receipt'=>1,'read_only_summary'=>1)); ?>
		</td>
		<!--
		<td style="width: 200px;">
			YOU MIGHT ALSO LIKE....
		</td>
		-->
	</tr>
	</table>

</div>
<script>
// the following lines will append the AddRoll code to the bottom of the page, for this page only. 
// We do this because:
// A. The addRoll code is in the global footer, which is shared by every page
// B. We do not want addRoll to serve adds for this particular page
// C. This page has the same URL as the previous purchase page (the one where the user has not yet finalized the purchase)
var script   = document.createElement("script");
script.type  = "text/javascript";
script.text  = "adroll_segments = "converted";"               // use this for inline script
document.body.appendChild(script);




try
{
  var pageTracker = _gat._getTracker("UA-16111468-1");
	//if(console) { console.log("TRACKING ECOMMERCE, TRAXKER="); console.log(pageTracker); }
  //pageTracker._trackPageview(); // already done.
  pageTracker._addTrans(
      "<?= $purchase['Purchase']['purchase_id'] ?>",            // transaction ID - required
      "<?= $this->Session->read("Auth.Customer.is_admin") ? "test" : "live" ?>",  // affiliation or store name
      "<?= $purchase['Purchase']['Charge_Amount'] ?>",           // total - required
      "0", //1.29",            // tax
      "<?= $purchase['Purchase']['Shipping_Cost'] ?>",           // shipping
      "<?= $billingAddress['ContactInfo']['City'] ?>",        // city
      "<?= $billingAddress['ContactInfo']['State'] ?>",      // state or province
      "<?= $billingAddress['ContactInfo']['Country'] ?>"              // country
    );

    //if(console) { console.log("DONE TRANS"); }


<? foreach($purchase['OrderItem'] as $item) { ?>
   // add item might be called for every item in the shopping cart
   // where your ecommerce engine loops through each item in the cart and
   // prints out _addItem for each 
   pageTracker._addItem(
      "<?= $item['Purchase_id'] ?>",           // transaction ID - necessary to associate item with transaction
      "<?= $item[0]['itemNumber'] ?>",           // SKU/code - required
      "<?= $item['Product']['name'] ?>",        // product name
      "",   // category or variation
      "<?= $item['Price'] ?>",          // unit price - required
      "<?= $item['Quantity'] ?>"               // quantity - required
   );
    //if(console) { console.log("DONE ITEM"); }
<? } ?>

<? if(!empty($livesite)) { ?>
   pageTracker._trackTrans(); //submits transaction to the Analytics servers
    //if(console) { console.log("TRANS SENT"); }
<? } ?>

} catch(err) {
	console.log(err);
}
</script>
