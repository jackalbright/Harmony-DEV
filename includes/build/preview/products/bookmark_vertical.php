<?
# .46 factor
# BUT! images aren't scaled.... we gotta change '$path' so it's appropriate to 'small' sized version.
$imgw = $large ? 424 : 106;
$imgh = $large ? 448 : 112;

?>
<tr>
	<td valign=top colspan=3>
		<img src="<?= $path ?>/top.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=1 rowspan=1>
		<img src="<?= $path ?>/border_left.png"/>
	</td>
	<td valign=top colspan=1 style="">
		<img src="<?= $path ?>/border.png"/>
	</td>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/tassel.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=1 rowspan=1>
		<img src="<?= $path ?>/image_left.png"/>
	</td>
	<td valign=top colspan=1 style="background-color: white; height: <?=$imgh?>px; width: <?=$imgw-20?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/image.png'); ">
		<? product_preview_image($image, null, $imgw-20, $imgh); ?>
	</td>
</tr>
<tr>
	<td valign=top colspan=1 rowspan=1>
		<img src="<?= $path ?>/text_left.png"/>
	</td>
	<td valign=top colspan=1 style="background-color: white; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/text.png'); ">
		<img src="<?= $path ?>/text.png"/>
	</td>
	<td valign=top colspan=1 rowspan=1>
		<img src="<?= $path ?>/text_right.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=1>
		<img src="<?= $path ?>/bottom_border_left.png"/>
	</td>
	<td valign=top colspan=1 style="width: <?=$borderw?>px;">
		<img width="<?=$borderw?>" src="<?= $path ?>/bottom_border.png"/>
	</td>
	<td valign=top colspan=1>
		<img src="<?= $path ?>/bottom_border_right.png"/>
	</td>
</tr>

<tr>
	<td valign=top colspan=1>
		<img src="<?= $path ?>/bottom_left.png"/>
	</td>
	<td valign=top colspan=1 style="height: <?=$perh?>px; width: <?=$perw?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/bottom.png'); ">
		<img src="<?=$path?>/bottom.png"/>
	</td>
	<td valign=top colspan=1>
		<img src="<?= $path ?>/bottom_right.png"/>
	</td>
</tr>
