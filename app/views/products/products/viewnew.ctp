<div class="product product_view">

<?
$related = $related_products;
if (count($related) > 0)
{
	# Show tabs....
	?>
	<table class="tab_list">
	<tr>
		<td id="<?= $product['Product']['code']?>_gtab" class="gtab selected_gtab">
			<a href="javascript:void(0)" onClick="selectTab('<?= $product['Product']['code'] ?>','gtab'); selectProductValue('<?= $product['Product']['code'] ?>');"><?= $hd->pluralize($product['Product']['name']) ?></a>
		</td>
		<td class="gspacer"></td>
		<? foreach($related_products as $rel) { ?>
		<td id="<?= $rel['Product']['code']?>_gtab" class="gtab">
			<a href="javascript:void(0)" onClick="selectTab('<?= $rel['Product']['code'] ?>','gtab'); selectProductValue('<?= $rel['Product']['code'] ?>');"><?= $hd->pluralize($rel['Product']['name']) ?></a>
		</td>
		<td class="gspacer"></td>
		<? } ?>
	</tr>
	</table>
	<?


	$product_name = $product['Product']['name'];
	$gallery_title = "Sample " . $product_name;
	if (!preg_match("/s$/", $gallery_title)) { $gallery_title .= "s"; }
	if ($product['Product']['is_stock_item'])
	{
		$gallery_title = "$product_name Ideas";
	}
	echo $hd->product_element("products/sample_gallery_album",$product['Product']['prod'],array('product'=>$product['Product'],'productSampleImages'=>$product['ProductSampleImages'], 'gallery_title'=>$gallery_title,'tabbed'=>true,'id'=>$product['Product']['code']."_gtab_content",'class'=>'gtab_content selected_gtab_content'));

	foreach($related as $rp)
	{
		$product_name = $rp['Product']['name'];
		$gallery_title = "Sample " . $product_name;
		if (!preg_match("/s$/", $gallery_title)) { $gallery_title .= "s"; }
		if ($rp['Product']['is_stock_item'])
		{
			$gallery_title = "$product_name Ideas";
		}

		echo $hd->product_element("products/sample_gallery_album",$rp['Product']['prod'],array('product'=>$rp['Product'],'productSampleImages'=>$rp['ProductSampleImages'], 'gallery_title'=>$gallery_title,'tabbed'=>true,'id'=>$rp['Product']['code']."_gtab_content",'class'=>'gtab_content'));
	}
} else {
	$product_name = $product['Product']['name'];
	$gallery_title = "Sample " . $product_name;
	if (!preg_match("/s$/", $gallery_title)) { $gallery_title .= "s"; }
	if ($product['Product']['is_stock_item'])
	{
		$gallery_title = "$product_name Ideas";
	}

	echo $hd->product_element("products/sample_gallery_album",$product['Product']['prod'],array('product'=>$product['Product'],'productSampleImages'=>$product['ProductSampleImages'], 'gallery_title'=>$gallery_title));
}

?>

<div class="right_align">

	<div class="">
		<?= $hd->product_element("products/select_button", $product['Product']['prod'], array('product'=>$product,'related'=>$related)); ?>
	</div>

	<div class="clear"></div>
</div>

<div>
	<table width="100%" class="tab_list">
	<tr>
		<td id="description_tab" class="tab selected_tab">
			<a href="javascript:void(0)" onClick="selectTab('description');">Description</a>
		</td>
		<!--
		<td id="description2_tab" class="tab ">
			<a href="javascript:void(0)" onClick="selectTab('description2');">D2</a>
		</td>
		-->
		<td class="spacer"></td>
		<? if ($product['Product']['secondary_desc'] != "") {  ?>
		<td id="options_tab" class="tab">
			<a href="javascript:void(0)" onClick="selectTab('options');">Options</a>
		</td>
		<td class="spacer"></td>
		<? } ?>
		<td id="quality_tab" class="tab">
			<a href="javascript:void(0)" onClick="selectTab('quality');">Quality Guarantee</a>
		</td>
		<td class="spacer"></td>
		<td id="pricing_tab" class="tab">
			<a href="javascript:void(0)" onClick="selectTab('pricing');">Pricing</a>
		</td>
		<td class="spacer"></td>
		<td id="shipping_tab" class="tab">
			<a href="javascript:void(0)" onClick="selectTab('shipping');">Shipping</a>
		</td>
		<td class="spacer"></td>
		<td id="testimonials_tab" class="tab">
			<a href="javascript:void(0)" onClick="selectTab('testimonials');">Testimonials</a>
		</td>
		<td class="spacer"></td>
		<td align=center>
		</td>
	</tr>
	</table>

	<div class="tabbed_container">

	<div class="selected_tab_content tab_content" id="description_tab_content">
		<div style="width: 600px;">
		<p>
			<?= $product['Product']['main_intro']; ?>
		</p>

		<div>
			<ul>
			<? if ($product['Product']['width'] > 0) { ?>
				<li>Size: 
				<?
					if(isset($product['RelatedProducts']) && count($product['RelatedProducts']))
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
						foreach($product['RelatedProducts'] as $subProduct)
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
					if(isset($product['RelatedProducts']) && count($product['RelatedProducts']))
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
						foreach($product['RelatedProducts'] as $subProduct)
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
			<? foreach($related_products as $rp) { ?>
				<br/>
				<?= $rp['Product']['name'] ?>
				<br/>
				<img src="/images/products/diagram/<?= $rp['Product']['code']?>.jpg"/>
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

	<div class="tab_content" id="pricing_tab_content">
		<table style="padding-top: 20px;">
		<tr>
			<td valign=top>
				<?= $this->element("products/pricing_grid", $this->viewVars); ?>
			</td>
			<td valign=top style="padding-top: 10px;">
				<ul>
					<li><b>Low minimums</b> (<?= $product['ProductPricing'][0]['quantity'] ?><?= !$product['Product']['is_stock_item'] ? " per design" : "" ?>) 
					<li><a href="/info/quantityPricing.php#<?=$product['Product']['prod']?>">Discounts</a> for larger quantities 
					<? if (!$product['Product']['is_stock_item']) { ?>
						<li><b>No <a href="/custom/designServices.php">design or setup charges</a></b> when our standard template is used 
					<? } ?>
				</ul>
			</td>
		</tr>
		</table>
	</div>

	<div class="tab_content" id="shipping_tab_content">
		<ul>
			<li><b>Fast service:</b> Most <? $product['Product']['is_stock_item'] ? "" : "custom " ?><?= strtolower($product['Product']['short_name'] ? $product['Product']['short_name'] : $product['Product']['name']) ?> orders ship within <?= $normal_ship_time ?>
			<li> Please allow 7-10 business days for production when ordering over <?= number_format($product['Product']['max_per_10_days']); ?> <?= $product_plural_name ?>.
		</ul>
		<hr/>
		<? echo $ajax->Javascript->event('window','load', $ajax->remoteFunction( array('url'=>"/shipping/calculator/".$product['Product']['code'], 'update'=>"shipping_calculator"))); ?>
		<div id="shipping_calculator"></div>

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

	<div class="tab_content" id="testimonials_tab_content">
		<?= $this->element("products/testimonials", array('testimonials'=>$product['Testimonials'])); ?>
	</div>

	</div>
</div>


</div>
