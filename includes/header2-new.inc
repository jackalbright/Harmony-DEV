<?
$wholesale_site = preg_match("/(www[.])?(wholesale)[.]/", $_SERVER['HTTP_HOST']);

include_once("database.inc");
?>
<div style="position: relative;" class="<?= $wholesale_site ? "wholesale" : "retail" ?>">

<table id="" border=0 cellspacing=1 cellpadding=0 width="100%" style="position: relative; z-index: 900;">
<tr>
	<td style="width: 140px;" rowspan=1 valign="bottom" align="left">
		<div class="bold" align="center">
		<a name="top" href="/index.php"><img class="logo" src="/images/HD-CHECKER-LOGO-sq.png" alt="harmony designs logo" border="0" /></a><br/>
		<? if(!empty($wholesale_site)) { ?>
		<div class='bold' style='color: #CC6633;'>WHOLESALE</div>
		<? }
		//else{
			?>
			<!--<div class='bold' style='color: #CC6633;'>&nbsp;</div>-->
            <?php
		//}
		 ?>
		</div>
	</td>
	<td valign="bottom" align="left" style="padding-left: 10px; width: 315px;">
		<table style="font-size: 13px;" border=0>
		<tr>
			<td valign="bottom" align="left" style="width; 250px;">
				<div style="font-size: 14px; font-weight: bold;" class="">
				Creating custom gifts since 1992
				<div class="" style="font-size: 13px; font-weight: normal; margin-top: 5px;">
				Museum-store quality &bull; Low minimums<br/>
				Free setup &amp; color printing &bull; Fast service
				</div>
				</div>
			</td>
			<td valign="bottom" style="width: 60px;">
				<div class="" style="padding-left: 10px;"> <a href="/products/madeinusa"><img src="/images/icons/small/made-in-usa.png"/></a> </div>
			</td>
		</tr>
		</table>
	</td>
	<td valign="bottom">
		<div class="" style="display: none;">
			<? if(!empty($malysoft) || !empty($hdtest)) { ?>
			<h3 style="padding: 5px; background-color: #CCC;"><a href="/wholesale">Wholesalers</a></h3>
			<? } ?>

			<!--
			<div style="font-weight: bold; background-color: #CCC; padding: 5px;">Resellers/Wholesalers</div>
			<ul>
				<li><a href="/content_snippets/view/wholesale2">Learn more</a>
				<li><a href="/account/signup/wholesale">Sign up</a> for an account
				<li><a href="/account/login">Log in</a> to your account
			</ul>
			-->
		</div>
	</td>
	<td align="right" rowspan=1 valign="top">
			<div>
			<? 
			//if(!empty($wholesale_site)) { 
			if(false) { 
			?>
				<a href="//harmonydesigns.com/">
                <img src="/images/webButtons2014/other/small/retailSite.png" align="absmiddle" alt="Go to Retail site"/></a>
                </a>
			<?php } ?>
			
			</div>
			<div style="padding-bottom: 15px; font-weight: bold; font-size: 14px; float: right;">
				<? if(empty($wholesale_site)) { ?>
					<a href="http://wholesale.harmonydesigns.com<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>" title="Go to Wholesale Site">
						<img src="/images/webButtons2014/other/small/wholesaleResellers.png" align="absmiddle" alt="Wholesale site"/></a>
						
				<? }else{?>
                <a href="//harmonydesigns.com/">
                <img src="/images/webButtons2014/other/small/retailSite.png" align="absmiddle" alt="Go to Retail site"/></a>
                </a>
                <?php
				}?>
                &nbsp;&nbsp;
				<img align='absmiddle' src='/images/icons/small/phone-grey.png'/>
				888.293.1109
			</div>

		<? if(!empty($advertisedCoupon)) { ?>
		<div class='relative right' style='padding-right: 10px;'>
			<a href="javascript:void(0)" onClick="j('#couponDetails').toggle();" style="color: #0369A7; font-weight: bold; font-size: 16px;">
				<? if(!empty($advertisedCoupon['Coupon']['filename'])) { ?>
					<img src="/<?= $advertisedCoupon['Coupon']['path'] ?>/<?= $advertisedCoupon['Coupon']['filename'] ?>" height=35/>
				<? } else { ?>
					<?= $advertisedCoupon['Coupon']['title'] ?>
				<? } ?>
			</a>
			<div id='couponDetails' align='center'>
				<div align='right'>
					<a href='javascript:void(0)' class='bold close' style='font-size: 16px;'>[X]</a>
				</div>
				<h3 class='bold'>
					<?= $advertisedCoupon['Coupon']['title'] ?>
				</h3>

				<?= $advertisedCoupon['Coupon']['description'] ?>

				<hr/>
				Use Promo Code <b><?= $advertisedCoupon['Coupon']['code'] ?></b> at checkout or with phone orders<br/>
				Ends <?= date("F j, Y", strtotime($advertisedCoupon['Coupon']['end'])); ?>
				<br/>
				<br/>
				<a href="javascript:void(0)" onClick="j('#promo_details').toggle();" title="Terms and Conditions" class=''>Details</a>


				<div id='promo_details' style="display: none; text-align: left;">
					<hr/>
					<h3>Terms and Conditions</h3>
					<p>
					<?= $this->element("../products/promo_details"); ?>
				</div>

				<!--<a href="/products/promo_details" title="Terms and Conditions" class='modal'>Details</a>-->
				<!--
				<a href='javascript:void(0)' onClick="var details = window.open('/products/promo_details', 'Promotion_Details', 'location=no,toolbar=no,width=400,height=175,status=yes,resize=yes,scrollbars=yes,menubar=no'); details.focus(); return false;">Details</a>
				-->
			</div>
			<style>
			#couponDetails
			{
				display: none; 
				padding: 10px;
				position: absolute; 
				top: 0; 
				left: 0; 
				width: 300px; 
				background-color: #DDD; 
				border: solid #AAA 1px; 
				z-index: 1000;
			}
			</style>
			<script>
			j('#couponDetails a.close').click(function() { j('#couponDetails').hide(); });
			</script>
		</div>
		<? } ?>
		<div class='clear'></div>
			<div style="">
				<img src="/images/icons/paypal-cc-wide.png" style=""/>
				<img src="/images/icons/small/amazon-payments.gif"/>
			</div>

			<div style="font-size: 10px;">
				<? include(dirname(__FILE__)."/../app/views/elements/shipfree.ctp"); ?>
			</div>

			<?  $this_customer = !empty($_SESSION['Auth']['Customer']) ? $_SESSION['Auth']['Customer'] : null;
				if(!empty($this_customer['guest'])) { $this_customer = null; } ?>
			<div id="account_links" align="right" class="bold">
				<!-- <a href="/account?login=1"><img align="center" src="/images/buttons/small/Log-In.gif"/></a> -->
				<?
					$goto = preg_replace("/\?(.*)$/", "", $_SERVER['REQUEST_URI']);
				?>
				<? if(!empty($this_customer)) { ?>
					<? if(!empty($this_customer['First_Name'])) { ?>
						<i>Hello <?= $this_customer['First_Name'] ?></i> |
					<? } else { ?>
						<i><?= $this_customer['eMail_Address'] ? $this_customer['eMail_Address'] : null; ?></i> |
					<? } ?>
				<? } ?>
				<a href="/account">My Account</a> | 
				<a href="/custom_images/index/reset">My Pictures</a> |
				<? include("header/designs.php"); ?>

				<? if (empty($this_customer)) { ?>
					<a href="/account/login?goto=<?= urlencode($goto) ?>">Log In/Sign Up</a>
				<? } else { ?>
					<a href="/account/logout">Log out</a>
				<? } ?>



			</div>
			<div class="clear"></div>

	</td>
