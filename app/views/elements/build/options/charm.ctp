<?
$defaultCharmID = !empty($build['options']['charmID']) ? $build['options']['charmID'] : null;
?>
<? if($build['Product']['code'] == 'PW') { ?>
	<p class="note">Please Note: The small ring shown on the charms is removed before placement in your paperweight.</p>
<? } ?>

<div class="clear" XXXstyle="height: 350px; overflow: scroll;">

				<div class="thin_padded center" style="float: left; height: 70px;"
					onClick="selectCharm('-1');">

				<div class="charm_div <?= -1 == $defaultCharmID ? "selected_charm" : "" ?>" id="charm_div_-1">
					<img id="charm_image_-1" height="50" title="No charm" src="/images/icons/no-charm-box.png" alt="Loading..."/>
					<br/>
					<nobr><input id="charm_-1" style="display: none;" type="radio" name="data[options][charmID]" <?= empty($defaultCharmID) ? "checked='checked'" : "" ?> value="-1">
						No charm
					</nobr>
				</div>
				</div>

		<? 
		$img_charms = !empty($image) ? $image->listCharms() : array();
		if(count($img_charms))
		{
		?>
			<? 
			$found = array();
			foreach($img_charms as $record) {
				$found[$record->id] = true;
				?>
				<div class="thin_padded center" style="float: left; height: 70px;"
					onClick="selectCharm('<?= $record->id ?>'); ">

				<div class="charm_div <?= $record->id == $defaultCharmID ? "selected_charm" : "" ?>" id="charm_div_<?= $record->id ?>">
					<img id="charm_image_<?= $record->id ?>" height="50" title="<?= ucwords($record->name) ?>" src="<?= $record->image ?>" alt="Loading..."/>
					<br/>
					<nobr><input id="charm_<?= $record->id ?>" style="display: none;" type="radio" name="data[options][charmID]" <?= $defaultCharmID == $record->id ? "checked='checked'" : "" ?> value="<?= $record->id ?>" 
					/><?= ucwords($record->name); ?></nobr>
				</div>
				</div>
			<? } ?>
		<? } ?>
			<?
			foreach($charms as $record) {
				if(!empty($found[$record->charm_id]) || (empty($record->popular) && $record->charm_id != $defaultCharmID)) { continue; }
				?>
				<div class="thin_padded center" style="float: left; height: 70px;" onClick="selectCharm('<?= $record->charm_id ?>'); ">
				<div class="charm_div <?= $record->charm_id == $defaultCharmID ? "selected_charm" : "" ?>" id="charm_div_<?= $record->charm_id ?>">
					<img height="50" title="<?= ucwords($record->name) ?>" id="charm_image_<?= $record->charm_id ?>" src="<?= $record->graphic_location ?>" alt="Loading..." />
					<br/>
					<nobr><input style="display: none;" id="charm_<?= $record->charm_id ?>" type="radio" name="data[options][charmID]" <?= $defaultCharmID == $record->charm_id ? "checked='checked'" : "" ?> value="<?= $record->charm_id ?>" 
					/><?= ucwords($record->name); ?></nobr>
				</div>
				</div>
			<? } ?>

			<div class="clear"></div>
			<div align="right">
				<a id='charms_all' href="/build/charms" rel="shadowbox;type=html;width=600;height=400">View all (<?=count($charms); ?>)</a>
			</div>

		<style>
		div.charm_div
		{
			border: solid #FFFFEE 4px;
			float: left;
			cursor: pointer;
			margin: 2px auto;
		}

		div.selected_charm
		{
			border: solid #66CC66 4px;
		}
		</style>

		<script>
		var charm_codes = [];
		<? foreach($charms as $charm) { ?>
		charm_codes['<?= $charm->charm_id ?>'] = '<?= $charm->charm_code ?>';
		<? } ?>

		function selectCharm(id, load)
		{
			j('#step_charm').trigger('showPart', [id, load]);
		}

		j('#step_charm').bind('showPart', function (e, charm_id,load)
		{
			//if(typeof console != 'undefined') { console.log("SHOW_CHARM="+charm_id+", ONLOAD="+load); }
			if(charm_id === '') // resetting to none.
			{
				charm_id = '-1';
			}

			if(!charm_id) { charm_id = j('input[name=data\\[options\\]\\[charmID\\]][checked]').val(); }; 
			if(charm_id == '-1')
			{
				if (prod == 'BC') 
				{
					setProduct('B','charm');
				}
			}
			var prod =$('prod').value;
			var template =$('template').value;

			j('#charm_'+charm_id).attr('checked','checked');

			j('.charm_div').removeClass("selected_charm");
			j('#charm_div_'+charm_id).addClass("selected_charm");

			var tassel_id = parseInt(j('input[name=data\\[options\\]\\[charmID\\]][checked]').val()); 
			if(!tassel_id || tassel_id == -1)
			{
				j('#step_tassel').trigger('showPart', ['41',load]);
			}


			check_tassel(); 
			//updateBuild('charm'); 
			//update_build_review(); 
			//update_build_pricing(); 

			// TODO bookmark vs paperweight path.
			var charm_code = charm_codes[charm_id];
			if(charm_code)
			{
				var charm_path = prod == 'PW' ? 
					"/charms/blanks/medium/"+charm_code+".gif" :
					"/charms/blanks-B/medium/"+charm_code+".gif";
				setPart('charm', charm_path,load);
			} else {
				setPart('charm', '',load);
			}

			if(template == 'standard' && prod == 'PW')
			{
				// Immediately hide text. So no overlap seen until reloaded.
				clearPart('quote');
				clearPart('personalization');
				showText();
			}

			if(charm_id == -1 && prod == 'BC')
			{
				//alert("no charm");
				setProduct('B');
			} else if (charm_id > 0 && (prod == 'B' || prod == 'BB' || prod == 'BNT')) {
				//alert("yes charm");
				setProduct('BC','charm');
			}
		});

		j(document).ready(function() { Shadowbox.close(); 
			showPleaseWait('charm');
		<? if(!empty($defaultCharmID)) { ?>
			//selectCharm('<?= $defaultCharmID ?>',true);
			j('#step_charm').trigger('showPart', ['<?=$defaultCharmID ?>',true]);
		<? } else { ?>
			j('#step_charm').trigger('showPart', [-1,true]);
		<? } ?>
		});


		function chooseCharm(charm_id)
		{
			//alert(j('#part_settings_charm').size());
			j('#part_settings_charm').load("/build/charms", { data: { charm_id: charm_id } }, function() { });
		}

		<? 
		error_log("BP=".$build['Product']['code']);
		?>

		<? if(!empty($reload)) { # Once reloaded from popup chosen ?>
		check_tassel(); 
		j('#step_charm').trigger('showPart', ['<?= $defaultCharmID ?>']);
		Shadowbox.setup('#charms_all');

		//updateBuild('charm'); 
		//update_build_review(); 
		//update_build_pricing(); 
		<?#= in_array($build['Product']['code'],array('BC')) ? "setProduct('B','charm');":""  ?>
		<? } ?>
		</script>



</div>
<div class="clear"></div>

