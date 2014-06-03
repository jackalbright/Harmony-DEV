<div class="product product_view">

<?
$products = array($product);

if (count($related_products) > 0) { 
	$products = array_merge($products, $related_products);
}
echo $hd->product_element("products/sample_gallery_album",$product['Product']['prod'],array('products'=>$products));
?>

<br/>

<div>
	<table class="tab_list" width="100%">
	<tr>
		<td id="description_tab" class="tab selected_tab">
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
		<td id="quality_tab" class="tab">
			<a href="javascript:void(0)" onClick="selectTab('quality');">quality guarantee</a>
		</td>
		<td class="spacer"></td>
		<td id="pricing_tab" class="tab">
			<a href="javascript:void(0)" onClick="selectTab('pricing');">pricing</a>
		</td>
		<td class="spacer"></td>
		<!--
		<td id="testimonials_tab" class="tab">
			<a href="javascript:void(0)" onClick="selectTab('testimonials');">testimonials</a>
		</td>

		<td class="spacer"></td>
		-->
	</tr>
	</table>

	<div class="tabbed_container">

	<div class="selected_tab_content tab_content" id="description_tab_content">
		<div style="">
		<p>
			<?= $product['Product']['main_intro']; ?>
		</p>

		<div>
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
	</div>

	<div class="tab_content" id="description2_tab_content">
		<table>
		<tr>
		<td valign=top style="width: 50%;">
		<p>
			<?= $product['Product']['main_intro']; ?>
		</p>
		</td>
		<td valign=top>
		<div>
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
						foreach($product['AllRelatedProducts'] as $subProduct)
						{
							
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
		</td>
		</tr>
		</table>
	</div>

	<div class="tab_content" id="options_tab_content">
		<table width="500">
		<tr>
		<td valign=top>
			<?= $product['Product']['name'] ?>
			<br/>
			<img src="/images/products/diagram/<?= $product['Product']['code']?>.jpg"/>
			<? foreach($product['RelatedProducts'] as $rp) { ?>
				<br/>
				<?= $rp['name'] ?>
				<br/>
				<img src="/images/products/diagram/<?= $rp['code']?>.jpg"/>
			<? } ?>
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

	<div class="tab_content" id="quality_tab_content">
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

	<div class="tab_content" id="pricing_tab_content">
		<a name="pricing">&nbsp;</a>
		<div id="pricing_calculator_holder">Calculator loading... Please wait.</div>
	<?
		echo $ajax->Javascript->event('window','load',
			$ajax->remoteFunction( array('url'=>"/products/calculator/".$product['Product']['code'], 'update'=>"pricing_calculator_holder")));
		?>
		<br/>
		<br/>
		<div class="sidebar_header">Pricing Chart:</div>
		<?
		echo $this->element("products/pricing_grid");
	?>
	</div>

	<div class="tab_content" id="testimonials_tab_content">
		<?= $this->element("products/testimonials", array('testimonials'=>$product['Testimonials'])); ?>
	</div>

	</div>
</div>


</div>
