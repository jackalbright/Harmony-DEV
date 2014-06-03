<? $this->set("enable_tracking", "product"); ?>
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
	<td valign="top" style="width: 400px;" align="center">
			<?= $hd->product_element("products/sample_gallery_tabbed",$product['Product']['prod'],array('products'=>$products,'size'=>'325')); ?>
	</td>
	<? } else { ?>
	<td valign="top" rowspan="4" style="width: 325px;" align="center">
		<?= $hd->product_element("products/sample_gallery_tabbed",$product['Product']['prod'],array('products'=>$products,'size'=>'300')); ?>
	</td>
	<? } ?>

	<td valign="top">
		<div class="">
		<?= $hd->product_element("products/intro", $product['Product']['prod']); ?>

		<div style="float: right;"><a style="color: #009900; font-weight: bold;" href="/info/testimonials.php">Reviews</a> <a href="/info/testimonials.php"><img src="/images/icons/5stars.png"/></a></div>
		<div class="clear"></div>

		<?= $this->element("products/compare"); ?>

		<br/>

		<?= $this->element("products/feature_comparison"); ?>
		<?= $this->element("products/pricing_comparison", array('no_title'=>true,'no_accordian'=>true)); ?>
		</div>
	</td>

	<td valign="top" width="225" rowspan=3 align="center">
		<?= $this->element("products/cta_new"); ?>
		<br/>

		<? if(empty($compare_products) || count($compare_products) <= 1) { ?>
		<?= $this->element("clients/clientlist", array('clients'=>$client_list,'vertical'=>true)); ?>
		<? } ?>
	</td>
</tr>
<tr>
	<? if($prod == 'RL') { ?>
	<td>&nbsp;</td>
	<? } ?>

	<td valign="top">
	</td>
</tr>
<tr>
	<? if($prod == 'RL') { ?>
	<td>&nbsp;</td>
	<? } ?>

	<td valign="top">

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
						<?= $this->element("products/testimonials", array('testimonials'=>$product['Testimonials'],'random'=>true)); ?>
					</div>
				</div>
		<? } ?>
	</td>
</tr>

</table>

</div>
