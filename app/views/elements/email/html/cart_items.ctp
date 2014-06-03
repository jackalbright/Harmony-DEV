<? $name = !empty($customer['Customer']['First_Name']) ? $customer['Customer']['First_Name'] : null;

if (!$name && !empty($customer['PreferredBillingAddress']))
{
	$full_name = split("/\s+/", $customer['PreferredBillingAddress']['In_Care_Of']);
	$name = $full_name[0];
}
if (!$name && !empty($customer['PreferredShippingAddress']))
{
	$full_name = split("/\s+/", $customer['PreferredShippingAddress']['In_Care_Of']);
	$name = $full_name[0];
}

$visit_date = null;
if (!empty($last_visit))
{
	$visit_time = strtotime($last_visit['TrackingRequest']['date']);
	$visit_date = date("l, F n", $visit_time); 
}

$cart_url = "http://".$_SERVER['HTTP_HOST']."/cart/display.php?login=1";

?>
<p>Hello<?= !empty($name) ? " $name" : "" ?>,

<p>Thank you for visiting our site at <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/">http://<?= $_SERVER['HTTP_HOST'] ?>/</a>. Since your last visit<? if($visit_date) { echo " on $visit_date"; } ?>, we have noticed you still have the following pending items remaining in your cart:
<br/>
<br/>

<div style='border: solid #CCC 2px;'>
<? foreach($cart_items as $cart_item) { 
	$qty = $cart_item['CartItem']['quantity'];
	$prod = $cart_item['CartItem']['productCode'];
	$product = $all_products[$prod];
	$name = strtolower($product['Product']['name']);
	if ($qty > 1) { $name = $hd->pluralize($name); }
	$parts = unserialize($cart_item['CartItem']['parts']);
	$imgtype = $imgid = null;
	if(!empty($parts['customImageID']))
	{
		$imgtype = 'Custom';
		$imgid = $parts['customImageID'];
	}
	if(!empty($parts['catalogNumber']))
	{
		$imgtype = 'Gallery';
		$imgid = $parts['catalogNumber'];
	}
?>
<div class="left" style="width: 150px;">
<? if($imgtype && $imgid) { ?>
<a href="<?= $cart_url ?>"><img src="http://<?= $_SERVER['HTTP_HOST'] ?>/images/preview/<?= $prod ?>/<?= $imgtype ?>/_<?= $imgid ?>/x150.png"/></a><br/>
<? } ?>
<a href="<?= $cart_url ?>"><?= $qty ?> <?= $name ?></a>
</div>
<? } ?>
</div>


<? if(!empty($custom_message)) { ?>
<p><?= $custom_message ?></p>
<? } ?>

<p>To view your items in your cart, <a href="<?=$cart_url ?>">login to your account</a>.

<p>If you have any questions about your order, please contact us at 888.293.1109, or email us at <a href="mailto:info@harmonydesigns.com">info@harmonydesigns.com</a>.

