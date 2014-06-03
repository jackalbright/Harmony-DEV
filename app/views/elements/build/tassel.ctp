<?
$defaultTasselID = isset($build['options']['tasselID']) ? $build['options']['tasselID'] : 41; # blank, yet set, means 'no tassel'
?>

<div align="left"> <a href="Javascript:void(0);" onClick="showBuildStepNext('<?= $option_code ?>');"><img src="/images/buttons/small/Next-green.gif"></a> </div>
<div class="" style="height: 400px; width: 400px; overflow: scroll;">
		<div>
		<script>
			function check_charm()
			{
				var tassel_none = $('tassel_none');
				if (!tassel_none) { return; } 
				// We don't have tassels for this product.
				var tassel_value = build_get_radio_option('tasselID');
				var charm_value = build_get_radio_option('charmID');
				if ((tassel_value == '-1' || !tassel_value) && charm_value != '')
				{
					// Maybe someday put in inline notification of?
					$('charm_none').checked = 'checked';
					return true;
				}
				return false;
			}
		</script>
		<div class="padded center" style="float: left; width: 85px;">
				<label for="tassel_none">
				<img src="/tassels/thumbs/no-tassel.gif" class="" alt="no tassel"/>
				<input id="tassel_none" type="radio" <?= ($defaultTasselID == -1 || !$defaultTasselID) ? "checked='checked'" : "" ?> name="data[options][tasselID]" value="-1" onClick="check_charm(); updateBuild('tassel');"/>None
				</label>
		</div>

		<? 
		$tassels_found = array();

		$img_tassels = $image->listTassels();
		if(count($img_tassels)) {
		?>
		<?php
			foreach ($img_tassels as $record) {
				$tassel_code = preg_replace("/ /", "-", $record->name);
				$tassels_found[$tassel_code] = true;
				?>
				<div class="padded center" style="float: left; width: 85px;">
				<label for="tassel_<?= $record->id ?>">
				<img src="/tassels/thumbs/<?= $tassel_code ?>.gif"/>
				<br/>
				<nobr><input id="tassel_<?= $record->id ?>" type="radio" name="data[options][tasselID]" <?= $defaultTasselID == $record->tassel_id ? "checked='checked'" : "" ?> value="<?= $record->id ?>" onClick="check_charm(); updateBuild('tassel');"/> <?= ucwords($record->name); ?></nobr>
				</label>
				</div>
				<?
			}
		}

			foreach ($tassels as $record) {
				$tassel_code = preg_replace("/ /", "-", $record->color_name);
				if (!empty($tassels_found[$tassel_code])) { continue; }
				?>
				<div class="padded center" style="float: left; width: 85px;">

				<label for="tassel_<?= $record->tassel_id ?>">
				<img src="/tassels/thumbs/<?= $tassel_code ?>.gif"/>
				<br/>
				<nobr><input type="radio" id="tassel_<?= $record->tassel_id ?>" <?= $defaultTasselID == $record->tassel_id ? "checked='checked'" : "" ?> name="data[options][tasselID]" value="<?= $record->tassel_id ?>" onClick="check_charm(); updateBuild('tassel');"/> <?= ucwords($record->color_name); ?></nobr>
				</label>

				</div>
				<?
			}
			?>

		</div>
</div>

