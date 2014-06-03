<?  if(empty($products)) { $products = $compare_products; } ?>
	<div style="" >
		<a name="tabs"></a>
        <div id="tabSet">
		<ul id="tabs" >
        <?php 
		// set the default display conditions. For some product types we want the default tab that is displayed when the page loads to be
		// different. The scrollTo variable is used in the document ready function below to display the correct default tab.
		
		if(empty($product['Product']['is_stock_item']) && preg_match("/custom/", $product['Product']['image_type'])) { 
			$galleryClass = 'selected';
			$compareClass = '';
			$scrollTo = '#gallery';
		}else{
			$galleryClass = '';
			$compareClass = 'selected';
			$scrollTo = '#compare';
		}
		
		?>
        
			<? //if(empty($product['Product']['is_stock_item'])) { ?>
			<li class="tab <?php echo $galleryClass?>"><a id="gallery_tab" href="#gallery" >Gallery</a></li>
			<? //} ?>
			<? if(count($compare_products) >= 2) { ?>
				<li class="tab <?php echo $compareClass?>"><a id="compare_tab" href="#compare">Compare Styles</a></li>
			<? } else { ?>
				<li class="tab "><a id="overview_tab" href="#overview">Overview</a></li>
			<? } ?>
			<? if(!empty($product['Product']['is_stock_item'])) { ?>
			<!--<li class="tab"><a id="gallery_tab" href="#gallery">Gallery</a></li>-->
			<? } ?>
			<? if(trim(strip_tags($product["Product"]['description'])) || !empty($product['ProductDescription'])) { ?>
			<li class="tab"><a id="details_tab" href="#details">Details</a></li>
			<? } ?>
			
			<li class="tab"><a id="reviews_tab" href="#reviews">Reviews</a></li>
			<!--
			<li class="tab"><a id="templates_tab" href="javascript:void(0)">Template &amp Specs</a></li>
			<li class="tab"><a id="sample_tab" href="javascript:void(0)">Free Samples</a></li>
			<li class="tab"><a id="wholesale_tab" href="javascript:void(0)">Wholesale</a></li>
			-->

			<? if(empty($product['Product']['is_stock_item']) && preg_match("/custom/", $product['Product']['image_type'])) { ?>
			<li class="tab"><a id="order_tab" href="#order">How To Order</a></li>
			<? } ?>
            <li class="tab"><a id="pricing_tab" href="#pricing">Pricing</a></li>
		</ul>
        </div>
		<div class="clear"></div>
		<div id="panes" style="overflow-y: scroll; height:400px;">
			<div class="pane selected" id="gallery_content">
            <a id='gallery'  name="gallery"></a>
				<?= $this->element("products/gallery",array('products'=>$products)); ?>
			</div>
			<? if(count($compare_products) >= 2) { ?>
				<div class="pane " id="compare_content">
                <a id='compare'  name="compare"></a>
					<?= $this->element("products/compare_top"); ?>
				</div>
			<? } else { ?>
				<div class="pane " id="overview_content">
                <a id='overview'  name="overview"></a>
					<?= $this->element("products/overview"); ?>
				</div>
			<? } ?>
			<div class="pane" id="details_content" style="">
            <a id='details'  name="details"></a>
				<?= $this->element("products/description"); ?>
			</div>
			
			<div class="pane" id="reviews_content">
             <a id='reviews' name="reviews"></a>
				<?= $this->element("products/reviews"); ?>
			</div>
			<?php //if(empty($product['Product']['is_stock_item'])) { ?>
			<div class="pane" id="order_content">
            <a id='order' name="order"></a>
				<?= $this->element("products/order"); ?>
			</div>
            <div class="pane" id="pricing_content">
            <a id='pricing' name="pricing"></a>
				<?= $this->element("products/pricing", array('products'=>$products)); ?>
			</div>
			<?php //} ?>
		</div>
	</div>
<style>
#tabSet {
  //position: fixed;
  //left: 200;
}
</style>

<script>


var container   = $('#panes');
    

function doScrollTo(hash) {

	//alert('doScrollTo : hash: ' + hash);
	theHash = hash.slice(1); // remove the initial hash tag
	 j('#panes').scrollTo( j("#" + theHash),700,{offset:-30,easing:'swing'});

}

j('#tabs .tab a').click(function(e) {
	var href = j(this).attr('href');
	e.preventDefault();
	//location.hash = href;
	doScrollTo(href);
	j('#tabs .tab').removeClass('selected');
	j(href + "_tab").closest('li').addClass('selected');
	
	return false;
});

j(window).hashchange(function() { // happens instead of click handler, as long as links have href='#somewhere' (which doesnt exist in id or a-name)
	var hash = location.hash;
	alert('hash: ' + hash);
	if(!hash) { hash = '#gallery' }
	
	theHash = hash.slice(1); // remove the initial hash tag
	
	doScrollTo(theHash);
	
	
	var content = hash + "_content";

	j('#tabs .tab').removeClass('selected');
	j(hash + "_tab").closest('li').addClass('selected');
	
	j(content).show().addClass('selected');

});

j(document).ready(function() {
	j(this).scrollTop(0);
	j(".pane").show();
	doScrollTo('<?php echo $scrollTo?>');
	
	//j(window).hashchange();
});
</script>
