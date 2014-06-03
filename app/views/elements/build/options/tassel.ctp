<?
$defaultTasselID = isset($build['options']['tasselID']) ? $build['options']['tasselID'] : 41; # blank, yet set, means 'no tassel'
?>

				
<div class="" style="position: relative;">
		<div class="relative">

		<script>
		document.observe('dom:loaded', function() {
			window.tassels = {};
			<? foreach($tassels as $tassel) { ?>
			window.tassels['tassel_image_<?= $tassel->tassel_id ?>'] = "/tassels/thumbs/<?= preg_replace("/ /", "-", $tassel->color_name) ?>.gif";
			<? } ?>
		});
		</script>

		<div class="padded center" style="float: left; width: 85px; height: 48px;"
				onClick="selectTassel('-1'); ">
				<div class="tassel_div" id="tassel_div_-1" style="background: url(/images/icons/no-tassel-box.png) no-repeat;">&nbsp;
				</div>
				<input id="tassel_-1" type="radio" style="display: none;" <?= ($defaultTasselID == -1 || !$defaultTasselID) ? "checked='checked'" : "" ?> name="data[options][tasselID]" value="-1"/>
				No tassel
		</div>

		<? 
		$tassels_found = array();

		$img_tassels = !empty($image) ? $image->listTassels() : array();
		if(count($img_tassels)) {
		?>
		<?php
			foreach ($img_tassels as $record) {
				$tassel_code = preg_replace("/ /", "-", $record->name);
				$tassels_found[$tassel_code] = true;
				?>
				<div class="padded center" style="float: left; width: 85px; height: 48px;"
					onClick="selectTassel('<?= $record->id ?>');">
					<div class="tassel_div" id="tassel_div_<?= $record->id ?>" style="background-color: #<?= $record->color ?>; ">&nbsp;</div>
				<!--<img id="tassel_image_<?= $record->id ?>" src="" alt="Loading..." onClick="$('tassel_<?=$record->id?>').checked='checked'; check_charm(); updateBuild('tassel');"/>-->
				<nobr><input style="display: none;" id="tassel_<?= $record->id ?>" type="radio" name="data[options][tasselID]" <?= $defaultTasselID == $record->id ? "checked='checked'" : "" ?> value="<?= $record->id ?>"/>
					<?= ucwords($record->name); ?>
				</nobr>
				</div>
				<?
			}
		}

			foreach ($tassels as $record) {
				$tassel_code = preg_replace("/ /", "-", $record->color_name);
				if (!empty($tassels_found[$tassel_code])) { continue; }
				?>
				<div class="padded center" style="float: left; width: 85px; height: 48px;"
					onClick="selectTassel('<?= $record->tassel_id ?>');" >

				<div class="tassel_div" id="tassel_div_<?= $record->tassel_id ?>" style="background-color: #<?= $record->color_code ?>;">&nbsp;</div>
				<!--<img id="tassel_image_<?= $record->tassel_id ?>" src="" alt="Loading..." onClick="$('tassel_<?=$record->tassel_id?>').checked='checked'; check_charm(); updateBuild('tassel');"/>-->
				<nobr><input style="display: none;" type="radio" id="tassel_<?= $record->tassel_id ?>" <?= $defaultTasselID == $record->tassel_id ? "checked='checked'" : "" ?> name="data[options][tasselID]" value="<?= $record->tassel_id ?>" 
				/> <?= ucwords($record->color_name); ?></nobr>

				</div>
				<?
			}
			?>

		</div>
		<div class="clear"></div>

		<style>
		div.tassel_div
		{
			cursor: pointer;
			border: solid 1px #CCC;
			width: 24px;
			height: 24px;
			margin: 2px auto;
		}

		div.selected_tassel
		{
			border: solid #333 4px;
		}
		</style>

		<script>
		var prod = $('prod').value;
		var tassel_codes = [];
		<? foreach($tassels as $tassel) { ?>
		tassel_codes['<?= $tassel->tassel_id ?>'] = '<?= preg_replace("/ /", "-", $tassel->color_name); ?>';
		<? } ?>

		function selectTassel(id,load) // we still need for form items/icons to interact.
		{
			j('#step_tassel').trigger('showPart', [id,load]);
		}

		j('#step_tassel').bind('showPart', function (e, tassel_id, load)
		{
			//if(typeof console != 'undefined') { console.log("TASSEL SHOWPART="+tassel_id+", ONLOAD="+load); }
			if(!tassel_id) { tassel_id = j('input[name=data\\[options\\]\\[tasselID\\]][checked]').val(); }

			//console.log(tassel_id);

			if(tassel_id == '-1')
			{
				//console.log("SETTING BNT");
				setProduct('BNT','tassel'); 
			} else if (prod == 'BNT') { 
				//console.log("SETTING B");
				setProduct('B','tassel');
			}

			check_charm();
			j('#tassel_'+tassel_id).attr('checked','checked');
			if(parseInt(tassel_id) == -1)
			{
				if(typeof console != 'undefined') { console.log("CLEARING CHARM"); }
				j('#step_charm').trigger('showPart', ['-1',load]);
				//j('#charm_-1').attr('checked','checked');
			}

			var tassel_code = tassel_codes[tassel_id];
			if(tassel_code)
			{
				var tassel_path = "/tassels/blanks/medium/"+tassel_code+".png";
				setPart('tassel', tassel_path,load);
			} else {
				setPart('tassel', '',load);
				setPart('charm', '',load);
			}

			j('#livepreview .tassel').prop('src', tassel_path);

			j('.tassel_div').removeClass("selected_tassel");
			j('#tassel_div_'+tassel_id).addClass("selected_tassel");

			//update_build_review(); 
			//update_build_pricing(); 
		});

		j(document).ready(function() { Shadowbox.close(); 
			showPleaseWait('tassel');
		<? if(!empty($defaultTasselID)) { ?>
			selectTassel('<?= $defaultTasselID ?>', true);
		<? } ?>
		
		});
		</script>
</div>

