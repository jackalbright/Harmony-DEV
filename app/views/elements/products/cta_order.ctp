<? $things = ucwords(Inflector::pluralize($product['Product']['short_name'])); ?>
<? if(empty($product['Product']['is_stock_item']) && preg_match("/custom/", $product['Product']['image_type'])) { ?>
	<?php $thisLabel = empty($product['Product']['is_stock_item']) ? "Step-by-Step Ordering" : "Order Now" ?>
    <h3><?php echo $thisLabel?></h3>

	<div class="standard_sidebar_container">
	<? if(false && !preg_match("/custom/", $product['Product']['image_type'])) { ?>
			<!--<div class="bold" align="center">--> 
				<a href="/gallery/browse?prod=<?= $product['Product']['code']?>">
					<img style="padding-top: 5px;" src="/images/webButtons2014/orange/large/browseStamps.png"/>
				</a>
			<!--</div>--> 
	<? } else { ?>
	
		<div align="center" style="padding: 5px;">
		<div align='left'>
			<ul class="standard_sidebar_list">
			<li>Three easy steps to see your <?= strtolower($things) ?>
			<li>Free preview &amp; proof option
			<li>Order in 10 minutes or less
			</ul>
		</div>

			<!--
			<div align="center" class="" style="font-size: 12px;">Build your project online<br/>or send your completed art</div>
			-->
			<div style="margin: 10px auto; width: 70%;">
				<a id='order_online' href="/products/design/<?= $product['Product']['code'] ?>">Design &amp; Order Online</a>
			</div>

			<div style="margin: 5 auto; width: 70%;">
			<a id='instant_pricing' href='/products/calculator/<?= $product['Product']['code'] ?>' class='modal' title='Get Pricing and Production Time - <?= Inflector::pluralize($product['Product']['short_name']); ?>'>
				Get Instant Pricing<br/>&amp; Production Time</a>
			</div>

			<div style="margin: 0 auto; width: 70%;">
				<div id='phone_orders'>
				Questions?
				888.293.1109
				</div>
			</div>
		</div>
		<style>
			#instant_pricing
			{
				display: block;
				padding-left: 35px;
				background: url("/images/icons/small/calculator.png");
				background-position: center left;
				background-repeat: no-repeat;
			}

			#order_online
			{
				display: block;
				padding-left: 35px;
				background: url("/images/icons/small/mouse.png");
				background-position: center left;
				background-repeat: no-repeat;
			}

			#phone_orders
			{
				margin-top: 10px;
				display: block;
				padding-left: 35px;
				background: url("/images/icons/small/phone-grey.png");
				background-position: center left;
				background-repeat: no-repeat;
			}
		</style>
	
	<? } ?>
	</div>
<? } ?>
