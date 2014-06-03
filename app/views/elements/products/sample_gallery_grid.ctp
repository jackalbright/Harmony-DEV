<?
$dollar_signs = array(
'DPW'=>'/images/icons/small/Circle-Small-1-Dollar-Sign-flat.gif',
'PW'=>'/images/icons/small/Circle-Small-2-Dollar-Signs-flat.gif',
'DPW-FLC'=>'/images/icons/small/Circle-Small-3-Dollar-Signs-flat.gif',

'DPWK'=>'/images/icons/small/Circle-Small-1-Dollar-Sign-flat.gif',
'PWK'=>'/images/icons/small/Circle-Small-1-Dollar-Sign-flat.gif',
'DPWK-FLC'=>'/images/icons/small/Circle-Small-2-Dollar-Signs-flat.gif',

'BB'=>'/images/icons/small/Circle-Small-1-Dollar-Sign-flat.gif',
'BNT'=>'/images/icons/small/Circle-Small-2-Dollar-Signs-flat.gif',
'B'=>'/images/icons/small/Circle-Small-3-Dollar-Signs-flat.gif',
'BC'=>'/images/icons/small/Circle-Small-4-Dollar-Signs-flat.gif',
);
		
			?>
<?
$this->set("shadowbox", true);


?>
<script>
	function showSampleLarge(link, larger_src)
	{
		$('master_sample').src = link;
		// TODO Caption?
		//document.location.href = "#master_link";
		document.location.href = "#gallery";

		$('master_larger').href = larger_src;
		$('master_link').href = larger_src;
		Shadowbox.setup($('master_larger'), {});
		Shadowbox.setup($('master_link'), {});
		//Shadowbox.open($('master_larger'));

		return false;
	}
</script>
<!--
-->
<? $horiz = in_array($prod, array('RL','PR')); ?>
		<?
			$pid = $products[0]['product_type_id'];
			$firstproduct = $related_products_by_id[$pid];
			$img = $firstproduct['ProductSampleImages'][0];
			$firstprod = $firstproduct['Product']['prod'];

			$mastersize = !empty($horiz) ? "-700x500":"250";
			$mastercontainer = 275;

			$tw = !empty($horiz) ? 200 : 115;

			$thumbsize = "-".($tw-15)."x{$tw}";
		?>
