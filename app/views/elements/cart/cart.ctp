<?
$checkout = !empty($checkout) ? $checkout : null;
$testShoppingCart = json_encode($shoppingCart);
?>

<table width="100%">
<tr>
<td valign="top">
	<table style="width: 700px !important; border: solid #CCC 1px; border-style: solid;" id="cartDisplay" class="solid_border">
	<tr style="background-color: #AAA; color: #FFF; ">
		<th class="border">Preview</th>
		<th class="border" style="width: 300px;">Details</th>
		<th class="border" style="width: 50px;">Quantity</th>
		<th class="border" style="width: 75px;">Unit Price</th>
		<th class="border" style="width: 75px;">Total</th>
	</tr>

	<?php
		
		$i = 0; foreach($shoppingCart as $cartItem) { 
		$cart_item_id = $cartItem['cart_item_id'];
		$quantity = $cartItem['quantity'];
		$options = $cartItem['parts'];
		$unitPrice = $cartItem['unitPrice'];
		$productCode = $code = $cartItem['productCode'];
		$template = $cartItem['template'];
		$cart_item_product = $product = $cartItem['Product'];
		$baseCode = $cart_item_product['code'];
		if ($baseCode == 'BC') { $baseCode = 'B'; }
		if ($baseCode == 'PSF') { $baseCode = 'PS'; }
		$customImage = $cartItem['CustomImage'];
		$galleryImage = $cartItem['GalleryImage'];
		$image_name = "Custom";
		$imageID = $customImage ? $customImage['Image_ID'] : null;
		$catalog_number = $galleryImage ? $galleryImage['catalog_number'] : null;
		if ($customImage) { $image_name = $customImage['Title']; }
		if ($galleryImage) { $image_name = $galleryImage['stamp_name']; }
		if (!$image_name) { $image_name = 'Custom'; }

		$product = !empty($product_map[$productCode]) ?  $product_map[$productCode] : null;
		$pricing = !empty($pricing_map[$productCode]) ?  $pricing_map[$productCode] : null;
		$related_products = !empty($related_product_map[$productCode]) ?  $related_product_map[$productCode] : null;
		$parent = !empty($parent_product_map[$productCode]) ?  $parent_product_map[$productCode] : null;
		$parentCode = !empty($parent) ? $parent['code'] : null;

		# If we submitted an order, we need to get the order_item_id from the cart_item_id....
		$order_item_id = null;
		if (!empty($receipt) && !empty($cart_item_id_map))
		{
			$order_item_id = $cart_item_id_map[$cart_item_id];
		}
		$oldBuild = empty($cartItem['new_build']);#false;
		$sides = array();
		if(!empty($cartItem['CartItem']['parts'])) { $sides[] = unserialize($cartItem['CartItem']['parts']); }
		if(!empty($cartItem['CartItem']['parts2'])) { $sides[] = unserialize($cartItem['CartItem']['parts2']); }

		#if(!empty($sides[0]['catalogNumber'])) { # STAMP, use old previewer. 
		#	$oldBuild = true;
		#}
		$webroot = APP."/webroot";
		##if(!file_exists("$webroot/images/designs/products/$code.svg") && (empty($parentCode) || !file_exists("$webroot/images/designs/products/$parentCode.svg")))
		#{
		#	$oldBuild = true;
		#}
	?>
	<tr class="<?= ($i % 2 == 0) ? 'cart_even' : 'cart_odd' ?>">
		<td valign=top align="center" class="border">

		<? if(!$oldBuild) { ?>
			<?= $this->element("cart/preview", array('cartItem'=>$cartItem,'order_item_id'=>$order_item_id,'product'=>$product,'checkout'=>$checkout)); ?>

			<? if(empty($checkout) && (!empty($cartItem['parts']['customized']) || !empty($product['customizable']))) { ?>
				<? if(!empty($this->params['admin'])) { ?>
					<a style="color: #0369A7;" href="/admin/cartItems/edit/<?= $cartItem_id ?>">
				<? } ?>
                
			<? } ?>
            
		<? } else { ?>
			<? if($order_item_id) { ?>
				<?= $this->element("build/preview", array('order_item_id'=>$order_item_id,'build'=>array('Product'=>$product, 'CustomImage'=>$customImage,'GalleryImage'=>$galleryImage,'cart'=>1,'template'=>$template,'options'=>$options,'no_view_larger'=>1))); ?>
                
			<? } else { ?>
				<?= $this->element("build/preview", array('cart_item_id'=>$cart_item_id,'build'=>array('Product'=>$product, 'CustomImage'=>$customImage,'GalleryImage'=>$galleryImage,'cart'=>1,'template'=>$template,'options'=>$options,'no_view_larger'=>1))); ?>
                
			<? } ?>
            
		<? } ?>

		<div>
			<? if((!empty($cartItem['parts']['customImageID']) || !empty($cartItem['parts']['catalogNumber'])) && empty($checkout) && empty($cartItem['order_item_id'])) { ?>
				<? if(!empty($this->params['admin'])) { ?>
					<a style="color: #0369A7;" href="/admin/cartItems/edit/<?= $cartItem_id ?>">Modify this item</a>
				<? } ?>
                <p>Preview is approximate. Actual design  is used for your product.</p>
			<? }else{ ?>
            	<p>Preview is approximate. Actual design  is used for your product.</p>
            <? } ?>
		</div>
		</td>
		<td valign=top class="border" style="width: 300px;">
		<? if(!$oldBuild) { # New ?>
			<?= $this->element("cart/description", array('cartItem'=>$cartItem,'product'=>$product,'checkout'=>$checkout)); ?>
			
		<? } else { ?>
			<?= $this->element("cart/item_description", array('cart_item'=>$cartItem,'product'=>$product,'imageID'=>$imageID,'cart_item_product'=>$cart_item_product,'cart_item_id'=>$cart_item_id,'catalog_number'=>$catalog_number,'checkout'=>$checkout,'quantity'=>$quantity)); ?>
		<? } ?>

			<br/>
			<div class="right_align">

			<? if(empty($this->params['admin']) && empty($checkout)) { ?>
			<br/>
			<br/>
			<div align="right">
			<? if($customImage) { ?>
				You might also like your art on
				<a href="/custom_images/select/<?= $customImage['Image_ID'] ?>?clear=1">other products</a>
			<? } else if ($galleryImage) { ?>
				You might also like
				<a href="/gallery/view/<?= $galleryImage['catalog_number'] ?>">other "<?= $image_name ?>" products</a>
			<? } else if ($product['is_stock_item'] && empty($parent) && empty($cartItem['parts']['customized'])) { ?>
				<?
					$name = !empty($product['short_name']) ? $product['short_name'] : $product['name'];
				?>
				Order more <a href="/details/<?= $product['prod'] ?>.php"><?= strtolower($hd->pluralize($name)) ?></a><br/>
			<? } else if ($product['is_stock_item'] && !empty($parent) && empty($cartItem['parts']['customized'])) { ?>
				Order more <a href="/details/<?= $parent['Product']['prod'] ?>.php"><?= strtolower($hd->pluralize($parent['Product']['short_name'])) ?></a><br/>
			<? } ?>
			</div>
			</div>
			<? } else if(!empty($this->params['admin'])) { ?>
				<?= $this->Html->link("Move to Saved Orders", "javascript:saveOrderItem('{$cart_item_id}');", array('style'=>'')); ?>
			<? } ?>
		</td>
		<td valign=top class="border">
			<? if(!empty($checkout) && empty($options['size'])) { ?>
				<?= $quantity ?>
			<? } else if(!empty($options['size']) && is_array($options['size'])) { ?>
				<table>
					<? foreach($options['size'] as $s=>$q) { 
						$cart_item_id = $cartItem['cart_item_id'];
						if(!empty($checkout) && empty($q)) { continue; }
					?>
					<tr>
						<td>
							<b><?= $s ?>:</b>
						</td>
						<td style="height: 2em; padding: 0px;">
							<? if(empty($checkout)) { ?>
							<input type="text" style="margin: 0px; width: 3em;" size="3" class="quantity_size<?=$cart_item_id?>" name="quantity_size<?=!empty($cart_item_id)?$cart_item_id:""?>[<?=$s?>]" value="<?= $q ?>"/>
							<? } else { ?>
								<?= $q ?>
							<? } ?>
						</td>
					</tr>
					<? } ?>
				<tr>
					<td colspan=2>
						<hr/>
					</td>
				</tr>
				<tr>
					<td valign="top">Total:</td>
					<td valign="top" align="left">
						<span id="quantity<?=$i?>"><?= $quantity ?></span>
					</td>
				</tr>
				</table>
				<? if(empty($checkout)) { ?>
				<input type="image" src="/images/buttons/small/Update-Qty-grey.gif" onClick="if(checkMinimum(quantitySum('quantity_size<?=$cart_item_id?>'), '<?= $product['minimum'] ?>', 'quantity<?=$cart_item_id?>')) { showPleaseWait(); return true; } else { return false; }"/>
				<br/>
				<? } ?>
			<? } else { ?>
				<nobr><input type="text" size=4 id="quantity<?= $i ?>" name="quantity<?= $cartItem['cart_item_id'] ?>" value="<?=$quantity?>" onChange="if(parseInt(this.value) > 0) { return checkMinimum(this.value, '<?= $cart_item_product['minimum'] ?>', 'quantity<?=$i?>'); }"/> x</nobr>
				<input type="image" onClick="showPleaseWait();" src="/images/buttons/small/Update-Qty-grey.gif"/>
				<br/>
			<? } ?>

			<? if(empty($checkout)) { ?>
				<? if(!empty($this->params['admin'])) { ?>
					<a href="/admin/cart_items/delete/<?= $cartItem['cart_item_id'] ?>" onClick="return confirm('Are you sure you want to remove this item?');">Remove</a>
				<? } else { ?>
					<a href="/cart/remove/<?= $cartItem['cart_item_id'] ?>" onClick="return confirm('Are you sure you want to remove this item?');">Remove</a>
				<? } ?>
			<? } ?>
		</td>
		<td valign=top class="border">
		<div style="">
			<? $setup = $cartItem['setupPrice']; ?>

			<? if(!empty($options['size'])) { ?>
				<table>
					<? foreach($options['size'] as $s=>$q) { 
						$cart_item_id = $cartItem['cart_item_id'];
						$surcharge = !empty($product["surcharge_$s"]) ? $product["surcharge_$s"] : 0;
						if(!empty($checkout) && empty($q)) { continue; }
					?>
					<tr>
						<td style="height: 2em; padding: 0px;">
							<nobr>x <?= sprintf("$%.02f", $unitPrice + $surcharge); ?></nobr>
						</td>
					</tr>
					<? } ?>
				</table>
			<? } else { ?>
				<?= sprintf("$%.02f", $unitPrice); ?>
				<? if(!empty($cartItem['parts2']) && !empty($cartItem['options_cost']['printing_back'])) { ?>
				<div>
					<i>(includes <?= sprintf("$%0.02f ea.", $cartItem['options_cost']['printing_back']); ?> for printing on back)</i>
				</div>
				<? } ?>
				<? if(!empty($cartItem['setupPrice']) && $cartItem['setupPrice'] > 0) { ?>
				<br/>
				<b>+ <?= sprintf("$%.0f setup", $setup); ?></b>
				<? } ?>
			<? } ?>
		</div>
		</td>
		<td valign=top class="border" align="right">
			<? $list_price = !empty($pricing) ? $pricing[0]['price'] : $unitPrice; ?>
			<? if (empty($is_wholesale) && $list_price > $unitPrice) { ?>
			<div style="text-decoration: line-through;"><?= sprintf("$%.02f", $list_price*$quantity+$setup); ?></div>
			<? } ?>
			<div style="color: #B82A2A; font-weight: bold;"><?= sprintf("$%.02f", $unitPrice*$quantity+$setup); ?></div>
			<? if (empty($is_wholesale) && $list_price > $unitPrice) { ?>
			<div style="color: #B82A2A;">
				<?= sprintf("(%u%% off)", ($list_price-$unitPrice)/$list_price*100); ?>
			</div>
			<? } ?>
			<? if(empty($customer['is_wholesale']) && !empty($product['free_shipping']) && !empty($config['free_ground_shipping_minimum']) && $subtotal > $config['free_ground_shipping_minimum']) { ?>
			<div class="alert2" style="margin-top: 1.5em; text-align: center;">
				THIS ITEM QUALIFIES FOR FREE SHIPPING
			</div>
			<? } ?>
		</td>
	</tr>
	<? $i++; } ?>

	</table>
