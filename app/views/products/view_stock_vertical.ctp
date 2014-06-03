<?= $this->element("steps/steps", array('step'=>'product','stock'=>1)); ?>
<div class="product product_view">
<?
$all_products = array_merge(array($product), $related_products);

?>
<table border=1>
<tr>
	<td colspan=3>
		<?= $hd->product_element("products/intro", $product['Product']['prod']); ?>
	</td>
	<td>
		<? if(empty($product['Product']['is_stock_item'])) { ?>
		<a href=""><h1>Try Before You Buy</h1></a>
		<? } ?>
	</td>
</tr>
<? foreach($all_products as $pr) { 
	$p = $pr['Product'];
	$code = $p['code'];

?>
<tr>
	<td>
		<h3><?= $p['pricing_name'] ?></h3>
		<?= $hd->product_element("products/sample_gallery_left",$p['prod'],array('products'=>array($pr),'class'=>'left')); ?>
	</td>
	<td>
		<?= $p['description'] ?>
	</td>
	<td>
		<?= $this->element("build/pricing_chart_small",array('price_list'=>$price_lists[$code])); ?>
		<? if(empty($p['is_stock_item'])) { ?>
		<div>
		Free setup &amp; design
		</div>
		<? } ?>
	</td>
	<td>
			<?
				$select_button = empty($p['is_stock_item']) ? "/images/buttons/Select.gif" : "/images/buttons/Add-to-Cart.gif";
			?>
			<? if($p['is_stock_item']) { ?>
				<form method="POST" action="/cart/add.php" onSubmit="return (verifyRequiredFields(this.id) && assertMinimum('<?= $p['minimum'] ?>'));">
					<input type="hidden" name="productCode" value="<?= $prod ?>"/>
					<b class="bold">Quantity:</b>
					<input id="quantity" name="quantity" size="3" onchange="return assertMinimum(<?= $p['minimum'] ?>);" value="<?= $p['minimum'] ?>"/>
					<div>
					<input type="image" src="/images/buttons/Add-to-Cart.gif" class="left"/>
					<a href="/products/calculator/<?= $prod ?>" rel="shadowbox;width=600;height=500"><img src="/images/icons/calculator.gif"/></a>
					<div class="clear"></div>
					</div>
				</form>
			<? } else { ?>
				<a href="<?= $select_url ?>" class="bold" onClick="track('products','get_started',{productCode: '<?= $prod ?>'});"><img src="/images/buttons/Select.gif"/></a>
				<a href="/products/calculator/<?= $prod ?>" rel="shadowbox;width=600;height=500"><img src="/images/icons/calculator.gif"/></a>
			<br/>
			<? } ?>
	</td>
</tr>
<? } ?>
</table>

<hr/>

<table width="100%" cellpadding=5>
<tr>
<td valign="top" style="width: 50%;">
<?
$products = array($product);

$width = 450;
$class = "";
if (count($related_products) > 0) { 
	$products = array_merge($products, $related_products);
	$width = 200;
	$class = "left";
}
#echo "C=".count($products);
#echo $hd->product_element("products/sample_gallery_left",$product['Product']['prod'],array('products'=>$products,'width'=>$width,'class'=>$class));
?>



</td>
<td valign="top" style="width: 50%; border-left: solid #CCC 1px;">


	<div class="clear">
		<?= $hd->product_element("products/choose", $product['Product']['prod']); ?>
	</div>

		<? if(!empty($client_list)) { ?>
		<div class="clear">
			<hr/>
		<a class="hidden right" href="#top" name="clientlist">Top</a>
		<?= $this->element("clients/clientlist", array('clients'=>$client_list)); ?>
		</div>
		<? } ?>

<? if(count($product['Testimonials'])) { ?>
		<div>
			<hr/>
			<a class="hidden right" href="#top" name="comments">Top</a>
			<div id="testimonials">
			<div class="sidebar_header">Customer Comments:</div>
				<?= $this->element("products/testimonials", array('testimonials'=>$product['Testimonials'],'limit'=>1,'random'=>true)); ?>
			</div>
		</div>
<? } ?>

<div class="hidden">
	<?= $this->element("products/tabbed_details"); ?>
</div>


</div>
