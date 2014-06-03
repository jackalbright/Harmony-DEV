<?
$defaultRibbonID = !empty($build['options']['ribbonID']) ? $build['options']['ribbonID'] : 1;
?>
<div class="heigth: 400px; width: 400px; overflow: scroll;">
		<div>
		<? 
		$ribbons_found = array();

		$img_ribbons = !empty($image) ? $image->listRibbons() : array();
		if(count($img_ribbons)) {
		?>
		<?php
			foreach ($img_ribbons as $record) {
				$ribbon_code = preg_replace("/ /", "-", $record->name);
				$ribbons_found[$ribbon_code] = true;
				?>
				<div class="left padded center" style="float: left; width: 80px;">
				<label for="ribbon_<?= $record->id ?>">
					<img src="/ribbons/<?= $ribbon_code ?>.png" height="50"/>
					<br/>
					<nobr><input type="radio" <?= $defaultRibbonID == $record->id ? "checked='checked'" : "" ?> id="ribbon_<?= $record->id ?>" value="<?= $record->id ?>" name="data[options][ribbonID]" onClick="chooseRibbon(this.value);"><?= ucwords($record->name); ?></nobr>
				</label>
				</div>
				<?
			}
		}

			foreach ($ribbons as $record) {
				$ribbon_code = preg_replace("/ /", "-", $record->color_name);
				if (!empty($ribbons_found[$ribbon_code])) { continue; }
				?>
				<div class="left padded center" style="float: left; width: 80px;">
				<label for="ribbon_<?= $record->ribbon_id ?>">
					<img src="/ribbons/<?= $ribbon_code ?>.png" height="50"/>
					<br/>
					<nobr><input type="radio" <?= $defaultRibbonID == $record->ribbon_id ? "checked='checked'" : "" ?> id="ribbon_<?= $record->ribbon_id ?>" value="<?= $record->ribbon_id ?>" name="data[options][ribbonID]" onClick="chooseRibbon(this.value);"><?= ucwords($record->color_name); ?></nobr>
				</label>
				</div>
				<?
			}
			?>

		</div>
		<script>
		var ribbon_urls = [];
		<? foreach($ribbons as $rib)  { ?>
		ribbon_urls['<?= $rib->ribbon_id ?>'] = '<?= "/ribbons/blanks/{$build['Product']['code']}/medium/". preg_replace("/ /", "-", $rib->color_name).".gif"; ?>';
		<? } ?>

		function chooseRibbon(ribbon_id,onLoad)
		{
			var ribbon_url = ribbon_urls[ribbon_id];
			setPart('ribbon', ribbon_url,onLoad);
		}

		j('#step_ribbon').bind('showPart', function (e, ribbon_id, load)
		{
			if(!ribbon_id) { ribbon_id = j('input[name=data\\[options\\]\\[ribbonID\\]][checked]').val(); }

			chooseRibbon(ribbon_id,load);
		});

		j(document).ready(function() {
		<? if(!empty($defaultRibbonID)) { ?>
			showPleaseWait('ribbon');
			chooseRibbon('<?= $defaultRibbonID ?>',true);
		<? } ?>
		});


		
		</script>
</div>
<div class="clear"></div>

