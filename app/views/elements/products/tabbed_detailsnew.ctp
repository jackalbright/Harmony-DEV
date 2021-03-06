<? if(empty($active_tab)) { $active_tab = ""; } ?>
<div>
	<table class="hidden tab_list" width="100%">
	<tr>
		<td id="description_tab" class="tab <?= (empty($active_tab) || $active_tab == 'description') ? "selected_tab" : "" ?>">
			<a href="javascript:void(0)" onClick="selectTab('description');">description</a>
		</td>
		<!--
		<td id="description2_tab" class="tab ">
			<a href="javascript:void(0)" onClick="selectTab('description2');">D2</a>
		</td>
		-->
		<td class="spacer"></td>
		<? if ($product['Product']['secondary_desc'] != "") {  ?>
		<td id="options_tab" class="tab">
			<a href="javascript:void(0)" onClick="selectTab('options');">options</a>
		</td>
		<td class="spacer"></td>
		<? } ?>
		<? if(!empty($_REQUEST['faq']) || !empty($customer['is_admin'])) { ?>
		<td id="wholesale_tab" class="tab">
			<a href="javascript:void(0)" onClick="selectTab('wholesale');">wholesale</a>
		</td>
		<td class="spacer"></td>
		<td id="faq_tab" class="tab">
			<a href="javascript:void(0)" onClick="selectTab('faq');">common questions</a>
		</td>
		<td class="spacer"></td>
		<? } ?>
	</tr>
	</table>

	<div class="right">
		<? if(file_exists(APP."/webroot/images/products/diagram/".$product['Product']['code'].".jpg")) { ?>
			<?= $product['Product']['name'] ?>
			<br/>
			<img src="/images/products/diagram/<?= $product['Product']['code']?>.jpg"/>
		<? } ?>
	</div>

	<div style="">
		<p>
			<?= $product['Product']['main_intro']; ?>
		</p>
		<a href="Javascript:void(0);" class="block right" onClick="showPopup('more_info');">Learn more</a>
		<div class="clear"></div>

		<div class="product_info_popup hidden" id="more_info">
			<a class="block right" href="Javascript:void(0);" onClick="hidePopup('more_info');">Close</a>
			<ul>
			<? if ($product['Product']['width'] > 0) { ?>
				<li>Size: 
				<?
					if(isset($product['AllRelatedProducts']) && count($product['AllRelatedProducts']))
					{
						?><ul>
						<li>
						<?= $product['Product']['pricing_name'] ?>: 
						<? if ($product['Product']['height'] > 0) { ?>
							<?= $hd->mmToIn($product['Product']['width'], 8, true); ?>" x <?= $hd->mmToIn($product['Product']['height'], 8, true); ?>"
						<? } else { ?> 
							<?= $hd->mmToIn($product['Product']['width'], 8, true); ?>" diameter
						<? } ?>
						</li>
						<?
					#error_log("ARP=".count($product['AllRelatedProducts']));
						foreach($product['AllRelatedProducts'] as $subProduct)
						{
							#error_log("ONE");
							
							if ($subProduct['width'] > 0 && $subProduct['height'] > 0) { ?>
							<li>
								<?= $subProduct['pricing_name'] ?>: 
								<?= $hd->mmToIn($subProduct['width'], 8, true); ?>" x <?= $hd->mmToIn($subProduct['height'], 8, true); ?>"
							</li>
							<? } else if ($subProduct['width'] > 0) { ?>
							<li>
								<?= $subProduct['pricing_name'] ?>: 
								<?= $hd->mmToIn($subProduct['width'], 8, true); ?>" diameter 
							</li>
							<? } 
						}
						?></ul><?
					} else {
						echo $hd->mmToIn($product['Product']['width'], 8, true) ?>" x <?= $hd->mmToIn($product['Product']['height'], 8, true) . '"';
					}
				?>
			<? } ?>
				<?
					$normal_ship_time_days = $product['Product']['normal_ship_time_days'];
					if ($normal_ship_time_days <= 4)
					{
						$normal_ship_time = ($normal_ship_time_days * 24) . " hours";
					} else {
						$normal_ship_time = $normal_ship_time_days . " days";
					}
				
				?>
				<?
					$main_desc = preg_split("/(\n|<br\s*\/?>)/", $product['Product']['main_desc']);
					foreach($main_desc as $main_desc_item)
					{
						$main_desc_item = preg_replace("/(<\/?(ul|li)[^>]*>)/i", "", $main_desc_item);
						if (!preg_match("/\w/", $main_desc_item)) { continue; }
						?>
						<li><?= $main_desc_item ?>
						<?
					}
					
				?>
			</ul>
		</div>
		</div>



	<div class="tabbed_container">

	<div class="tab_content" id="options_tab_content">
		<table width="500">
		<tr>
		<td valign=top>
		</td>
		<td valign=top>
		<ul>
			<? if(!$product['Product']['is_stock_item']) { ?>
			<li><b>Use your <a href="/custom_images?prod=<?=$product['Product']['code']?>">own art</a> or select an image from <a href="/gallery/browse?prod=<?=$product['Product']['code']?>">our gallery</a></b>
			<li> Free personalization
			<? } ?>
			<? if ($product['Product']['secondary_desc']) { 
				$desc_items = preg_split("/(\n|<br\s*\/?>)/", $product['Product']['secondary_desc']);
			?>
				<? foreach($desc_items as $desc_item) { if ($desc_item != "") { 
					# Strip off tags if <ul> or <li> or ending.
					$desc_item = preg_replace("/(<\/?(ul|li)[^>]*>)/i", "", $desc_item);
					if (!preg_match("/\w/", $desc_item)) { continue; }
				
				?>
				<li><?= $desc_item ?>
				<? } } ?>
			<? } ?>
		</ul>
		</td>
		</tr>
		</table>
		<div class="clear"></div>
	</div>

	<div class="tab_content" id="wholesale_tab_content">
		<?= $wholesaleContent['ContentSnippet']['content'] ?>
	</div>

	<div class="tab_content" id="faq_tab_content">
		<?= $this->element("faqs/list", array('faqs'=>$productFaq,'title'=>"Common ".$product['Product']['name']." Questions")); ?>
		<? foreach($faqTopics as $faqTopic) { ?>
			<?= $this->element("faqs/list", array('faqs'=>$faqTopic['Faq'],'title'=>$faqTopic['FaqTopic']['topic_name'])); ?>
		<? } ?>
		<!--
		<ul>
			<li> Materials and workmanship are guaranteed
			<li> Your <?= !$product['Product']['is_stock_item'] ? "personalized" : ""; ?> <?= strtolower($hd->pluralize(($product['Product']['short_name'] ? $product['Product']['short_name'] : $product['Product']['name']), true)); ?> are made in USA
			<? if ($product['Product']['quality_desc']) { 
				$desc_items = preg_split("/(\n|<br\s*\/?>)/", $product['Product']['quality_desc']);
			?>
				<? foreach($desc_items as $desc_item) { if ($desc_item != "") { 
					# Strip off tags if <ul> or <li> or ending.
					$desc_item = preg_replace("/(<\/?(ul|li)[^>]*>)/i", "", $desc_item);
					if (!preg_match("/\w/", $desc_item)) { continue; }
				
				?>
				<li><?= $desc_item ?>
				<? } } ?>
			<? } ?>
		</ul>
		-->
	</div>

	<div class="tab_content" id="processing_tab_content">
			<ul>
			<? 
				if (!$product['Product']['is_stock_item']) { 
			?>
			<li> Full-color printing is provided at no extra charge.
			<li> Email proofs are provided at your request. A paper proof is available for $5.  An optional pre-production sample is available for $40 and includes overnight shipping.
			<? 
				} 
			?>
			</ul>
	</div>

	<div class="<?= (!empty($active_tab) && $active_tab == 'pricing') ? "selected_tab_content" : "" ?> tab_content" id="pricing_tab_content">
		<a name="pricing">&nbsp;</a>
		<div id="pricing_calculator_holder">Calculator loading... Please wait.</div>
	<?
		echo $ajax->Javascript->event('window','load',
			$ajax->remoteFunction( array('url'=>"/products/calculator/".$product['Product']['code'], 'update'=>"pricing_calculator_holder")));
		?>
		<br/>
		<br/>
	</div>

	<div class="tab_content" id="testimonials_tab_content">
		<?= $this->element("products/testimonials", array('testimonials'=>$product['Testimonials'])); ?>
	</div>

	</div>

	<table><tr>
	<td><h4>Pricing Chart</h4></td>
	<td align="right">
		<a class="bold" href="/products/calculator/<?= $product['Product']['code'] ?>" rel="shadowbox;width=650;height=450">Pricing Calculator</a>
	</td>
	</tr>
	<tr>
	<td colspan=2>
		<?  echo $this->element("products/pricing_grid"); ?>
	</td>
	</tr></table>

	<div>
		<h4>Select an Image:</h4>
		<? $hide_select = false; ?>

		<table width="100%">
		<tr>
		<? if(!empty($build['GalleryImage'])) { ?>
		<td>
			<img src="<?= $build['GalleryImage']['image_location'] ?>" style="height: 100px;"/><br/>
			<?= $build['GalleryImage']['stamp_name'] ?><br/>
			<? $hide_select = true; ?>
		</td>
		<? } else if (!empty($build['CustomImage'])) { ?>
		<td>
			<img src="<?= $build['CustomImage']['Image_Location'] ?>" style="height: 100px;"/><br/>
			<? if(!empty($build['CustomImage']['title'])) { echo $build['CustomImage']['title']."<br/>"; } ?>
			<? $hide_select = true; ?>
		</td>
		<? } ?>
		<? if ($hide_select) { ?>
			<td align="center">
				<?  if(!isset($product_option_field)) { $product_option_field = ""; } ?>
				<?= $hd->product_element("products/select_button", $product['Product']['prod'], array('product'=>$product,'parent_product'=>$parent_product,'related'=>$related_products,'rightbar_template'=>false,'product_option_field'=>$product_option_field,'default_product_option_value'=>$default_product_option_value)); ?>
				<div class="clear"></div>
				<div class=""><a href="Javascript:void(0);" onClick="showPopup('gallery_select');">Select another image</a></div>
			</td>
		<? } ?>
		</tr>
		</table>

		<div class="<?= $hide_select ? "hidden" : "" ?>" id="gallery_select">
			<?= $this->element("gallery/select",array('short'=>1)); ?>
		</div>
	</div>

</div>
