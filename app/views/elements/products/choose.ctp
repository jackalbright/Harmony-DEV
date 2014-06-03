<div id="product_choose" class="" style="width: 275px;">
<? 
$prod = $product['Product']['code'];

?>
<? if (!empty($compare_products) && count($compare_products) > 1) { $ps = $compare_products; 

$w = intval(100 / count($ps));

?>
	<table width="100%" border=0 cellpadding=1 cellspacing=3>
	<? if(count($ps) > 1) { ?>
	<tr class="">
		<? foreach($ps as $p) { ?>
		<th class="header" align=center valign="top" width="<?=$w?>%">
			<?= $p['pricing_name'] ?>
		</th>
		<? } ?>
	</tr>
	<? } ?>
	<tr>
		<? foreach($ps as $p) { ?>
		<td align=left valign="top" width="<?=$w?>%">
			<?= $p['description'] ?>
		</td>
		<? } ?>
	</tr>
	<tr>
		<? foreach($ps as $p) { 
			$prod = $p['code']; 
			$select_url = empty($customize) ? "/gallery?prod=$prod" : "/build/customize/$prod";
			if(empty($p['minimum'])) { $p['minimum'] = 1; } #Default.
		?>
		<td align=center valign="top" width="<?=$w?>%">
			<?
				$select_button = empty($p['is_stock_item']) ? "/images/buttons/Select.gif" : "/images/buttons/Add-to-Cart.gif";
			?>
			<? if($p['is_stock_item']) { ?>
				<form method="POST" action="/cart/add.php" onSubmit="return (verifyRequiredFields(this.id) && assertMinimum('<?= $p['minimum'] ?>'));">
					<input type="hidden" name="productCode" value="<?= $prod ?>"/>
					<table>
					<tr>
						<td>
							<b class="bold">Quantity:</b>
							<input id="quantity" name="quantity" size="3" onchange="return assertMinimum(<?= $p['minimum'] ?>);" value="<?= $p['minimum'] ?>"/>
						</td>
						<td>
							<input type="image" src="/images/buttons/Add-to-Cart.gif" class="left"/>
						</td>
					</tr>
					</table>
				</form>
			<? } else { ?>
				<a href="<?= $select_url ?>" class="bold" onClick="track('products','get_started',{productCode: '<?= $prod ?>'});"><img src="/images/buttons/Select.gif"/></a>
			<br/>
			<? } ?>

		</td>
		<? } ?>
	</tr>
	<tr>
		<? foreach($ps as $p) { 
			$code = $p['code'];
			$price_list = !empty($price_lists[$code]) ? $price_lists[$code] : null;
		?>
		<td align=center valign="top" width="<?=$w?>%">
			<?= $this->element("build/pricing_chart_small",array('price_list'=>$price_list)); ?>
			<? if(empty($p['is_stock_item'])) { ?>
			<div>
			Free setup &amp; design
			</div>
			<? } ?>
		</td>
		<? } ?>
	</tr>

	</table>

<? } else if (false) { ?>
	<table width="100%" style="padding-top: 20px;">
	<tr>
				<td width="50%" valign="middle" align="center">
					<a href="/gallery?prod=<?= $prod ?>" class="bold" onClick="track('products','get_started',{productCode: '<?= $product['Product']['code'] ?>'});"><img src="/images/webButtons2014/blue/large/getStarted.png"/></a><br/>
					<!--<a href="/products/template?prod=<?= $prod ?>" class="bold"><img src="/images/buttons/Get-Started-teal.gif"/></a><br/>-->
				</td>
				<td width="50%" valign="middle" style="line-height: 1.3em;">
					<?= $this->element("products/links"); ?>
				</td>
	</tr>
	</table>

<? } else { 

	$p = $product['Product']; 
	$w = 50; 
	$code = $p['code'];
	$price_list = !empty($price_lists[$code]) ? $price_lists[$code] : null;
?>
	<table width="100%" border=0 cellpadding=1 cellspacing=3>
	<tr>
		<? if(empty($no_features)) { ?>
		<td align=left valign="top" width="<?=$w?>%">
			<?= $p['description'] ?>
		</td>
		<? } ?>
		<? if(empty($no_chart)) { ?>
		<td align=center valign="top">
			<div>
			<?
				$select_button = empty($p['is_stock_item']) ? "/images/buttons/Select.gif" : "/images/buttons/Add-to-Cart.gif";
				$select_url = empty($customize) ? "/gallery?prod=$prod" : "/build/customize/$prod";
			?>
			<? if($p['is_stock_item']) { ?>
			<div>
				<h3 class="grey_header" style=""><span style="color: #B82A2A;">
					Order <?= Inflector::pluralize($product['Product']['short_name']) ?>
				</span></h3>
				<div class="clear"></div>
				<div class="whitebg grey_border">
				<?= $this->element("products/stock_calc_container",array('p'=>$p)); ?>
				</div>
				<br/>
			</div>
			<? } else { ?>
				<a href="<?= $select_url ?>" class="bold" onClick="track('products','get_started',{productCode: '<?= $prod ?>'});"><img src="/images/webButtons2014/blue/large/getStarted.png"/></a>
			<br/>
			<? } ?>
			</div>
			<?= $this->element("build/pricing_chart_small",array('price_list'=>$price_list)); ?>
			<? if(empty($p['is_stock_item'])) { ?>
			<div>
			Free setup &amp; design
			</div>
			<? } ?>

		</td>
		<? } ?>
	</tr>
	</table>
<? } ?>
</div>
					<script>


						//document.observe('dom:loaded', function() { calculateStockSubtotal('<?= $p['code'] ?>'); });
					</script>
	<? if(false && ($malysoft || $hdtest)) { ?>
	<div>
		<?= $form->create('CustomImage',array('type'=>'file')); ?>
			<input type="hidden" name="prod" value="<?= $prod ?>"/>
			<? echo $form->input('file',array('type'=>'file','label'=>"Step 1: Select image to upload",'class'=>'required')); ?>
			<input type="image" src="/images/buttons/Preview-Product.gif"/>
		</form>
		(browse stamps | ...)
	</div>
	<? } ?>
