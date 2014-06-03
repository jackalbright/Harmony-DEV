<?
$imgw = $large ? 228 : 114;
$imgh = $large ? 224 : 112;
$textw = $large ? 228 : 114;
$texth = $large ? 160 : 80;
$perw = $large ? 228 : 114;
$perh = $large ? 86 : 43;
?>

<tr>
	<td valign=top colspan=3>
		<img src="<?= $path ?>/top.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=1 rowspan=1>
		<img src="<?= $path ?>/image_left.png"/>
	</td>
	<td valign=top colspan=1 style="background-color: white; height: <?=$imgh?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/image.png'); ">
		<? product_preview_image($image, null, $imgw, $imgh); ?>
	</td>
	<td valign=top colspan=1 rowspan=1>
		<img src="<?= $path ?>/image_right.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=3 rowspan=1>
		<img src="<?= $path ?>/center.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/text_left.png"/>
	</td>
	<td valign=top colspan=1 style="background-color: white; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/text.png'); ">
		<div style="height: <?=$texth?>px; width: <?=$textw-6?>px; padding: 3px; overflow: hidden;">
		<? product_preview_text(true); ?>
		</div>
	</td>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/text_right.png"/>
	</td>
</tr>

<tr>
	<td valign=top colspan=1 style="vertical-align: top; text-align: center; height: <?=$perh?>px; background-image: url('<?= $path ?>/personalization.png'); ">
		<div style="padding: 2px; width: <?=$perw-4?>px; height: <?=$perh-4?>px; overflow: hidden;">
		<? product_preview_personalization(); ?>
		</div>
		
	</td>
</tr>
<tr>
	<td valign=top colspan=3>
		<img src="<?= $path ?>/bottom.png"/>
	</td>
</tr>
