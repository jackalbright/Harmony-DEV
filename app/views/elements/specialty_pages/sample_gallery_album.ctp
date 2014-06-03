<?
if (!isset($specialtyPageSampleImages) && isset($specialtyPage['SpecialtyPageSampleImages']))
{
	$specialtyPageSampleImages = $specialtyPage['SpecialtyPageSampleImages'];
}
if (isset($specialtyPage['SpecialtyPage']))
{
	$specialtyPage = $specialtyPage['SpecialtyPage'];
}

$path = "specialties/".$specialtyPage['page_url'];

if (!isset($gallery_title)) { $gallery_title = 'Sample Gallery'; }
$pathclass = "image_gallery_" . preg_replace("/\//", "_", $path);

#error_log("P=$path");

#print_r($specialtyPage);
$file_count = count($specialtyPageSampleImages);

if ($file_count > 0)
{
	$underpath = preg_replace("/\W+/", "_", $path);
?>
	<table width="100%" class="image_gallery_scroll_table">
	<tr>
		<td>&nbsp; </td>
		<td colspan=1>
			<h3>Sample Gallery</h3>
		</td>
		<td>&nbsp; </td>
	</tr>
	<tr>
		<td>
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_left('image_gallery_scroll');"><img src="/images/buttons/Circle-left.gif"/></a>
		</td>
		<td align=center>
			<div class="right_align">Click on an image to view larger</div>
			<div id="image_gallery_scroll_container_full">
			<table id="image_gallery_scroll_table" class="image_gallery_scroll <?= $pathclass ?>" style="" cellpadding=0 cellspacing=0>
			<tr id="image_gallery_scroll_row">
				<? 
				$i = 0;
				foreach($specialtyPageSampleImages as $image) 
				{ 
					#$hidden = $i++ > 0 ? "hidden" : "";
					$hidden = "";
					#
				?>
				<td class="image">
						<a class="lightbox image_gallery_scroll_image sample_image_<?=$underpath?>" title="<?= $image['title'] ?>" rel="shadowbox[<?=$underpath?>]" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/<?= $path ?>/<?= $image['specialty_page_image_id'] ?>.<?=$image['file_ext'] ?>">
							<img border="0" src="/images/galleries/<?= $path ?>/display/<?= $image['specialty_page_image_id'] ?>.<?=$image['file_ext'] ?>" id="image_gallery_<?=$underpath?>"/></a>
				</td>
				<?
				}
				?>
			</tr>
			</table>
			</div>
		</td>
		<td>
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_right('image_gallery_scroll');"><img src="/images/buttons/Circle-right.gif"/></a>
		</td>
	</tr>
	</table>

<?
}
?>
