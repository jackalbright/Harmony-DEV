<? if(empty($active_tab)) { $active_tab = "pricing"; } ?>
<div class="clear"></div>
<div>
		<script>
			var loadedCalculator = false;
			function loadCalculator()
			{
				if(loadedCalculator) { return; }
				new Ajax.Updater("pricing_calculator_holder", "/products/calculator/<?= $product['Product']['code'] ?>", { asynchronous: true, evalScripts: true });
				loadedCalculator = true;
			}
		</script>

	<div class="" id="">
		<?= $this->element("products/feature_comparison", array('no_accordian'=>true)); ?>
	</div>



	<div class="tab_content" id="faq_tab_content">
		<?= $this->element("faqs/list", array('faqs'=>$productFaq,'title'=>"Common ".$product['Product']['name']." Questions")); ?>
		<? foreach($faqTopics as $faqTopic) { ?>
			<?= $this->element("faqs/list", array('faqs'=>$faqTopic['Faq'],'title'=>$faqTopic['FaqTopic']['topic_name'])); ?>
		<? } ?>
	</div>

	<div class="product_subsection" id="">
		<?= $this->element("products/pricing_comparison",array('no_accordian'=>true,'no_title'=>true)); ?>
	</div>

	<div class="hidden" id="wholesale_tab_content">
		<div style="float: right; width: 225px; border: solid #CCC 1px; background-color: #DDD; padding: 5px; margin: 5px;">
			<b>Call now for a free project consultation</b>
			<?= $this->element("products/links"); ?>
		</div>
		<?= $product['Product']['wholesale_info'] ?>
		<?= $wholesaleContent['ContentSnippet']['content'] ?>
	</div>

	<div class="tab_content" id="reviews_tab_content">
		<?= $this->element("products/testimonials", array('testimonials'=>$product['Testimonials'])); ?>
	</div>
</div>

</div>
