<?
if (empty($class)) { $class = ""; }
if (empty($width)) { $width = 200; }
$id = "image_gallery";
?>

<div id="<?= $id ?>" class="<?= $class ?>" style="padding-bottom: 20px;">
<?
if (!isset($specialtyPageSampleImages) && isset($specialtyPage['SpecialtyPageSampleImages']))
{
	$specialtyPageSampleImages = $specialtyPage['SpecialtyPageSampleImages'];
}
#if (isset($specialtyPage['Product']))
#{
#	$specialtyPage = $specialtyPage['Product'];
#}

if (isset($specialtyPage['SpecialtyPage']))
{
	$specialtyPage = $specialtyPage['SpecialtyPage'];
}


$path = "specialties/".$specialtyPage['page_url'];
$gallery_title = ucwords($specialtyPage['body_title']) . " Gallery";
#if (!isset($gallery_title)) { $gallery_title = 'Sample Gallery'; }
$pathclass = "image_gallery_" . preg_replace("/\//", "_", $path);


#error_log("P=$path");

#print_r($specialtyPage);
$file_count = count($specialtyPageSampleImages);

if ($file_count > 0)
{
	$underpath = preg_replace("/\W+/", "_", $path);
?>
	<div style="padding-right: 10px;">
	<table style="width: 100%; " class="image_gallery ">
	<tr>
		<td align=center colspan=3>
			<h4><?= $gallery_title ?></h4>

			<div id="<?= $id ?>_row">
				<? 
				$i = 0;
				foreach($specialtyPageSampleImages as $image) 
				{ 
					#$hidden = $i++ > 0 ? "hidden" : "";
					$hidden = "";
					#
				?>
				<div class="image <?= $i++ > 0 ? 'hidden' : "" ?>">
				<a class="lightbox image_gallery_scroll_image sample_image_<?=$underpath?>" title="<?= $image['title'] ?>" rel="shadowbox[<?=$underpath?>]" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>">
					<img border="0" width="<?= $width ?>" src="/images/galleries/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>" id="image_gallery_<?=$underpath?>"/>
				</a>
				<br/>
				<a class="lightbox image_gallery_scroll_image sample_image_<?=$underpath?>" title="<?= $image['title'] ?>" rel="shadowbox[<?=$underpath?>]" id="image_gallery_largelink1_<?=$underpath?>" href="/images/galleries/<?= $path ?>/<?= $image['product_image_id'] ?>.<?=$image['file_ext'] ?>">+ View Larger</a>
				</div>
				<?
				}
				?>
			</div>
		</td>
	</tr>
	<tr>
		<td align="right">
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_left('<?=$id?>');"><img src="/images/buttons/Circle-left.gif"/></a>
		</td>
		<td width="100"><span id="<?=$id?>_counter">1</span> of <?= $file_count ?></td>
		<td align="left">
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_right('<?=$id?>');"><img src="/images/buttons/Circle-right.gif"/></a>
		</td>
	</tr>
	</table>
	</div>

<?
}
?>
</div>