</td>
<? if(empty($nosummary) && (empty($checkout) || $this->action == 'receipt')) { ?>
<td valign="top" style="width: 250px;">
<div id="review">
	<? if(empty($checkout)) { $checkout = null; } ?>
	<? $this->set("checkout", $checkout); ?>
	<?= $this->element("../cart/update_review"); ?>

	<div align="right" valign="top">


	<a name="trustlink" href="http://secure.trust-guard.com/security/6480" rel="nofollow" target="_blank" onclick="var nonwin=navigator.appName!='Microsoft Internet Explorer'?'yes':'no'; window.open(this.href.replace(/https?/, 'https'),'welcome','location='+nonwin+',scrollbars=yes,width=517,height='+screen.availHeight+',menubar=no,toolbar=no'); return false;" oncontextmenu="var d = new Date(); alert('Copying Prohibited by Law - This image and all included logos are copyrighted by trust-guard \251 '+d.getFullYear()+'.'); return false;"><img name="trustseal" alt="Security Seals" style="border: 0;" src="//dw26xg4lubooo.cloudfront.net/seals/logo/6480-lg.gif" /></a>


      	<!-- <a name="trustlink" href="http://secure.trust-guard.com/certificates/6480" target="_blank" onclick="var nonwin=navigator.appName!='Microsoft Internet Explorer'?'yes':'no'; window.open(this.href.replace('http', 'https'),'welcome','location='+nonwin+',scrollbars=yes,width=517,height='+screen.availHeight+',menubar=no,toolbar=no'); return false;" oncontextmenu="var d = new Date(); alert('Copying Prohibited by Law - This image and all included logos are copyrighted by trust-guard \251 '+d.getFullYear()+'.'); return false;"><img name="trustseal" alt="Security Seal" style="border: 0;" src="https://c674753.ssl.cf2.rackcdn.com/security-6480-mini-white.gif" /></a> -->



	<!--
          <a target="_blank" href="https://www.scanalert.com/RatingVerify?ref=www.harmonydesigns.com"><img height="30" border="0" src="https://images.scanalert.com/meter/www.harmonydesigns.com/12.gif" alt="HACKER SAFE certified sites prevent over 99.9% of hacker crime." oncontextmenu="alert('Copying Prohibited by Law - HACKER SAFE is a Trademark of ScanAlert'); return false;" /></a>
	  -->
	<SCRIPT LANGUAGE="JavaScript"  TYPE="text/javascript" SRC="//smarticon.geotrust.com/si.js"></SCRIPT>
	</div>
</div>
</td>
<? } else if (!empty($checkout) && empty($purchase_id) && $this->action == 'form') {  ?>
<td valign="top" align="center" style="width: 250px;">
			<input id="place_order" type="image" src="/images/webButtons2014/orange/large/placeYourOrder.png"/>
			<div id="processing" style="font-weight: bold; font-size: 14px; text-align:center;" class="hidden">
				Processing order...
				<img align="top" src="/images/waiting.gif"/>
			</div>

			<div style="border: solid #CCC 2px;">
				<h3 style="background-color: #AAA; padding: 5px;">Order Summary</h3>
				<div id="order_summary2">Type in your zip/postal code to determine shipping costs and grand total</div>
			</div>
</td>
<? } ?>
</tr>
</table>
<? if(!empty($this->params['admin'])) { ?>
<script>
function saveOrderItem(cart_item_id)
{
	var defaultDate = j.format.date(new Date(), "MM/dd/yyyy");
	if(orderDate = prompt("Enter an order date (mm/dd/yyyy)", defaultDate))
	{
		var ymd = j.format.date((new Date(orderDate)), "yyyy-MM-dd").toString();
		//console.log(ymd);
		var data = { "data[Purchase][Order_Date]": ymd };
		j('#CartForm').ajaxSubmit({
			url: "/admin/checkout/save_cart_item/"+cart_item_id,
			data: data,
			dataType: 'json',
			success: function(response) {
				if(response.error)
				{
					alert(response.error);
				} else if(response.location) {
					window.location.href = response.location;
				}
				//console.log(response);
			}
		});
	}
}
</script>
<? } ?>

