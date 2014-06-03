<div style="padding: 10px;">
<h2>Select a charm</h2>
<?
$defaultCharmID = !empty($build['options']['charmID']) ? $build['options']['charmID'] : null;
?>
<? if($build['Product']['code'] == 'PW') { ?>
	<p class="note">Please Note: The small ring shown on the charms is removed before placement in your paperweight.</p>
<? } ?>
				<div class="thin_padded center" style="float: left; height: 70px;" onClick="parent.chooseCharm(-1);">

				<div class="charm_div" id="charm_div_-1">
					<img id="charm_image_-1" title="No Charm" src="/images/icons/no-charm-box.png" alt="Loading..."/>
					<br/>
					<nobr><input id="charm_-1" style="display: none;" type="radio" name="data[options][charmID]" <?= empty($defaultCharmID) ? "checked='checked'" : "" ?> value="-1">
						No charm
					</nobr>
				</div>
				</div>


			<?  foreach($charms as $record) { ?>
				<div class="thin_padded center" style="float: left; height: 70px;"
					onClick="parent.chooseCharm('<?= $record->charm_id ?>');">
				<div class="charm_div" id="charm_div_<?= $record->charm_id ?>">
					<img height="50" title="<?= ucwords($record->name) ?>" id="charm_image_<?= $record->charm_id ?>" src="<?= $record->graphic_location ?>" alt="Loading..."/>
					<br/>
					<nobr><input style="display: none;" id="charm_<?= $record->charm_id ?>" type="radio" name="data[options][charmID]" <?= $defaultCharmID == $record->charm_id ? "checked='checked'" : "" ?> value="<?= $record->charm_id ?>" 
					/><?= ucwords($record->name); ?></nobr>
				</div>
				</div>
			<? } ?>

		<style>
		div.charm_div
		{
			float: left;
			cursor: pointer;
			border: solid 1px #CCC;
			margin: 2px;
			text-align: center;
		}

		div.selected_charm
		{
			border: solid #66CC66 4px;
		}
		</style>

		<script>
		/*
		<? if(!empty($defaultCharmID)) { ?>
		selectCharm('<?= $defaultCharmID ?>');
		<? } else { ?>
		selectCharm('-1');
		<? } ?>
		*/
		</script>



<div class="clear"></div>
</div>

