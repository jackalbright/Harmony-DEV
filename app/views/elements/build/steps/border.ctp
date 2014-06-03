<?
$defaultBorderID = $currentItem->parts->borderID;
$default = true;
?>
<div class="clear">
<!--<h2><?php echo $counter;?>. Choose your border</h2>-->

		<br/>

		<div>
		<? $img_borders = $image->listBorders(); 
		if(count($img_borders))
		{
		?>
		<h4>Recommended:</h4>
		<?
			foreach($img_borders as $record) {
				$checked = "";
				if ($default && (empty($currentItem->parts->borderID) || $currentItem->parts->borderID == $record->id)) {
					$checked = ' checked="checked"';
					$default = false;
				}
				?>
				<div class="left thick_padded center" style="width: 100pxpx; height: 90px; float: left;">
				<label>
				<input type="radio" id="border_<?= $record->id ?>" class="borderID" name="borderID" value="<?= $record->id ?>" <?= $checked ? $checked : "" ?> />
				<nobr><?= ucwords($record->name); ?></nobr><br/>
				</label>
				<img src="<?=$record->image ?>" onClick="$('border_<?= $record->id ?>').checked = 1;"/>
				</a>
				</div>
			<? } ?>
		<? } ?>

			<div class="left thick_padded center" style="width: 100pxpx; height: 90px; float: left;">
				<input type="radio" id='border_0' class="borderID" name="borderID" value="0" <?= ($default || $currentItem->parts->borderID == '0') ? "checked='checked'" : "" ?> />
				No Border<br />
				<img src="/borders/blank.gif" width="50" height="50" class="" alt="no border" onClick="$('border_None').checked = 1;"/>
			</div>
			<div class="clear"></div>
		</div>

		<h4>All Borders:</h4>
		<div>
		<?
			foreach($borders as $record) {
				$checked = "";
				if ($currentItem->parts->borderID == $record->border_id) {
					$checked = ' checked="checked"';
					$default = false;
				}
				?>
				<div class="left thick_padded center" style="width: 100pxpx; height: 90px; float: left;">
				<label>
				<nobr><input type="radio" id="border_<?= $record->border_id ?>" class="borderID" name="borderID" value="<?= $record->border_id ?>" <?= $checked ? $checked : "" ?> /><?= ucwords($record->name); ?></nobr>
				</label>
				<img src="<?=$record->location ?>" onClick="$('border_<?= $record->border_id ?>').checked = 1;"/>
				</div>
			<? } ?>
		</div>

		<div style="clear: both;">
		<p>Tip: A border helps anchor your design.</p>
		</div>
</div>

