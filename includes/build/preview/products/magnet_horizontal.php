<?
$imgh = $large ? 228 : 114;
$imgw = $large ? 200 : 100;
$textw = $large ? 224 : 112;
$texth = $large ? 274 : 137;
$perw = $large ? 200 : 100;
$perh = $large ? 56 : 28;

?>
<tr>
	<td valign=top colspan=4>
		<img src="<?= $path ?>/top.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/image_left.png"/>
	</td>
	<td valign=top colspan=1 style="background-color: white; width: <?=$imgw?>px; height: <?=$imgh?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/image.png'); ">
		<? product_preview_image($image, null, $imgw, $imgh); ?>
	</td>
	<td valign=top colspan=1 rowspan=2 style="background-color: white; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/text.png'); ">
		<div style="width: <?=$textw-6?>px; height: <?=$texth?>px; padding: 3px; overflow: hidden;">
		<? product_preview_text(true); ?>
		</div>
	</td>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/text_right.png"/>
	</td>
</tr>

<tr>
	<td valign=top colspan=1 style="vertical-align: top; text-align: center; background-image: url('<?= $path ?>/personalization.png'); ">
		<div style="padding: 2px; width: <?=$perw-4?>px; height: <?=$perh-4?>px; overflow: hidden;">
		<? product_preview_personalization(); ?>
		</div>
		
	</td>
</tr>
<tr>
	<td valign=top colspan=4>
		<img src="<?= $path ?>/bottom.png"/>
	</td>
</tr>
