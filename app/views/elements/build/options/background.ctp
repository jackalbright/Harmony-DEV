<?
$defaultBackground = isset($build['options']['backgroundColor']) ? $build['options']['backgroundColor'] : (in_array($build["Product"]['code'], array('PZ','MP')) ? "#000000" : "#FFFFFF");
$defaultBackground = preg_replace("/^#/", "", $defaultBackground);
$defaultName = $backgroundColors[$defaultBackground];

?>

				
<div class="" style="position: relative;">
	<div class="bold">
		Selected Color: <span id="selectedColor"><?= $defaultName ?></span>
	</div>
		<div class="relative left">


		<table>
		<? $colorsPerRow = 7;
		$i = 0; foreach ($backgroundColors as $bg=>$name) { ?>
			<?= $i % $colorsPerRow == 0 ? "<tr>" : "" ?>
			<td>
			<div class="padded center" style="width: 30px; height: 30px;"
				onClick="selectBackground('<?= $bg ?>','<?= $name ?>');" >

			<div class="background_div" id="background_div_<?= $bg ?>">
				<div style="background-color: #<?= $bg ?>;">&nbsp;</div>
			</div>
			<input style="display: none;" id="background_<?= $bg ?>" type="radio" name="data[options][backgroundColor]" <?= $defaultBackground == $bg ? "checked='checked'" : "" ?> value="<?= $bg ?>"/>
			</div>
			</td>
			<?= $i+1 % $colorsPerRow == 0 || $i+1 == count($backgroundColors) ? "</tr>" : "" ?>
		<? $i++; } ?>
		</table>
		</div>

		<div class="left" style="max-width: 150px;">
		<div class="grey_border_top"><span></span></div>
		<div class='' style="padding: 5px; border: solid #CCC 1px; border-bottom: 0px; border-top: 0px;">
			<b>Please note:</b><br/>
			No background color will show if your picture is stretched to the edge.
		</div>
		<div class="grey_border_bottom"><span></span></div>
		</div>
		<div class="clear"></div>


		<style>
		div.background_div
		{
			cursor: pointer;
			padding: 2px;
		}
		div.background_div div
		{
			width: 26px;
			height: 24px;
			border: solid 1px #CCC;
		}

		div.selected_background
		{
			border: solid #333 2px;
		}

		div.selected_background div
		{
			width: 20px;
			height: 20px;
		}
		</style>

		<script>
		var prod = $('prod').value;

		function selectBackground(id,name,load) // we still need for form items/icons to interact.
		{
			j('#step_background').trigger('showPart', [id,name, load]);
		}

		j('#step_background').bind('showPart', function (e, background_id, name, load)
		{
			j('#selectedColor').html(name);
			//console.log("BACK="+background_id);
			//if(typeof console != 'undefined') { console.log("TASSEL SHOWPART="+background_id+", ONLOAD="+load); }
			if(!background_id) { background_id = j('input[name=data\\[options\\]\\[backgroundColor\\]][checked]').val(); }

			//console.log("BACK2="+background_id);

			//console.log(background_id);

			j('input[name=data\\[options\\]\\[backgroundColor\\]]').removeAttr('checked');

			j('#background_'+background_id).attr('checked','checked');

			j('#livepreview .background_color').css({backgroundColor: "#"+background_id}); // Load color.

			// IF color is dark, set (pers) font to white. otherwise, set font to black.
			var choseColor = '<?= isset($build['options']['personalizationColor']) ?>';

			var dark = (colorBrightness(background_id) <= 130);
			//console.log("BG COLOR DARK="+dark);

			if(!choseColor || !load) // on page re-load, don't set color from what they set it to.
			{
				var persColor = dark ? "persColorWhite" : "persColorBlack";
				j('#'+persColor).attr('checked','checked');
				// XXX problematic when initial product load w/black bg....unless we default pers color to white
			}
			//console.log("TRANSIMG_WHITE="+j('#transimg_white').size());

			if(j('#transimg_white').size())
			{
				//console.log("WHITE TRANS...");
				if(dark)
				{
					//console.log("SHOWING WHITE");
					j('#transimg_white').show();
					j('#transimg').hide();
				} else {
					//console.log("SHOWING DARK");
					j('#transimg_white').hide();
					j('#transimg').show();
				}
			}

			//console.log("DONE LOADING...");

			j('.background_div').removeClass("selected_background");
			j('#background_div_'+background_id).addClass("selected_background");

			var template = j('#template').val();
			var no_pers = j('#personalizationNone').val();

			// Since we do not call 'setPart', since no actual picture....
			updateViewLarger();
			if(!load) { 
				// Update text to show proper color.
				if(j('#parts .quote'))// && template == 'standard')
				{
					if(dbg) console.log("SHOW_TRUE_STD");
					showText(true);
				} else if (j('#parts .personalization')) {// && template == 'imageonly' && !no_pers) {
					if(dbg) console.log("SHOW_PERS. NOP="+no_pers);
					showPersonalization(true);
				} else if (!load) {
					updateBuild('background');
				}
			}
		});

		<? if(!empty($defaultBackground)) { ?>
		j(document).ready(function() {
			selectBackground('<?= $defaultBackground ?>', '<?= $defaultName ?>', true);
		});
		<? } ?>
		j(document).ready(function() { Shadowbox.close(); });
		</script>
</div>

