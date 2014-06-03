<div class="clear">
	<select name="data[options][crystalType]" onChange="updateBuild('<?=$i?>');" onChangeX="update_build_pricing();">
		<option <?= (empty($build['options']['crystalType']) || $build['options']['crystalType'] == 'glass') ? "selected='selected'" : "" ?> value="">Glass Crystal (Free/included)</option>
		<option <?= (!empty($build['options']['crystalType']) && $build['options']['crystalType'] == 'lead') ? "selected='selected'" : "" ?> value="yes">French Lead Crystal (+$10.00 ea)</option>
	</select>
</div>
