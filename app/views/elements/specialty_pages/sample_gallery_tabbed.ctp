<?
if(empty($size)) { $size = "250"; }
?>
<div>
		<div class="">
		<div id="gallery_type_sample" class="gallery_type">
		<div class="gallery_type_inner sample_gallery">
			<?
			$path = "specialties/".$specialtyPage['SpecialtyPage']['page_url'];
			$pathclass = "image_gallery_" . preg_replace("/\//", "_", $path);
			$id = "gallery_type_sample";
			
			$file_count = count($sample_images);
			
			if (!empty($sample_images))
			{
				$underpath = preg_replace("/\W+/", "_", $path);
			?>
				<div style="">
				<table style="width: 100%; " class="image_gallery " cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td colspan=3 class="gallery_type_tab selected bold">
						Sample Gallery
					</td>
				</tr>
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
							<?  $i = 0; foreach($sample_images as $image) { if(!empty($image['SpecialtyPageSampleImage'])) { $image = $image['SpecialtyPageSampleImage']; } ?>
							<div class="image <?= $i++ > 0 ? 'hidden' : "" ?>">
								<a class="lightbox image_gallery_scroll_image sample_image_<?=$underpath?>" title="<?= $image['title'] ?>" rel="shadowbox[<?=$underpath?>]" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/<?= $path ?>/<?= $image['specialty_page_image_id'] ?>.<?=$image['file_ext'] ?>">
										<img border="0" src="/images/galleries/cached/<?= $path ?>/<?= $image['specialty_page_image_id'] ?>/<?= $size ?>.<?=$image['file_ext'] ?>" id="image_gallery_<?=$underpath?>"/>
									</a>
								<br/>
								<a class="lightbox image_gallery_scroll_image sample_image_<?=$underpath?>" title="<?= $image['title'] ?>" rel="shadowbox[<?=$underpath?>]" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/<?= $path ?>/<?= $image['specialty_page_image_id'] ?>.<?=$image['file_ext'] ?>">+ View Larger</a>
							</div>
							<? } ?>
					</div>
			
			<?  } ?>
		</div>
		</div>


	</div>
</div>
