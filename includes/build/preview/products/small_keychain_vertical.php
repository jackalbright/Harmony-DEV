<?
$imgw = $large ? 200 : 100;
$imgh = $large ? 276 : 138;
$textw = $large ? 210 : 105;
$texth = $large ? 196 : 98;
$perh = $large ? 56 : 28;
$perw = $large ? 192 : 96;
?>
<tr>
	<td valign=top colspan=5>
		<img src="<?= $path ?>/top.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/image_left.png"/>
	</td>
	<td valign=top colspan=1 rowspan=2 style="background-color: white; width: <?=$imgw?>px; height: <?=$imgh?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/image.png'); ">
		<? product_preview_image($image, null, $imgw, $imgh); ?>
	</td>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/center.png"/>
	</td>
	<td valign=top colspan=1 rowspan=1 style="background-color: white; vertical-align: center; text-align: center; background-image: url('<?= $path ?>/text.png'); ">
		<div style="height: <?=$texth?>px; padding: 2px; width: <?=$textw-4?>px; overflow: hidden;">
		<? product_preview_text(true); ?>
		</div>
	</td>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/text_right.png"/>
	</td>
</tr>

<tr>
	<td valign=top colspan=1 style="vertical-align: top; text-align: center; background-image: url('<?= $path ?>/personalization.png'); ">
		<div style="padding: 2px; height: <?=$perh?>px; overflow: hidden; width: <?=$perw?>px;">
		<? product_preview_personalization(); ?>
		</div>
	</td>
</tr>
<tr>
	<td valign=top colspan=5>
		<img src="<?= $path ?>/bottom.png"/>
	</td>
</tr>
