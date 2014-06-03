<?
$imgh = $large ? 214 : 107;
$imgw = $large ? 178 : 139;
$textw = $large ? 278 : 138;
$texth = $large ? 140 : 70;
$perh = $large ? 32 : 16;
$perw = $large ? 266 : 133;

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
	<td valign=top colspan=1 style="background-color: white; width: <?=$textw?>px; height: <?=$texth?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/text.png'); ">
		<div style="padding: 3px; height: <?=$texth-6?>px; width: <?=$textw-6?>px; overflow: hidden;">
		<? product_preview_text(true); ?>
		</div>
	</td>
</tr>

<tr>
	<td valign=top colspan=1 style="vertical-align: top; text-align: center; height: 19px; background-image: url('<?= $path ?>/personalization.png'); ">
		<div style="padding: 2px; height: <?=$perh?>px; overflow: hidden; width: <?=$perw?>px;">
		<? product_preview_personalization(); ?>
		</div>
	</td>
</tr>

<tr>
	 <td valign=top style="" colspan=3>
		<img src="<?= $path ?>/bottom.png"/>
	</td>
</tr>

</tr>
