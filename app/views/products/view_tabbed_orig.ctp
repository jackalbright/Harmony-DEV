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
	<td valign="top" style="width: 375px;" align="center">
			<?= $hd->product_element("products/sample_gallery_tabbed",$product['Product']['prod'],array('products'=>$products,'size'=>'350')); ?>
	</td>
	<? } else { ?>
	<td valign="top" rowspan="4" style="width: 300px;" align="center">
		<?= $hd->product_element("products/sample_gallery_tabbed",$product['Product']['prod'],array('products'=>$products,'size'=>'275')); ?>
	</td>
	<? } ?>

	<td valign="top">
		<div class="">
		<?= $hd->product_element("products/intro", $product['Product']['prod'],array('no_more'=>1)); ?>
		<br/>


		<?= $this->element("products/tabbed_details_orig"); ?>

	</td>

	<td valign="top" width="225" rowspan=3 align="center">
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

		<?= $this->element("clients/clientlist", array('clients'=>$client_list,'vertical'=>true,'twocol'=>false)); ?>
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
