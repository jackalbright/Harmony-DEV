<div id="cta_col" class="rounded_wrapper" style="">
<? if(empty($product['Product']['is_stock_item'])) { ?>

	<? 
	if(!isset($calc)) { ?>
        <h3 class="grey_header" style="">
            <span>Calculate Pricing</span>
        </h3>
        <div id='mini_calc' class="whitebg grey_border" style="padding: 2px;">
            <?= $this->requestAction("/products/mini_calc/".$product['Product']['code'], array('return')); ?>
        </div>
        <br/>
	<? } ?>

	<? if(preg_match("/custom/", $product['Product']['image_type'])) { #true || !isset($get_started) || !empty($get_started)) { ?>
    <div class='widget'>
	<?= $this->element("products/cta_order"); ?>
	</div>	<!--widget-->		
	<? } ?>


	<?php
	if(!isset($learn_more)){
		//echo "<div class='widget'>";
		echo $this->element("products/cta_learnmore");
		//echo "</div>";
	}
	 
	 
	 ?>
	<?= !isset($rush) ? $this->element("products/cta_rush") : ""; ?>
	<? if(!isset($clients) && !empty($compare_products) && count($compare_products) > 1) { ?>
		<?= $this->element("clients/clientlist", array('vertical'=>true,'clients'=>$client_list)); ?>
	<? } ?>

<? } else { ?>
<div>
	<h3 class="grey_header" style=""><span>
		Order <?= Inflector::pluralize($product['Product']['short_name']) ?>
	</span></h3>
	<div class="clear"></div>
	<div class="whitebg grey_border">
	<?= $this->element("products/stock_calc_container",array('p'=>$product['Product'])); ?>
	</div>
</div>
<br/>
<? if(empty($compare_products) || count($compare_products) <= 1) { ?>
	<?= $this->element("build/pricing_chart_small",array('price_list'=>$price_lists[$product['Product']['code']])); ?>
<? } ?>
<? } ?>

</div>

<div class="clear"></div>
<style>
#cta_col h3 span
{
	color: #B82A2A;
}
</style>
