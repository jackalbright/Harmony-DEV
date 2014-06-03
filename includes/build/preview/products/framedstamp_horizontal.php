<?
$imagew = $large ? 216 : 108;
$imageh = $large ? 250 : 125;

?>
<tr>
	<td valign=top colspan=4>
		<img src="<?= $path ?>/top.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/text_left.png"/>
	</td>
	<td valign=top colspan=1 rowspan=1 style="background-color: white; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/text.png'); ">
		<img src="<?=$path?>/text.png"/>
	</td>
	<td valign=top colspan=1 rowspan=2 style="background-color: white; height: <?=$imageh?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/image.png'); ">
		<? product_preview_image($image, null, $imagew, $imageh); ?>
	</td>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/image_right.png"/>
	</td>
</tr>

<tr>
	<td valign=top colspan=1 style="vertical-align: top; text-align: center; background-image: url('<?= $path ?>/personalization.png'); ">
		<img src="<?=$path?>/personalization.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=4>
		<img src="<?= $path ?>/bottom.png"/>
	</td>
</tr>