<? if(!empty($horiz)) { ?>
<td valign="top" class="sample_gallery" rowspan="1">
	<a name="gallery"></a>
	<table width="100%"><tr><td colspan=2 valign="top">

	<div class="grey_border_top"><span></span></div>
	<div class="grey_border_sides">
		<a id="master_link" name="master_link" rel="shadowbox" href="/images/galleries/cached/products/<?= $firstprod ?>/<?= $img['product_image_id'] ?>.<?= $img['file_ext'] ?>">
			<img id="master_sample" src="/images/galleries/cached/products/<?= $firstprod ?>/<?= $img['product_image_id'] ?>/<?=$mastersize?>.<?= $img['file_ext'] ?>"/>
		</a>
		<div align="center">
			<a id="master_larger" rel="shadowbox" href="/images/galleries/cached/products/<?= $firstprod ?>/<?= $img['product_image_id'] ?>.<?= $img['file_ext'] ?>">+ View Larger</a>
		</div>
	</div>
	<div class="grey_border_bottom"><span></span></div>

	</td>
	</tr></table>
	<table width="100%"><tr><td valign="top" style="">
		<? if(empty($compare) && count($products) > 1) { ?>
		<?= $hd->product_element("products/intro", $product['Product']['prod'],array('no_more'=>1,'learn_more'=>'#included')); ?>
		<? } ?>
		<h4 class="grey_header"><span>
			<img class='nobg' src="/images/icons/5stars.png"/>
		Reviews 
		</span></h4>
		<div class="grey_border" align="left">

			<div style="padding: 5px;">
			<?= $this->element("products/testimonials", array('testimonials'=>$product['Testimonials'],'random'=>true,'limit'=>1,'more'=>'#customers')); ?>
			</div>
		</div>
	</div>
	</td>
	<td style="" valign="top" style="width: 450px; ">
	<? $pid = $products[0]['product_type_id']; ?>
	<? if(empty($compare) && count($products) == 1) { ?>
		<?= $hd->product_element("products/intro", $product['Product']['prod'],array('no_more'=>1,'learn_more'=>'#included')); ?>
		<div class="clear"></div>
	<? } ?>
	<? if(count($products) > 1 || count($related_products_by_id[$pid]['ProductSampleImages']) > 1) { ?>
		<div style="">
		<? if(empty($product['Product']['is_stock_item'])) { ?>
		<div style="padding: 5px; font-size: 22px; font-weight: bold;" class="product_subsection_header">
			<?= !empty($compare) ? "Gallery" : " Examples &amp; Pricing" ?>
		</div>
		<? } ?>
			<div class="clear">
				<?
					$productsWithPictures = 0;
					foreach($products as $pr) { if(!empty($related_products_by_id[$pr['product_type_id']]['ProductSampleImages'])) { $productsWithPictures++; } }
				?>
				<? $i = 0; foreach($products as $pr) { 
					$code = $prod = $pr['code'];
					$pid = $pr['product_type_id'];
					$product = $p = $related_products_by_id[$pid];
					$id = "sample_gallery_$code";
					$productSampleImages = $product['ProductSampleImages'];
					#if(empty($productSampleImages)) { continue; }
					#if($productsWithPictures == 1 && count($productSampleImages) <= 1) { continue; }
				?>
				<div class="" style="margin-top: 10px;">
					<!--
					<? if(!empty($dollar_signs[$code])) { ?>
						<a href="#compare"><img style="vertical-align: middle;" src="<?= $dollar_signs[$code] ?>"/></a>
					<? } ?>
					-->
					<div style="font-weight: bold; background-color: #CCC; padding: 5px; min-height: 40px;">
						<? if(!empty($dollar_signs[$code])) { ?><div style='background-color: white; padding: 5px; float: right; margin: 2px;'><?= !empty($dollar_signs[$code]) ? "<img align='absmiddle' src='{$dollar_signs[$code]}'/>" : "" ?></div><? } ?>
						<?= strip_tags($product['Product']['pricing_name']) ?>
						<?= !empty($product['Product']['pricing_description']) ? "<div style='font-weight: normal;'>".$product['Product']['pricing_description']."</div>" : "" ?>
						<div class="clear"></div>
					</div>
				</div>
				<?
					$prod = $product['Product']['prod'];
					$path = "products/".$product['Product']['prod'];
					$pathclass = "222image_gallery_" . preg_replace("/\//", "_", $path);
					
					$file_count = count($productSampleImages);
		
					if(!empty($horiz)) { $cols = 2; }
		
					if(empty($cols)) { $cols = 3; }
					$rows = ($productsWithPictures <= 1) ? (empty($horiz) ? 2 : 5) : 1;
					$thumbcontainer = $cols * (!empty($horiz) ? 200 : 115) + 10;
				?>
				<div style="border: solid #CCC 1px; background-color: white;">
				<table>
					<?
					
					if (!empty($productSampleImages))
					{
						$underpath = preg_replace("/\W+/", "_", $path);
					?>
						<?  $i = 0; foreach($productSampleImages as $image) { ?>
						<? if($i == $rows*$cols) { ?> 
							<tr id="view_all_<?= $prod ?>"><td align="right" colspan="<?=$cols?>"><a href="Javascript:void(0);" onClick="$('all_<?= $prod ?>').removeClassName('hidden'); $('view_all_<?= $prod ?>').addClassName('hidden'); $('hide_<?= $prod ?>').removeClassName('hidden');">View all</a> (<?= count($productSampleImages); ?>)</td></tr> 
							<tr id="hide_<?= $prod ?>" class="hidden"><td align="right" colspan="<?=$cols?>"><a href="Javascript:void(0);" onClick="$('all_<?= $prod ?>').addClassName('hidden'); $('view_all_<?= $prod ?>').removeClassName('hidden'); $('hide_<?= $prod ?>').addClassName('hidden')">Hide</a></td></tr>
							<tbody id="all_<?= $prod ?>" class="view_all_gallery hidden">
						<? } ?>
						<? if($i % $cols == 0) { ?><tr><? } ?>
						<td class="image" width="<?= $tw ?>">
							<a class="image_gallery_scroll_image sample_image_<?=$underpath?>" title="<?= $image['title'] ?>" id="image_gallery_largelink1_<?=$underpath?>_<?=$i?>" href="/images/galleries/cached/<?= $path ?>/<?= $image['product_image_id'] ?>/<?=$mastersize?>.<?=$image['file_ext'] ?>" onClick="return showSampleLarge(this.href, '/images/galleries/cached/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>');">
								<img border="0" src="/images/galleries/cached/<?= $path ?>/<?= $image['product_image_id'] ?>/<?= $thumbsize ?>.<?=$image['file_ext'] ?>" id="image_gallery_<?=$underpath?>_<?=$i?>"/></a>
							<br/>
						</td>
						<? if($i+1 % $cols == 0 || $i+1 == count($productSampleImages)) { ?></tr><? }?>
						<? if($i+1 == count($productSampleImages)) { ?> </tbody> <? } ?>
						<?  $i++; } ?>
					<? } ?>
				</table>
				</div>
				<? } ?>
				<? if(!isset($pricing) || !empty($pricing)) { ?>
				<?= $this->element("products/product_pricing", array('price_lists'=>$price_lists,'prod'=>$code,'p'=>0,'XXXicon'=>(!empty($dollar_signs[$code]) ? $dollar_signs[$code] : null))); ?>
				<? } ?>
		
			</div>
		</div>
	<? } ?>
	</div>
	</td>
	</tr></table>
</td>
<? } else { ?>
<td valign="top" class="sample_gallery" style="width: 275px;" rowspan="3">
	<a name="gallery"></a>
	<div class="grey_border_top"><span></span></div>
	<div class="grey_border_sides">
		<a id="master_link" name="master_link" rel="shadowbox" href="/images/galleries/cached/products/<?= $firstprod ?>/<?= $img['product_image_id'] ?>.<?= $img['file_ext'] ?>">
			<img id="master_sample" src="/images/galleries/cached/products/<?= $firstprod ?>/<?= $img['product_image_id'] ?>/<?=$mastersize?>.<?= $img['file_ext'] ?>"/>
		</a>
		<div align="center">
			<a id="master_larger" rel="shadowbox" href="/images/galleries/cached/products/<?= $firstprod ?>/<?= $img['product_image_id'] ?>.<?= $img['file_ext'] ?>">+ View Larger</a>
		</div>
	</div>
	<div class="grey_border_bottom"><span></span></div>

		<h4 class="grey_header"><span>
			<img class='nobg' src="/images/icons/5stars.png"/>
			Reviews 
		</span></h4>
		<div class="grey_border" align="left">

		<div style="padding: 5px;">
		<?= $this->element("products/testimonials", array('testimonials'=>$product['Testimonials'],'random'=>true,'limit'=>1,'more'=>'#customers')); ?>
		</div>

		</div>
</td>
<td valign="top">
	<div class="main_border_top"><span></span></div>
	<div class="main_border_sides">
		<? if(empty($compare)) { ?>
		<?= $hd->product_element("products/intro", $product['Product']['prod'],array('no_more'=>1,'learn_more'=>'#included')); ?>
		<? } ?>

		<div style="">
		<? if(empty($product['Product']['is_stock_item'])) { ?>
		<div class="product_subsection_header" style="padding: 5px; font-size: 22px; font-weight: bold;">
			<?= !empty($compare) ? "Gallery" : " Examples &amp; Pricing" ?>
		</div>
		<? } ?>
			<div class="clear">
				<?
					$productsWithPictures = 0;
					foreach($products as $pr) { if(!empty($related_products_by_id[$pr['product_type_id']]['ProductSampleImages'])) { $productsWithPictures++; } }
				?>
				<? $i = 0; foreach($products as $pr) { 
					$code = $prod = $pr['code'];
					$pid = $pr['product_type_id'];
					$product = $p = $related_products_by_id[$pid];
					$id = "sample_gallery_$code";
					$productSampleImages = $product['ProductSampleImages'];
					#if(empty($productSampleImages)) { continue; }
					#if($productsWithPictures == 1 && count($productSampleImages) <= 1) { continue; }
				?>
				<div class="" style="margin-top: 10px;">
					<? if(false && empty($product['Product']['is_stock_item'])) { ?>
					<div class="right">
						<a href="#included">Free with your order</a> | <a href="#pricing">Pricing</a>
					</div>
					<? } ?>

					<!--
					<? if(!empty($dollar_signs[$code])) { ?>
						<a href="#compare"><img style="vertical-align: middle;" src="<?= $dollar_signs[$code] ?>"/></a>
					<? } ?>
					-->
					<div style="font-weight: bold; background-color: #CCC; padding: 5px; min-height: 40px;">
						<? if(!empty($dollar_signs[$code])) { ?><div style='background-color: white; padding: 5px; float: right; margin: 2px;'><?= !empty($dollar_signs[$code]) ? "<img align='absmiddle' src='{$dollar_signs[$code]}'/>" : "" ?></div><? } ?>
						<?= strip_tags($product['Product']['pricing_name']) ?>
						<?= !empty($product['Product']['pricing_description']) ? "<div style='font-weight: normal;'>".$product['Product']['pricing_description']."</div>" : "" ?>
						<div class="clear"></div>
					</div>
				</div>
				<?
					$prod = $product['Product']['prod'];
					$path = "products/".$product['Product']['prod'];
					$pathclass = "image_gallery_" . preg_replace("/\//", "_", $path);
					
					$file_count = count($productSampleImages);
		
					if(!empty($horiz)) { $cols = 2; }
		
					if(empty($cols)) { $cols = 3; }
					$rows = ($productsWithPictures <=  1) ? (empty($horiz) ? 2 : 5) : 1;
					$thumbcontainer = $cols * (!empty($horiz) ? 200 : 115) + 10;
				?>
				<div style="border: solid #CCC 1px; background-color: white;">
				<table>
					<?
					
					if (!empty($productSampleImages))
					{
						$underpath = preg_replace("/\W+/", "_", $path);
					?>
						<?  $i = 0; foreach($productSampleImages as $image) { ?>
						<? if($i == $rows*$cols) { ?> 
							<tr id="view_all_<?= $prod ?>"><td align="right" colspan="<?=$cols?>"><a href="Javascript:void(0);" onClick="$('all_<?= $prod ?>').removeClassName('hidden'); $('view_all_<?= $prod ?>').addClassName('hidden'); $('hide_<?= $prod ?>').removeClassName('hidden');">View all</a> (<?= count($productSampleImages); ?>)</td></tr> 
							<tr id="hide_<?= $prod ?>" class="hidden"><td align="right" colspan="<?=$cols?>"><a href="Javascript:void(0);" onClick="$('all_<?= $prod ?>').addClassName('hidden'); $('view_all_<?= $prod ?>').removeClassName('hidden'); $('hide_<?= $prod ?>').addClassName('hidden')">Hide</a></td></tr>
							<tbody id="all_<?= $prod ?>" class="view_all_gallery hidden">
						<? } ?>
						<? if($i % $cols == 0) { ?><tr><? } ?>
						<td class="image" width="<?= $tw ?>">
							<a class="image_gallery_scroll_image sample_image_<?=$underpath?>" title="<?= $image['title'] ?>" id="image_gallery_largelink1_<?=$underpath?>_<?=$i?>" href="/images/galleries/cached/<?= $path ?>/<?= $image['product_image_id'] ?>/<?=$mastersize?>.<?=$image['file_ext'] ?>" onClick="return showSampleLarge(this.href, '/images/galleries/cached/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>');">
								<img border="0" src="/images/galleries/cached/<?= $path ?>/<?= $image['product_image_id'] ?>/<?= $thumbsize ?>.<?=$image['file_ext'] ?>" id="image_gallery_<?=$underpath?>_<?=$i?>"/></a>
							<br/>
						</td>
						<? if($i+1 % $cols == 0 || $i+1 == count($productSampleImages)) { ?></tr><? }?>
						<? if($i+1 == count($productSampleImages)) { ?> </tbody> <? } ?>
						<?  $i++; } ?>
					<? } ?>
				</table>
				</div>
				<? if(!isset($pricing) || !empty($pricing)) { ?>
				<?= $this->element("products/product_pricing", array('price_lists'=>$price_lists,'prod'=>$code,'p'=>0,'XXicon'=>(!empty($dollar_signs[$code]) ? $dollar_signs[$code] : null))); ?>
				<?}?>
				<? } ?>
		
			</div>
		</div>

		<? if(count($compare_products) <= 1) { ?>
			<?= $this->element("products/details_free"); ?>
		<? } ?>
	</div>
	<div class="main_border_bottom"><span></span></div>
</td>
<? } ?>