</tr>
</table>


<table id="" border=0 cellspacing=1 cellpadding=0 width="100%" style="position: relative; z-index: 800;">
<tr>
	<td colspan=4 valign="bottom">
	<div id="prinav_row"><span>
		<table class="" width="100%" id="" cellpadding=0 cellspacing=0> <tr>
		<td width="890"> 
			<div class="left" style="z-index: 801;">
			<?  include("dropdown_primary.inc"); ?> 
			</div>
			<div class="left" style="padding-left: 15px;">
			<? include("header/search.php"); ?> 
			</div>
			<div class="clear"></div>
		</td>
		<td align="right">
		  	<?php
				$subTotal = 0;
				$subQuantity = 0;
	
				$session_id = session_id();
				$customer_id = !empty($_SESSION['Auth']['Customer']['customer_id']) ? $_SESSION['Auth']['Customer']['customer_id'] : null;
	
				#$cartItems = get_db_records("cart_items", " customer_id = '$customer_id' OR session_id = '$session_id' ");
				$cartItems = get_db_records("cart_items", " session_id = '$session_id' ");

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
			?>
		 	<div class="relative right" style="padding-right: 10px; padding-bottom: 2px;">
				<? if($subQuantity > 0) { ?>
				<a href="/cart/display.php" class="block nounderline" style="position: absolute; bottom: 6px; left: 45px; color: black; XXXcolor: #58589C; font-weight: bold; font-size: 12px; width: 35px; text-align: center;">(<?= $subQuantity ?>)</a>
				<? } ?>
				<a href="/cart/display.php">
					<? if($subQuantity > 0) { ?>
					<img src="/images/buttons/Cart.gif"/>
					<? } else { ?>
					<img src="/images/buttons/Cart-empty.gif"/>
					<? } ?>
				</a>
			</div>
		</td>
		</tr></table>
	</span></div>
	</td>
</tr>
</table>

<? if(empty($checkout_step)) { ?>
<div style="float: right;" align="right" id="currently_building">
		<? if(!empty($build_context)) { ?>
			<?= $build_context ?>
		<? } else { ?>
			<? include("header/building.php"); ?>
		<? } ?>
</div>
<? } ?>


<? $current_step_num = null; ?>
<? if(empty($steps_disabled) && ( 
	(!empty($checkout_step) || !empty($stepname)) 
	# || (!empty($_SESSION['Build']['Product']) && (!empty($_SESSION['Build']['CustomImage']) || !empty($_SESSION['Build']['GalleryImage'])))
	)) { ?>
<div id="crumbs_bar" style="height: 30px;">
	<div id="crumbs_col" align="left" valign="top">
					<? if(!empty($checkout_step)) { ?>
					<? include("header/checkout.php"); ?>
						<div class="clear"></div>
					<? } else if (!empty($stepname)) { ?>
						<? include("header/buildsteps.php"); ?>
						<div class="clear"></div>
					<? } ?>
	</div>
</div>
<? } ?>

<div id="main_title" style="overflow: hidden;">
	<? if(!empty($status_bar)) { ?>
	<div class="right">
		<?= $status_bar ?>
	</div>
	<? } ?>
	<? if(isset($body_title)) { ?>
	<h1 id="title" class="left"><?= $body_title ?></h1>
	<? } ?>
</div>


</div>
<div class="clear"></div>
