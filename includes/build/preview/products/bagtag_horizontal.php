<?
$imagew = $large ? 200 : 50;
$imageh = $large ? 220 : 55;

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
		<img src="<?= $path ?>/text.png"/>
		<? product_preview_text(true); ?>
	</td>
	<td valign=top colspan=1 style="background-color: white; height: <?= $imageh ?>px; width: <?= $imagew ?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/image.png'); ">
		<? product_preview_image($image, null, $imagew, $imageh); ?>
	</td>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/image_right.png"/>
	</td>
</tr>

<tr>
	<td valign=top colspan=2 style="vertical-align: top; text-align: left;">
		<img src="<?= $path ?>/personalization.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=4>
		<img src="<?= $path ?>/bottom.png"/>
	</td>
</tr>
