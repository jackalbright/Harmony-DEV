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

<table border=0 id="view_related_chart" class="relative" cellspacing=0 cellpadding=5 width="100%">
<tr>
	<td valign="top" rowspan=5 class="product_nav">
		<div class="first"> <a href="#sample">Sample gallery</a> </div>
		<div> <a href="#compare">Compare styles</a> </div>
		<div> <a href="#included">What's included</a> </div>
		<div> <a href="#pricing">Pricing</a> </div>
		<div> <a href="/info/testimonials.php">Reviews <img src="/images/icons/5stars.png"/></a></div>
		<div> <a href="#customers">A few of our customers</a> </div>
	</td>
	<td valign="top" style="width: 265px;" rowspan="2">
		<?
			$pid = $products[0]['product_type_id'];
			$firstproduct = $related_products_by_id[$pid];
			$img = $firstproduct['ProductSampleImages'][0];
			$firstprod = $firstproduct['Product']['prod'];
		?>
		<img src="/images/galleries/cached/products/<?= $firstprod ?>/<?= $img['product_image_id'] ?>/250.<?= $img['file_ext'] ?>"/>
	</td>
	<td valign="top">
		<?= $hd->product_element("products/intro", $product['Product']['prod'],array('no_more'=>1)); ?>
	</td>


	<td valign="top" width="210" rowspan=3 align="center">
		<?
		$name = $product['Product']['name'];
		if(!empty($product['Product']['short_name'])) 
		{
			$name = $product['Product']['short_name'];
		}
		?>
		<?
			$cta_title = (empty($product['Product']['is_stock_item']) ? "See your " : "Order your ") . strtolower($hd->pluralize($name))." now" ;
		?>
		<?= $this->element("products/cta_new"); ?>
		<br/>

	</td>
</tr>
<tr>
	<td valign="top">
	<?= $hd->product_element("products/sample_gallery_grid",$product['Product']['prod'],array('products'=>$products,'size'=>'250')); ?>
	</td>
</tr>
<tr>
	<td valign="top" colspan=2>
		<a name="compare"><h4>Compare Styles</h4></a>
		<?= $this->element("products/tabbed_details"); ?>
	</td>
</tr>
<tr>
	<td valign="top" colspan=2>
		<?= $this->element("clients/clientlist", array('clients'=>$client_list)); ?>
	</td>
</tr>

<tr class="hidden">
	<td valign="top" colspan=3>
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
	</td>
</tr>

</table>

</div>
