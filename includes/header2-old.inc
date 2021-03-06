<?
include_once("database.inc");

$customer_id = !empty($_SESSION['Auth']['Customer']['customer_id']) ? $_SESSION['Auth']['Customer']['customer_id'] : null;
#echo "CID=$customer_id";
$session_id = session_id();

$saved_img_count = 0;

if ($customer_id)
{
	$saved_images = get_db_record("custom_image", array(" customer_id = '$customer_id' "), null, array("COUNT(*) AS count"));
	$saved_img_count = $saved_images['count'];
}

$unsaved_img_count = 0;
$session_id = session_id();
$unsaved_images = get_db_record("custom_image", array(" customer_id IS NULL AND session_id = '$session_id' "), null, array("COUNT(*) AS count"));
$unsaved_img_count = $unsaved_images['count'];

?>
<div>

<div>
<table id="" border=0 cellspacing=0 width="100%">
<tr>
	<td colspan=4 align="right">
	<? if(!empty($special_offer)) { ?>
		<div id="special_offer" class="alert2">
			<?= $special_offer ?>
		</div>
	<? } ?>
	</td>
</tr>
<tr>
	<td id="logo" rowspan=2 valign=top align="center">
		<a name="top" href="/index.php"><img class="logo" src="/images-shared/large-logo.gif" alt="harmony designs logo" border="0" /></a>
		<div class="bold " align="center">Questions? 888.293.1109</div>
	</td>
	<td rowspan=1 colspan=2 valign="top" align="left">
		<div id="since1992">Creating custom gifts since 1992</div>
	</td>
	<td colspan=1 rowspan=2 align=right valign=top id="cart">
		<? $this_customer = isset($_SESSION['Auth']['Customer']) ? $_SESSION['Auth']['Customer'] : null; ?>
		<table border=0 width="250">
		<? if (!empty($this_customer)) { ?>
		<tr>
			<td colspan=2 align="left">
			     	<i>Hello, <?= $this_customer['First_Name'] != "" ? $this_customer['First_Name'] : ($this_customer['eMail_Address'] ? $this_customer['eMail_Address'] : "guest"); ?></i>
			</td>
		</tr>
		<? } ?>

		<tr>
			<td valign="bottom" align="left">
				<div align="left">
				<? if(empty($this_customer)) { ?>
					<a href="?login=1"><img src="/images/buttons/small/Log-In.gif"/></a>
				<? } else { ?>
					<a href="/account/logout">Logout</a>
					<br/>
				<? } ?>
				</div>
	     			<a href="/account">My Account</a><br/>
	     			<a style="color: #009900;" href="/custom_images">My Images <?= ($saved_img_count+$unsaved_img_count > 0) ? sprintf("(%s)", $saved_img_count + $unsaved_img_count) : "" ?></a>
				<? if($unsaved_img_count > 0) { ?><br/><a href="/custom_images" class="bold alert">(<?= $unsaved_img_count ?> unsaved <?= $unsaved_img_count > 1 ? "images" : "image" ?>)</a><br/><? } ?>
			</td>
		 <td valign="top" align="right" style="">
			<a href="/cart/display.php"><img src="/images/icons/shopping_cart.gif" height="40" alt="Shopping Cart" border="0" class="carticon"></a>
			<br/>
		  	<?php
				$subTotal = 0;
				$subQuantity = 0;
				#$cartItems = !empty($_SESSION['shoppingCart']) ? $_SESSION['shoppingCart'] : array();
	
				$session_id = session_id();
				$customer_id = !empty($_SESSION['Auth']['Customer']['customer_id']) ? $_SESSION['Auth']['Customer']['customer_id'] : null;
	
				#echo "$session_id / $customer_id";
	
				$cartItems = get_db_records("cart_items", " customer_id = '$customer_id' OR session_id = '$session_id' ");
	
				foreach ($cartItems as $cartItem)
				{
					#echo "CI=".print_r($cartItem,true);
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
				echo "(".$subQuantity." items)";
			?>
				<?
				if (count($cartItems)) { 
					echo '<br/><a href="/cart/checkout" class="viewcart">Checkout</a>';
				}
				?>
				<a class="hidden" href="/includes/fakecc.php">_</a>
				<br/>
				<img height="25" src="/images/icons/paypal-cc.png"/>
	     	</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td valign="top">
		<div align="center" style="font-size: 1.2em; width: 325px;">
		Museum-store quality &bull; Low minimums 
		<br/>
		Design online
		&bull; 
		Made in USA
		</div>
		<div class="hidden">Free sample with every order</div>
	</td>
	<td valign="top" style="width: 250px;" align="left">
		<div class="clear"></div>
		<div style="width: 250px;">
			<img valign="top" class="left" style="border: solid #CCC 1px !important;" src="/images/icons/pancreatic_awareness_ribbon.jpg" height="50"/>
			Harmony Designs donates<br/>a percentage of its annual<br/>profits to cancer research
		</div>
		<div class="clear"></div>
	</td>
</tr>
<tr class="hidden">
	<td colspan=1>
		<div id="questions" class="center_align">Questions? 888.293.1109</div>
	</td>
	<td>
		<table width="575">
		<tr>
		<td>
			<div style="padding: 5px; margin: 10px 0px; background-color: #EEE; border: solid #CCC 1px;">
				<div class="">
					<b>Specialties:</b><br/>
	  				<a href="/specialties/museumstore.php?start_over=1">Museums</a> |
	  				<a href="/specialties/educator.php?start_over=1">Education</a> |
	  				<a href="/specialties/corporate.php?start_over=1">Corporate</a> |
	  				<a href="/specialties/weddingfavors.php?start_over=1">Weddings</a>
				</div>
			</div>
		</td>
		<td>
			<div style="text-align: left; " valign="top">
			<img valign="top" class="left" style="border: solid #CCC 1px !important;" src="/images/icons/pancreatic_awareness_ribbon.jpg" height="50"/>
			Harmony Designs donates<br/>a percentage of its annual<br/>profits to cancer research
			</div>
		</td>
		</tr>
		</table>
	</td>
	<td align="left" style="width: 275px;">
		<img src="/images/credit_card_logos.gif"/>
		<!--
		<a href="/custom_images?new=1">
			<img src="/images/buttons/View-your-image-on-all-products-redder-new.gif"/>
		</a>
		-->
	</td>
</tr>
</table>
</div>

<form action="/product/search.php" method="get"  id="" name="searchform" onsubmit="return preflightSearch();">
<table width="100%" cellspacing=0 border=0>
<tr id="prinav_row">
<!--
</td>
-->
<td id="prinav_bar" colspan=1 align=left>
	<? include("dropdown_primary.inc"); ?>
</td>
<td style="width: 400px;" align="right" colspan=1>
	<table cellpadding=0 cellspacing=0>
	<tr>
		<td style="width: 155px;">
          		<input type="text" id="" name="q" style="width: 150px; " value="<?= !empty($searchString) ? $searchString : "" ?>"/>
		</td>
		<td style="padding-left: 5px; width: 35px;">
			<input type="image" value="Search" src="/images/buttons/small/Search-grey.gif"/>
		</td>
	</tr>
	</table>
</td>
</tr>
<tr id="crumbs_bar">
<td colspan=2>
	<table width="100%" cellpadding=0 cellspacing=0 id="crumbs_row">
	<tr>
		<td id="crumbs_col" colspan=1>
			<?
				if (!empty($stepname)) { $step = $stepname; }
				if (empty($step)) { $step = ''; } # Show 5 steps without any highlighting...

				$steps = get_db_records("purchase_steps",null,'purchase_step_id ASC');
				$purchase_steps = array();
				foreach($steps as $stepitem)
				{
					$purchase_steps[$stepitem['name']] = $stepitem;
				}
			?>
			<div id="steps_container" align="" class="hidden">
			<? if(!empty($checkout_step)) { ?>
				<table border=0 id="steps" cellpadding=0 cellspacing=0 border=1>
				<tr>
					<td class="step1 step <?= $checkout_step == 1 ? 'selected_step' : 'previous_step' ?>" valign="top">
						<a href="/checkout/shipping_select">Address</a>
					</td>
					<td class="step2 step <?= $checkout_step == 2 ? 'selected_step' : ($checkout_step > 2 ? 'previous_step' : "") ?>" valign="top">
						<a href="/checkout/shipping_method">Shipping</a>
					</td>
					<td class="step3 step <?= $checkout_step == 3 ? 'selected_step' : ($checkout_step > 3 ? 'previous_step' : "") ?>" valign="top">
						<a href="/checkout/payment_select">Payment</a>
					</td>
					<td class="step4 step <?= $checkout_step == 4 ? 'selected_step' : "" ?>" valign="top">
						<a href="/checkout/review">Review</a>
					</td>
				</tr>
				</table>
			<? } else { ?>
				<table border=0 id="steps" cellpadding=0 cellspacing=0 border=1>
				<tr>
					<? if (!empty($stock) || (!empty($build['Product']) && $build['Product']['is_stock_item']) || (!empty($product['Product']) && $product['Product']['is_stock_item'])) { ?>
						<td id="" class="step1 step <?= $step == 'product' ? 'step1_selected_step selected_step' : 'step1_previous_step previous_step'; ?>" valign="top">
							<a href="<? !empty($build['CustomImage']) || !empty($build['GalleryImage']) ? "/products/select" : "/products" ?>"><?= $purchase_steps['product']['title'] ?></a> <span class="arrow"></span>
							<div class="step_subtext"><?= strip_tags($purchase_steps['product']['text']); ?></div>
						</td>
						<td id="" class="step2 step <?= $step == 'cart' ? 'step2_selected_step selected_step' : ''; ?>" valign="top">
							<nobr><?= $purchase_steps['cart']['title'] ?></nobr>
							<div class="step_subtext"><?= strip_tags($purchase_steps['cart']['text']); ?></div>
						</td>
			
					<? } else { ?>
			
						<? if(empty($build['image_first'])) { ?>
						<td id="" class="step1 step <?= $step == 'product' ? 'step1_selected_step selected_step' : 'step1_previous_step previous_step'; ?>" valign="top">
							<a href="<? (!empty($build['CustomImage']) || !empty($build['GalleryImage'])) ? "/products/select" : "/products" ?>"><?= $purchase_steps['product']['title'] ?></a> <span class="arrow"></span>
							<div class="step_subtext"><?= strip_tags($purchase_steps['product']['text']); ?></div>
						</td>
						<td id="" class="step2 step <?= $step == 'image' ? 'step2_selected_step selected_step' : (!empty($build['CustomImage']) || !empty($build['GalleryImage']) ? "step2_previous_step previous_step" : "") ?>" valign="top">
							<? if($step == 'image' || !empty($build['CustomImage']) || !empty($build['GalleryImage'])) { ?>
								<a href="/gallery"><?= $purchase_steps['image']['title'] ?></a> <span class="arrow"></span>
							<? } else { ?>
								<nobr><?= $purchase_steps['image']['title'] ?></nobr> <span class="arrow"></span>
							<? } ?>
							<div class="step_subtext"><?= strip_tags($purchase_steps['image']['text']); ?></div>
						</td>
						<? } else { ?>
						<td id="" class="step1 step <?= $step == 'image' ? 'step1_selected_step selected_step' : 'step1_previous_step previous_step'; ?>" valign="top">
							<? if($step == 'image' || !empty($build['CustomImage']) || !empty($build['GalleryImage'])) { ?>
								<a href="/gallery"><?= $purchase_steps['image']['title'] ?></a> <span class="arrow"></span>
							<? } else { ?>
								<nobr><?= $purchase_steps['image']['title'] ?></nobr> <span class="arrow"></span>
							<? } ?>
							<div class="step_subtext"><?= strip_tags($purchase_steps['image']['text']); ?></div>
						</td>
						<td id="" class="step2 step <?= $step == 'product' ? 'step2_selected_step selected_step' : ( (!empty($build['CustomImage']) || !empty($build['GalleryImage'])) ? "step2_previous_step previous_step" : ""); ?>" valign="top">
							<? if ($step == 'product' || !empty($product) || !empty($build['Product'])) { ?>
								<a href="/products/select"><?= $purchase_steps['product']['title'] ?></a> <span class="arrow"></span>
							<? } else { ?>
								<nobr><?= $purchase_steps['product']['title'] ?></nobr> <span class="arrow"></span>
							<? } ?>
							<div class="step_subtext"><?= strip_tags($purchase_steps['product']['text']); ?></div>
						</td>
						<? } ?>
				
						<? if (empty($build['GalleryImage']) && empty($gallery)) { ?>
						<td id="" class="step3 step <?= $step == 'layout' ? 'step3_selected_step selected_step' : (!empty($build['template']) ? "step3_previous_step previous_step" : ""); ?>" valign="top">
							<? if (!empty($build['Product']) && (!empty($build['CustomImage']) || !empty($build['GalleryImage']))) { ?>
								<a href="/build/create"><?= $purchase_steps['layout']['title'] ?></a> <span class="arrow"></span>
							<? } else { ?>
								<nobr><?= $purchase_steps['layout']['title'] ?></nobr> <span class="arrow"></span>
							<? } ?>
							<div class="step_subtext"><?= strip_tags($purchase_steps['layout']['text']); ?></div>
						</td>
				
						<td id="" class="step4 step <?= $step == 'options' ? 'step4_selected_step selected_step' : ''; ?>" valign="top">
							<? if ($step == 'options' || $step == 'cart' || !empty($build['template'])) { ?>
								<a href="/build/customize"><?= $purchase_steps['options']['title'] ?></a> <span class="arrow"></span>
							<? } else { ?>
								<nobr><?= $purchase_steps['options']['title'] ?></nobr> <span class="arrow"></span>
							<? } ?>
							<div class="step_subtext"><?= strip_tags($purchase_steps['options']['text']); ?></div>
						</td>
						<td id="" class="step5 step <?= $step == 'cart' ? 'step5_selected_step selected_step' : ''; ?>" valign="top">
							<nobr><?= $purchase_steps['cart']['title'] ?></nobr> 
							<div class="step_subtext"><?= strip_tags($purchase_steps['cart']['text']); ?></div>
						</td>
						<? } else { ?>
						<td id="" class="step3 step <?= $step == 'options' ? 'selected_step' : ''; ?>" valign="top">
							<? if ($step == 'options' || $step == 'cart') { ?>
								<a href="/build/customize"><?= $purchase_steps['options']['title'] ?></a> <span class="arrow"></span>
							<? } else { ?>
								<nobr><?= $purchase_steps['options']['title'] ?></nobr> <span class="arrow"></span>
							<? } ?>
							<div class="step_subtext"><?= strip_tags($purchase_steps['options']['text']); ?></div>
						</td>
						<td id="" class="step4 step <?= $step == 'cart' ? 'step4_selected_step selected_step' : ''; ?>" valign="top">
							<nobr><?= $purchase_steps['cart']['title'] ?></nobr>
							<div class="step_subtext"><?= strip_tags($purchase_steps['cart']['text']); ?></div>
						</td>
						<? } ?>
					<? } ?>
				</tr>
				</table>
			<? } ?>
				<div class="clear"></div>
			</div>
		</td>
		<td align="right" style="vertical-align: middle; ">
			<!--
			<a href="/custom_images"><img style="vertical-align: middle;" height="30" src="/images/icons/arrow.gif"/> Upload your art</a> OR
			<a href="/gallery/browse"><img style="vertical-align: middle;" height="30" src="/images/icons/stamp.jpg"/> Browse our stamp images</a><? if(!empty($malysoft) || !empty($hdtest)) { ?> OR
			<a href="/gallery/clipart"><img style="vertical-align: middle;" height="30" src="/images/icons/Mona-lisa-clipart.jpg"/> Browse Clipart.com&trade;</a> <? } ?>
			-->
			<div class="currently_building">
			<? if (empty($in_build) && !empty($_SESSION['Build']['Product']) && (!empty($_SESSION['Build']['CustomImage']) || !empty($_SESSION['Build']['GalleryImage']))) { ?>
			<?
				$name = "Your custom";
				$imgtype = "_";
				$imgid = "_";
				if (!empty($_SESSION['Build']['CustomImage']))
				{
					if (!empty($_SESSION['Build']['CustomImage']['Title'])) { $name = "&quot;".$_SESSION['Build']['CustomImage']['Title']."&quot;"; }
					$imgtype = "Custom";
					$imgid = $_SESSION['Build']['CustomImage']['Image_ID'];
				} else if (!empty($_SESSION['Build']['GalleryImage'])) { 
					if (!empty($_SESSION['Build']['GalleryImage']['stamp_name'])) { $name = "&quot;".$_SESSION['Build']['GalleryImage']['stamp_name']."&quot;"; }
					$imgtype = "Gallery";
					$imgid = $_SESSION['Build']['GalleryImage']['catalog_number'];
				}
			?>
			Currently building: <a href="/build/customize"><?= $name ?> <?= $_SESSION['Build']['Product']['name'] ?></a>
			<? } ?>
			</div>
		</td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td colspan="<?= empty($exclude_leftbar) ? 2 : 3 ?>" valign=top>
	<table width="100%" cellpadding=0 cellspacing=0 border=0>
	<tr>
	<td valign="top">
	<? if(isset($body_title)) { ?>
	<h1 id="title"><?= $body_title ?></h1>
	<? } ?>
	</td>
	</tr>
	<tr>
	<? if(!empty($status_bar)) { ?>
	<td valign="top">
		<?= $status_bar ?>
	</td>
	<? } ?>
	</tr>
	</table>

</form>

</td>
</tr>
</table>

</div>
