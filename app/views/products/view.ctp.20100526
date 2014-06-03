<?= $this->element("steps/steps", array('step'=>'product','stock'=>1)); ?>
<div class="product product_view">
<?
if(empty($products)) { $products = $compare_products; }

if(empty($product['Product']['is_stock_item']) && preg_match("/custom/", $product['Product']['image_type'])) { 
	$upload = true;
}

?>
	<script>
					function loadCustomProductImages()
					{
						<? foreach($products as $p) { $code = $p['code']; ?>
							/*
							$('gallery_<?= $prod ?>_img').src = "/product_image/view/...";
							$('gallery_<?= $prod ?>_img').removeClassName('hidden');
							$('gallery_<?= $prod ?>_samples').addClassName('hidden');
							*/

							new Ajax.Updater('custom_gallery_<?= $code ?>', "/products/ajax_image_preview/<?= $code ?>", {asynchronous:true, evalScripts: true});
						<? } ?>
						showGalleryTab('gallery_type','custom');
						$('gallery_type_tab_custom').removeClassName('hidden');

						//new Ajax.Updater('go_here', "test_ajax", {method: 'get', evalScripts: true, asynchronous:true, insertion: Insertion.Bottom});
					}
	</script>

<table border=0 id="view_related_chart" class="relative" cellspacing=0 cellpadding=5>
<tr>
	<? if($prod == 'RL') { ?>
	<td valign="top" colspan=2>
		<table width="100%">
		<tr>
		<td style="width: 425px;" valign="top" align="center">
			<?= $hd->product_element("products/sample_gallery_tabbed",$product['Product']['prod'],array('products'=>$products,'size'=>'400')); ?>
		</td>
		<td valign="top">
			<?= $hd->product_element("products/intro", $product['Product']['prod']); ?>
			<div class="" style="color: #009900;">
				<div class="right"><a style="color: #009900; font-weight: bold;" href="#clientlist">A few of our customers</a></div>
				<a style="color: #009900; font-weight: bold;" href="/info/testimonials.php">Reviews</a> <a href="/info/testimonials.php"><img src="/images/icons/5stars.png"/></a>
				<div class="clear"></div>
			</div>
		</td>
		</tr>
		</table>
	</td>
	<? } else { ?>
	<td valign="top" rowspan="4" style="width: 275px;" align="center">
		<?= $hd->product_element("products/sample_gallery_tabbed",$product['Product']['prod'],array('products'=>$products)); ?>
	</td>
	<td valign="top">
		<?= $hd->product_element("products/intro", $product['Product']['prod']); ?>
		<br/>
			<div class="clear" style="color: #009900;">
				<div class="right"><a style="color: #009900; font-weight: bold;" href="#clientlist">A few of our customers</a></div>
				<a style="color: #009900; font-weight: bold;" href="/info/testimonials.php">Reviews</a> <a href="/info/testimonials.php"><img src="/images/icons/5stars.png"/></a>
				<div class="clear"></div>
			</div>
	</td>
	<? } ?>
	<td valign="top" width="200" rowspan=2 align="center">
		<?
		$name = $product['Product']['name'];
		if(!empty($product['Product']['short_name'])) 
		{
			$name = $product['Product']['short_name'];
		}
		?>
		<div style="position: relative;">
			<div style="position: absolute; top: -50px; right: -25px;">
				<img src="/images/Try-our-preview-tool.gif"/>
			</div>
		</div>
		<?= $this->element("rbox", array('element'=>'products/cta','title'=>"See your ".strtolower($hd->pluralize($name))." now",'title_style'=>'')); ?>
		<br/>
		<b>or</b>
		<br/>
		<br/>

		<div align="left">
		<?= $this->element("rbox", array('element'=>'products/links','title'=>'')); ?>
		</div>
	</td>
