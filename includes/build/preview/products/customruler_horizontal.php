<?
$imagew = $large ? 276 : 138;
$imageh = $large ? 200 : 100;
$textw = $large ? 684 : 342;
$texth = $large ? 200 : 100;
$perh = $large ? 200 : 100;
$perw = $large ? 444 : 222;

?>

<tr>
	<? if ($large) { ?><td valign=top colspan=3><img src="<?= $path ?>/top_left.png"/></td><? } ?>
	<td valign=top colspan=3>
		<img src="<?= $path ?>/top_right.png"/>
	</td>
</tr>
<tr>
	<? if ($large) { ?>
	<td valign=top><img src="<?= $path?>/text_left.png"/></td>
	<td valign=top colspan=1 style="background-color: white; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/text.png'); ">
		<div style="padding: 3px; height: <?=$texth-6?>px; width: <?=$textw-6?>px; overflow: hidden;">
		<? product_preview_text(); ?>
		</div>
	</td>
	<td valign=top colspan=1 style="padding: 3px; height: <?=$perh-6?>px; width: <?=$perw-6?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/personalization.png'); ">
		<div style="height: <?=$perh-6?>px; width: <?=$perw-6?>px; overflow: hidden;">
		<? product_preview_personalization(); ?>
		</div>
		
	<? } ?>
	<td valign=top colspan=1 rowspan=1>
		<img src="<?= $path ?>/center.png"/>
	</td>
	<td valign=top colspan=1 rowspan=1 style="background-color: white; width: <?=$imagew?>px; height: <?=$imageh?>px; vertical-align: top; text-align: center; background-image: url('<?= $path ?>/image.png'); ">
		<? product_preview_image($image, null, $imagew, $imageh); ?>
	</td>
	<td valign=top colspan=1 rowspan=1>
		<img src="<?= $path ?>/image_right.png"/>
	</td>
</tr>

<tr>
	<? if ($large) { ?><td valign=top colspan=3><img src="<?= $path ?>/bottom_left.png"/></td><? } ?>
	<td valign=top colspan=3>
		<img src="<?= $path ?>/bottom_right.png"/>
	</td>
</tr>
