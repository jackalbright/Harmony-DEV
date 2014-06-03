<div>
	<div class="bold"><?= $title ?>:</div>
	<form method="POST" enctype="multipart/form-data" action="<?= $url ?>">
		<? if (isset($scalewidth)) { ?>
		<input type="hidden" name="data[<?= $name ?>][scalewidth]" value="<?= $scalewidth ?>"/>
		<? } ?>
		<? if (isset($scaleheight)) { ?>
		<input type="hidden" name="data[<?= $name ?>][scaleheight]" value="<?= $scaleheight ?>"/>
		<? } ?>
		<? if (isset($no_scale)) { ?>
		<input type="hidden" name="data[<?= $name ?>][no_scale]" value="<?= $no_scale ?>"/>
		<? } ?>
		<img src="<?= $imgfolder ?>/<?= $imgfile ?>"/>
		<br/>
		<? if(isset($caption)) { ?><?= $caption ?><br/><? } ?>
		<input type="file" name="data[<?= $name ?>][file]"/>
		<input type="submit" value='Upload'/>
	</form>
</div>
