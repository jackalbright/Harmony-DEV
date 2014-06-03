<?
$defaultBorderID = isset($build['options']['borderID']) ? $build['options']['borderID'] : 2; # blank, yet set, means 'no border'
?>
<div align="left"> <a href="Javascript:void(0);" onClick="showBuildStepNext('<?= $option_code ?>');"><img src="/images/buttons/small/Next-green.gif"></a> </div>
<div class="clear" style="height: 400px; width: 400px; overflow: scroll;">
		<div class="medium_padded center" style="width: 100px; height: 60px; float: left; padding-top: 15px;">
				<label for="border_none">
				<img src="/borders/blank.gif" class="" alt="no border"/>
				<nobr><input id="border_none" type="radio" <?= !$defaultBorderID ? "checked='checked'" : "" ?> name="data[options][borderID]" value="" onClick="updateBuild('border');"/>No Border</nobr>
				</label>
		</div>

		<? $img_borders = $image->listBorders(); 
		$found = array();
		if(count($img_borders))
		{
			foreach($img_borders as $record) { 
				$found[$record->id] = true;
			?>
				<div class="medium_padded center" style="width: 100px; height: 60px; float: left; padding-top: 15px;">
				<label for="border_<?= $record->id ?>">
				<img src="<?=$record->image ?>" onClick="$('border_<?= $record->id ?>').checked = 1;"/>
				<nobr><input id="border_<?= $record->id ?>" type="radio" <?= $defaultBorderID == $record->border_id ? "checked='checked'" : "" ?>  name="data[options][borderID]" onClick="updateBuild('border');" value="<?= $record->id ?>"/><?= ucwords($record->name); ?></nobr>
				</label>
				</div>
			<? }
		} 

		foreach($borders as $record) {
				if (!empty($found[$record->border_id])) { continue; }
				?>
				<div class="medium_padded center" style="width: 100px; height: 60px; float: left; padding-top: 15px;">
				<label for="border_<?= $record->border_id ?>">
				<img src="<?=$record->location ?>" onClick="$('border_<?= $record->border_id ?>').checked = 1;"/>
				<nobr><input id="border_<?= $record->border_id ?>" type="radio" <?= $defaultBorderID == $record->border_id ? "checked='checked'" : "" ?> name="data[options][borderID]" onClick="updateBuild('border');" value="<?= $record->border_id ?>"/><?= ucwords($record->name); ?></nobr>
				</label>
				</div>
		<? } ?>

</div>

<div style="clear: both;">
<p>Tip: A border helps anchor your design.</p>
</div>


