<?
$textw = $large ? 195 : 98;
$texth = $large ? 204 : 102;
$imgw = $large ? 200 : 100;
$imgh = $large ? 180 : 90;
$perw = $large ? 414 : 207;
$perh = $large ? 30 : 15;
?>
<tr>
	<td valign=top colspan=5>
		<img src="<?= $path ?>/top.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/text_left.png"/>
	</td>
	<td valign=top colspan=1 rowspan=1 style="background-color: white; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/text.png'); ">
		<div style="height: <?=$texth?>px; width: <?=$textw-6?>px; padding: 3px; overflow: hidden;">
		<? product_preview_text(true); ?>
		</div>
	</td>
	<td valign=top colspan=1 style="background-color: white; height: <?=$imgh?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/image.png'); ">
		<? product_preview_image($image, null, $imgw, $imgh); ?>
	</td>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/image_right.png"/>
	</td>
</tr>

<tr>
	<td valign=top colspan=2 style="vertical-align: top; text-align: right; background-image: url('<?= $path ?>/personalization.png'); ">
		<div style="padding: 1px; height: <?=$perh-2?>px; width: <?= $perw-2?>px; overflow: hidden;">
		<? product_preview_personalization(); ?>
		</div>
		
	</td>
</tr>
<tr>
	<td valign=top colspan=5>
		<img src="<?= $path ?>/bottom.png"/>
	</td>
</tr>
