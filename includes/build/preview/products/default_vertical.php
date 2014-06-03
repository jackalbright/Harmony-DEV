<?
$imageh = $large ? 200 : 100;

?>
<tr>
	<td colspan=3>
		<img src="<?= $path ?>/top.gif"/>
	</td>
</tr>
<tr>
	<td colspan=1 rowspan=3>
		<img src="<?= $path ?>/left.gif"/>
	</td>
	<td colspan=1 style="background-color: white; height: <?=$imageh?>px; vertical-align: middle; text-align: center; background-image: url('<?= $path ?>/center.gif'); ">
		<? product_preview_image($image, null, $imageh); ?>
	</td>
	<td colspan=1 rowspan=3>
		<img src="<?= $path ?>/right.gif"/>
	</td>
</tr>
<tr>
	<td colspan=1>
		<? product_preview_text(); ?>
	</td>
</tr>
<tr>
	<td colspan=1>
		<? product_preview_personalization(); ?>
	</td>
</tr>
<tr>
	<td colspan=3>
		<img src="<?= $path ?>/bottom.gif"/>
	</td>
</tr>
