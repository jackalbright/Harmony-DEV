<?
if (empty($id)) { $id = ''; }
if (empty($path)) { $path = ''; }
if (empty($width)) { $width = 200; }
$prefix = "/images/galleries";
if (empty($model_key)) { $id = 'id'; }
if (empty($model)) { $model = 'SampleImage'; }
$file_count = count($sample_images);

?>
<div id="sample_gallery_left_<?= $id ?>" class="sample_gallery sample_gallery_left">
	<? if (!empty($title)) { ?>
	<h4><?= $title ?></h4>
	<? } ?>
	<div id="sample_gallery_left_<?= $id ?>_row">
	<?
	$i = 0;
	foreach($sample_images as $image) # can be just filenames!
	{
		$title = "";
		$image_path = $image;
		if(is_array($image))
		{
			$title = $image[$model]['title'];
			$image_path = "$prefix/$path/".$image[$model][$model_key].".".$image[$model]['file_ext'];
		}
	?>
		<div class="image <?= $i++ > 0 ? 'hidden' : "" ?>">
			<a class="image_<?= $id ?>" title="<?= $title ?>" rel="shadowbox[<?= $id ?>]" id="" href="<?= $image_path ?>">
				<img width="<?= $width ?>" src="<?= $image_path ?>" id="">
			</a>
			<br/>
			<a class="" rel="shadowbox[<?= $id ?>]" id="" href="<?= $image_path ?>">+ View Larger</a>
		</div>
	<?
	}
	?>
	</div>
	<table width="100%">
	<tr>
		<td align="right">
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_left('sample_gallery_left_<?=$id?>');"><img src="/images/buttons/Circle-left.gif"/></a>
		</td>
		<td align="center" width="100"><span id="sample_gallery_left_<?=$id?>_counter">1</span> of <?= $file_count ?></td>
		<td align="left">
			<a href="Javascript:void(0)" onClick="return image_gallery_scroll_right('sample_gallery_left_<?=$id?>');"><img src="/images/buttons/Circle-right.gif"/></a>
		</td>
	</tr>
	<? if(!empty($album_link)) { ?>
	<tr>
		<td colspan=3 align="center">
			<a rel="shadowbox[width=500;height=400]" href="<?= $album_link ?>">+ Show All</a>
		</td>
	</tr>
	<? } ?>
	</table>
</div>
