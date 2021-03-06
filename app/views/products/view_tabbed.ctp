<? if(false && !empty($malysoft)) { ?>
<script>
	function docHeight() {
		var body = document.body,
		    html = document.documentElement;

		var height = Math.max( body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );
		return height;
	}
	var incr = 5;
	Event.observe(window, 'scroll', function(e) { var scrolledDown = Math.ceil(document.documentElement.scrollTop / docHeight() * 100); if(scrolledDown > incr && (!window.scrolledDown || scrolledDown > window.scrolledDown+incr)) { window.scrolledDown = Math.floor(scrolledDown/incr)*incr; alert(window.scrolledDown); } } );
</script>
<? } ?>
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

<table border=0 id="view_related_chart" class="relative" cellspacing=0 cellpadding=5 width="100%">
<tr>
	<?= $hd->product_element("products/sample_gallery_grid",$product['Product']['prod'],array('products'=>$products,'size'=>'250','cols'=>($prod =='RL' ? 3 : 4))); ?>
	<td valign="top" rowspan=3 align="center" XXXstyle="width: 220px;">
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
		<div class="clear"></div>

	</td>
</tr>
<tr>
	<td colspan=1>
<? if(count($compare_products) > 1) { # Put the details lower, since multiple galleries. ?>
<div class="" id="" style="width: 100%; margin: 0 auto;">
		<div class="">
			<br/>
			<?= $this->element("products/details_free"); ?>
		</div>
</div>
<div class="" id="" style="margin: 0 auto;">
		<div class="">
			<br/>
			<?= $this->element("products/feature_comparison",array('no_accordian'=>1)); ?>
		</div>
</div>
<? } ?>


<div class="" id="" style="width: 100%; margin: 0 auto;">
		<? if(empty($compare_products) || count($compare_products) <= 1) { ?>
		<div class="">
			<br/>
			<?= $this->element("clients/clientlist", array('clients'=>$client_list)); ?>
		</div>
		<? } ?>
	</div>


<div style="margin: 0 auto; width: 100%;">
		<div class="" style="margin: 0 auto; width: 100%;">
				<div class="right"><a class="top" name="reviews" href="#">Top</a></div>
				<div class="product_subsection_header">Reviews</div>
				<div class="clear"></div>
				<br/>
				<? if(count($product['Testimonials'])) { ?>
					<div id="testimonials">
						<?= $this->element("products/testimonials", array('testimonials'=>$product['Testimonials'])); ?>
					</div>
				<? } ?>
		</div>
</div>
</td><tr></table>
</div>


