<?
$imgh = $large ? 174 : 87;
$imgw = $large ? 234 : 117;
$perh = $large ? 77 : 39;
$perw = $large ? 234 : 117;
?>
<tr>
	<td valign=top colspan=3>
		<img src="<?= $path ?>/top.png"/>
	</td>
</tr>
<tr>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/image_left.png"/>
	</td>
	<td valign=top colspan=1 rowspan=1 style="background-color: white; height: <?=$imgh?>px; width: <?=$imgw?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/image.png'); ">
		<? product_preview_image($image, null, $imgw, $imgh); ?>
	</td>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/image_right.png"/>
	</td>
</tr>

<tr>
	<td valign=top colspan=1 style="vertical-align: top; text-align: center; height: <?=$perh?>px; background-image: url('<?= $path ?>/personalization.png'); ">
		<div style="padding: 2px; height: <?=$perh-4?>px; overflow: hidden; width: <?=$perw-4?>px;">
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
