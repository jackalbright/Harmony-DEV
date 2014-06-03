<?
$imgw = $large ? 378 : 95;
$imgh = $large ? 269 : 97;
$texth = $large ? 243 : 61;

?>
<tr>
	<td valign=top colspan=3>
		<img src="<?= $path ?>/top.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=1 rowspan=3>
		<img src="<?= $path ?>/image_left.png"/>
	</td>
	<td valign=top colspan=1 rowspan=1 style="background-color: white; height: <?=$imgh?>px; width: <?=$imgw?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/image.png'); ">
		<? product_preview_image($image, null, $imgw, $imgh); ?>
	</td>
	<td valign=top colspan=1 rowspan=3>
		<img src="<?= $path ?>/image_right.png"/>
	</td>
</tr>

<tr>
	<td valign=top colspan=1 rowspan=1 style="background-color: white; vertical-align: center; text-align: center; height: <?=$texth?>px; background-image: url('<?= $path ?>/text.png'); ">
		<img src="<?=$path?>/text.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=1 style="vertical-align: top; text-align: center; background-image: url('<?= $path ?>/personalization.png'); ">
		<img src="<?=$path?>/personalization.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=3>
		<img src="<?= $path ?>/bottom.png"/>
	</td>
</tr>
