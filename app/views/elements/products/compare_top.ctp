<?
#$leftpadding = 750 - count($compare_products) * 175; # For pic.
$imgw = intval(700 / count($compare_products));# <= 2 ? 325 : 175;

$padding = 750/count($compare_products) - $imgw;#$imgw;#(count($compare_products) <= 2 ? 250 : 175); # For pic.
$pl = $padding/2;
$pr = $padding/2;

# XXX separate padding left and padding right - may not match....
?>

<div align="center">
<table class="compareTable" border=0 align="left">
<tr>
<? $pid = $product['Product']['product_type_id']; $i = 0; foreach($compare_products as $cp) { $ccode = $cp['code']; $cpid = $cp['product_type_id']; 
	#print_r($related_products_by_id[$cpid]['ProductSampleImages'][0]);

	# If no special picture in directory, just grab first from gallery... should be 175px wide, 350px tall
	$thumbpath = "/images/products/compare/small/$ccode.png";
	$largepath = "/images/products/compare/$ccode.png";

	if(!file_exists(APP."/../$thumbpath"))
	{
		if( !empty($related_products_by_id[$cpid]['ProductSampleImages'][0]) )
		{
			$pimg = $related_products_by_id[$cpid]['ProductSampleImages'][0] ;
			$cprod = $related_products_by_id[$cpid]['Product']['prod'];

		} else {
			$pimg = $related_products_by_id[$pid]['ProductSampleImages'][0] ;
			$cprod = $related_products_by_id[$pid]['Product']['prod'];

		}
		
		$imgid = $pimg['product_image_id'];
		$imgext = $pimg['file_ext'];
		$size = "-{$imgw}x350";

		$thumbpath = "/images/galleries/cached/products/$cprod/$imgid/$size.$imgext";
		$largepath = "/images/galleries/products/$cprod/$imgid.$imgext";
	}
?>
<td colspan=2 width="<?= 100 / count($compare_products); ?>%" XXXstyle="padding-left: <?=$pl ?>px;" align="left">
	<a href="<?= $largepath ?>" rel="shadowbox">
		<img src="<?= $thumbpath ?>" style="border: solid #CCC 1px;"/>
	</a>
</td>
<? } ?>
</tr>
<!-- add to cart-->


<? if(!empty($product['Product']['is_stock_item'])) { ?>
<tr>
<? foreach($compare_products as $cp) { $cpid = $cp['product_type_id'];  ?>
<td colspan=2>
	<?#= $this->element("products/stock_calc_container",array('p'=>$cp,'prod'=>$cp['code'])); ?>
	<form action="/cart/add.php">
	<div id="stock_calc_<?= $cp['code'] ?>">
		<?= $this->requestAction("/products/stock_calc/".$cp['code'], array('return')); ?>
	</div>
	</form>
	<style>
	#stock_calc_<?= $cp['code'] ?> .atc
	{
		text-align: right;
	}
	</style>
</td>
<? } ?>
</tr>
<? } ?>


<!-- end add to cart-->
<tr>
<? foreach($compare_products as $cp) { $cpid = $cp['product_type_id']; 
?>
<? if($i++ < count($compare_products)) { ?>
<td rowspan=2 class="spacer"></td>
<? } ?>
<td XXXstyle="padding-left: <?=$pl ?>px;" valign="top" align="left">
<div align="left" style="margin: 0 auto; ">
	<h3 style="font-weight: bold;"><?= !empty($cp['pricing_name']) ? $cp['pricing_name'] : $cp['name'] ?></h3>
</div>
</td>
<? } ?>
</tr>
<tr>
<? foreach($compare_products as $cp) { $cpid = $cp['product_type_id']; 
	$ccode = $cp['code'];
	$prices = $compare_pricings[$ccode][0]['pricing_data'];
	$highPrice = $prices[0]['price'];
	$lowPrice = $prices[count($prices)-1]['price'];
?>
<td valign="top" align="left">
	<div class="bold" style="">
		<b>Minimum:</b>
		<?= $cp['minimum'] ?>
	</div>

	<div class="bold" style="">
		<div class="bold left">From:&nbsp;</div>
		<div class="left">
		<a href="javascript:void(0)" onClick="j('#pricing_tab').click(); j(window).scrollTo('#tabs', 100, { offset: {top: -75}});" style="text-decoration: underline;">
			<?= sprintf("$%.02f - $%.02f ea.", $lowPrice, $highPrice); ?>
		</a>
		<br/>
		<!--
		<a href="javascript:void(0)" onClick="j('#pricing_tab').click(); j(window).scrollTo('#tabs', 100, { offset: {top: -75}});">
			Bulk Pricing
		</a>
		-->
		</div>
		<div class="clear"></div>
	</div>
	<? if(true || !empty($features[$cpid])) { 
	?>
	<br/>
	<ul style="margin-left: 0px;">
		<? foreach($product_options as $opt) { 
			$feature = Set::extract("/ProductFeature[product_type_id=$cpid]", $opt);
			if(empty($feature)) { continue; }
			#print_r($feature);
			$name = $opt['ProductOption']['option_name'];
			$link = strip_tags($opt['ProductOption']['option_description']);
			#null;
			#if(preg_match("/^\//", $desc)) { 
			#	$link = $desc;
			#	$desc = null;

			#}
			$text = !empty($feature[count($feature)-1]['ProductFeature']['text']) ? $feature[count($feature)-1]['ProductFeature']['text'] : null;
			if(empty($text))
			{ # fail, diagnose.
				#print_r($feature);
			}
		?>
		<li>
			<? if(!empty($name)) { ?>
				<?
					$shadowbox = preg_match('/images/', $link) ? 'shadowbox' : 'shadowbox;width=500;height=400';

				?>
				<? if(!empty($text)) { ?><b><? } ?><?= !empty($link) ? $this->Html->link($name, $link, array('rel'=>$shadowbox)) : $name ?><? if(!empty($text)) { ?></b><? } ?><? } ?><? if(!empty($name) && !empty($text)) { ?><? if(!preg_match("/:\s*$/", $name)) { ?>: <? } ?> 
			<? } ?>
			<?= !empty($text) ? $text : null ?>
		<? } ?>
	</ul>
	<? } ?>
	<br/>

</div>
</td>
<? } ?>
</tr>

<?php 
//if(!empty($product['Product']['is_stock_item'])) { // comment out this section so we can move the button up below the picture
if(false){
?>
<tr>
<? foreach($compare_products as $cp) { $cpid = $cp['product_type_id'];  ?>
<td colspan=2>
	<?#= $this->element("products/stock_calc_container",array('p'=>$cp,'prod'=>$cp['code'])); ?>
	<form action="/cart/add.php">
	<div id="stock_calc_<?= $cp['code'] ?>">
		<?= $this->requestAction("/products/stock_calc/".$cp['code'], array('return')); ?>
	</div>
	</form>
	<style>
	#stock_calc_<?= $cp['code'] ?> .atc
	{
		text-align: right;
	}
	</style>
</td>
<? } ?>
</tr>
<? } ?>


</table>
</div>
<style>
table.compareTable .spacer
{
	width: <?= $padding/count($compare_products) ?>px;
	
}
</style>