</tr>
<tr>
	<td valign="top">
		<? $i = 0; foreach($products as $pr) { 
			$code = $prod = $pr['code'];
			$pid = $pr['product_type_id'];
			$p = $related_products_by_id[$pid];
		?>
		<div>
			<table width="100%">
			<tr>
			<th colspan=4 class="product_title">
				<h3><?= $p['Product']['pricing_name']; ?> <?= !empty($p['Product']['pricing_description']) ? "&mdash; ".$p['Product']['pricing_description'] : "" ?></h3>
			</th>
			</tr>
			<? if($prod == 'PR') { ?>
			<tr class="product">
				<td class="gallery_col" style="width: 275px;" valign="top">
					<div id="gallery_<?= $prod ?>">
					<?= $hd->product_element("products/sample_gallery_vertical",$p['Product']['prod'],array('products'=>array($p),'class'=>'left','size'=>'-160x160','gallery_title'=>'')); ?>
					</div>
					<?= $p['Product']['description'] ?>
					<div>
						<?
							$select_button = empty($p['Product']['is_stock_item']) ? "/images/buttons/Select.gif" : "/images/buttons/Add-to-Cart.gif";
							if (!preg_match("/custom/", $p['Product']['image_type']))
							{
								$select_button = '/images/buttons/Browse-Our-Images.gif';
							}
							#$select_url = empty($customize) ? "/gallery?prod=$prod" : "/build/customize/$prod";
							$select_url =  "/build/create/$prod";
						?>
						<? if($p['Product']['is_stock_item']) { ?>
							<form method="POST" action="/cart/add.php" onSubmit="return (verifyRequiredFields(this.id) && assertMinimum('<?= $p['Product']['minimum'] ?>'));">
								<input type="hidden" name="productCode" value="<?= $prod ?>"/>
								<table>
								<tr>
								<td class="nobr">
									<b class="bold">Quantity:</b>
									<input id="quantity" name="quantity" size="3" onchange="return assertMinimum(<?= $p['Product']['minimum'] ?>);" value="<?= $p['Product']['minimum'] ?>"/>
								</td>
								<td>
								<input type="image" src="/images/buttons/Add-to-Cart.gif" class="left"/>
								</td>
								</tr>
								</table>
							</form>
						<? } else { ?>
							<a href="<?= $select_url ?>" class="bold" onClick="track('products','get_started',{productCode: '<?= $prod ?>'});"><img src="<?= $select_button ?>"/></a>
						<br/>
						<? } ?>
					</div>
				</td>
				<td style="width: 250px;" valign="top" align="left">
				<div class="right">
					<?= $this->element("build/pricing_chart_small",array('price_list'=>$price_lists[$code],'prod'=>$prod)); ?>
					<? if(empty($p['Product']['is_stock_item'])) { ?>
					<div class='hidden'>
					Free setup &amp; design
					</div>
					<? } ?>
					<div align="left">
					</div>
				</div>
				</td>
			</tr>
			<? } else { ?>
			<tr class="product">
				<td class="hidden gallery_col" style="width: 250px;" valign="top">
					<div id="gallery_<?= $prod ?>">
					<?= $hd->product_element("products/sample_gallery_vertical",$p['Product']['prod'],array('products'=>array($p),'class'=>'left','size'=>'-160x160','gallery_title'=>'')); ?>
					</div>
				</td>
				<td style="width: 225px;" valign="top">
					<?= $p['Product']['description'] ?>
				</td>
				<td style="width: 250px;" valign="top" align="left">
				<div class="right">
					<div align="right">
						<?
							$select_button = empty($p['Product']['is_stock_item']) ? "/images/buttons/Select.gif" : "/images/buttons/Add-to-Cart.gif";
							if (!preg_match("/custom/", $p['Product']['image_type'])) 
							{
								$select_button = '/images/buttons/Browse-Our-Images.gif';
							}
							#$select_url = empty($customize) ? "/gallery?prod=$prod" : "/build/customize/$prod";
							$select_url =  "/build/create/$prod";
						?>
						<? if($p['Product']['is_stock_item']) { ?>
							<form method="POST" action="/cart/add.php" onSubmit="return (verifyRequiredFields(this.id) && assertMinimum('<?= $p['Product']['minimum'] ?>'));">
								<input type="hidden" name="productCode" value="<?= $prod ?>"/>
								<table>
								<tr>
								<td class="nobr">
									<b class="bold">Quantity:</b>
									<input id="quantity" name="quantity" size="3" onchange="return assertMinimum(<?= $p['Product']['minimum'] ?>);" value="<?= $p['Product']['minimum'] ?>"/>
								</td>
								<td>
								<input type="image" src="/images/buttons/Add-to-Cart.gif" class="left"/>
								</td>
								</tr>
								</table>
							</form>
						<? } else { ?>
							<a href="<?= $select_url ?>" class="bold" onClick="track('products','get_started',{productCode: '<?= $prod ?>'});"><img src="<?= $select_button ?>"/></a>
						<br/>
						<? } ?>
					</div>
					<?= $this->element("build/pricing_chart_small",array('price_list'=>$price_lists[$code],'prod'=>$prod)); ?>
				</div>
				</td>
			</tr>
			<? } ?>
			</table>
		</div>
		<? $i++; } ?>
	</td>
</tr>
<tr>
	<td valign="top">
		<?= $this->element("products/comparison"); ?>
	</td>
</tr>

<tr class="hidden">
	<td valign="top" colspan=2>
		<a name="reviews">&nbsp;</a>
		<br/>
		<? if(count($product['Testimonials'])) { ?>
				<div>
					<div id="testimonials">
					<div class="sidebar_header">Reviews:</div>
						<?= $this->element("products/testimonials", array('testimonials'=>$product['Testimonials'],'limit'=>1,'random'=>true)); ?>
					</div>
				</div>
		<? } ?>
	</td>
</tr>
<tr>
	<td valign="top" colspan=2>
		<a name="clientlist">&nbsp;</a>
		<br/>
		<br/>
		<?= $this->element("clients/clientlist", array('clients'=>$client_list,'vertical'=>false)); ?>
	</td>
</tr>

</table>

</div>
