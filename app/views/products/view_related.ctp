<?= $this->element("steps/steps", array('step'=>'product','stock'=>1)); ?>
<div class="product product_view">
<?
#print_r($related_products);
#$products = array($product);

#if (count($compare_products) > 0) { 
	#$products = array_merge($products, $compare_products);
#}
$products = $compare_products;

?>
W
<table border=0 id="view_related_chart" cellspacing=0 cellpadding=1>
<tr>
	<td colspan=3 valign="top">
		<?= $hd->product_element("products/intro", $product['Product']['prod']); ?>
	</td>
	<td colspan=2 rowspan="<?= $product['Product']['is_stock_item'] ? 1 : 2; ?>" align="right" valign="bottom">
		<?= $this->element("products/links"); ?>
	</td>
</tr> 
<? if(empty($product['Product']['is_stock_item'])) { ?>
<tr>
	<td colspan=3 valign="top">
			<div align="left">
				<script>
					function loadCustomProductImages()
					{
						<? foreach($products as $p) { $code = $p['code']; ?>
							/*
							$('gallery_<?= $prod ?>_img').src = "/product_image/view/...";
							$('gallery_<?= $prod ?>_img').removeClassName('hidden');
							$('gallery_<?= $prod ?>_samples').addClassName('hidden');
							*/

							new Ajax.Updater('gallery_<?= $code ?>', "/products/ajax_image_preview/<?= $code ?>", {asynchronous:true});
						<? } ?>
						//new Ajax.Updater('go_here', "test_ajax", {method: 'get', evalScripts: true, asynchronous:true, insertion: Insertion.Bottom});
					}
				</script>
				<table width="100%">
				<tr>
					<td valign="top" style="border: solid #CCC 1px; background-color: white;">
						<table>
						<tr>
							<th align="left" colspan=2>
								<label class="bold color_dark" for="file_<?= $prod ?>">Step 1. Put your image on <?= strtolower($hd->pluralize($product['Product']['name'])); ?></label>
							</th>
						</tr>
						<tr>
							<td>
								<script>
								Event.observe(window,'load', function() {
									new AjaxUpload('upload_button', {action: '/custom_images/ajax_add', name: 'data[CustomImage][file]', onSubmit: function() { showPleaseWait(); } , onComplete: function() { loadCustomProductImages(); hidePleaseWait(); } });
									});
								</script>
								<input id="upload_button" type="image" src="/images/buttons/Upload-Your-Image-grey.gif"/>
							</td>
						</tr>
						</table>
					</td>
					<td class="bold nobr" valign="middle"> - OR - </td>
					<td valign="top" style="border: solid #CCC 1px; background-color: white;">
						<table>
						<tr>
							<th align="left">
								<label class="bold nobr color_dark" for="">Put one of our images on <?= strtolower($hd->pluralize($product['Product']['name'])); ?></label>
							</th>
						</tr>
						<tr>
							<td align="right">
								<br/>
								<a href="/products/get_started/gallery"><img src="/images/buttons/small/Browse-Our-Images.gif"/></a>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>

				</form>
			</div>
	</td>
</tr>
<tr>
	<td colspan=3>
		<div class="bold color_dark">Step 2: Select a <?= strtolower($product['Product']['name']) ?> style</div>
	</td>
</tr>
<? } ?>
<? $i = 0; foreach($products as $pr) { 
	#$p = $pr['Product'];
	$code = $prod = $pr['code'];
	$pid = $pr['product_type_id'];
	$p = $related_products_by_id[$pid];
?>
<tr>
	<th colspan=4 class="product_title">
		<h3><?= $p['Product']['pricing_name']; ?></h3>
	</th>
	<? if($i == 0) { ?>
	<td rowspan="<?= count($products)*2 ?>" valign="top" align="center">
		<?= $this->element("clients/clientlist", array('clients'=>$client_list,'vertical'=>true)); ?>

	</td>
	<? } ?>
</tr>
<tr class="product">
	<td class="gallery_col" style="width: 275px;" valign="top">
		<div id="gallery_<?= $prod ?>">
		<?= $hd->product_element("products/sample_gallery_vertical",$p['Product']['prod'],array('products'=>array($p),'class'=>'left','size'=>'-175x175','gallery_title'=>'')); ?>
		</div>
	</td>
	<td style="width: 200px;" valign="top">
		<?= $p['Product']['description'] ?>
		<div>
			<?
				$select_button = empty($p['is_stock_item']) ? "/images/buttons/Select.gif" : "/images/buttons/Add-to-Cart.gif";
				#$select_url = empty($customize) ? "/gallery?prod=$prod" : "/build/customize/$prod";
				$select_url =  "/build/create/$prod";
			?>
			<? if($p['Product']['is_stock_item']) { ?>
				<form method="POST" action="/cart/add.php" onSubmit="return (verifyRequiredFields(this.id) && assertMinimum('<?= $p['Product']['minimum'] ?>'));">
					<input type="hidden" name="productCode" value="<?= $prod ?>"/>
					<b class="bold">Quantity:</b>
					<input id="quantity" name="quantity" size="3" onchange="return assertMinimum(<?= $p['Product']['minimum'] ?>);" value="<?= $p['Product']['minimum'] ?>"/>
					<div>
					<input type="image" src="/images/buttons/Add-to-Cart.gif" class="left"/>
					<div class="clear"></div>
					</div>
				</form>
			<? } else { ?>
				<a href="<?= $select_url ?>" class="bold" onClick="track('products','get_started',{productCode: '<?= $prod ?>'});"><img src="/images/buttons/Select.gif"/></a>
			<br/>
			<? } ?>
		</div>
	</td>
	<td style="width: 250px;" valign="top" align="right">
		<?= $this->element("build/pricing_chart_small",array('price_list'=>$price_lists[$code],'prod'=>$prod)); ?>
		<? if(empty($p['Product']['is_stock_item'])) { ?>
		<div class='hidden'>
		Free setup &amp; design
		</div>
		<? } ?>
	</td>
</tr>
<? $i++; } ?>
<tr>
	<td colspan=4>
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
	</td>
</tr>
</table>

</div>
