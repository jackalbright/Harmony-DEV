<?
$this->set("shadowbox", true);

if(empty($size)) { $size = "250"; }
?>
<div>
		<div class="">
		<div id="gallery_type_sample" class="gallery_type" style="width: <?= $size + 25; ?>px;">
		<div class="gallery_type_inner">
		<? if(empty($no_label)) { ?>
			<div class="gallery_type_tab selected bold"> Sample Gallery </div>

			<? if(count($products) > 1) { ?>
			<div style="">
			<table width="100%" cellspacing=0>
			<tr>
				<? $i = 0; foreach($products as $pr) { 
					$code = $prod = $pr['code'];
					$pid = $pr['product_type_id'];
					$p = $related_products_by_id[$pid];
				?>
				<td id="sample_gallery_tab_<?= $code ?>" width="<?= floor(100/count($products)) ?>%" class="sample_gallery_tab <?= !$i ? "selected" : "" ?>" align="center" style="font-size: 10pt;">
					<a style="font-weight: normal;" href="Javascript:void(0)" onClick="showGalleryTab('sample_gallery', '<?= $code ?>');"><?= $pr['pricing_name']; ?></a>
				</td>
				<? $i++; } ?>
			</tr>
			</table>
			</div>
			<? } ?>
		<? } ?>
		<? $i = 0; foreach($products as $pr) { 
			$code = $prod = $pr['code'];
			$pid = $pr['product_type_id'];
			$product = $p = $related_products_by_id[$pid];
			$id = "sample_gallery_$code";
		?>
		<div id="<?=$id?>" class="sample_gallery <?= $i > 0 ? "hidden" : "" ?>" style="">
			<?
			$productSampleImages = $product['ProductSampleImages'];
			$path = "products/".$product['Product']['prod'];
			$pathclass = "image_gallery_" . preg_replace("/\//", "_", $path);
			
			$file_count = count($productSampleImages);
			
			if (!empty($productSampleImages))
			{
				$underpath = preg_replace("/\W+/", "_", $path);
			?>
				<div style="">
				<table style="width: 100%; " class="image_gallery " cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td align="right" style="width: 50px;">
						<a href="Javascript:void(0)" onClick="return image_gallery_scroll_left('<?=$id?>');"><img src="/images/buttons/small/Circle-left.gif"/></a>
					</td>
					<td align=center colspan=1>
						<div align="center">
							<nobr><span id="<?=$id?>_counter">1</span> of <?= $file_count ?></nobr>
						</div>
					</td>
					<td align="left" style="width: 50px;">
						<a href="Javascript:void(0)" onClick="return image_gallery_scroll_right('<?=$id?>');"><img src="/images/buttons/small/Circle-right.gif"/></a>
					</td>
				</tr>
				</table>
				</div>
					<div id="<?= $id ?>_row" styleOLD="z-index: 1; position: relative;">
							<?  $i = 0; foreach($productSampleImages as $image) { ?>
							<div class="image <?= $i++ > 0 ? 'hidden' : "" ?>">
								<a class="lightbox image_gallery_scroll_image sample_image_<?=$underpath?>" title="<?= $image['title'] ?>" rel="shadowbox[<?=$underpath?>]" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/cached/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>">
										<img border="0" <?= $i-1 > 0 ? "alt" : "src" ?>="/images/galleries/cached/<?= $path ?>/<?= $image['product_image_id'] ?>/<?= $size ?>.<?=$image['file_ext'] ?>" id="image_gallery_<?=$underpath?>"/>
									</a>
								<br/>
								<a class="lightbox image_gallery_scroll_image sample_image_<?=$underpath?>" title="<?= $image['title'] ?>" rel="shadowbox[<?=$underpath?>]" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/cached/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>">+ View Larger</a>
							</div>
							<? } ?>
					</div>
			
			<?  } ?>
			</div>
		<? $i++; } ?>
		</div>
		</div>

	</div>
</div>
