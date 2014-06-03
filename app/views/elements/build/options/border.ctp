<?
$defaultBorderID = isset($build['options']['borderID']) ? $build['options']['borderID'] : ($template == 'imageonly' ? -1 : 2); # blank, yet set, means 'no border'
?>
<div style="clear: both;">
<p>Tip: A border helps anchor your design.</p>
</div>
<div class="clear" XXstyle="height: 350px; overflow: scroll;">

		<div class="center" style="width: 110px; height: 50px; float: left; padding: 5px;"
			onClick="selectBorder('-1'); ">
				<div class="border_div" id="border_div_-1">
					<img id="border_image_-1" src="/borders/No Border.gif" alt="Loading..." onClick="selectBorder('-1');" width="100"/>
					<nobr><input style=" display: none; " id="border_-1" type="radio" <?= empty($defaultBorderID) ? "checked='checked'" : "" ?>  name="data[options][borderID]" 
				value="-1"/>No border</nobr>
				</div>
		</div>

			<script>
			document.observe('dom:loaded', function() {
			window.borders = {};
			<? foreach($borders as $record) { ?>
				window.borders['border_image_<?= $record->border_id ?>'] = '<?= $record->location ?>';
			<? } ?>
			});
			</script>

		<? $img_borders = !empty($image) ? $image->listBorders() : array(); 
		$found = array();
		if(count($img_borders))
		{
			?>
			<?
			foreach($img_borders as $record) { 
				$found[$record->id] = true;
			?>
				<div class="center" style="width: 110px; height: 50px; float: left; padding: 5px;"
					onClick="selectBorder('<?= $record->id ?>'); ">
				<div class="border_div" id="border_div_<?= $record->id ?>">
					<img id="border_image_<?= $record->id ?>" src="<?= $record->image ?>" alt="Loading..." onClick="selectBorder('<?= $record->id ?>');" width="100"/>
					<nobr><input style=" display: none; " id="border_<?= $record->id ?>" type="radio" <?= $defaultBorderID == $record->id ? "checked='checked'" : "" ?>  name="data[options][borderID]" 
				value="<?= $record->id ?>"/><?= ucwords($record->name); ?></nobr>
				</div>
				</div>
			<? }
		} 

		foreach($borders as $record) {
				if (!empty($found[$record->border_id]) || $record->name == 'None') { continue; }
				?>
				<div class="center" style="width: 110px; height: 50px; float: left; padding: 5px;"
					onClick="selectBorder('<?= $record->border_id ?>');">
				<div id="border_div_<?= $record->border_id ?>" class="border_div">
				<img id="border_image_<?= $record->border_id ?>" src="<?= $record->location ?>" alt="Loading..." onClick="selectBorder('<?= $record->border_id ?>');" width="100"/>
				<nobr><input style="display: none;" id="border_<?= $record->border_id ?>" type="radio" <?= $defaultBorderID == $record->border_id ? "checked='checked'" : "" ?> name="data[options][borderID]" value="<?= $record->border_id ?>"/><?= ucwords($record->name); ?></nobr>
				</div>

				</div>
		<? } ?>

		<div class="clear"></div>

		<style>
		div.border_div
		{
			cursor: pointer;
			border: solid 1px #CCC;
			margin: 2px auto;
		}

		div.selected_border
		{
			/*border: solid #333 4px;*/
			border: solid #66CC66 4px;
		}
		</style>

		<script>
		function selectBorder(border_id,load)
		{
			//console.log("SELECT BORDER="+border_id+", LOADON="+load);
			j('#step_border').trigger('showPart',[border_id,load]);
		}

		j('#step_border').bind('showPart', function (e, border_id, load)
		{
			var border_urls = [];
			<? foreach($borders as $border) { ?>
			border_urls['<?= $border->border_id ?>'] = '<?= preg_replace("@^/borders/@", "/borders/blanks/medium/", $border->location) ?>';
			<? } ?>

			//console.log("SHOWPART BORDER, LOADON="+load);
			if(!border_id) { border_id = j('input[name=data\\[options\\]\\[borderID\\]]:checked').val(); }
			j('.border_div').removeClass("selected_border");
			j('#border_div_'+border_id).addClass("selected_border");
			j('#border_'+border_id).prop('checked','checked');

			var border_path = border_urls[border_id];
			//console.log("BORDER("+border_id+")="+border_path);
			//console.log(j('#border_'+border_id));
			if(border_id != '-1' && border_path)
			{
				setPart('border_1', border_path, load);
				setPart('border_2', border_path, true);
			} else {
				setPart('border_1', '', load);
				setPart('border_2', '', true);
			}
			// updateBuild('border');
		});
		<? if(!empty($defaultBorderID)) { ?>
		j(document).ready(function() {
			selectBorder('<?= $defaultBorderID ?>',true);
		});
		<? } ?>
		</script>

</div>



