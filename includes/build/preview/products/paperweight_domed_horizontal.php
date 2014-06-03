<?
$imgw = $large ? 400 : 100;
$imgh = $large ? 384 : 96;
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
	<td valign=top colspan=1 style="background-color: white; height: <?=$imgh?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/image.png'); ">
		<? product_preview_image($image, null, $imgw, $imgh); ?>
	</td>
	<td valign=top colspan=1 rowspan=2>
		<img src="<?= $path ?>/image_right.png"/>
	</td>
</tr>

<tr>
	<td valign=top colspan=1 style="vertical-align: top; text-align: center; background-image: url('<?= $path ?>/personalization.png'); ">
		<? product_preview_personalization(); ?>
		
	</td>
</tr>
<tr>
	<td valign=top colspan=3>
		<img src="<?= $path ?>/bottom.png"/>
	</td>
</tr>
